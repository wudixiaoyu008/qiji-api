<?php namespace App\Utils;

class Yunpian
{
  public function send($mobile, $code)
  {
    // 必要参数
    $ch = curl_init();
    $apikey = env('YunPian_API_KEY');
    $text = "【策马奔腾】您的验证码是{$code}，千万不要告诉别人哦！";
    //发送短信
    $data = ['text' => $text, 'apikey' => $apikey, 'mobile' => $mobile];
    curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $json_data = curl_exec($ch);
    //解析返回结果（json格式字符串）
    return json_decode($json_data, true);
  }
}