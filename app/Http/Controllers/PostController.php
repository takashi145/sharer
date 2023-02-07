<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * 投稿一覧を表示
     */
    public function index()
    {
        $posts = Post::with('user')->get();
        return Inertia::render('Post/Index', [
            'posts' => $posts
        ]);
    }
}
