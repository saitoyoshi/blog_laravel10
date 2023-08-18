<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
    <a href="{{ route('post.create') }}">投稿</a>
  @foreach($posts as $post)
    <ul>
        <li>タイトル：<a href="{{ route('post.show', $post) }}">{{ $post->title }}</a></li>
        <a href="{{ route('post.edit', $post) }}"><button>更新</button></a>
        <form action="{{ route('post.destroy', $post) }}" method="post">
            @csrf
            @method('delete')
            <button>削除</button>
        </form>
        <li>Posted by {{ $post->user->name }} on {{ $post->updated_at->diffForHumans() }}</li>
        <li>タグ:
            @foreach ($post->tags as $tag)
                {{ $tag->name }}
            @endforeach
        </li>
    </ul>
  @endforeach
</body>
</html>
