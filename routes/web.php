<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostsController::class, 'index'])->name('home');
Route::get('/login', [UserController::class, 'showLogin'])->name('login.show');
Route::post('/login', [UserController::class, 'login'])->name('login.store');
Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware(['custom.auth'])->group(function () {

    // User-only or shared routes
    Route::get('/blog', [PostsController::class, 'blog'])->name('showblog');
    Route::get('/write', [PostsController::class, 'showWriteForm'])->name('write.form');
    Route::post('/write', [PostsController::class, 'storePost'])->name('write');
    Route::get('/post/{id}', [PostsController::class, 'show'])->name('post.show');
    Route::get('/post/{id}/edit', [PostsController::class, 'edit'])->name('posts.edit');
    Route::put('/post/{id}', [PostsController::class, 'update'])->name('posts.update');
    Route::delete('/post/{id}', [PostsController::class, 'destroy'])->name('posts.destroy');
    Route::get('/MyPosts', [PostsController::class, 'userPosts'])->name('userPosts.show');

    Route::post('/Comment/{id}', [CommentController::class, 'store'])->name('comment.store');
    Route::post('/Comment/Reply/{id}', [CommentController::class, 'reply'])->name('reply.store');
    Route::delete('/Comment/delete/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::post('/Like/{post}', [PostsController::class, 'like'])->name('like.store');

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::get('/register', [UserController::class, 'showRegister'])->name('register.show');
        Route::post('/register', [UserController::class, 'register'])->name('register.store');
        Route::get('/role', [UserController::class, 'showRole'])->name('role.show');
        Route::post('/role', [UserController::class, 'storeRole'])->name('role.store');
        Route::get('/all_user', [UserController::class, 'allUser'])->name('allUsers.show');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
        Route::get('/user/{id}', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
    });
});
