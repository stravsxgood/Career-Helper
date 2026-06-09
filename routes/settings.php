<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    /*
    |--------------------------------------------------------------------------
    | Profile Settings
    |--------------------------------------------------------------------------
    */

    Route::get('settings/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('settings/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('settings/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Password Update
    |--------------------------------------------------------------------------
    */

    Route::put('settings/password', [PasswordController::class, 'update'])
        ->name('password.update');
});

Route::middleware(['auth', 'verified'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Appearance Settings
    |--------------------------------------------------------------------------
    | Biarkan Livewire kalau memang file-nya Livewire component.
    |--------------------------------------------------------------------------
    */

    Route::livewire('settings/appearance', 'pages.settings.appearance')
        ->name('appearance.edit');

    /*
    |--------------------------------------------------------------------------
    | Security Settings
    |--------------------------------------------------------------------------
    | Biarkan Livewire kalau memang file-nya Livewire component.
    |--------------------------------------------------------------------------
    */

    Route::livewire('settings/security', 'pages.settings.security')
        ->middleware([
            'password.confirm',
        ])
        ->name('security.edit');
});
