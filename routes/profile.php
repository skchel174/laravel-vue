<?php

declare(strict_types=1);

use App\Http\Controllers\Profile\ChangeEmailController;
use App\Http\Controllers\Profile\ChangePasswordController;
use App\Http\Controllers\Profile\ProfileController;

Route::prefix('/profile')
    ->middleware(['auth', 'auth.session', 'verified'])
    ->group(function () {
        Route::get('/', [ProfileController::class, 'index'])
            ->name('profile');

        Route::prefix('/email')
            ->group(function () {
                Route::patch('/', [ChangeEmailController::class, 'change'])
                    ->name('profile.email.change');

                Route::get('/{token}', [ChangeEmailController::class, 'verify'])
                    ->name('profile.email.verify');
            });

        Route::patch('/password', ChangePasswordController::class)
            ->name('profile.password.change');

        Route::patch('/update', [ProfileController::class, 'update'])
            ->name('profile.update');

        Route::delete('/delete', [ProfileController::class, 'delete'])
            ->name('profile.delete');
    });
