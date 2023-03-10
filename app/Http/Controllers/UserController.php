<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleDetailResource;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * ユーザーページを表示
     */
    public function index(Request $request, User $user)
    {
        $type = $request->query('type');

        $articles = null;
        
        if($type === 'favorite') {
            $articles = $user
                ->like()
                ->paginate(30);
        }else {
            $articles = $user
                ->articles()
                ->paginate(30);
        }

        return Inertia::render('User/Index', [
            'articles' => ArticleDetailResource::collection($articles),
            'user' => new UserResource($user),
            'type' => $type
        ]);
    }
}
