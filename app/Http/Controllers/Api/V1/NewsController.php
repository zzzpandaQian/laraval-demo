<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use App\Http\Resources\NewsResource;

class NewsController extends ApiController
{
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $keyword = $request->input('keyword');
        $news_category_id = $request->news_category_id;


        $news = News::where('status', 1)
            ->when($keyword, function ($query) use ($keyword) {
                return $query->where('title', 'like', '%' . $keyword . '%');
            })
            ->when($news_category_id, function ($query) use ($news_category_id) {
                return $query->where('news_category_id', $news_category_id);
            })
            ->orderBy('id', 'desc')
            ->paginate($limit);

        return NewsResource::collection($news)->additional([
            "status" => "success",
            "code" => 200,
        ]);
    }

    public function detail($id)
    {
        // $user = auth('api')->user();
        $news = News::find($id);
        return $this->success(new NewsResource($news));
    }

    public function index2(Request $request)
    {
        $limit            = $request->input('limit', 10);
        $keyword          = $request->input('keyword');
        $news_category_id = $request->input('news_category_id');

        if ($news_category_id) {
            $results = News::when($keyword, function ($query) use ($keyword) {
                return $query->where('title', 'like', '%' . $keyword . '%');
            })->where('news_category_id', $news_category_id)
                ->orderBy('id', 'DESC')->paginate($limit);
        } else {
            $news_category = NewsCategory::all();
            foreach ($news_category as $key => $value) {
                $results = News::when($keyword, function ($query) use ($keyword) {
                    return $query->where('title', 'like', '%' . $keyword . '%');
                })->where('news_category_id', $value->id)->orderBy('id', 'DESC')->paginate($limit);
            }
        }

        return $this->collection(NewsResource::collection($results));
    }


    public function category()
    {
        $news_category = NewsCategory::where('status', 1)->get();
        return $this->success($news_category);
    }
}
