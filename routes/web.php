<?php

use App\Http\Controllers\ArticleController;
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
    Route::resource('post', PostController::class)->except('create');

    Route::post('/post/{post}/articles', [ArticleController::class, 'store'])->name('article.create');
    Route::post('/post/{post}/articles/{article}', [ArticleController::class, 'destroy'])->name('article.delete');

    Route::put('/post/{post}/like', [LikeController::class, 'like'])->name('post.like');
    Route::delete('/post/{post}/like', [LikeController::class, 'unlike'])->name('post.unlike');

    Route::get('/users/{user}', [UserController::class, 'index'])->name('user.index');
});

require __DIR__.'/auth.php';
