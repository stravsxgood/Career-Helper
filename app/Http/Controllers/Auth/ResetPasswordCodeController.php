<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\ResetPasswordCodeNotification;
use App\Support\ResetPasswordCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class ResetPasswordCodeController extends Controller
{
    private const CODE_EXPIRES_MINUTES = 60;
    private const RESEND_COOLDOWN_SECONDS = 300;
    private const MAX_CODE_ATTEMPTS = 5;

    public function showUsernameForm()
    {
        return view('pages.auth.username-request');
    }

    public function sendCode(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255'],
        ]);

        $username = $validated['username'];

        session([
            'reset_password_username' => $username,
        ]);

        $user = User::where('username', $username)->first();

        if ($user) {
            $this->generateAndSendCode($user);
        }

        return redirect()
            ->route('password.code.verify.form')
            ->with('status', 'Jika username valid, kode reset password telah dikirim ke email yang terdaftar.');
    }

    public function showCodeForm()
    {
        if (! session('reset_password_username')) {
            return redirect()->route('password.code.request');
        }

        return view('pages.auth.verify-code');
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'max:20'],
        ]);

        $username = session('reset_password_username');

        if (! $username) {
            return redirect()->route('password.code.request');
        }

        $user = User::where('username', $username)->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'code' => 'Kode reset password tidak valid.',
            ]);
        }

        if (! $user->reset_password_code_hash || ! $user->reset_password_code_expires_at) {
            throw ValidationException::withMessages([
                'code' => 'Kode reset password tidak valid atau sudah tidak tersedia.',
            ]);
        }

        if (now()->greaterThan($user->reset_password_code_expires_at)) {
            $this->clearResetCode($user);

            throw ValidationException::withMessages([
                'code' => 'Kode reset password sudah kadaluarsa. Silakan kirim ulang kode.',
            ]);
        }

        if ($user->reset_password_code_attempts >= self::MAX_CODE_ATTEMPTS) {
            $this->clearResetCode($user);

            throw ValidationException::withMessages([
                'code' => 'Terlalu banyak percobaan. Silakan kirim ulang kode reset password.',
            ]);
        }

        $normalizedCode = ResetPasswordCode::normalize($request->input('code'));

        if (! Hash::check($normalizedCode, $user->reset_password_code_hash)) {
            $user->increment('reset_password_code_attempts');

            throw ValidationException::withMessages([
                'code' => 'Kode reset password tidak valid.',
            ]);
        }

        session([
            'reset_password_code_verified' => true,
            'reset_password_code_verified_at' => now()->timestamp,
        ]);

        return redirect()->route('password.code.reset');
    }

    public function resendCode()
    {
        $username = session('reset_password_username');

        if (! $username) {
            return redirect()->route('password.code.request');
        }

        $user = User::where('username', $username)->first();

        if ($user) {
            $this->ensureCanResendCode($user);
            $this->generateAndSendCode($user);
        }

        return back()->with('status', 'Jika username valid, kode baru telah dikirim ke email yang terdaftar.');
    }

    public function showResetForm()
    {
        $this->ensureCodeHasBeenVerified();

        return view('pages.auth.reset-code');
    }

    public function resetPassword(Request $request)
    {
        Log::info('RESET CODE: resetPassword terpanggil');

        $this->ensureCodeHasBeenVerified();

        $validated = $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $username = session('reset_password_username');

        $user = User::where('username', $username)->first();

        if (! $user) {
            return redirect()
                ->route('password.code.request')
                ->withErrors([
                    'username' => 'Session reset tidak valid. Silakan mulai ulang reset password.',
                ]);
        }

        $oldPasswordHash = $user->password;

        $user->forceFill([
            'password' => Hash::make($validated['password']),
            'remember_token' => Str::random(60),
        ])->save();

        $user->refresh();

        $this->clearResetCode($user);

        session()->forget([
            'reset_password_username',
            'reset_password_code_verified',
            'reset_password_code_verified_at',
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'Password berhasil direset. Silakan login dengan password baru.');
    }

    private function generateAndSendCode(User $user): void
    {
        $code = ResetPasswordCode::generate();

        $user->forceFill([
            'reset_password_code_hash' => Hash::make($code),
            'reset_password_code_expires_at' => now()->addMinutes(self::CODE_EXPIRES_MINUTES),
            'reset_password_code_sent_at' => now(),
            'reset_password_code_attempts' => 0,
        ])->save();

        $user->notify(new ResetPasswordCodeNotification($code));
    }

    private function ensureCanResendCode(User $user): void
    {
        if (! $user->reset_password_code_sent_at) {
            return;
        }

        $secondsSinceLastSent = $user->reset_password_code_sent_at->diffInSeconds(now());

        if ($secondsSinceLastSent < self::RESEND_COOLDOWN_SECONDS) {
            $remaining = self::RESEND_COOLDOWN_SECONDS - $secondsSinceLastSent;

            throw ValidationException::withMessages([
                'resend' => 'Tunggu ' . $remaining . ' detik sebelum meminta kode baru.',
            ]);
        }
    }

    private function ensureCodeHasBeenVerified(): void
    {
        $verified = session('reset_password_code_verified');
        $verifiedAt = session('reset_password_code_verified_at');

        if (! $verified || ! $verifiedAt) {
            abort(403);
        }

        if (now()->timestamp - $verifiedAt > 600) {
            session()->forget([
                'reset_password_code_verified',
                'reset_password_code_verified_at',
            ]);

            abort(403);
        }
    }

    private function clearResetCode(User $user): void
    {
        $user->forceFill([
            'reset_password_code_hash' => null,
            'reset_password_code_expires_at' => null,
            'reset_password_code_sent_at' => null,
            'reset_password_code_attempts' => 0,
        ])->save();
    }
}
