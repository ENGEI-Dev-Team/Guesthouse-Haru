@extends('layouts.admin_layout')

@section('title', 'お問い合わせメール管理')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
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
    <!-- ページネーションリンク -->
    <div class="pagination">
      {{ $contact->links('pagination::bootstrap-4') }}
    </div>
  </div>
</section>
@endsection