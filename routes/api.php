<?php

declare(strict_types=1);

use App\Http\Controllers\Api\Articles\LikesController;
use App\Http\Controllers\Api\Articles\BookmarkController as ArticleBookmarkController;
use App\Http\Controllers\Api\Comments\BookmarkController as CommentBookmarkController;
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

Route::middleware(['auth:sanctum', 'throttle:30,1'])->group(function () {
    Route::prefix('/topics/{topic}/subscription')
        ->name('api.topics.subscription')
        ->group(function () {
            Route::post('', [SubscriptionController::class, 'make']);
            Route::delete('', [SubscriptionController::class, 'remove']);
        });

    Route::prefix('/articles/{article}')->group(function () {
        Route::prefix('/bookmark')
            ->name('api.articles.bookmark')
            ->group(function () {
                Route::post('', [ArticleBookmarkController::class, 'make']);
                Route::delete('', [ArticleBookmarkController::class, 'remove']);
            });

        Route::prefix('/like')
            ->name('api.articles.like')
            ->group(function () {
                Route::post('', [LikesController::class, 'add']);
                Route::delete('', [LikesController::class, 'remove']);
            });

        Route::prefix('/comments/{comment}/bookmark')
            ->name('api.comments.bookmark')
            ->group(function () {
                Route::post('', [CommentBookmarkController::class, 'make']);
                Route::delete('', [CommentBookmarkController::class, 'remove']);
            });
    });
});
