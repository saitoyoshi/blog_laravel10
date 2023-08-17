<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
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
}
