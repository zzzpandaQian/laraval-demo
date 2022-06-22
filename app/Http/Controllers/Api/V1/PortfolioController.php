<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Portfolio;
use App\Http\Resources\PortfolioResource;

class PortfolioController extends ApiController
{
    public function index()
    {
        $portfolio = Portfolio::orderBy("id", 'DESC')->where('status', 1)->get();

        return $this->collection(PortfolioResource::collection($portfolio));
    }

    public function detail($id)
    {
        $portfolio = Portfolio::where('id', $id)->first();

        return $this->success(new PortfolioResource($portfolio));
    }
}
