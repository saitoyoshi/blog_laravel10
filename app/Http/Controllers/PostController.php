<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View {
        $posts = Post::all();
        return view('post.index', compact('posts'));
    }
    public function create(): View {
        return view('post.create');
    }

    public function store(PostFormRequest $request): RedirectResponse {
        $post = new Post();
        $post->user_id = Auth::user()->id;
        $post->title = $request->title;
        $post->content = $request->content;

        $post->save();
        // 半角と全角のスペースを半角スペースひとつに置換する
        $tags = str_replace('　', ' ', trim($request->tags));
        $tags = preg_replace('/\s+/', ' ', $tags);
        $tags = explode(" ", $tags);
        foreach ($tags as $tagname) {
            // すでに同じ名前のタグが存在するかをチェック
            $tag = Tag::where('name', $tagname)->first();
            if (!$tag) {
                $tag = new Tag();
                $tag->name = $tagname;
                $tag->save();
            }

            // タグが投稿に関連づけられていない場合のみ関連づける
            if (!$post->tags->contains($tag->id)) {
                $post->tags()->attach($tag->id);
            }
        }
        return redirect(route('post.index'))->with('message', $post->title . 'を投稿しました');
    }

    public function show(Post $post): View {
        return view('post.show', compact('post'));
    }
}
