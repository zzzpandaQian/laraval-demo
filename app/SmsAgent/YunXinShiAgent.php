<?php

namespace Toplan\PhpSms;

class YunXinShiAgent extends Agent implements ContentSms, TemplateSms
{
    public function __construct()
    {
        $this->config(Sms::config('YunXinShi'));
    }

    public function sendContentSms($to, $content)
    {
        $params = [
            'uid'      => $this->uid,
            'pwd'      => $this->pwd,
            'ac'       => 'send',
            'mobile'   => $to,
            'content'  => $content,
        ];

        $result = $this->curlGet($this->apiUrl, $params);
        // $result = [
        //     'request' => 1,
        //     'response' => '{"stat":"100","message":"发送成功"}'
        // ];

        $this->setResult($result);
    }

    /**
     * Template SMS send process.
     *
     * @param string|array $to
     * @param int|string   $tempId
     * @param array        $tempData
     */
    public function sendTemplateSms($to, $tempId, array $tempData)
    {
        $params = [
            'ac'       => 'send',
            'uid'      => $this->uid,
            'pwd'      => $this->pwd,
            'template' => $tempId,
            'mobile'   => $to,
            'content'  => json_encode($tempData)
        ];
        $result = $this->curlGet($this->apiUrl, $params);

        $this->setResult($result);
    }


    protected function setResult($result)
    {

        if ($result['request']) {
            $response = mb_convert_encoding($result['response'], 'UTF-8', 'UTF-8,GBK,GB2312');
            $this->result(Agent::INFO, $response);
            $result = json_decode($response, true);
            if (isset($result['stat']) && $result['stat'] == 100) {
                $this->result(Agent::SUCCESS, true);
            } else {
                $this->result(Agent::CODE, $result['stat']);
            }
            $this->result(Agent::INFO, $result['message']);
        } else {
            $this->result(Agent::INFO, 'request failed');
        }
    }
}
