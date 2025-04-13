<?php

declare(strict_types=1);

use App\Http\Controllers\RegisterController;
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

Route::get('/register', [RegisterController::class, 'form'])
    ->name('register.form');

Route::post('/register', [RegisterController::class, 'register'])
    ->name('register');

Route::get('/register/report', [RegisterController::class, 'report'])
    ->name('register.report');

Route::post('/register/resend', [RegisterController::class, 'resend'])
    ->name('register.resend');

Route::get('/register/verify/{token}', [RegisterController::class, 'verify'])
    ->name('register.verify');
