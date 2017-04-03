<?php namespace App\Http\V1_0\Validation\Auth\Login;

use App\Http\Common\BaseValidation;

class WechatValidation extends BaseValidation {
  public function rules()
  {
    return [
      'wechat_id'   => 'required',
      'wechat_info' => 'required',
    ];
  }
}