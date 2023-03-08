<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class FollowController extends Controller
{
    public function follow(User $user)
    {
        if(!$user->isFollowing(Auth::id())) {
            Auth::user()->follows()->attach($user->id);
        }
        return Redirect::back();
    }

    public function unfollow(User $user)
    {
       Auth::user()->follows()->detach($user->id);
       return Redirect::back();
    }

    public function get_followers(User $user)
    {
        $users = $user->followers;
        return UserResource::collection($users);
    }

    public function get_follows(User $user)
    {
        $users = $user->follows;
        return UserResource::collection($users);
    }
}
