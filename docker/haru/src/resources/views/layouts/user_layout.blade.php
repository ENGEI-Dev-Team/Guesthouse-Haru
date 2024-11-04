<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  @yield('styles')

</head>

<body>
  <header class="header">
    <div class="logo">
      <a href="{{ route('user.index') }}" class="logo-link">
        <div class="logo-img">
          <img src="{{ asset('images/haru_logo.JPG') }}" alt="Haru.のロゴ">
        </div>
        <h1 class="header-title">島のお宿 Haru.</h1>
      </a>
    </div>
    <nav>
      <ul class="nav-menu">
        <li></li>
      </ul>
    </nav>
    <a href="{{ route('user.reservation') }}" class="nav-list book-btn">Book Now</a>
  </header>
  @yield('content')
  <footer>
    <p>©2024 Haru.</p>
  </footer>
  @yield('scripts')
</body>
</html>