<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use App\Models\News;

class NewsResource extends Resource
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
        $tag = [];
        foreach ($this->tags()->pluck('news_tags.name')->toArray() as $value) {
            $tag[] = $value;
        }
        return [
            'id'                 => $this->id,
            'title'              => $this->title,
            'news_category_id'   => $this->news_category_id,
            'news_category_name' => optional($this->newsCategory)->name,
            'tag'                => $tag,
            'image_url'          => $this->imageUrl,
            'image_thumb'        => $this->image_thumbnail_small_url,
            'short'              => $this->short,
            'content'            => $this->content,
            'read_count'         => $this->read_count,
            'created_at'         => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'status'             => $this->status
        ];
    }
}
