<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Articles\BookmarkController;
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
    ->name('api.topics.subscription')
    ->middleware(['auth:sanctum', 'throttle:6,1'])
    ->group(function () {
        Route::post('/', [SubscriptionController::class, 'make']);
        Route::delete('/', [SubscriptionController::class, 'remove']);
    });

Route::prefix('/articles/{article}/bookmark')
    ->name('api.articles.bookmark')
    ->middleware(['auth:sanctum', 'throttle:6,1'])
    ->group(function () {
        Route::post('', [BookmarkController::class, 'make']);
        Route::delete('', [BookmarkController::class, 'remove']);
    });
