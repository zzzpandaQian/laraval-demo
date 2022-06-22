<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Helpers\ApiResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * @OA\Info(
 *     version="1.0",
 *     title="atcms 接口文档"
 * ),
 * @OA\Server(
 *     url="http://atcms.test/api"
 * )
 */
class ApiController extends BaseController
{
    use ApiResponse, AuthorizesRequests, ValidatesRequests;
}
