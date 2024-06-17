<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\RegisterController;
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
