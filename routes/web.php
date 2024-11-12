<?php
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\CommentController;

Route::get('/', [AuthController::class,'index'])->name('home');

///// AuthController
Route::get('verify', [AuthController::class, 'verify'])->name('verify');

Route::post('register',[AuthController::class, 'register'])->name('register');
Route::get('/register', [AuthController::class, 'registerForm'])->name('registerForm');
Route::get('login', [AuthController::class, 'loginForm'])->name('loginForm');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::delete('logout',[AuthController::class, 'logout'])->name('logout');
Route::put('/update/profile/{id}', [AuthController::class, 'update'])->name('update');

////////////// Middleware in Route
Route::middleware('checkAuth')->group(function (){
    Route::get('/edit/profile', [AuthController::class, 'editProfile'])->name('auth.edit');
    Route::get('my_profile', [AuthController::class, 'my_profile'])->name('my_profile');
    Route::post('follow/{id}', [FollowController::class, 'follow'])->name('follow');
    Route::post('unfollow/{id}', [FollowController::class, 'unfollow'])->name('unfollow');
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/delete', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});
////// PostController
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::get('/user/{username}', [PostController::class, 'userProfile'])->name('user_profile');
