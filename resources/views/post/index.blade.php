<x-layouts.layout>
    <x-slot:title>
        投稿一覧
    </x-slot:title>
<div class="mb-3">
@if(request()->has('tagname'))<a href="/post">投稿一覧に戻る</a>@endif
</div>
    <div class="mb-4"><a href="{{ route('post.create') }}">投稿する</a></div>
    @if(session('message'))
        <p class="text-info">{{ session('message') }}</p>
    @endif
  @foreach($posts as $post)
  <div class="card border mb-3">
    <div class="card-body">
        <h5 class="card-title"><a class="text-dark d-block" href="{{ route('post.show', $post) }}">{{ $post->title }}</a></h5>
        @if (\illuminate\Support\Facades\Auth::id() === $post->user_id)
        <div class="">
        <a href="{{ route('post.edit', $post) }}"><button class="btn btn-primary btn-sm">更新</button></a>
        <form class="ms-2 d-inline" action="{{ route('post.destroy', $post) }}" method="post" onsubmit="return confirm('本当に削除していいですか？')">
            @csrf
            @method('delete')
            <button class="btn btn-danger btn-sm">削除</button>
        </form>
    </div>
        @else
        <small class="card-text text-info">編集できません</small>
        @endif
        <p class="card-text">Posted by {{ $post->user->name }} on {{ $post->updated_at->diffForHumans() }}</p>
        <p class="card-text">タグ:
            @foreach ($post->tags as $tag)
                <a href="/post?tagname={{ $tag->name }}">{{ $tag->name }}&nbsp;&nbsp;</a>
            @endforeach
        </p>
    </div>
</div>
  @endforeach
    <div>{{ $posts->links() }}</div>
</x-layouts>
