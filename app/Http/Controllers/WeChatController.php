<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use App\Models\User;
use Session;
use Log;

class WeChatController extends Controller
{
    const EVENT_SUBSCRIBE  = 'SUBSCRIBE'; // 没关注时扫描：订阅公共号
    const EVENT_UNSUBSCRIBE = 'UNSUBSCRIBE';// 已关注后，手动取消订阅号时触发

    /**
     * 默认首页
     *
     * @return string
     */
    public function home(Request $request)
    {
        $token = '';

        if (config('app.env') == 'local') {
            $user = User::first();
            $openid = $user->wx_openid;
        } else {
            $user = auth()->user();
            if (!$user) {
                $openid = $user->wx_openid;
                $app = app('wechat.official_account');
                return $app->oauth->redirect(route('wechat.oauth_callback'));
            }
        }

        if (isset($user) && $user) {
            $token = JWTAuth::fromUser($user);
        }

        return view('wechat', compact('openid', 'token'));
    }

    public function oauthCallback(Request $request)
    {
        if ($request->has('code')) {
            $app = app('wechat.official_account');
            $auth = $app->oauth;

            $code =  $request->input('code');
            $accessToken = $auth->getAccessToken($code);
            $wx_user = $auth->user($accessToken);

            $openid = $wx_user->id;
            $user = User::where('wx_openid', $openid)->first();

            // openid存在则更新用户
            if ($user) {
                if ($user->name == "") {
                    $field['name'] = $wx_user->nickname;
                }
                $field['avatar'] = $wx_user->avatar;
                $field['gender'] = $wx_user->original['sex'];
                $user->update($field);
            }

            auth()->login($user);
        }

        return redirect(route('wechat'));
    }


    /**
     * 处理微信的请求消息
     *
     * @return string
     */
    public function serve()
    {
        Log::info('wechat request arrived.');

        $app = app('wechat.official_account');

        $app->server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    if (isset($message->Event)) {
                        switch (strtoupper($message->Event)) {
                            //关注
                            case self::EVENT_SUBSCRIBE:
                                return $this->onSubscribe();
                                break;
                            //取关
                            case self::EVENT_UNSUBSCRIBE:
                                return $this->onUnsubscribe();
                                break;
                        }
                    }
                    return '感谢您对我们的支持，我们将竭诚为您服务';
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                    return '收到图片消息';
                    break;
                case 'voice':
                    return '收到语音消息';
                    break;
                case 'video':
                    return '收到视频消息';
                    break;
                case 'location':
                    return '收到坐标消息';
                    break;
                case 'link':
                    return '收到链接消息';
                    break;
                case 'file':
                    return '收到文件消息';
                // ... 其它消息
                default:
                    return '收到其它消息';
                    break;
            }

            // ...
        });

        return $app->server->serve();
    }



    /**
     * 用户关注时触发，用于子类重写
     *
     * @return void
     */
    protected function onSubscribe()
    {
        return '感谢您对我们的支持，我们将竭诚为您服务';
    }

    protected function onUnsubscribe()
    {
        return '感谢您对我们的支持，我们将竭诚为您服务';
    }
}
