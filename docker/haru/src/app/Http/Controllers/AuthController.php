<?php

namespace App\Http\Controllers;

use App\DDD\Auth\Domain\ValueObject\Password;
use App\DDD\Auth\UseCase\loginAdminUseCase;
use App\DDD\Auth\UseCase\RegisterAdminUseCase;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private $registerAdminUseCase;
    private $loginAdminUseCase;

    public function __construct(RegisterAdminUseCase $registerAdminUseCase, loginAdminUseCase $loginAdminUseCase)
    {
        $this->registerAdminUseCase = $registerAdminUseCase;
        $this->loginAdminUseCase = $loginAdminUseCase;
    }

    // 新規登録フォームを表示
    public function showRegisterForm()
    {
        return view('admin.register');
    }

    // 登録処理
    public function register(RegisterRequest $request)
    {
        try {
            $passwordValueObject = new Password($request->password);

            $this->registerAdminUseCase->execute($request->name, $request->email, $passwordValueObject);
            return redirect()->route('admin.login');
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        } catch (\exception $e) {
            return back()->withErrors(['error' => '登録に失敗しました']);
        }
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
