<?php

namespace App\Http\Controllers\Api\V1;

use JWTAuth;
use Validator;
use SmsManager;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\InvalidRequestException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends ApiController
{
    use AuthenticatesUsers;

    /**
     * @var bool
     * 获取到微信信息后是否创建用户，在系统有其他注册用户途径时关闭，避免重复创建用户
     */
    protected $createWithWxUser = true;

    /**
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => [
            'sendSmsCode', 'login', 'register',
            'verifyCode', 'verifyXcx', 'verifyCodeWechat',
            'test', 'wechatOauth', 'jssdk',
            'mplogin', 'bindMobileMp'
        ]]);
    }

    public function username()
    {
        return 'mobile';
    }

    public function test()
    {
        $user = User::findOrFail(1);
        $token = auth('api')->login($user);

        return $this->success([
            'user' => $user,
            'token' => 'bearer ' . $token
        ]);
    }

    public function login()
    {
        $credentials = request(['mobile', 'password']);
        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => '登录失败'], 401);
            // throw new AuthenticationException();
        }

        return $this->respondWithToken($token);
    }

    public function me(Request $request)
    {
        // $user = $request->user();
        $user = auth('api')->user();
        return $this->success(new UserResource($user));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return $this->message('退出成功');
    }

    /**
     * Refresh a token.
     * 刷新token，如果开启黑名单，以前的token便会失效。
     * 值得注意的是用上面的getToken再获取一次Token并不算做刷新，两次获得的Token是并行的，即两个都可用。
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    public function register(Request $request)
    {
        $inputs = $this->validate($request, [
            'name'           => 'required',
            'nickname'       => 'required',
            'gender'         => 'required',
            'birthday'       => 'required',
            'id_number'      => 'required',
            'marital_status' => 'required',
            'habitation'     => 'required',
            'company_id'     => 'required',
        ]);

        auth('api')->user()->update($inputs);

        return $this->message('注册成功');
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->success([
            'token' => 'bearer ' . $token,
        ]);
    }

    public function sendSmsCode()
    {
        // 发送前校验
        $result = SmsManager::validateSendable();
        if (!$result['success']) {
            return response()->json($result);
        }

        //使用内置的验证逻辑
        $result = SmsManager::validateFields();
        if (!$result['success']) {
            return response()->json($result);
        }

        $result = SmsManager::requestVerifySms();

        return response()->json($result);
    }

    /**
     * 验证短信验证码
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyCode(Request $request)
    {
        //验证数据
        $validator = Validator::make(
            $request->all(),
            [
                'mobile' => 'required|confirm_mobile_not_change|confirm_rule:mobile_required|zh_mobile', //|confirm_mobile_not_change|confirm_rule:mobile_required
                'code'   => 'required|verify_code', //|verify_code
            ],
            [
                'mobile'                           => '请输入正确的手机号',
                'mobile.confirm_mobile_not_change' => '请重新发送验证码',
                'mobile.zh_mobile'                 => '电话号码格式不支持',
                'code.required'                    => '请输入验证码',
                'code.verify_code'                 => '验证码输入错误',
            ]
        );

        if ($validator->fails()) {
            //验证失败后建议清空存储的发送状态，防止用户重复试错
            SmsManager::forgetState();
            return $this->failed(collect($validator->errors())->first());
        }

        $user_request = $request->all();

        $users = User::where('mobile', $user_request['mobile'])->first();

        if ($users == null) {
            $field = array(
                'wx_openid' => $user_request['wx_openid'],
                'mobile'    => $user_request['mobile'],
                'name'      => $user_request['mobile'],
            );
            $users = User::create($field);
        } else {
            $field['wx_openid'] = $request->input('wx_openid');
            $users->update($field);
        }

        $token = JWTAuth::fromUser($users);

        return $this->message([
            'message' => '验证成功',
            'user'    => [
                'mobile' => $user_request['mobile'],
                'status' => $users->status,
            ],
            'token'   => [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => auth('api')->factory()->getTTL() * 60
            ]
        ]);
    }

    /**
     * 微信用户验证短信验证码
     * 如果手机号存在，更新已有数据的openid
     * 如果手机号不存在，创建新用户
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyCodeWechat(Request $request)
    {
        //验证数据
        $validator = Validator::make(
            $request->all(),
            [
                'mobile' => 'required|confirm_mobile_not_change|confirm_rule:mobile_required|zh_mobile', //|confirm_mobile_not_change|confirm_rule:mobile_required
                'code'   => 'required|verify_code', //|verify_code
            ],
            [
                'mobile'                           => '请输入正确的手机号',
                'mobile.confirm_mobile_not_change' => '请重新发送验证码',
                'mobile.zh_mobile'                 => '电话号码格式不支持',
                'code.required'                    => '请输入验证码',
                'code.verify_code'                 => '验证码输入错误',
            ]
        );
        if ($validator->fails()) {
            //验证失败后建议清空存储的发送状态，防止用户重复试错
            SmsManager::forgetState();
            return $this->failed(collect($validator->errors())->first());
        }

        // 前端在验证手机接口必须带上 openid
        $wx_openid = $request->input('openid');
        $mobile    = $request->input('mobile');

        $app = app('wechat.official_account');
        $wx_user = $app->user->get($wx_openid);
        // \Log::info($wx_user);

        $field = array(
            'wx_openid' => $wx_openid,
            'mobile'    => $mobile,
            'name'      => isset($wx_user['nickname']) ? $wx_user['nickname'] : $mobile,
            'wx_avatar' => isset($wx_user['headimgurl']) ? $wx_user['headimgurl'] : '',
        );

        // 手机号存在 或 openid存在 更新用户；否则创建用户
        $userMb = User::where('mobile', $mobile)->first();
        // \Log::info($userMb);

        $userWx = User::where('wx_openid', $wx_openid)->first();
        if ($userMb) {
            $userMb->update($field);
        } elseif ($userWx) {
            $userWx->update($field);
        } else {
            User::create($field + ['avatar' => isset($wx_user['headimgurl']) ? $wx_user['headimgurl'] : '']);
        }

        $user = User::where('mobile', $mobile)->first();
        $token = JWTAuth::fromUser($user);

        return $this->success([
            'message' => '手机号验证成功',
            'user' => new UserResource($user),
            'token'   => isset($token) ? 'bearer ' . $token : '',
        ]);
    }

    /**
     * 小程序验证短信验证码
     * 如果手机号存在，更新已有数据的openid
     * 如果手机号不存在，创建新用户
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyXcx(Request $request)
    {
        //验证数据
        $validator = Validator::make(
            $request->all(),
            [
                'mobile' => 'required|confirm_mobile_not_change|confirm_rule:mobile_required|zh_mobile', //|confirm_mobile_not_change|confirm_rule:mobile_required
                'code'   => 'required|verify_code', //|verify_code
            ],
            [
                'mobile'                           => '请输入正确的手机号',
                'mobile.confirm_mobile_not_change' => '请重新发送验证码',
                'mobile.zh_mobile'                 => '电话号码格式不支持',
                'code.required'                    => '请输入验证码',
                'code.verify_code'                 => '验证码输入错误',
            ]
        );
        if ($validator->fails()) {
            //验证失败后建议清空存储的发送状态，防止用户重复试错
            SmsManager::forgetState();
            return $this->failed(collect($validator->errors())->first());
        }

        $user = User::where('mobile', $request->input('mobile'))->first();

        if ($user) {
            $field['xcx_openid'] = $request->input('openid');
            $user->update($field);
        } else {
            $field = array(
                'xcx_openid' => $request->input('openid'),
                'mobile' => $request->input('mobile'),
                'name'   => $request->input('mobile'),
            );
            $user = User::create($field);
        }

        $token = JWTAuth::fromUser($user);

        return $this->success([
            'message' => '绑定成功',
            'user' => new UserResource($user),
            'token' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60
            ]
        ]);
    }


    /**
     * 微信小程序授权登录
     *
     * @param Request $request
     * @return void
     */
    public function mplogin(Request $request)
    {
        $this->validate($request, [
            'code'     => 'required',
            'userInfo' => 'required',
        ]);

        $miniProgram = \EasyWeChat::miniProgram();
        try {
            $result = $miniProgram->auth->session($request->code);
        } catch (Exception $e) {
            \Log::error('小程序授权发生错误');
            report($e);
            throw new InvalidRequestException('发生错误，请稍后重试');
        }

        if (!isset($result['openid'])) {
            \Log::error("小程序授权解析" . json_encode($result));
            throw new InvalidRequestException('授权失败，请重新进入小程序');
        }

        $openid = $result['openid'];
        $user = User::where('xcx_openid', $openid)->first();

        $fields = [
            'wx_nickname' => $request->input('userInfo.nickName'),
            'gender'      => $request->input('userInfo.gender'),
            'wx_avatar'   => $request->input('userInfo.avatarUrl'),
            'wx_country'  => $request->input('userInfo.country'),
            'wx_province' => $request->input('userInfo.province'),
            'wx_city'     => $request->input('userInfo.city'),
            'session_key' => $result['session_key'],
        ];

        if ($user) {
            $user->update($fields);
        } else {
            if ($this->createWithWxUser) {
                $fields['xcx_openid'] = $openid;
                $user = User::create($fields);
            } else {
                $userDetail = ['status' => 0];
            }
        }

        if ($user) {
            $token = auth('api')->login($user);
            $userDetail = new UserResource($user);
        }

        return $this->success([
            'session_info' => $result,
            'xcx_openid'   => $openid,
            'user'         => $userDetail,
            'token'        => isset($token) ? 'bearer ' . $token : '',
        ]);
    }


    /**
     * 微信小程序获取手机号并关联账号（获取微信手机号方式）
     *
     * @param Request $request
     * @return void
     */
    public function bindMobileMp(Request $request)
    {
        $this->validate($request, [
            'iv'            => 'required',
            'encryptedData' => 'required',
        ]);
        $nickName = $request->input('nickName');
        $xcx_openid = $request->input('openid');

        $miniProgram = \EasyWeChat::miniProgram();
        // 解密信息
        try {
            $decryptedData = $miniProgram->encryptor->decryptData($request->input('session_key'), $request->input('iv', ''), $request->input('encryptedData', ''));
            $mobile = $decryptedData['purePhoneNumber'];
        } catch (Exception $e) {
            \Log::error('解析微信用户信息发生错误: ' . $nickName);
            throw new InvalidRequestException('微信解析失败，请重新进入小程序');
        }

        // 是否已登录用户（未绑定手机号）
        $user = User::where('mobile', $mobile)->first();
        if ($user) {
            User::where('id', $user->id)->update([
                'mobile'    => $mobile,
            ]);
            $token = JWTAuth::fromUser($user);
            return $this->success([
                'msg'   => '手机号码绑定成功',
                'user'  => new UserResource($user),
                'token' => 'bearer ' . $token,
            ]);
        }

        if (!$user) {
            $info['mobile']     = $mobile;
            $info['name']       = $nickName ? $nickName : $mobile;
            $info['xcx_openid'] = $xcx_openid;
            $info['avatar']     = $request->input('avatarUrl');

            $user = User::create($info);
        } else {
            if ($user->name != '' || $user->name == $mobile) {
                $info['name'] = $nickName ? $nickName : $mobile;
            }
            $info['xcx_openid'] = $xcx_openid;
            User::where('id', $user->id)->update($info);
        }

        $token = auth('api')->login($user);

        return $this->success([
            'msg'   => '手机号码绑定成功',
            'user'  => new UserResource($user),
            'token' => 'bearer ' . $token,
        ]);
    }

    /**
     *
     * 微信授权
     * https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/Wechat_webpage_authorization.html#3
     * https://www.easywechat.com/docs/4.1/official-account/oauth
     *
     */
    public function wechatOauth(Request $request)
    {
        // $this->validate($request, [
        //     'code'     => 'required',
        // ]);

        $app = app('wechat.official_account');
        $oauth = $app->oauth;

        // 当 scope 为 snsapi_base 基础授权 时 $oauth->user(); 对象里只有 id (openid)，没有其它信息。
        // 记录用户授权类型：$field['oauth_scope'] ：0未授权, 1静默授权，2用户信息授权
        // TODO: 是否关注，获取到的信息不一致
        $wx_user = $oauth->user();
        $wx_original = $wx_user->getOriginal();
        if (isset($wx_original['scope']) && $wx_original['scope'] == 'snsapi_base') {
            $field['oauth_scope'] = 1;
        } else {
            $field['name'] = $wx_user->getNickname();
            $field['wx_nickname'] = $wx_user->getNickname();
            $field['wx_avatar'] = $wx_user->getAvatar();
            $field['avatar'] = $wx_user->getAvatar();
            $field['gender'] = $wx_original['sex'];
            $field['oauth_scope'] = 2;
        }

        $openid = $wx_user->getId();
        $user = User::where('wx_openid', $openid)->first();

        // \Log::info(json_encode($wx_user));
        // \Log::info($openid);
        // \Log::info($user);

        // openid存在则更新用户, 否则创建
        if ($user) {
            if ($user->oauth_scope > $field['oauth_scope']) {
                unset($field['oauth_scope']);
            }
            if ($user->name != "") {
                unset($field['name']);
            }
            User::where('wx_openid', $openid)->update($field);
        } else {
            if ($this->createWithWxUser && $field['oauth_scope'] == 2) {
                $field['wx_openid'] = $openid;
                $user = User::create($field);
            } else {
                $userDetail = ['status' => 0];
            }
        }

        if ($user) {
            $token = JWTAuth::fromUser($user);
            $userDetail = new UserResource($user);
        }

        return $this->success([
            'token'  => isset($token) ? 'bearer ' . $token : '',
            'user'   => $userDetail,
            'openid' => $openid,
            'wx_user' => $wx_user,
        ]);
    }

    public function jssdk(Request $request)
    {
        if (config('app.env') == 'local') {
            return null;
        }
        $arr = explode(',', $request->get('apis'));
        $debug = $request->get('debug') === 'true' ? true : false;
        $json = $request->get('json') === 'true' ? true : false;
        $url = $request->get('url');

        // check
        if (!$url) {
            return response()->json(['status' => false, 'msg' => 'params error', 'data' => '']);
        }
        $app = app('wechat.official_account');
        $app->jssdk->setUrl($url);
        $config = $app->jssdk->buildConfig($arr, $debug, $json, $url);
        return response($config);
    }
}
