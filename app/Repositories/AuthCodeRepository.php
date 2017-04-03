<?php namespace App\Repositories;

use Coolcode\Shared\Entities\AuthCode;
use App\Repositories\Interfaces\AuthCodeInterface;

class AuthCodeRepository Implements AuthCodeInterface {

  /**
   * @param array $cat_id
   * @param $is_draft
   * @param $order
   * @param $take
   */
  public function ifExistsAuthCode($userId)
  {

    $query = AuthCode::whereRaw(
      'user_id = ? and type = 1 and is_used = 0 and created_at >= DATE_SUB(NOW(), INTERVAL 10 MINUTE)', [$userId]
    )->get();
    return $query;
  }

  public function createCaptcha($userId, $userIp)
  {
    do {
      $randomCode = mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9) . mt_rand(0, 9);
      $ifSame = AuthCode::whereRaw('user_id = ? and code = ?', [$userId, $randomCode])->count();
    } while ($ifSame);

    return [
      'type'    => 1,
      'user_id' => $userId,
      'user_ip' => $userIp,
      'code'    => $randomCode,
    ];
  }

  public function ifExistsUserId($userId)
  {
    $c = AuthCode::where('user_id', '=', $userId)->value('is_used');
    return $c;
  }

  public function ifCodeIsMatch($userId, $code)
  {
    $ncode = Authcode::where('user_id', '=', $userId)->where('code', $code)->value('code');
    return $ncode;
  }

  public function makeAuthCodeUsed($userId, $code)
  {
    $authcodes = Authcode::where('user_id', '=', $userId)->where('code', $code)->where('is_used', 0)
                         ->get();
    $authcode = $authcodes[0];
    $authcode->is_used += 1;
    $authcode->save();
  }

  public function sendLimit($userId, $userIp)
  {
    $ip_day_times = AuthCode::whereRaw(
        'user_ip = ? and created_at >= CURDATE()', [$userIp])->count();
    $ip_second_times = AuthCode::whereRaw(
        'user_ip = ? and created_at >= DATE_SUB(NOW(),INTERVAL 10 SECOND)', [$userIp])->count();
    if ($ip_day_times >= 50 || $ip_second_times >= 3) {
      AuthCode::create(['user_ip' => $userIp]);
      return 'ipLimit';
    }

    $send_day_times = AuthCode::whereRaw(
        'user_id = ? and code >= 0 and created_at >= CURDATE()', [$userId])->count();
    if ($send_day_times >= 10) {
      AuthCode::create(['user_ip' => $userIp]);
      return 'dayLimit';
    }

    $send_hour_times = AuthCode::whereRaw(
        'user_id = ? and code >= 0 and created_at >= DATE_SUB(NOW(),INTERVAL 1 HOUR)', [$userId])->count();
    if ($send_hour_times >= 3) {
      AuthCode::create(['user_ip' => $userIp]);
      return 'hourLimit';
    }

    $send_minute_times = AuthCode::whereRaw(
        'user_id = ? and code >= 0 and created_at >= DATE_SUB(NOW(),INTERVAL 1 MINUTE)', [$userId])->count();
    if ($send_minute_times !== 0) {
      AuthCode::create(['user_ip' => $userIp]);
      return 'minuteLimit';
    }
  }

  public function updateAuthCode($authCode)
  {
    $authCode->is_used = 1;
    $authCode->save();
  }

  public function createAuthCode($authCode)
  {
    AuthCode::create([
      'code'    => $authCode['code'],
      'user_id' => $authCode['user_id'],
      'user_ip' => $authCode['user_ip'],
      'type'    => $authCode['type'],
    ]);
  }

}
