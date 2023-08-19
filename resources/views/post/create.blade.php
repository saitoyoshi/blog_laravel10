<x-layouts.layout>
    <x-slot:title>
        投稿画面
    </x-slot:title>
<div class="mb-4">
<a href="{{ route('post.index') }}">戻る</a>
</div>
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <p class="text-danger">{{ $error }}</p>
        @endforeach
    @endif
  <form action="{{ route('post.store') }}" method="POST">
    @csrf
    <div class="mb-3">
    <label for="title" class="form-label">タイトル</label>
    <input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control">
</div>
<div class="mb-3">
    <label for="content" class="form-label">本文</label>
    <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ old('content') }}</textarea>
</div>
<div class="mb-3">
    <label for="tags" class="form-label">タグ(複数の場合空白で区切ること)</label>
    <input type="text" id="tags" name="tags" value="{{ old('tags') }}" class="form-control">
</div>
<button class="btn btn-primary">投稿</button>
</form>
</x-layouts.layout>
