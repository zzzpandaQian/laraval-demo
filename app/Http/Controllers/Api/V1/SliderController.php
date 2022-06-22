<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Slider;
use App\Http\Resources\SliderResource;

class SliderController extends ApiController
{
    public function index()
    {
        $slider = Slider::where('status', 1)->orderBy('sort_order', 'DESC')->get();

        return $this->collection(SliderResource::collection($slider));
    }
}
