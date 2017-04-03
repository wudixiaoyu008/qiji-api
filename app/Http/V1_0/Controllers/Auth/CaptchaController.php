<?php namespace App\Http\V1_0\Controllers\Auth;

use App\Http\V1_0\Controllers\ApiController;
use App\Http\V1_0\Validation\Auth\Captcha\SendToMobileValidation;
use App\Repositories\Interfaces\AuthCodeInterface;
use App\Repositories\Interfaces\UserInterface;
use Illuminate\Http\Request;
use App\Utils\Yunpian;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CaptchaController extends ApiController {
  /**
   * CaptchaController constructor.
   * @param UserInterface $User
   */
  public function __construct(UserInterface $user, AuthCodeInterface $authCode, Yunpian $yunPian)
  {
    $this->user = $user;
    $this->authCode = $authCode;
    $this->yunPian = $yunPian;
  }

  public function sendToMobile(Request $request)
  {
    $this->validateRequest($request, new SendToMobileValidation());
    $mobile = $request->mobile;

    // 判断是否存在该用户
    $user = $this->user->findOrCreate($mobile);
    if (!$user) {
      throw new HttpException(500, trans('failure.captcha.mobile_register_failed'));
    }
    $userId = $user->id;
    $userIp = $request->getClientIp();

    // ip 以及发送次数限制验证
    $limitType = $this->authCode->sendLimit($userId, $userIp);
    switch ($limitType) {
      case "ipLimit":
        throw new HttpException(403, trans('failure.captcha.ip_limit'));
        break;
      case "dayLimit":
        throw new HttpException(403, trans('failure.captcha.day_limit'));
        break;
      case "hourLimit":
        throw new HttpException(403, trans('failure.captcha.hour_limit'));
        break;
      case "minuteLimit":
        throw new HttpException(403, trans('failure.captcha.minute_limit'));
        break;
    }

    //判断 10 分钟内是否已经生成验证码
    $authCodes = $this->authCode->ifExistsAuthCode($userId);
    if ($authCodes->count() == 0) {
      $authCode = $this->authCode->createCaptcha($userId, $userIp);
      if (!isset($authCode)) {
        throw new HttpException(500, trans('failure.captcha.gen_captcha_failed'));
      }
    } else {
      $authCode = $authCodes[0];
      $this->authCode->updateAuthCode($authCode);
    }

    $code = $authCode['code'];
    $sendResponse = $this->yunPian->send($mobile, $code);
    if ($sendResponse['code'] !== 0) {
      throw new HttpException(500, trans('failure.captcha.send_captcha_failed'));
    }
    $this->authCode->createAuthCode($authCode);
    return $this->response->array([
      'message'     => trans('success.captcha.send_to_mobile'),
      'status_code' => 200,
    ]);
  }
}