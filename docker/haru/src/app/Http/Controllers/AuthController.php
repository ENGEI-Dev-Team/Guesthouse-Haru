<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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
            'password' => 'required|string|min:6|max:255|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/'
        ], [
            'name.required' => 'Nameの入力がありません',
            'email.required' => 'Emailの入力がありません',
            'email.unique' => 'このEmailはすでに使用されています',
            'password.required' => 'Passwordの入力がありません',
            'password.min' => 'Passwordは6文字以上である必要があります',
            'password.regex' => 'Passwordには小文字、大文字、数字を含める必要があります',
        ]);

        Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return redirect()->route('admin.login');
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

        $loginData = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($loginData)) {
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
