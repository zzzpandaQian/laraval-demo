<?php

namespace App\Http\Controllers\Api\V2;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use App\Http\Resources\NewsResource;

class NewsController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/v2/news",
     *     operationId="getNewsList",
     *     tags={"新闻v2"},
     *     summary="新闻列表",
     *     @OA\Parameter(
     *         name="page",
     *         description="第几页",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         description="每页行数",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="keyword",
     *         description="搜索关键字",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The result of news"
     *     ),
     *     security={
     *         {"passport": {}},
     *     }
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit', 10);
        $keyword = $request->input('keyword');

        $news = News::when($keyword, function ($query) use ($keyword) {
            return $query->where('title', 'like', '%' . $keyword . '%');
        })->orderBy('id', 'desc')->paginate($limit);

        return NewsResource::collection($news)->additional([
            "status" => "success",
            "code" => 200,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/v2/news/show/{id}",
     *     operationId="getNewsItem",
     *     tags={"新闻v2"},
     *     summary="新闻详细",
     *     description="根据ID返回新闻详细",
     *     @OA\Parameter(
     *         name="id",
     *         required=true,
     *         in="path",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The news item",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="404 not found"
     *     ),
     *     security={
     *         {"passport": {}},
     *     }
     * )
     */
    public function show($news)
    {
        // $user = auth('api')->user();

        $news = News::where('id', $news)->first();
        return $this->success(new NewsResource(
            $news
        ));
    }

    /**
     * @OA\Get(
     *     path="/v2/news2",
     *     operationId="getNews2List",
     *     tags={"新闻v2"},
     *     summary="新闻列表",
     *     @OA\Parameter(
     *         name="page",
     *         description="第几页",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         description="每页行数",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="keyword",
     *         description="搜索关键字",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="news_category_id",
     *         description="分类ID",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The result of news"
     *     ),
     *     security={
     *         {"passport": {}},
     *     }
     * )
     */

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

    /**
     * @OA\Get(
     *     path="/v2/news/category",
     *     operationId="getNewsCategory",
     *     tags={"新闻v2"},
     *     summary="新闻分类",
     *     @OA\Parameter(
     *         name="page",
     *         description="第几页",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         description="每页行数",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="keyword",
     *         description="搜索关键字",
     *         required=false,
     *         in="query",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="The result of news"
     *     ),
     *     security={
     *         {"passport": {}},
     *     }
     * )
     */

    public function category(Request $request)
    {
        $limit            = $request->input('limit', 10);
        $keyword          = $request->input('keyword');

        $news_category = NewsCategory::when($keyword, function ($query) use ($keyword) {
            return $query->where('name', 'like', '%' . $keyword . '%');
        })->paginate($limit);
        return $this->success($news_category);
    }
}
