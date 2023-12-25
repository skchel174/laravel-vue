<?php

declare(strict_types=1);

use App\Http\Controllers\Article\ArticleController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\User\UserController;
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

Route::get('/users/{user:login}', [UserController::class, 'profile'])
    ->name('user');

Route::get('/users/{user:login}/articles/{status?}', [UserController::class, 'articles'])
    ->name('user.articles');

Route::get('/users/{user:login}/bookmarks/articles', [UserController::class, 'bookmarkedArticles'])
    ->name('user.bookmarks.articles');

Route::get('/articles/{id}', [ArticleController::class, 'index'])
    ->name('article');

Route::post('/article/{article}/comments', [CommentController::class, 'create'])
    ->middleware(['auth', 'auth.session', 'verified'])
    ->name('articles.comment.create');

Route::post('/article/{article}/comments/{comment}/comments', [CommentController::class, 'reply'])
    ->middleware(['auth', 'auth.session', 'verified'])
    ->name('articles.comment.reply');

require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
