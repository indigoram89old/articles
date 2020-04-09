<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleMediaResource extends JsonResource
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
            'file' => $this->file,
            'slug' => $this->slug,
            'link' => $this->link,
            
            'copyright' => $this->copyright,
            'caption' => $this->caption,
            'width' => $this->width,
            'height' => $this->height,
            
            'type' => $this->when($this->pivot, function () {
                return $this->pivot->type;
            }),
        ];
    }
}
