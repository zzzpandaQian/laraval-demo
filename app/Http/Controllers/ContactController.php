<?php

namespace App\Http\Controllers;

use PhpSms;
use SmsManager;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
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

        $inputs['ip'] = $request->getClientIp();
        $ip_info = getIpInfo($inputs['ip']);
        $inputs['city'] = $ip_info ? $ip_info['city'] : '';

        $result = Contact::create($inputs);

        return response()->json([
            'code' => 200,
            'data' => $result,
            'msg' => ''
        ]);
    }
}
