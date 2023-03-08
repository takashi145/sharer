<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Models\Article;
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
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/{category}/article', [ArticleController::class, 'index'])->name('article.index');
    Route::get('/article/create', [ArticleController::class, 'create'])->name('article.create');
    Route::post('/article', [ArticleController::class, 'store'])->name('article.store');
    Route::delete('/article/{article}', [ArticleController::class, 'destroy'])->name('article.delete');

    Route::put('/articles/{article}/like', [LikeController::class, 'like'])->name('article.like');
    Route::delete('/articles/{article}/like', [LikeController::class, 'unlike'])->name('article.unlike');

    Route::get('/users/{user}', [UserController::class, 'index'])->name('user.index');
    Route::post('/user/{user}/follow', [FollowController::class, 'follow'])->name('user.follow');
    Route::delete('/user/{user}/follow', [FollowController::class, 'unfollow'])->name('user.unfollow');
});

require __DIR__.'/auth.php';
