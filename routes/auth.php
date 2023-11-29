<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('/register')
    ->group(function () {
        Route::middleware('guest')
            ->group(function () {
                Route::get('/', [RegisterController::class, 'index'])
                    ->name('register.form');

                Route::post('/', [RegisterController::class, 'register'])
                    ->name('register');
            });

        Route::middleware(['auth', 'auth.session', 'unverified'])
            ->group(function () {
                Route::get('/prompt', [RegisterController::class, 'prompt'])
                    ->name('register.prompt');

                Route::middleware('throttle:6,1')
                    ->group(function () {
                        Route::get('/email', [RegisterController::class, 'notify'])
                            ->name('register.email');

                        Route::get('/verification/{token}', [RegisterController::class, 'verify'])
                            ->name('register.verify');
                    });
            });
    });

Route::prefix('/login')
    ->middleware('guest')
    ->group(function () {
        Route::get('/', [LoginController::class, 'index'])
            ->name('login.form');

        Route::post('/', [LoginController::class, 'login'])
            ->middleware('login.limiter')
            ->name('login');
    });

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware(['auth', 'auth.session'])
    ->name('logout');

Route::prefix('/password')
    ->middleware('guest')
    ->group(function () {
        Route::get('/forgot', [PasswordResetController::class, 'index'])
            ->name('password.forgot');

        Route::post('/forgot', [PasswordResetController::class, 'email'])
            ->middleware('throttle:6,1')
            ->name('password.forgot.email');

        Route::get('/reset/{token}', [PasswordResetController::class, 'form'])
            ->name('password.reset.form');

        Route::post('/reset', [PasswordResetController::class, 'reset'])
            ->name('password.reset');
    });

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
});

