<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * ユーザーページを表示
     */
    public function index(User $user)
    {
        $posts = null;
        // ログインユーザーの場合は非公開の投稿も取得
        if(Auth::id() === $user->id) {
            $posts = Auth::user()->posts()->with('like')->get();
        }else {
            $posts = $user->posts()->where('published', '=', 1)->get();
        }

        return Inertia::render('User/Index', [
            'posts' => $posts,
            'user' => $user,
        ]);
    }
}
