<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\AuthController;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/posts', PostController::class);
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::post('comments', [CommentController::class, 'store']);
    Route::get('/api-comments', [CommentController::class, 'apiComments']);
    Route::post('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::put('comments/{comment}', [CommentController::class, 'update']);

    Route::get('/api/posts', [PostController::class, 'apiPosts']);
    

    Route::delete('comments/{comment}', [
        CommentController::class,
        'destroy'
    ]);
});

    // Public routes
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::post('/api/login', [AuthController::class, 'showLoginForm'])->name('login');

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);


    Route::post('/login', [AuthController::class, 'login']);

    // Route::middleware('auth')->group(function () {
    //     Route::get('/home', [PostController::class, 'index'])->name('home');

//     Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
//     Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
//     Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
//     Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
//     Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
//     Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');

//     Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
//     Route::get('comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
//     Route::patch('comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
//     Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// });
