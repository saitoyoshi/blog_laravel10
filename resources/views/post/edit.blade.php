<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
    <a href="{{ route('post.index') }}">戻る</a>
    @if($errors->any())
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif
  <form action="" method="POST">
    @csrf
    <div>
    <label for="">タイトル</label>
    <input type="text" name="title" value="{{ old('title', $post->title) }}">
</div>
<div>
    <label for="">本文</label>
    <textarea name="content" id="" cols="30" rows="10">{{ old('content', $post->content) }}</textarea>
</div>
<div>
    <label for="">タグ(複数の場合空白で区切ること)</label>
    <input type="text" name="tags" value="{{ old('tags',
        implode(" ", $post->tags->pluck('name')->toArray())
    ) }}">
</div>
<button>投稿</button>
  </form>
</body>
</html>
