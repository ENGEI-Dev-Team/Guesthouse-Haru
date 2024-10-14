<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  @yield('styles')
</head>

<body>
  <header class="header">
    <div class="logo">
      <a href="{{ route('user.index') }}}" class="logo-link">
        <div class="logo-img">
          <img src="{{ asset('images/logo.webp') }}" alt="Haru.のロゴ">
        </div>
        <h1 class="header-title">島のお宿 Haru.</h1>
      </a>
    </div>
    <nav>
      <ul class="nav-menu">
        <li><a href="{{ route('admin.dashboard') }}" class="nav-list">TOP</a></li>
        <li><a href="" class="nav-list">予約一覧</a></li>
        <li><a href="{{ route('admin.contact') }}" class="nav-list">お問い合わせ</a></li>
        <li><a href="{{ route('admin.blog.create') }}" class="nav-list">ブログ作成</a></li>
        <li><a href="{{ route('admin.blogLists') }}" class="nav-list">ブログ一覧</a></li>
        <li>
          <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit" class="nav-list btn">ログアウト</button>
          </form>
        </li>
      </ul>
    </nav>
  </header>
  @yield('content')
  <footer>
    <p>©2024 by Haru.</p>
  </footer>
  @yield('scripts')
</body>
</html>