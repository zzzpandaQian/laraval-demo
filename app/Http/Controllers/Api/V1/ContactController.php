<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends ApiController
{
    /**
     * 构造方法
     */
    public function __construct()
    {
    }

    /**
     * 提交表单
     *
     * @return json
     */
    public function create(Request $request)
    {
        $inputs = $request->all();
        $result = Contact::create($inputs);

        return $this->success($result);
    }
}
