<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use SEOMeta;

class NewsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SEOMeta::setTitle('新闻中心');
        SEOMeta::setDescription('新闻中心');
        SEOMeta::addKeyword('新闻中心');

        $cats = NewsCategory::all();

        foreach ($cats as $key => $value) {
            //  分类下的前5个文章
            $results[$value->id] = News::where('news_category_id', $value->id)->orderBy('id', 'DESC')->paginate(6);
        }

        return view('web.news.index', compact('results', 'cats'));
    }

    public function index2()
    {
        SEOMeta::setTitle('新闻列表V2');
        SEOMeta::setDescription('新闻列表V2');
        SEOMeta::addKeyword('新闻列表V2');

        $cats = NewsCategory::all();

        foreach ($cats as $key => $value) {
            $results[$value->id] = News::where('news_category_id', $value->id)->orderBy('id', 'DESC')->paginate(6);
        }

        return view('web.news.index2', compact('results', 'cats'));
    }

    public function list($news_category_id)
    {
        $results = News::where('news_category_id', $news_category_id)
            ->orderBy('id', 'DESC')->paginate(6);
        $news_category  =  NewsCategory::where('id', $news_category_id)->first();

        SEOMeta::setTitle($news_category->name);
        SEOMeta::setDescription($news_category->permalink);
        SEOMeta::addKeyword($news_category->name);

        return view('web.news.list', compact('results'));
    }

    public function detail($id)
    {
        $item = News::find($id);
        SEOMeta::setTitle($item->seo_title);
        SEOMeta::setDescription($item->seo_description);
        SEOMeta::addKeyword($item->seo_keywords);
        return view('web.news.detail', ['item'=>$item]);
    }

    public function search(Request $request)
    {

        SEOMeta::setTitle('搜索页面');
        SEOMeta::setDescription('搜索页面');
        SEOMeta::addKeyword('搜索页面');

        $keyword = $request->input('keyword');
        $results = News::when($keyword, function ($query) use ($keyword) {
            return $query->where('title', 'like', '%'.$keyword.'%');
        })->orderBy('id', 'desc')->paginate(5);

        return view('web.news.list_search', ['results'=>$results]);
    }
}
