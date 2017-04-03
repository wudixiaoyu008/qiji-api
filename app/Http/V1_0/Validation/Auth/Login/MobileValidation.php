<?php namespace App\Http\V1_0\Validation\Auth\Login;

use App\Http\Common\BaseValidation;

class MobileValidation extends BaseValidation {
  public function rules()
  {
    return [
      'mobile' => 'required|digits:11',
      'code'   => 'required',
    ];
  }
}