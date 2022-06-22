<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SliderResource extends Resource
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
            'id'          => $this->id,
            'title'       => $this->title,
            'image_url'   => $this->imageUrl,
            'link'        => $this->link,
            'description' => $this->description,
            'button'      => $this->button,
            'light'       => $this->light,
            'position'    => $this->position,
            'sort_order'  => $this->sort_order,
        ];
    }
}
