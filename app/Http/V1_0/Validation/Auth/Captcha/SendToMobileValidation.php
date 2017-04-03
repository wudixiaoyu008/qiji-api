<?php namespace App\Http\V1_0\Validation\Auth\Captcha;

use App\Http\Common\BaseValidation;

class SendToMobileValidation extends BaseValidation {
  public function rules()
  {
    return [
      'mobile' => 'required|digits:11'
    ];
  }

}