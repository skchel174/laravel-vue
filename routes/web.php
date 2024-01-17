<?php

declare(strict_types=1);

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
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
    Route::get('/', [UserController::class, 'profile'])
        ->name('user');

    Route::get('/articles/{status?}', [UserController::class, 'articles'])
        ->name('user.articles');

    Route::get('/comments', [UserController::class, 'comments'])
        ->name('user.comments');

    Route::get('/bookmarks/articles', [UserController::class, 'bookmarkedArticles'])
        ->name('user.bookmarks.articles');

    Route::get('/bookmarks/comments', [UserController::class, 'bookmarkedComments'])
        ->name('user.bookmarks.comments');

    Route::get('/following', [UserController::class, 'following'])
        ->name('user.following');

    Route::get('/followers', [UserController::class, 'followers'])
        ->name('user.followers');
});

Route::prefix('/articles')->group(function () {
    Route::get('/{article}', [ArticleController::class, 'index'])
        ->whereNumber('article')
        ->name('article');

    Route::middleware(['auth', 'auth.session', 'verified'])->group(function () {
        Route::get('/editor', [ArticleController::class, 'editor'])
            ->name('editor');

        Route::get('/{article}/editor', [ArticleController::class, 'editor'])
            ->middleware('can:update,article')
            ->name('article.editor');

        Route::post('/create', [ArticleController::class, 'create'])
            ->name('article.create');

        Route::patch('/{article}/update', [ArticleController::class, 'update'])
            ->middleware('can:update,article')
            ->name('article.update');
    });

    Route::prefix('/{article}/comments')->group(function () {
        Route::get('/', [ArticleController::class, 'comments'])
            ->name('article.comments');

        Route::middleware(['auth', 'auth.session', 'verified'])->group(function () {
            Route::post('/', [CommentController::class, 'create'])
                ->name('articles.comment.create');

            Route::patch('/{comment}', [CommentController::class, 'edit'])
                ->middleware('can:update,comment')
                ->name('articles.comment.update');

            Route::post('/{comment}/comments', [CommentController::class, 'reply'])
                ->name('articles.comment.reply');
        });
    });
});

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
