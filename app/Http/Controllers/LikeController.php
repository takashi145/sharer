<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LikeController extends Controller
{
    /**
     * 投稿をお気に入り登録する
     */
    public function like(Article $article)
    {
        $article->users()->detach(Auth::id());
        $article->users()->attach(Auth::id());
        return response()->noContent();
    }

    /**
     * お気に入り登録を解除する
     */
    public function unlike(Article $article)
    {
        Auth::user()->like()->detach($article->id);
        return response()->noContent();
    }
}
