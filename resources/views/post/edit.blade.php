<x-layouts.layout>
    <x-slot:title>
        更新画面
    </x-slot:title>
    <div class="mb-4">
<a href="{{ route('post.index') }}">戻る</a>
</div>
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif
  <form action="{{ route('post.update', $post) }}" method="POST">
    @csrf
    @method('put')
    <div class="mb-3">
    <label for="title" class="form-label">タイトル</label>
    <input class="form-control" id="title" type="text" name="title" value="{{ old('title', $post->title) }}">
</div>
<div class="mb-3">
    <label for="content" class="form-label">本文</label>
    <textarea name="content" id="content" cols="30" rows="10" class="form-control">{{ old('content', $post->content) }}</textarea>
</div>
<div class="mb-3">
    <label for="tags" class="form-label">タグ(複数の場合空白で区切ること)</label>
    <input class="form-control" id="tags" type="text" name="tags" value="{{ old('tags',
        implode(" ", $post->tags->pluck('name')->toArray())
    ) }}">
</div>
<button class="btn btn-primary">更新</button>
  </form>
</x-layouts.layout>
