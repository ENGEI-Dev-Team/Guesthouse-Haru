@extends('layouts.admin_layout')

@section('title', 'ブログ作成')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/create_blog.css') }}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
<section class="create-blog">
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

    <h2 class="section-title">ブログ作成</h2>
    <form action="{{ route('admin.blog.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label for="image">画像:</label>
        <input type="file" name="image" id="image" class="form-input">
      </div>

      <div class="form-group">
        <label for="category">カテゴリー:</label>
        <div class="category-select">
          <select name="categories[]" id="category" multiple class="select">
            @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="title">タイトル:</label>
        <input type="text" name="title" id="title" class="form-input" value="{{ old('title') }}" required>
      </div>

      <div class="form-group">
        <label for="content">内容:</label>
        <textarea name="content" id="content" class="form-input" required>{{ old('content') }}</textarea>
      </div>
      <button type="submit" class="submit-button">作成</button>
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