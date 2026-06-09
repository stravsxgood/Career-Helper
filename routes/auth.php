<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\ResetPasswordCodeController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    /*
    |--------------------------------------------------------------------------
    | Forgot Password via Email Link
    |--------------------------------------------------------------------------
    */

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    /*
    |--------------------------------------------------------------------------
    | Reset Password via Username + Code
    |--------------------------------------------------------------------------
    */

    Route::get('forgot-password/username', [ResetPasswordCodeController::class, 'showUsernameForm'])
        ->name('password.code.request');

    Route::post('forgot-password/username', [ResetPasswordCodeController::class, 'sendCode'])
        ->middleware('throttle:5,1')
        ->name('password.code.send');

    Route::get('forgot-password/code', [ResetPasswordCodeController::class, 'showCodeForm'])
        ->name('password.code.verify.form');

    Route::post('forgot-password/code', [ResetPasswordCodeController::class, 'verifyCode'])
        ->middleware('throttle:5,1')
        ->name('password.code.verify');

    Route::post('forgot-password/code/resend', [ResetPasswordCodeController::class, 'resendCode'])
        ->middleware('throttle:3,1')
        ->name('password.code.resend');

    Route::get('reset-password-code', [ResetPasswordCodeController::class, 'showResetForm'])
        ->name('password.code.reset');

    Route::post('reset-password-code', [ResetPasswordCodeController::class, 'resetPassword'])
        ->middleware('throttle:5,1')
        ->name('password.code.update');

    /*
    |--------------------------------------------------------------------------
    | Reset Password via Email Token
    |--------------------------------------------------------------------------
    | Route dinamis {token} wajib di bawah reset-password/code.
    |--------------------------------------------------------------------------
    */

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
