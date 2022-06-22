<?php

namespace App\Http\Controllers\Api\V1;

use SEOMeta;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends ApiController
{
    public function index($slug)
    {
        $pages = Page::where("permalink", $slug)->first();
        return $this->success($pages);
    }
}
