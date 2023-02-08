<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ArticleController extends Controller
{
     /**
     * 記事の保存
     * 
     * @param App\Http\Requests\StoreArticleRequest $request
     * @param App\Models\Post $post
     */
    public function store(StoreArticleRequest $request, Post $post)
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
            return to_route('post.edit', $post->id)
            ->with('flash', [
                'status' => 'success',
                'message' => '記事を追加しました。',
            ]);
        }catch(\Exception $e) {
            DB::rollBack();
            return back()
            ->with('flash', [
                'status' => 'error',
                'message' => 'リンクの追加に失敗しました。'
            ]);
        }
    }

    /**
     * 指定された投稿(post)と記事(article)の紐づけを削除
     * 
     * @param App\Models\Post $post
     * @param App\Models\Article $article
     */
    public function destroy(Post $post, Article $article)
    {
        DB::beginTransaction();
        try {
            $article->posts()->detach($post->id);
            if(count($post->articles) === 0) {
                $post->published = false;
                $post->save();
            }
            DB::commit();
        }catch(\Exception $e) {
            DB::rollBack();
            return false;
        }

        return to_route('post.edit', $post->id)->with('flash', [
                'status' => 'error',
                'message' => '記事を削除しました。',
            ]);
    }
}
