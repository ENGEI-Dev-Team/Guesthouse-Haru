@extends('layouts.user_layout')

@section('title', 'ホームページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/blog_lists.css') }}">
<link rel="stylesheet" href="{{ asset('css/top.css') }}">
@endsection

@section('content')
<div class="top-image">
  <img src="{{ asset('images/teshima1.webp') }}" alt="豊島の風景" class="top-image">
  <div class="top-texts">
    <h3 class="top-title animated-text">島のお宿 Haru.</h3>
  </div>
</div>

<section class="haru">
  <div class="inner">
    <h1 class="haru-title">Special Experience Stay at Haru.</h1>
    <div class="feature-container">
      <div class="feature">
        <h2 class="feature-title">1. Traditional Japanese House</h2>
        <p class="feature-content">Enjoy a special moment in a historically rich traditional Japanese house that can only be experienced here. Surrounded by the beauty of Japanese aesthetics, a heartwarming experience awaits you.</p>
      </div>

      <div class="feature">
        <h2 class="feature-title">2. One Group Per Day</h2>
        <p class="feature-content">Relax to your heart's content in a luxurious space that is entirely yours, free from any interruptions. Spend pleasant moments in tranquility, feeling refreshed in harmony with nature.</p>
      </div>

      <div class="feature">
        <h2 class="feature-title">3. Convenient Access</h2>
        <p class="feature-content">Located just a 3-minute walk from Karato Port. Nearby, you can find various art installations, and the Teshima Art Museum is about a 15-minute walk away.</p>
      </div>

      <div class="feature">
        <h2 class="feature-title">4. Nature-Rich Environment</h2>
        <p class="feature-content">At Haru, surrounded by the sea and mountains, you can leisurely enjoy rural island living. Forget about time and immerse yourself in the island's tranquil lifestyle.</p>
      </div>
    </div>
  </div>
</section>

<section class="room">
  <div class="inner">
    <div class="section-title">
      <h2>Room</h2>
    </div>
    <div class="room-photos">
      <img src="{{  asset('images/house1.jpg') }}" alt="">
      <img src="{{  asset('images/house2.jpg') }}" alt="">
      <img src="{{  asset('images/house8.jpg') }}" alt="">
      <img src="{{  asset('images/house3.jpg') }}" alt="">
      <img src="{{  asset('images/house14.webp') }}" alt="">
      <img src="{{  asset('images/house10.jpg') }}" alt="">
    </div>
    <a href="" class="detail-link">Show all photos ></a>
  </div>

  </div>
</section>

<section class="services">
  <div class="inner">
    <div class="section-title">
      <h2>Services</h2>
    </div>

    <div class="service-list">
      <!-- アメニティー -->
      <div class="service-item" data-modal="amenities-modal">
        <div class="icon">
          <i class="fas fa-bed"></i>
        </div>
        <h4 class="service-title">Amenities</h4>
        <p class="service-content">We provide toothbrushes, razors, body towels, skincare products, shampoo, body soap, and more.</p>
      </div>

      <!-- Wi-Fi -->
      <div class="service-item" data-modal="wifi-modal">
        <div class="icon">
          <i class="fas fa-wifi"></i>
        </div>
        <h4 class="service-title">Free Wi-Fi</h4>
        <p class="service-content">High-speed Wi-Fi is available throughout the entire facility, making it ideal for remote work.</p>
      </div>

      <!-- 荷物お預かり -->
      <div class="service-item" data-modal="facility-modal">
        <div class="icon">
          <i class="fas fa-suitcase"></i>
        </div>
        <h4 class="service-title">Luggage storage</h4>
        <p class="service-content">We offer luggage storage before check-in. Please let us know the time you'd like to drop off your luggage.</p>
      </div>

      <!-- 送迎 -->
      <div class="service-item" data-modal="room-modal">
        <div class="icon">
          <i class="fas fa-car"></i>
        </div>
        <h4 class="service-title">Pick-up</h4>
        <p class="service-content">We provide a pick-up service for those arriving at Ieura Port after 4:30 PM. Please let us know your boat's arrival time. (Please note that we do not offer pick-up outside of this time frame.)</p>
      </div>

      <!-- 朝食サービス -->
      <div class="service-item" data-modal="breakfast-modal">
        <div class="icon">
          <i class="fas fa-coffee"></i>
        </div>
        <h4 class="service-title">Breakfast</h4>
        <p class="service-content">Breakfast is self-service. We provide bread, rice, instant soup, onions, eggs, and other ingredients for you to prepare your own breakfast.</p>
      </div>

      <!-- 自炊 -->
      <div class="service-item" data-modal="cooking-modal">
        <div class="icon">
          <i class="fas fa-utensils"></i>
        </div>
        <h4 class="service-title">Self-cooking</h4>
        <p class="service-content">You can bring your own ingredients and cook at the guesthouse. It is also possible to order takeout from local restaurants and enjoy your meal at the guesthouse.</p>
      </div>
    </div>
  </div>
  </div>
