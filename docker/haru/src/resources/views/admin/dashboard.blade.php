@extends('layouts.admin_layout')

@section('title', '管理者TOPページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
<link rel="stylesheet" href="{{ asset('css/blog_lists.css') }}">
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
@endsection

@section('content')
<!-- 予約カレンダー -->
<section class="reservation-calendar">
  <div class="inner">
    <h2 class="section-title  calendar-text">Calendar</h2>
    <div id="calendar"></div>
  </div>
</section>

<!-- お問い合わせ -->
<section class="contact">
  <div class="inner">
    <div class="section-title">
      <h2>Contacts</h2>
    </div>

    <!-- 絞り込みフォーム -->
    <form action="{{ route('admin.contact') }}" method="get" class="filter">
      <div class="filter-row">
        <div class="filter-lists">
          <input type="text" name="name" id="name" class="filter-item" placeholder="名前" value="{{ request('name') }}">
        </div>

        <div class="filter-lists">
          <input type="text" name="email" id="email" class="filter-item" placeholder="メールアドレス" value="{{ request('email') }}">
        </div>

        <div class="filter-lists">
          <input type="text" name="message" id="message" class="filter-item" placeholder="メッセージ内容" value="{{ request('message') }}">
        </div>

        <div class="filter-lists">
          <select name="status" id="status">
            <option value="">全てのステータス</option>
            <option value="unresolved" {{ request('status') == 'unresolved' ? 'selected' : '' }}>未対応</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>対応中</option>
            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>完了</option>
          </select>
        </div>

        <div class="filter-lists">
          <input type="date" name="date_from" class="filter-item" placeholder="開始日" value="{{ request('date_from') }}">
        </div>

        <div class="filter-lists">
          <input type="date" name="date_to" class="filter-item" placeholder="終了日" value="{{ request('date_to') }}">
        </div>

        <div class="filter-lists">
          <button type="submit" class="submit-button">検索</button>
          <a href="{{ route('admin.contact') }}" class="all-button">全て</a>
        </div>
      </div>
    </form>

    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif

    <!-- お問い合わせ一覧 -->
    <table class="table">
      <thead>
        <tr>
          <th>名前</th>
          <th>メールアドレス</th>
          <th>メッセージ</th>
          <th>日時</th>
          <th>ステータス</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($contact as $request)
        <tr style="cursor: pointer;" onclick="location.href='{{ route('admin.contactDetail', $request->id) }}'">
          <td>{{ $request->name }}</td>
          <!-- メール送信機能 -->
          <td><a href="mailto:{{ $request->email }}?subject=Inquiry&body=Thank you for your inquiry." class="email-link">{{ $request->email }}</a>
          </td>
          <td>{{ Str::limit($request->message, 50, '...') }}</td>
          <td>{{ $request->created_at->format('Y-m-d')  }}</td>
          <td>
            <form action="{{ route('updateStatus', $request->id) }}" method="post">
              @csrf
              <select name="status" id="status" onchange="this.form.submit()" style="color: {{ $request->status == 'unresolved' ? 'red' : ($request->status == 'in_progress' ? 'green' : 'blue') }}" onclick="event.stopPropagation();">
                <option value="unresolved" {{ $request->status == 'unresolved' ? 'selected' : '' }}>未対応</option>
                <option value="in_progress" {{ $request->status == 'in_progress' ? 'selected' : '' }}>対応中</option>
                <option value="resolved" {{ $request->status == 'resolved' ? 'selected' : '' }}>完了</option>
              </select>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="detail-btn">
      <a href="{{ route('admin.contact') }}" class="detail-link">Show all contacts ></a>
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
      <a href="{{ route('admin.blogDetail', ['id' => $blog->id]) }}" class="blog-item">
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
    <div class="detail-btn">
      <a href="{{ route('admin.blogLists') }}" class="detail-link">Show all blogs ></a>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/main.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/main.min.js'></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var events = @json($bookedDates);

    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      events: events,
    });

    calendar.render();
  });
</script>
@endsection