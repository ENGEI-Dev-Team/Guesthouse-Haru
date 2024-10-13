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
          <img src="{{ asset('images/logo.webp') }}" alt="Haru.のロゴ">
        </div>
        <h1 class="header-title">島のお宿 Haru.</h1>
      </a>
    </div>
    <nav>
      <ul class="nav-menu">
        <li class="dropdown">
          <a href="javascript:void(0);" class="nav-list" id="language-btn">EN &#9663;</a>
          <ul class="dropdown-menu" id="dropdown-menu">
            <li><a href="" class="nav-list">日本語 (JP)</a></li>
          </ul>
        </li>
        <li><a href="" class="nav-list book-btn">Book Now</a></li>
      </ul>
    </nav>
  </header>
  @yield('content')
  <footer>
    <p>©2024 Haru.</p>
  </footer>
  <script>
    document.getElementById('language-btn').addEventListener('click', function() {
      var dropdownMenu = document.getElementById('dropdown-menu');

      if (dropdownMenu.style.display === "block") {
        dropdownMenu.style.display = "none";
      } else {
        dropdownMenu.style.display = "block";
      }
    });

    window.onclick = function(event) {
      if (!event.target.matches('#language-btn')) {
        var dropdown = document.getElementsByClassName('dropdown-menu');
        for (var i = 0; i < dropdowns.length; i++) {
          dropdowns[i].style.display = "none";
        }
      }
    };
  </script>
  @yield('scripts')
</body>
</html>
