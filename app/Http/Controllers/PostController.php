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
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PostController extends Controller
{
    public function index(Request $request): View {
        $tagname = $request->input('tagname');
        if ($tagname) {
            $postsQueryBuilder = Post::whereHas('tags', function ($query) use ($tagname) {
                $query->where('name', $tagname);
            });
        } else {
            $postsQueryBuilder = Post::orderBy('updated_at', 'desc');
        }
        $posts = $postsQueryBuilder->paginate(15);
        return view('post.index', compact('posts', 'request'));
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

    public function edit(Request $request, Post $post): View {
        if (!$this->checkOwnPost($request->user()->id, $post->id)) {
            throw new AccessDeniedHttpException();
        }
        return view('post.edit', compact('post'));
    }
    private function checkOwnPost(int $userId, int $postId): bool {
        $post = Post::where('id', $postId)->first();
        if (!$post) {
            return false;
        }
        return $post->user_id === $userId;
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

    public function destroy(Request $request, Post $post): RedirectResponse {
        if (!$this->checkOwnPost($request->user()->id, $post->id)) {
            throw new AccessDeniedHttpException();
        }
        DB::transaction(function () use ($post) {
            $post->tags()->detach();
            $post->delete();
        });
        return redirect(route('post.index'))->with('message', $post->title . 'を削除しました');
    }
}
