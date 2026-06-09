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
    /*
    |--------------------------------------------------------------------------
    | Show Profile Edit Page
    |--------------------------------------------------------------------------
    | Menampilkan halaman settings profile.
    |--------------------------------------------------------------------------
    */
    public function edit(Request $request): View
    {
        return view('pages.settings.profile', [
            'user' => $request->user(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Update Profile Information
    |--------------------------------------------------------------------------
    | Update data profile seperti name, username, dan email.
    |--------------------------------------------------------------------------
    */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->validated());

        $validated = $request->validated();

        $nameChanged = isset($validated['name']) && $user->name !== $validated['name'];
        $usernameChanged = array_key_exists('username', $validated) && $user->username !== $validated['username'];
        $emailChanged = isset($validated['email']) && $user->email !== $validated['email'];

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        /*
        |--------------------------------------------------------------------------
        | Reset Email Verification
        |--------------------------------------------------------------------------
        | Kalau email berubah, status verified dikosongkan ulang.
        |--------------------------------------------------------------------------
        */
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $message = 'Profile berhasil diupdate.';

        if ($usernameChanged && $nameChanged) {
            $message = 'Username dan Name berhasil diganti.';
        } elseif ($usernameChanged) {
            $message = 'Username berhasil diganti.';
        } elseif ($nameChanged) {
            $message = 'Name berhasil diganti.';
        } elseif ($emailChanged) {
            $message = 'Email berhasil diganti.';
        }

        return Redirect::route('profile.edit')
            ->with('status', 'profile-updated')
            ->with('toast_message', $message);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete User Account
    |--------------------------------------------------------------------------
    | Menghapus akun user setelah password divalidasi.
    |--------------------------------------------------------------------------
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
