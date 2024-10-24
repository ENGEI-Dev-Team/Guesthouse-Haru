@extends('layouts.admin_layout')

@section('title', 'ブログ一覧')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/blog_lists.css') }}">
@endsection

@section('content')
<section class="blogs-filter">
  <div class="inner">
    <h2 class="section-title">Blog lists</h2>
    <form action="{{ route('admin.blogLists') }}" method="get" class="filter-form">
      <div class="form-group">
        <input type="text" name="keyword" id="keyword" value="{{ request('keyword') }}" placeholder="Keyword...">
      </div>

      <div class="form-group">
        <select name="category" id="category">
          <option value="">Category</option>
          @foreach ($categories as $category)
          <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <select name="order" id="order">
          <option value="newest" {{ request('order') == 'newest' ? 'selected' : '' }}>Newest</option>
          <option value="oldest" {{ request('order') == 'oldest' ? 'selected' : '' }}>Oldest</option>
        </select>
      </div>

      <button type="submit" class="filter-button">Search</button>
      <a href="{{ route('admin.blogLists') }}" class="filter-button">All</a>
    </form>
  </div>
</section>

<section class="blog-lists">
  <div class="inner">
    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif
    <div class="blog-container">
      @foreach ($blogs as $blog)
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
  </div>
</section>