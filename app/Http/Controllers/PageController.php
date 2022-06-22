<?php

namespace App\Http\Controllers;

use SEOMeta;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index($page)
    {

        $pages=Page::where("permalink", $page)->first();

        SEOMeta::setTitle($pages->seo_title);
        SEOMeta::setDescription($pages->seo_description);
        SEOMeta::addKeyword($pages->seo_keywords);

        return view('web.page.index', compact('pages'));
    }

    public function message()
    {

        return view('web.page.message', compact('message'));
    }
}
