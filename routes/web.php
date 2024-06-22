<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\AuthSessionController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\LocalizationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::put('/appearance', LocalizationController::class)
    ->name('appearance');

Route::prefix('/register')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/', [RegisterController::class, 'index'])
            ->name('register');

        Route::post('/', [RegisterController::class, 'register'])
            ->name('register');
    });

    Route::middleware(['auth', 'unverified'])->group(function () {
        Route::get('/notice', [RegisterController::class, 'notice'])
            ->name('register.notice');

        Route::get('/notify', [RegisterController::class, 'notify'])
            ->middleware(['throttle:6,1'])
            ->name('register.notify');

        Route::get('/verify/{token}', [RegisterController::class, 'verify'])
            ->middleware(['throttle:6,1'])
            ->name('register.verify');
    });
});

Route::prefix('/login')
    ->middleware('guest')
    ->group(function () {
        Route::get('/', [AuthSessionController::class, 'index'])
            ->name('login');

        Route::post('/', [AuthSessionController::class, 'create'])
            ->name('login');
    });

Route::get('/logout', [AuthSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::prefix('/password')
    ->middleware('guest')
    ->group(function () {
        Route::get('/forgot', [ResetPasswordController::class, 'notice'])
            ->name('password.forgot');

        Route::post('/notify', [ResetPasswordController::class, 'notify'])
            ->name('password.notify');

        Route::get('/{user}/{token}', [ResetPasswordController::class, 'form'])
            ->name('password');

        Route::post('/reset/{user}/{token}', [ResetPasswordController::class, 'reset'])
            ->name('password.reset');
    });
