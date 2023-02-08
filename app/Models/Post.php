<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'published',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function articles() {
        return $this->belongsToMany(Article::class);
    }

    public function like() {
        return $this->belongsToMany(User::class);
    }

    // 指定されたユーザーがこの投稿をお気に入り登録しているか
    public function isLiked($user){
        return $this->like()->where('user_id', $user->id)->exists();
    }

    // 公開中の投稿だけに絞り込む
    public function scopeSearchPublished($query) {
        return $query->where('published', 1);
    }
}
