<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Topics\SubscriptionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('/topics/{topic}/subscription')
    ->middleware(['auth:sanctum', 'throttle:6,1'])
    ->group(function () {
        Route::post('/', [SubscriptionController::class, 'make'])
            ->name('api.topics.subscription');
        Route::delete('/', [SubscriptionController::class, 'remove'])
            ->name('api.topics.subscription');
    });
