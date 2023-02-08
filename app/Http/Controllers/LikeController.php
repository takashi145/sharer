<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LikeController extends Controller
{
    /**
     * 投稿をお気に入り登録する
     */
    public function like(Post $post)
    {
        $post->like()->sync(Auth::id());
        return Redirect::back();
    }

    /**
     * お気に入り登録を解除する
     */
    public function unlike(Post $post)
    {
        Auth::user()->like()->detach($post->id);
        return Redirect::back();
    }
}
