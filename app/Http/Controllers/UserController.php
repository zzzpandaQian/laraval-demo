<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return view('user.index', ['user' => $user]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        $gender = config('array.gender');
        if ($request->isMethod('post')) {
            User::where('id', $user->id)->update([
                'name'         => $request->name,
                'gender'       => $request->gender,
                'email'        => $request->email,
                'mobile'       => $request->mobile,
                'address'      => $request->address,
                'birthdate'    => $request->birthdate,
            ]);

            $user = User::where('id', $user->id)->first();
            $message = '修改成功';
            return view('user.edit', compact('user', 'message', 'gender'));
        }

        return view('user.edit', compact('user', 'gender'));
    }

    public function password(Request $request)
    {
        $id = $request->user()->id;

        if ($request->isMethod('post')) {
            //验证数据
            $validator = Validator::make(
                $request->all(),
                [
                    'password'    => 'required_with:new_password|current_password:' . $id,
                    'passwordnew' => 'required|string|min:6|confirmed',
                ],
                [
                    'password.current_password' => '原密码不正确',
                    'passwordnew.min'           => '请输入6位以上密码',
                ]
            );
            if ($validator->fails()) {
                return redirect('user/password')
                    ->withErrors($validator)
                    ->withInput();
            }

            $password = bcrypt($request->passwordnew);
            $update_user = User::where('id', $request->user()->id)->update(['password' => $password]);

            $request->session()->flash('flash_msg_type', 'success'); // primary/secondary/success/danger/warning/info/light/dark/
            $request->session()->flash('flash_msg_head', '提示信息');
            $request->session()->flash('flash_msg_body', '密码修改成功');
            $request->session()->flash('flash_msg_foot', ''); // 可选
            $request->session()->flash('flash_msg_url', route('user.index')); // 可选，未设置则跳转首页
            return view('web.page.message');
            // return view('web.page.message', ['msg' => '密码修改成功', 'url' => $user_index, 'name' => '用户中心']);
        } else {
            return view('user.password');
        }
    }
}
