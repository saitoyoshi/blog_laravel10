<x-layouts.layout>
    <x-slot:title>
        詳細画面
    </x-slot:title>
    <div class="mb-4">
<a href="{{ route('post.index') }}">戻る</a>
</div>
    <ul class="list-group">
        <li class="list-group-item">タイトル:{{ $post->title }}</li>
        <p class="list-group-item">本文:<br><br>{!! nl2br(htmlspecialchars($post->content)) !!}</p>
        <li class="list-group-item">Posted by {{ $post->user->name }} on {{ $post->updated_at->diffForHumans() }}</li>
        <li class="list-group-item">タグ:
            @foreach ($post->tags as $tag)
            <a href="/post?tagname={{ $tag->name }}">{{ $tag->name }}&nbsp;&nbsp;</a>
            @endforeach
        </li>
    </ul>
</x-layouts.layout>
