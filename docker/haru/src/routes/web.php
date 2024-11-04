<?php

use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminCalendarController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
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

    // 予約ページ
    Route::get('/admin/calendar', [AdminCalendarController::class, 'index'])->name('admin.calendar');

    // 管理者ブログ作成
    Route::get('admin/blog/create', [AdminBlogController::class, 'create'])->name('admin.blog.create');
    Route::post('/blogs', [AdminBlogController::class, 'store'])->name('admin.blog.store');

    // 管理者ブログ一覧
    Route::get('admin/blogs', [AdminBlogController::class, 'blogLists'])->name('admin.blogLists');

    // ブログ詳細ページ
    Route::get('admin/blogs/{id}', [AdminBlogController::class, 'blogDetail'])->name('admin.blogDetail');

    // コメントの削除
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // ブログ編集ページ
    Route::get('/admin/blogs/{blog}/edit', [AdminBlogController::class, 'edit'])->name('admin.blogEdit');
    Route::PUT('/admin/blogs/{blog}', [AdminBlogController::class, 'update'])->name('admin.blogUpdate');

    //  ブログ削除機能
    Route::delete('/admin/blogs/{blog}', [AdminBlogController::class, 'destroy'])->name('admin.blogDelete');

    // お問い合わせページ
    Route::get('/admin/contact', [ContactController::class, 'index'])->name('admin.contact');

    // お問い合わせ詳細ページ
    Route::get('admin/contact/{id}', [ContactController::class, 'showDetail'])->name('admin.contactDetail');

    // お問い合わせ削除
    Route::delete('/admin/contact/{id}', [ContactController::class, 'delete'])->name('admin.contactDelete');

    // ステータスの更新管理
    Route::post('/admin/contact/{id}', [ContactController::class, 'updateStatus'])->name('updateStatus');
});

// コメントの保存
Route::post('/blogs/{blog}/comments', [CommentController::class, 'store'])->name('comments.store');

// ユーザー用ルート

// ユーザートップページ
Route::get('/', [UserController::class, 'index'])->name('user.index');

// ブログ一覧ページ
Route::get('/blogs', [UserController::class, 'blogLists'])->name('user.blogLists');

// ブログ詳細ページ
Route::get('/blogs/{id}', [UserController::class, 'blogDetail'])->name('user.blogDetail');

// 内装ページ
Route::get('/room', [UserController::class, 'room'])->name('user.room');

// お問い合わせ機能
Route::post('/admin/contact', [ContactController::class, 'store'])->name('contact.store');

// 予約ページ
Route::get('/reservation', [ReservationController::class, 'index'])->name('user.reservation');
