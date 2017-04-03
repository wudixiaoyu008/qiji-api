<?php namespace App\Repositories;


use App\Repositories\Interfaces\UserInterface;
use Coolcode\Shared\Entities\User;
use Coolcode\Shared\Entities\UserInfo;
use Coolcode\Shared\Entities\UserToken;

class UserRepository Implements UserInterface {

  /**
   * @param array $cat_id
   * @param $is_draft
   * @param $order
   * @param $take
   */
  public function findOrCreate($mobile)
  {
    $query = User::firstOrCreate([
      'mobile' => $mobile,
    ]);
    UserInfo::firstOrCreate([
      'user_id'  => $query->id,
      'nickname' => substr_replace($mobile, 'XXXX', 3, 4)
    ]);
    return $query;
  }

  public function findUserId($mobile)
  {
    $user_id = User::where('mobile', '=', $mobile)->value('id');
    return $user_id;
  }

  public function getUser($userId)
  {
    $user = User::find($userId);
    return $user;
  }

  public function findOrCreateWithWechat($wechatId, $wechatInfo)
  {
    $user = User::with('userToken')->join('user_tokens',
      function ($join) use ($wechatId) {
        $join->on('users.id', '=', 'user_tokens.user_id')
          ->where('user_tokens.wechat_id', '=', $wechatId)
          ->whereNotNull('users.id');
      })->first();

    if (is_null($user)) {
      $user = User::create();

      //create user info
      $userInfo = new UserInfo();
      $userInfo->nickname = $wechatInfo['nickname'];
      $userInfo->avatar_url = $wechatInfo['avatar_url'];
      $userInfo->user()->associate($user);
      $userInfo->save();

      $user->info = [$userInfo];

      //create user Token
      $userToken = new UserToken();
      $userToken->wechat_id = $wechatId;
      $userToken->wechat_info = json_encode($wechatInfo);
      $userToken->user()->associate($user);
      $userToken->save();

      $user->userToken = [$userToken];

      $user = User::with('userToken')->join('user_tokens',
        function ($join) use ($wechatId) {
          $join->on('users.id', '=', 'user_tokens.user_id')
            ->where('user_tokens.wechat_id', '=', $wechatId)
            ->whereNotNull('users.id');
        })->first();
    }

    return $user;
  }
}