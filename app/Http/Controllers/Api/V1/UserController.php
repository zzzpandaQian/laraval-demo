<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;

class UserController extends ApiController
{
    public function index(Request $request)
    {
        $user = auth('api')->user();

        return $this->success(new UserResource($user));
    }

    public function edit(Request $request)
    {
        $user = auth('api')->user();
        $inputs = $request->all();
        if ($request->avatar) {
            User::where('id', $user->id)->update($inputs);
        } else {
            unset($inputs['avatar']);
            User::where('id', $user->id)->update($inputs);
        }

        return $this->message('修改成功！');
    }
}
