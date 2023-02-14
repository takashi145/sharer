<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ArticleController extends Controller
{

    /**
     * 記事一覧を表示
     */
    public function index()
    {
        $articles = Article::all();
        return Inertia::render('Article/Index', [
            'articles' => ArticleResource::collection($articles),
        ]);
    }

     /**
     * 記事の保存
     * 
     * @param App\Http\Requests\StoreArticleRequest $request
     * @param App\Models\Post $post
     */
    public function store(StoreArticleRequest $request)
    {
        DB::beginTransaction();
        try {
            $article = null;
            $article = Article::FirstOrNew([
                'user_id' => Auth::id(),
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
            
            DB::commit();
            return to_route('articles.index')
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
     * 記事の更新
     */
    public function update(Request $request, Article $article)
    {
        $article->url = $request->url;
        $article->save();

        return to_route(back())->with('flash', [
            'status' => 'success',
            'message' => '更新しました。'
        ]);
    }

    /**
     * 記事を削除
     * 
     * @param App\Models\Article $article
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return to_route(back())->with('flash', [
                'status' => 'error',
                'message' => '記事を削除しました。',
            ]);
    }
}
