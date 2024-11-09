<?php

namespace App\Http\Controllers;

use App\DDD\Auth\UseCase\loginAdminUseCase;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $loginAdminUseCase;

    public function __construct(loginAdminUseCase $loginAdminUseCase)
    {
        $this->loginAdminUseCase = $loginAdminUseCase;
    }

    // ログインフォームを表示
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // ログイン処理
    public function login(LoginRequest $request)
    {
        if ($this->loginAdminUseCase->execute($request->email, $request->password)) {
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'ログイン情報が正しくありません',
        ]);
    }

    // ログアウト処理
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
