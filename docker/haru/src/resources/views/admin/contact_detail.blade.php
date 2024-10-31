@extends('layouts.admin_layout')

@section('title', 'お問い合わせ詳細ページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/contactDetail.css') }}">
@endsection

@section('content')
<section class="contact-detail">
  <div class="inner">
    <h2 class="section-title">お問い合わせ詳細</h2>
    <table class="table">
      <tr>
        <th>名前</th>
        <td>{{ $contact->name }}</td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td><a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></td>
      </tr>
      <tr>
        <th>メッセージ</th>
        <td>{{ $contact->message }}</td>
      </tr>
      <tr>
      <tr>
        <th>ステータス</th>
        <td>
          <span style="color: {{ $contact->status == 'unresolved' ? 'red' : ($contact->status == 'in_progress' ? 'green' : 'blue') }}">
            {{ $contact->status == 'unresolved' ? '未対応' : ($contact->status == 'in_progress' ? '対応中' : '完了') }}
          </span>
        </td>
      </tr>

      <tr>
        <th>日付</th>
        <td>{{ $contact->created_at->format('Y-m-d') }}</td>
      </tr>
    </table>
    <a href="javascript:history.back();" class="detail-link">戻る</a>
  </div>
</section>
@endsection