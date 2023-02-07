<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ArticleController extends Controller
{
     /**
     * 記事の保存
     */
    public function store(Request $request, Post $post)
    {
        $article = null;
        $article = Article::FirstOrNew([
            'url' => $request->input('url')
        ]);
        $isExists = $article->exists();
        $dt_ago = now()->subMonth();

        if(!$isExists || ($isExists && $article->updated_at < $dt_ago)) {
            if($article->setAttributes($request->input('url'))){
                $article->post_id = $post->id;
                $article->updated_at = now();
                $article->save();
            }
        }

        return to_route('post.show', $post->id);
    }

    public function destroy(Post $post, Article $article)
    {
        dd($post);
        $article->delete();
        return back();
    }
}
