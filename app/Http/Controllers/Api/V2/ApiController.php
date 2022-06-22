<?php

namespace App\Http\Controllers\Api\V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Helpers\ApiResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ApiController extends BaseController
{
    use ApiResponse, AuthorizesRequests, ValidatesRequests;
}
