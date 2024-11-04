@extends('layouts.admin_layout')

@section('title', 'お問い合わせ詳細ページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/contactDetail.css') }}">
@endsection

@section('content')
<section class="contact-detail">
  <div class="inner">
    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    <div class="alert alert-error">
      {{ session('error') }}
    </div>
    @endif

    <h2 class="section-title">お問い合わせ詳細</h2>
    <table class="table">
      <tr>
        <th>名前</th>
        <td>{{ $contact->getName() }}</td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td><a href="mailto:{{ $contact->getEmail() }}">{{ $contact->getEmail() }}</a></td>
      </tr>
      <tr>
        <th>メッセージ</th>
        <td>{{ $contact->getMessage() }}</td>
      </tr>
      <tr>
      <tr>
        <th>ステータス</th>
        <td>
          <span style="color: {{ $contact->getStatus() == 'unresolved' ? 'red' : ($contact->getStatus() == 'in_progress' ? 'green' : 'blue') }}">
            {{ $contact->getStatus() == 'unresolved' ? '未対応' : ($contact->getStatus() == 'in_progress' ? '対応中' : '完了') }}
          </span>
        </td>
      </tr>

      <tr>
        <th>日付</th>
        <td>{{ $contact->getCreatedAt()->format('Y-m-d') }}</td>
      </tr>
    </table>
    <div class="btn-action">
      <a href="javascript:history.back();" class="detail-link">戻る</a>
      <form action="{{ route('admin.contactDelete', $contact->getId()) }}" method="post" class="delete-form">
        @csrf
        @method('DELETE')
        <button type="submit" class="detail-link delete-button">削除</button>
      </form>
    </div>
  </div>
</section>
@endsection