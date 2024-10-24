<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者新規登録</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
  <div class="login-container">
    <h2>管理者登録</h2>
    <!-- エラーメッセージ -->
    @if ($errors->any())
    <div class="error-message">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <!-- ログインフォーム -->
    <form action="{{ route('admin.register.submit') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="name">名前:</label>
        <input type="name" id="name" name="name" class="input-form" required>
      </div>
      <div class="form-group">
        <label for="email">メールアドレス:</label>
        <input type="email" id="email" name="email" class="input-form" required>
      </div>
      <div class="form-group">
        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" class="input-form" required>
      </div>
      <button type="submit" class="btn">登録</button>
    </form>

    <p class="auth-p">すでにアカウントをお持ちですか？<a href="{{ route('admin.login') }}" class="register-link">ログイン</a></p>
  </div>
</body>
</html>