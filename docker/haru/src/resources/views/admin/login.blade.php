<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>管理者ログイン</title>
  <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
  <div class="login-container">
    <h2>管理者ログイン</h2>
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
    <form action="{{ route('admin.login') }}" method="POST">
      @csrf
      <div class="form-group">
        <label for="email">メールアドレス:</label>
        <input type="email" id="email" name="email" class="input-form" required>
      </div>
      <div class="form-group">
        <label for="password">パスワード:</label>
        <input type="password" id="password" name="password" class="input-form" required>
      </div>
      <button type="submit" class="btn">ログイン</button>
    </form>
  </div>
</body>
</html>