<?php

declare(strict_types=1);

use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\User\ArticlesController;
use App\Http\Controllers\User\BookmarksController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('main');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'auth.session', 'verified'])->name('dashboard');

Route::prefix('/users/{user:login}')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])
        ->name('user');

    Route::get('/articles/{status?}', [ArticlesController::class, 'index'])
        ->name('user.articles');

    Route::get('/bookmarks/articles', [BookmarksController::class, 'articles'])
        ->name('user.bookmarks.articles');

    Route::get('/bookmarks/comments', [BookmarksController::class, 'comments'])
        ->name('user.bookmarks.comments');
});

Route::prefix('/articles/{article}')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])
        ->name('article');

    Route::get('/comments', [ArticleController::class, 'comments'])
        ->name('article.comments');

    Route::prefix('/comments')
        ->middleware(['auth', 'auth.session', 'verified'])
        ->group(function () {
        Route::post('/', [CommentController::class, 'create'])
            ->name('articles.comment.create');

        Route::post('/{comment}/comments', [CommentController::class, 'reply'])
            ->name('articles.comment.reply');

        Route::patch('/{comment}/comments', [CommentController::class, 'edit'])
            ->middleware('can:update,comment')
            ->name('articles.comment.update');
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
