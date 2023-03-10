<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ArticleDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'title2' => $this->title2,
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
            'thumbnail_url' => $this->thumbnail_url,
            'is_liked' => $this->is_liked(Auth::user()),
            'updated_at' => $this->updated_at,
            'user' => new UserResource($this->user),
            'tags' => $this->tags,
        ];
    }
}
