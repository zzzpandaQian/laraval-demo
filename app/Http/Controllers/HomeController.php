<?php

namespace App\Http\Controllers;

use Mail;
use SEOMeta;
use App\Models\User;
use App\Models\Slider;
use App\Models\Dealers;
use App\Models\Partner;
use App\Models\SeoItem;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Http\Resources\PortfolioResource;

class HomeController extends Controller
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
    public function index(Request $request)
    {

        $seo = SeoItem::where('seo_url', '/')->first();
        if ($seo) {
            SEOMeta::setTitle($seo->seo_title);
            SEOMeta::addKeyword($seo->seo_keywords);
            SEOMeta::setDescription($seo->seo_description);
        }

        $dealers = Dealers::get()->toArray();
        $dealers = json_encode($dealers);

        $partner = Partner::orderBy("id", 'DESC')->where('status', 1)->get();
        $slider = Slider::where('status', 1)->orderBy('sort_order', 'asc')->get();

        return view('home', compact('slider', 'partner', 'dealers'));
    }

    public function single(Request $request)
    {

        $seo = SeoItem::where('seo_url', '/')->first();
        if ($seo) {
            SEOMeta::setTitle($seo->seo_title);
            SEOMeta::addKeyword($seo->seo_keywords);
            SEOMeta::setDescription($seo->seo_description);
        }
        $slider = Slider::where('status', 1)->orderBy('sort_order', 'asc')->get();
        return view('single', compact('slider'));
    }

    public function portfolio($id)
    {
        $portfolio = Portfolio::where('id', $id)->first();
        $data = new PortfolioResource($portfolio);
        echo json_encode($data);
        // return view('home', ['portfolios' => $portfolios]);

    }
}
