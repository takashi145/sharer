<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }

    /**
     * 投稿一覧を表示
     */
    public function index()
    {
        $posts = Post::with('user')->where('published', '=', 1)->get();
        return Inertia::render('Post/Index', [
            'posts' => $posts
        ]);
    }

    /**
     * 投稿作成画面を表示
     */
    public function create()
    {
        return Inertia::render('Post/Create');
    }

    /**
     * 投稿を保存
     * 
     * @param App\Http\Requests\StorePostRequest $request
     */
    public function store(StorePostRequest $request)
    {
        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'published' => 1
        ]);

        return to_route('post.show', $post->id)
            ->with('flash', [
                'status' => 'success',
                'message' => '投稿を作成しました。',
            ]);
    }

     /**
     * 投稿詳細画面を表示
     */
    public function show(Post $post)
    {
        return Inertia::render('Post/Show', [
            'post' => $post->load('articles'),
        ]);
    }

     /**
     * 投稿編集画面を表示
     */
    public function edit(Post $post)
    {
        return Inertia::render('Post/Edit', [
            'post' => $post->load('articles'),
        ]);
    }


     /**
     * 投稿を編集
     */
    public function update(Request $request, Post $post)
    {
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->save();

        return to_route('post.show', $post->id)
            ->with('flash', [
                'status' => 'success',
                'message' => '更新しました。'
            ]);
    }


     /**
     * 投稿を削除
     */
    public function destroy(Post $post) {
        $post->delete();
        return to_route('post.index')
            ->with('flash', [
                'status' => 'error',
                'message' => '投稿を削除しました。',
            ]);
    }
}
