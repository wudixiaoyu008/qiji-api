<?php namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class BaseTransformer extends TransformerAbstract {

  public function userTransform($user)
  {
    return [
      'id'         => $user->user_id,
      'realname'   => $user->real_name,
      'nickname'   => $user->nickname,
      'avatar_url' => $user->avatar_url,
    ];
  }
}