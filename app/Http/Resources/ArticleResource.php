<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'created_at' => $this->created_at,

            'slug' => $this->slug,
            'title' => $this->title,

            'categories' => ArticleCategoryResource::collection($this->whenLoaded('categories')),
            'media' => ArticleMediaResource::collection($this->whenLoaded('media')),
            'contents' => ArticleContentResource::collection($this->whenLoaded('contents')),
        ];
    }
}
