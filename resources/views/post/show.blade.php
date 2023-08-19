<x-layouts.layout>
    <x-slot:title>
        詳細画面
    </x-slot:title>
    <div class="mb-4">
<a href="{{ route('post.index') }}">戻る</a>
</div>
    <ul>
        <li>タイトル：{{ $post->title }}</li>
        <p>本文:{!! nl2br(htmlspecialchars($post->content)) !!}</p>
        <li>Posted by {{ $post->user->name }} on {{ $post->updated_at->diffForHumans() }}</li>
        <li>タグ:
            @foreach ($post->tags as $tag)
                {{ $tag->name }}
            @endforeach
        </li>
    </ul>
</x-layouts.layout>
