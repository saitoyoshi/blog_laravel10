<x-layouts.layout>
    <x-slot:title>
        投稿一覧
    </x-slot:title>

@if(request()->has('tagname'))<a href="/post">投稿一覧</a>@endif
    <a href="{{ route('post.create') }}">投稿する</a>
    @if(session('message'))
        <p class="text-info">{{ session('message') }}</p>
    @endif
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
                <a href="/post?tagname={{ $tag->name }}">{{ $tag->name }}</a>
            @endforeach
        </li>
    </ul>
  @endforeach
    <div>{{ $posts->links() }}</div>
</x-layouts>
