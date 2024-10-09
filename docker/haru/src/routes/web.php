<?php

use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
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

// 管理者TOP
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// 管理者ブログ作成
Route::middleware('admin')->group(function () {
    Route::get('admin/blog/create', [AdminBlogController::class, 'create'])->name('admin.blog.create');
    Route::post('/blogs', [AdminBlogController::class, 'store'])->name('admin.blog.store');
});

// 管理者ブログ一覧
Route::middleware('admin')->group(function () {
    Route::get('admin/blogs', [AdminBlogController::class, 'blogLists'])->name('admin.blogLists');
});

Route::middleware('admin')->group(function () {
    Route::get('/', function () {
        return view('top');
    });
