<?php
/**
 * yii2-dingtalk-robot
 * User: Phil<qin_phil@qq.com>
 * DateTime: 2019/7/8 11:49 AM
 * 使用钉钉机器人作为日志的target
 */

namespace philpm\dingtalk;

use yii\base\InvalidConfigException;

class Target extends \yii\log\Target
{
    /**
     * @var string 机器人access_token
     */
    public $robotToken;

    /**
     * @var array 需要at的人的手机号 eg. [mobile1,mobile2]
     */
    public $at;

    /**
     * @var boolean 是否at所有人
     */
    public $isAtAll = false;

    public function export()
    {
        $text = implode("\n", array_map([$this, 'formatMessage'], $this->messages)) . "\n";

        $data = [
            "msgtype" => "text",
            "text" => [
                "content" => $text
            ],
            "at" => [
                "atMobiles" => $this->at,
                "isAtAll" => $this->isAtAll
            ]
        ];

        $this->curl_post_ssl($data,"https://oapi.dingtalk.com/robot/send?"+$this->robotToken);

    }

    /**
     *  POST请求
     */
    protected function curl_post_ssl($data = null,$url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json;charset=utf-8'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new InvalidConfigException('钉钉机器人请求数据失败: ' . curl_error($ch));
        }
        curl_close($ch);
        return json_decode($res, true);
    }
}