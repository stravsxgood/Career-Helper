<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function create(): View
    {
        return view('pages.auth.login');
    }

    /**
     * Menangani proses autentikasi login pengguna.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = User::where('email', $request->email)->first();

        // 1. Intersepsi jika akun mengaktifkan Two-Factor Authentication (2FA)
        if ($user && Hash::check($request->password, $user->password) && $user->two_factor_secret) {
            $request->session()->put('login.id', $user->id);

            return redirect()->route('two-factor.login');
        }

        // 2. Jalankan proses login standar jika tidak ada 2FA
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Menangani proses logout dan invalidasi session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
