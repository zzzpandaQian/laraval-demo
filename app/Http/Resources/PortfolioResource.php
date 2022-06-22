<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PortfolioResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    // 'status'
    public function toArray($request)
    {
        return [
            'id'                    => $this->id,
            'title'                 => $this->title,
            'image_url'             => $this->imageUrl,
            'sub_title'             => $this->sub_title,
            'more_images_url'       => $this->more_images_url,
            'more_images_url_thumb' => $this->more_images_url_thumb,
            'content'               => $this->content,
            'status'                => $this->status,
        ];
    }
}
