<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman pengaturan profil user.
     */
    public function edit(Request $request): View
    {
        return view('pages.settings.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Memperbarui informasi profil user.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $validated = $request->validated();

        // Cek perubahan data sebelum disimpan
        $nameChanged = isset($validated['name']) && $user->name !== $validated['name'];
        $usernameChanged = isset($validated['username']) && $user->username !== $validated['username'];
        $emailChanged = isset($validated['email']) && $user->email !== $validated['email'];

        $user->fill($validated);

        // Reset verifikasi email jika email diubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Tentukan pesan toast berdasarkan field yang berubah
        $message = match (true) {
            $usernameChanged && $nameChanged => 'Username dan Name berhasil diperbarui.',
            $usernameChanged => 'Username berhasil diperbarui.',
            $nameChanged => 'Name berhasil diperbarui.',
            $emailChanged => 'Email berhasil diperbarui.',
            default => 'Profile berhasil diperbarui.',
        };

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('toast_message', $message);
    }

    /**
     * Menghapus akun user secara permanen.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