</section>

<section class="blogs">
  <div class="inner">
    <div class="section-title">
      <h2>Blogs</h2>
    </div>
    <div class="blog-container">
      @foreach ($latestBlogs as $blog)
      <a href="" class="blog-item">
        @if ($blog->image)
        <div class="blog-image">
          <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}">
        </div>
        @endif
        <div class="blog-content-container">
          <h3 class="blog-title">{{ $blog->title }}</h3>
          <p class="blog-content">{{ Str::limit($blog->content, 150, '...') }}</p>
          <p class="blog-date">{{ $blog->created_at->format('F j, Y') }}</p>
        </div>
      </a>
      @endforeach
    </div>
    <a href="" class="detail-link">Show all blogs ></a>
  </div>
</section>

<img src="{{ asset('images/teshima2.jpg') }}" alt="豊島の風景" class="teshima-main-image">
<div class="teshima">


  <div class="inner">
    <div class="section-title">
      <h2>The Setouchi Triennale</h2>
    </div>
    <div class="teshima-contents">
      <p>The Setouchi Triennale is a grand initiative aimed at revitalizing the region through art, bringing the forgotten islands of the Seto Inland Sea back to life.</p>
      <p>With the theme of "Restoration of the Sea," the festival aspires to reconnect people with the rich nature and restore the smiles of the elderly residents. </p>
      <p>On Teshima, the fusion of natural beauty and art transforms the island into a single artwork, offering visitors a unique and unforgettable experience.</p>
      <p>Let's rediscover the charm of Setouchi and envision a hopeful future for the islands.</p>
    </div>
    <a href="https://setouchi-artfest.jp/en/artworks-artists/artworks/teshima/" class="detail-link">More detail info ></a>
  </div>

  <div class="teshima-gallery">
    <img src="{{ asset('images/teshima3.jpg') }}" alt="豊島の風景">
    <img src="{{ asset('images/teshima4.jpg') }}" alt="豊島の風景">
    <img src="{{ asset('images/teshima6.jpg') }}" alt="豊島の風景">
  </div>
</div>

<section class="contact">
  <div class="inner">
    <div class="section-title">
      <h2>Contact</h2>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    <div class="contact-container">
      <div class="contact-form">
        <form action="" method="POST">
          @csrf
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="input-form" value="{{ old('name') }}">
            @error('name')
            <span class="error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="input-form" value="{{ old('email') }}">
            @error('email')
            <span class="error">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-group">
            <label for="message">Message</label>
            <textarea id="message" name="message" class="textarea-form" value="{{ old('message') }}">{{ old('message') }}</textarea>
            @error('message')
            <span class="error">{{ $message }}</span>
            @enderror
          </div>
          <button type="submit" class="submit-button">Send</button>
        </form>
      </div>
    </div>
  </div>
</section>

<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3288.5692180048054!2d134.0969456!3d34.488450900000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x35538b4b5eb6ce1d%3A0x78f65adedac94afb!2z44CSNzYxLTQ2NjIg6aaZ5bed55yM5bCP6LGG6YOh5Zyf5bqE55S66LGK5bO25ZSQ5quD77yS77yU77yY77yY!5e0!3m2!1sen!2sjp!4v1726580598204!5m2!1sen!2sjp" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

@endsection

@section('script')
<script>

</script>
@endsection