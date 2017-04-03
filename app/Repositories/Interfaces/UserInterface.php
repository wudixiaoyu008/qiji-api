<?php

namespace App\Repositories\Interfaces;


interface UserInterface {

  /**
   * @param array $cat_id
   * @param $is_draft
   * @param $order
   * @param $take
   * @return mixed
   */
  public function findOrCreate($mobile);

  public function findUserId($mobile);

  public function getUser($userId);

  public function findOrCreateWithWechat($wechatId, $wechatInfo);

}