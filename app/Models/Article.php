<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'url',
        'title',
        'description',
        'thumbnail_url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function is_liked($user)
    {
        return $user
            ? (bool) $this->users()->where('user_id', $user->id)->count()
            : false;
    }

    public function getTitleAttribute($value)
    {
        if(empty($value)) {
            return 'No Title';
        }
        return mb_strimwidth($value, 0, 80, '...');
    }

    public function getDescriptionAttribute($value)
    {
        $value = preg_replace('/^[\s　]+/u', '', $value); // 先頭の全角・半角スペース除去
        $value = preg_replace('/[\s　]+$/u', '', $value); // 最後の全角・半角スペース除去
        return mb_strimwidth($value, 0, 150, '...');
    }

    public function getThumbnailUrlAttribute($value) 
    {
        if(empty($value)) {
            return url('images/no_image_available.png'); // サムネイル画像がないとき
        }
        return $value;
    }


    public function setAttributes($url) 
    {
        $this->url = $url;
        try {
            // urlから情報を取得
            $html = file_get_contents($url);
        } catch (\Exception $e) {
            return false;
        }

        $default_libxml_error = libxml_use_internal_errors(true); // libxml エラー設定を変更

        $doc = new \DOMDocument();
        $doc->loadHTML($html);

        libxml_use_internal_errors($default_libxml_error); // libxml　エラー状態を元にもどす

        $tags = $doc->getElementsByTagName('meta');
        $attributes = [
            'title' => '',
            'thumbnail_url' => '',
            'description' => ''
        ];

        foreach($tags as $tag) {
            if($tag->hasAttribute('property') && $tag->hasAttribute('content')) { // 必要なデータを集める
                $property = $tag->getAttribute('property');
                $content = $tag->getAttribute('content');
                if($property === 'og:title') {
                    $attributes['title'] = $content;
                } else if($property === 'og:image') {
                    $attributes['thumbnail_url'] = $content;
                } else if($property === 'og:description') {
                    $attributes['description'] = $content;
                }

            } else if($tag->hasAttribute('name')) {
                $property = $tag->getAttribute('name');
                $content = $tag->getAttribute('content');
                if(empty($attributes['description']) && $property === 'description') { // og:descriptionがないときの保険
                    $attributes['description'] = $content;
                }
            }
        }

        if(empty($attributes['title'])) { // og:titleがないときの保険
            $titles = $doc->getElementsByTagName('title');
            if(count($titles) > 0) {
                $title = $titles[0];
                $attributes['title'] = $title->textContent;
            }
        }

        $this->fill($attributes);
        return true;

    }
}
