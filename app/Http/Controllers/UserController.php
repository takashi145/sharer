<?php

namespace App\Http\Controllers;

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
                ->get();
        }else {
            $articles = $user
                ->load('like')
                ->articles()
                ->get();
        }

        return Inertia::render('User/Index', [
            'articles' => ArticleResource::collection($articles),
            'user' => new UserResource($user),
            'type' => $type
        ]);
    }
}