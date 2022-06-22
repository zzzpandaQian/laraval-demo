<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\FormData;

class DemoController extends ApiController
{

    public function formData(Request $request)
    {
        $inputs = $request->all();

        FormData::create($inputs);

        return $this->message('提交成功！');
    }
}
