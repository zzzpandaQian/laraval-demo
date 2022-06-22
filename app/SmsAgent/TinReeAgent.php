<?php

namespace Toplan\PhpSms;

class TinReeAgent extends Agent implements TemplateSms
{
    public function __construct()
    {
        $this->config(Sms::config('TinRee'));
    }

    /**
     * Template SMS send process.
     *
     * @param string|array $mobile
     * @param int|string   $templateId
     * @param array        $tempData
     */
    public function sendTemplateSms($mobile, $templateId, array $tempData)
    {
        $params = [
            'accesskey'  => $this->accesskey,
            'secret'     => $this->secret,
            'sign'       => $this->sign,
            'templateId' => $templateId,
            'mobile'     => $mobile,
            'content'    => implode("##", $tempData)
        ];

        $result = $this->curlGet($this->sendUrl, $params);

        $this->setResult($result);
    }

    protected function setResult($result)
    {
        if ($result['request']) {
            $response = $result['response'];
            $this->result(Agent::INFO, $response);
            $result = json_decode($response, true);
            if (isset($result['code']) && $result['code'] == 0) {
                $this->result(Agent::SUCCESS, true);
            } else {
                $this->result(Agent::CODE, $result['code']);
            }
            $this->result(Agent::INFO, $result['msg']);
        } else {
            $this->result(Agent::INFO, 'request failed');
        }
    }
}
