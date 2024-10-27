<?php

namespace App\Http\Controllers;

use App\DDD\Auth\Domain\ValueObject\Password;
use App\DDD\Auth\UseCase\loginAdminUseCase;
use App\DDD\Auth\UseCase\RegisterAdminUseCase;
use Illuminate\Http\Request;
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
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins',
            'password' => 'required|string|min:6|max:255'
        ], [
            'name.required' => 'Nameの入力がありません',
            'email.required' => 'Emailの入力がありません',
            'email.unique' => 'このEmailはすでに使用されています',
            'password.required' => 'Passwordの入力がありません',
            'password.min' => 'Passwordは6文字以上である必要があります', 
        ]);

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
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6|max:255|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/'
        ], [
            'email.required' => 'Emailの入力がありません',
            'password.required' => 'Passwordの入力がありません',
            'password.min' => 'Passwordは6文字以上である必要があります',
            'password.regex' => 'Passwordには小文字、大文字、数字を含める必要があります',
        ]);

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
