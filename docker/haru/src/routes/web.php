<?php

use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// 管理者用ルート

// 管理者登録
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/register', [AuthController::class, 'register'])->name('admin.register.submit');

// 管理者ログイン
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');

// 管理者ログアウト
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->group(function () {
    // 管理者TOP
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // 管理者ブログ作成
    Route::get('admin/blog/create', [AdminBlogController::class, 'create'])->name('admin.blog.create');
    Route::post('/blogs', [AdminBlogController::class, 'store'])->name('admin.blog.store');

    // 管理者ブログ一覧
    Route::get('admin/blogs', [AdminBlogController::class, 'blogLists'])->name('admin.blogLists');

    // ブログ詳細ページ
    Route::get('admin/blogs/{id}', [AdminBlogController::class, 'blogDetail'])->name('admin.blogDetail');

    // コメントの削除
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // ブログ編集ページ
    Route::get('/admin/blogs/{blog}/edit', [AdminBlogController::class, 'edit'])->name('admin.blogEdit');
    Route::PUT('/admin/blogs/{blog}', [AdminBlogController::class, 'update'])->name('admin.blogUpdate');

    //  ブログ削除機能
    Route::delete('/admin/blogs/{blog}', [AdminBlogController::class, 'destroy'])->name('admin.blogDelete');
});

// コメントの保存
Route::post('/blogs/{blog}/comments', [CommentController::class, 'store'])->name('comments.store');