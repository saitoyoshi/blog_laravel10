<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostFormRequest;
use App\Http\Requests\PutFormRequest;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View {
        $tagname = $request->input('tagname');
        if ($tagname) {
            $posts = Post::whereHas('tags', function ($query) use ($tagname) {
                $query->where('name', $tagname);
            })->get();
        } else {
            $posts = Post::orderBy('updated_at', 'desc')->get();
        }
        return view('post.index', compact('posts'));
    }
    public function create(): View {
        return view('post.create');
    }

    private function getTagNames(?string $tagsString): array {
        // 半角と全角のスペースを半角スペースひとつに置換する
        $tags = str_replace('　', ' ', trim($tagsString));
        $tags = preg_replace('/\s+/', ' ', $tags);
        return explode(" ", $tags);
    }
    public function store(PostFormRequest $request): RedirectResponse {
        return DB::transaction(function () use ($request) {
            $post = new Post();
            $post->user_id = Auth::user()->id;
            $post->title = $request->title;
            $post->content = $request->content;

            $post->save();
            $tags = str_replace('　', ' ', trim($request->tags));

            $tags = $this->getTagNames($request->tags);
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

        });
    }

    public function show(Post $post): View {
        return view('post.show', compact('post'));
    }

    public function edit(Post $post): View {
        return view('post.edit', compact('post'));
    }

    public function update(PutFormRequest $request, Post $post): RedirectResponse {
        return DB::transaction(function () use ($request, $post) {

            $post->title = $request->title;
            $post->content = $request->content;

            $post->update();

            $newTagNames = $this->getTagNames($request->tags);
            $newTags = [];
            foreach ($newTagNames as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $newTags[] = $tag->id;
            }
            $post->tags()->sync($newTags);


            return redirect(route('post.index'))->with('message', $post->title . 'を更新しました');
        });
    }

    public function destroy(Post $post): RedirectResponse {
        DB::transaction(function () use ($post) {
            $post->tags()->detach();
            $post->delete();
        });
        return redirect(route('post.index'))->with('message', $post->title . 'を削除しました');
    }
}
