<?php namespace App\Http\V1_0\Controllers\Auth;

use App\Http\V1_0\Controllers\ApiController;
use App\Http\V1_0\Validation\Auth\Login\WechatValidation;
use App\Http\V1_0\Validation\Auth\Login\MobileValidation;
use App\Repositories\Interfaces\AuthCodeInterface;
use App\Repositories\Interfaces\UserInterface;
use App\Transformers\LoginTransformer;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginController extends ApiController {

  /**
   * LoginController constructor.
   * @param UserInterface $userInterface
   * @param AuthCodeInterface $authCodeInterface
   */
  public function __construct(UserInterface $userInterface,
                              AuthCodeInterface $authCodeInterface)
  {
    $this->userInterface = $userInterface;
    $this->authcodeInterface = $authCodeInterface;
  }

  /**
   * Wechat Login
   * @param Request $request
   * @internal param ThirdPartyValidation $validation
   * @return mixed
   */
  public function wechat(Request $request)
  {
    $this->validateRequest($request, new WechatValidation());

    $wechatId = $request->wechat_id;
    $wechatInfo = $request->wechat_info;

    $user = $this->userInterface->findOrCreateWithWechat($wechatId, $wechatInfo);

    return $this->response->item($user, new LoginTransformer());
  }

  public function mobile(Request $request)
  {
    $this->validateRequest($request, new MobileValidation());

    $mobile = $request->mobile;
    $code = $request->code;

    $userId = $this->userInterface->findUserId($mobile);
    $c = $this->authcodeInterface->ifExistsUserId($userId);

    if (!isset($c)) {
      throw new HttpException(404, trans('failure.login.get'));
    }

    $code = $this->authcodeInterface->ifCodeIsMatch($userId, $code);

    if (!isset($code)) {
      throw new HttpException(404, trans('failure.login.match'));
    }

    $authCodes = $this->authcodeInterface->ifExistsAuthCode($userId);

    if ($authCodes->count()) {
      //验证码被使用, 使用次数+1
      $this->authcodeInterface->makeAuthCodeUsed($userId, $code);

      $user = $this->userInterface->getUser($userId);

      return $this->response->item($user, new LoginTransformer());
    }
    throw new HttpException(417, trans('failure.login.overdue'));
  }
}