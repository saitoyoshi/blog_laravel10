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
    <ul>
        <li>タイトル：{{ $post->title }}</li>
        <p>本文:{{ $post->content }}</p>
        <li>Posted by {{ $post->user->name }} on {{ $post->updated_at->diffForHumans() }}</li>
        <li>タグ:
            @foreach ($post->tags as $tag)
                {{ $tag->name }}
            @endforeach
        </li>
    </ul>
</body>
</html>
