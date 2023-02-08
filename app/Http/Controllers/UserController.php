<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * ユーザーページを表示
     */
    public function index(Request $request, User $user)
    {
        $type = $request->query('type');

        $posts = null;
        
        if($type === 'favorite') {
            $posts = $user
                ->like()
                 // ログインユーザーではない場合は公開された投稿のみ取得
                ->when(Auth::id() !== $user->id, function ($query) {
                    $query->searchPublished();
                })
                ->get();
        }else {
            $posts = $user
                ->posts()
                ->with('like')
                ->when(Auth::id() !== $user->id, function ($query) {
                    $query->searchPublished();
                })
                ->get();
        }

        return Inertia::render('User/Index', [
            'posts' => PostResource::collection($posts),
            'user' => new UserResource($user),
            'type' => $type
        ]);
    }
}
