<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use App\Http\Resources\PortfolioResource;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolio=Portfolio::orderBy("id", 'DESC')->where('status', 1)->get();

        return view('web.portfolio.index', compact('portfolio'));
    }

    public function detail($id)
    {
        $portfolio = Portfolio::where('id', $id)->first();
        $data = new PortfolioResource($portfolio);

        return view('web.portfolio.detail', compact('data'));
    }
}
