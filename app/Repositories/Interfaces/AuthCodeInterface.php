<?php namespace App\Repositories\Interfaces;


interface AuthCodeInterface {
  /**
   * @param array $cat_id
   * @param $is_draft
   * @param $order
   * @param $take
   * @return mixed
   */
  public function ifExistsAuthCode($mobile);

  public function createCaptcha($userId, $userIp);

  public function ifExistsUserId($userId);

  public function ifCodeIsMatch($userId, $code);

  public function makeAuthCodeUsed($userId, $code);

  public function sendLimit($userId, $userIp);

  public function updateAuthCode($authCode);

  public function createAuthCode($authCode);

}