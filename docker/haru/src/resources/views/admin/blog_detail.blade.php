@extends('layouts.admin_layout')

@section('title', 'ブログ詳細ページ')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
<link rel="stylesheet" href="{{ asset('css/blog_detail.css') }}">
@endsection

@section('content')
<section class="blog-detail">
  <div class="inner">
    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    
    <div class="blog-container">
      @if (session('update_success'))
      <div class="alert alert-success">
        {{ session('update_success') }}
      </div>
      @endif
      @if (session('create_success'))
      <div class="alert alert-success">
        {{ session('create_success') }}
      </div>
      @endif
      @if (session('delete_success'))
      <div class="alert alert-success">
        {{ session('delete_success') }}
      </div>
      @endif

      <div class="blog-img">
        @if ($blog->image)
        <img src="{{ Storage::url($blog->image) }}" alt="{{ $blog->title }}">
        @endif

      </div>
      <div class="contents">
        <h3 class="blog-title">{{ $blog->title }}</h3>
        <p class="blog-content">{{ $blog->content }}</p>
        <p class="blog-date">{{ $blog->created_at->format('F d, Y') }}</p>
        <div class="blog-actions">
          <a href="{{ route('admin.blogEdit', $blog) }}" class="edit-button">編集</a>

          <form action="{{ route('admin.blogDelete', $blog) }}" method="post" class="delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="delete-button">削除</button>
          </form>
        </div>
      </div>
    </div>

    <div class="comments">
      <div class="comment-post">
        <h4 class="comment-title">Comment this post</h4>
        <form action="{{ route('comments.store', $blog->id) }}" method="post" class="comment-form">
          @csrf
          <div class="form-group">
            <label for="author">Name</label>
            <input type="text" name="author" id="author" required>
          </div>
          <div class="form-group">
            <label for="content">Comment</label>
            <textarea name="content" id="content" required></textarea>
          </div>
          <button type="submit">Submit</button>
        </form>
      </div>
    </div>

    <div class="comments">
      @if (session('comment_success'))
      <div class="alert alert-success">
        {{ session('comment_success') }}
      </div>
      @endif
      <div class="comment-lists">
        <h4 class="comment-title">Comment lists</h4>
        <ul class="comment-item">
          @forelse ($blog->comments as $comment)
          <li>
            <div class="comment-header">
              <p class="commenter-name">{{ $comment->author }}</p>
              <div class="comment-actions">
                <span class="comment-date">{{ $comment->created_at->format('F d, Y') }}</span>
                <form action="{{ route('comments.destroy', $comment) }}" method="post" class="delete-form">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="delete-button">削除</button>
                </form>
              </div>
            </div>
            <p class="comment-content">{{ $comment->content }}</p>
          </li>
          @empty
          <li>There is no comment yet</li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</section>
@endsection