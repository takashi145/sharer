<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ArticleController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    /**
     * 記事一覧を表示
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $tag_name = $request->query('tag');

        $tag = null;

        if($tag_name) {
            $tag = Tag::where('name', $tag_name)->first();
        }
        
        if($tag) {
            $articles = $tag->articles()->searchKeyword($keyword)->orderBy('id', 'desc')->get();
        }else {
            $articles = Article::searchKeyword($keyword)->orderBy('id', 'desc')->get();
        }

        return Inertia::render('Article/Index', [
            'articles' => ArticleResource::collection($articles),
            'tag_name' => $tag ? $tag->name : null,
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
            $article = Article::firstOrNew([
                'user_id' => Auth::id(),
                'url' => $request->input('url')
            ]);
            $isExists = $article->exists;

            $dt_ago = now()->subMonth();

            if(!$isExists || ($isExists && $article->updated_at < $dt_ago)) {
                if($article->setAttributes($request->input('url'))){
                    $article->updated_at = now();
                    $article->save();
                }
            }

            if(!$isExists) {
                $tags = array_unique($request->input('tags'));
                foreach($tags as $key => $tag_name) {
                    if($key >= 5) {
                        break;
                    }
                    $tag = Tag::firstOrCreate([
                        'name' => $tag_name
                    ]);

                    $article->tags()->attach($tag->id);
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
     * 記事を削除
     * 
     * @param App\Models\Article $article
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return Redirect::back()->with('flash', [
                'status' => 'error',
                'message' => '記事を削除しました。',
            ]);
    }
}
