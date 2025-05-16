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
})->name('main');

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'form'])
        ->name('register.form');

    Route::post('/register', [RegisterController::class, 'register'])
        ->name('register');
});

Route::middleware(['auth', 'unverified'])->group(function () {
    Route::get('/register/email', [RegisterController::class, 'report'])
        ->name('register.report');

    Route::post('/register/email', [RegisterController::class, 'resend'])
        ->name('register.resend');

    Route::get('/register/verify/{token}', [RegisterController::class, 'verify'])
        ->name('register.verify');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', function () {
        return 'Profile page';
    })->name('profile');
});
