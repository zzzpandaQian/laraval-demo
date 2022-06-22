<?php

namespace App\Http\Controllers;

use Mail;
use PhpSms;
use Toplan\PhpSms\Sms;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('web.example.home');
    }

    public function email()
    {
        $name = 'John';
        Mail::send('emails.test', ['name' => $name], function ($message) {
            $to = '32990@qq.com';
            $message->to($to)->subject('邮件测试');
        });

        return "发送成功";
    }

    public function message(Request $request)
    {
        $request->session()->flash('flash_msg_type', 'danger'); // primary/secondary/success/danger/warning/info/light/dark/
        $request->session()->flash('flash_msg_head', '提示信息');
        $request->session()->flash('flash_msg_body', '这是提示信息内容。Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.');
        $request->session()->flash('flash_msg_foot', '补充说明'); // 可选
        $request->session()->flash('flash_msg_url', route('example')); // 可选，未设置则跳转首页

        return redirect("message");
    }

    public function modals()
    {
        $portfolio = Portfolio::where('status', 1)->orderBy('id', 'desc')->take(6)->get();
        return view('web.example.modals', compact('portfolio'));
    }

    public function sendsms(Request $request)
    {

        // 全文消息示例
        // $content = '【我的装修派】温馨提示：您于4-14在曼城积分商城消费2积分，账户当前可用积分为3积分。进入曼城积分商城查询详情。';
        // PhpSms::make()->to('13788921860')->content($content)->send();

        //发送模板消息示例1
        // $templates = [
        //     'TinRee' => '182754'
        // ];
        // PhpSms::make()->to('18888888888')->template($templates)->send();

        //发送模板消息示例2：带参数
        // $templates = [
        //     'TinRee' => '182754'
        // ];
        // $tempData = [
        //     'name' => 'anson'
        // ];
        // PhpSms::make()->to('18888888888')->template($templates)->data($tempData)->send();

        // 云信使模板
        // $templates = [
        //     'YunXinShi' => '547653',
        // ];
        // $tempData = [
        //     'time'    => 1,
        //     'consume' => 2,
        //     'residue' => 3,
        // ];
        // PhpSms::make()->to('13788921860')->template($templates)->data($tempData)->send();

        // 阿里云模板
        $templates = [
            'Aliyun' => 'SMS_164470397',
        ];
        $tempData = [
            'code'    => 1234,
        ];
        PhpSms::make()->to('13788921860')->template($templates)->data($tempData)->send();

        echo "已发送";
        // return redirect("example");
    }

    public function guzzle()
    {
        $client = new \GuzzleHttp\Client();

        $api_url = 'http://atcms.test/api/news2';

        // GET
        $response = $client->request('GET', $api_url);

        // POST
        $response = $client->request(
            'POST',
            $api_url,
            [
                'form_params' => [
                    'param1' => 'abc',
                ]
            ]
        );

        //获取内容
        $result = json_decode($response->getBody()->getContents(), true);
        return $result;
    }

    public function mpQrcode()
    {
        $user = \User::find(1);

        if (!$user->qrcode) {
            $app = \EasyWeChat::miniProgram();

            $path = 'pages/index/index?shop_id='.$user->id;
            $optional = [
                'width' => '600',
                'line_color' => [
                    'r' => 105,
                    'g' => 166,
                    'b' => 134,
                ],
            ];
            $response = $app->app_code->get($path, $optional);

            // 保存小程序码到文件
            if ($response instanceof \EasyWeChat\Kernel\Http\StreamResponse) {
                $contents = $response->getBody()->getContents();
                $filename = 'shop-' . $user->id . '.png';
                $path = 'images/shop_qrcode/' . $filename;
                $filename = \Storage::disk('public')->put($path, $contents);
                $user->qrcode = $path;
                $user->save();
            }
        }
    }
}
