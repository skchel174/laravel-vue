<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
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
        ->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::middleware(['auth', 'unverified'])->group(function () {
    Route::get('/verification', [VerificationController::class, 'index'])
        ->name('verification');
    Route::post('/verification', [VerificationController::class, 'send'])
        ->name('verification.send');
    Route::get('/verification/{token}', [VerificationController::class, 'verify'])
        ->name('verification.confirm');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', function () {
        return 'Profile page';
    })->name('profile');
});
