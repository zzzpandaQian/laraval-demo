<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'mobile'     => 'required|unique:users|confirm_mobile_not_change|confirm_rule:mobile_required',
            'verifyCode' => 'required|verify_code',
            'password'   => 'required|string|min:6',
        ],
        [
            'mobile' => '请输入正确的手机号',
            'mobile.confirm_mobile_not_change' => '请重新发送验证码',
            'verifyCode.required' => '请输入验证码',
            'verifyCode.verify_code' => '验证码输入错误',
            'password' => '请输入6位以上密码',
        ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'           => $data['mobile'],
            'mobile'         => $data['mobile'],
            'email_verified' => 1,
            'password'       => bcrypt($data['password']),
        ]);
    }
}
