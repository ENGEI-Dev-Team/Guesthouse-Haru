@extends('layouts.admin_layout')

@section('title', 'ブログ編集')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<link rel="stylesheet" href="{{ asset('css/blog_edit.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<section class="edit-blog">
  <div class="inner">
    @if ($errors->any())
    <div class="error-message">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    
    <h2 class="section-title">ブログ編集</h2>
    <form action="{{ route('admin.blogUpdate', $blog->id) }}" method="post" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group">
        @if ($blog->image)
        <div class="blog-edit-image-container">
          <img src="{{ asset('storage/' . $blog->image) }}" alt="{{ $blog->title }}" class="blog-edit-image">
        </div>
        @endif
        <label for="image">画像:</label>
        <input type="file" name="image" id="image" class="form-input">
      </div>

      <div class="form-group">
        <label for="category">カテゴリー:</label>
        <select name="categories[]" id="category" multiple class="select">
          @foreach ($categories as $category)
          <option value="{{ $category->id }}">{{ $category->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="title">タイトル:</label>
        <input type="text" name="title" id="title" value="{{ old('title', $blog->title) }}" class="form-input" required>
      </div>

      <div class="form-group">
        <label for="content">内容:</label>
        <textarea name="content" id="content" class="form-input" required>{{ old('content', $blog->content) }}</textarea>
      </div>

      <button type="submit" class="submit-button">更新</button>
    </form>
  </div>
</section>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.select').select2({
      multiple: true,
      placeholder: "カテゴリを選択 (複数可)",
      allowClear: true
    });
  });
</script>
@endsection