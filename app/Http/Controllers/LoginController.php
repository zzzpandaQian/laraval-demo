<?php
namespace App\Http\Controllers;

use App\Exceptions\CouponCodeUnavailableException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{

    public function password(Request $request)
    {
        if ($request->isMethod('post')) {
            //验证数据
            $validator = Validator::make(
                $request->all(),
                [
                    'mobile' => 'required|exists:users|confirm_mobile_not_change|confirm_rule:mobile_required',
                    'verifyCode' => 'required|verify_code',
                    'password' => 'required|string|min:6|confirmed',
                ],
                [
                    'mobile' => '请输入正确的手机号',
                    'mobile.confirm_mobile_not_change' => '请重新发送验证码',
                    'verifyCode.required' => '请输入验证码',
                    'verifyCode.verify_code' => '验证码输入错误',
                    'password' => '请输入6位以上密码',
                ]
            );

            if ($validator->fails()) {
                return redirect('login/password')
                    ->withErrors($validator)
                    ->withInput();
            }

            $moblie = $request->mobile;
            $password = bcrypt($request->password);
            $is_user = User::where('mobile', $request->mobile)->first();

            $update_user = User::where('mobile', $request->mobile)->update(['password' => $password]);
            $request->session()->flash('flash_msg_type', 'success'); // primary/secondary/success/danger/warning/info/light/dark/
            $request->session()->flash('flash_msg_head', '提示信息');
            $request->session()->flash('flash_msg_body', '密码修改成功');
            $request->session()->flash('flash_msg_foot', ''); // 可选
            $request->session()->flash('flash_msg_url', url('/')); // 可选，未设置则跳转首页
            return view('web.page.message');
        }

        return view('auth.password');
    }

    public function verifycode_login(Request $request)
    {
        if ($request->isMethod('post')) {
            //验证数据
            $validator = Validator::make(
                $request->all(),
                [
                    'mobile' => 'required|exists:users|confirm_mobile_not_change|confirm_rule:mobile_required',
                    'verifyCode' => 'required|verify_code',
                ],
                [
                    'mobile' => '请输入正确的手机号',
                    'mobile.confirm_mobile_not_change' => '请重新发送验证码',
                    'verifyCode.required' => '请输入验证码',
                    'verifyCode.verify_code' => '验证码输入错误',
                ]
            );

            if ($validator->fails()) {
                return redirect('login/verifycode_login')
                    ->withErrors($validator)
                    ->withInput();
            }

            $user = User::where('mobile', $request->mobile)->first();
            if ($user) {
                auth('web')->login($user);
            }
            return redirect('/');
        }

        return view('auth.verifycode_login');
    }
}
