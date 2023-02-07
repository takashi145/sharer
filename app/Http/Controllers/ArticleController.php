<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ArticleController extends Controller
{
     /**
     * 記事の保存
     */
    public function store(Request $request, Post $post)
    {
        DB::beginTransaction();
        try {
            $article = null;
            $article = Article::FirstOrNew([
                'url' => $request->input('url')
            ]);
            $isExists = $article->exists();
            $dt_ago = now()->subMonth();

            if(!$isExists || ($isExists && $article->updated_at < $dt_ago)) {
                if($article->setAttributes($request->input('url'))){
                    $article->updated_at = now();
                    $article->save();
                }
            }
            $article->posts()->sync($post->id);
            DB::commit();
            return to_route('post.show', $post->id);
        }catch(\Exception $e) {
            DB::rollBack();
            dd($e);
        }

    }

    public function destroy(Post $post, Article $article)
    {
        $article->posts()->detach($post->id);
        return back();
    }
}
