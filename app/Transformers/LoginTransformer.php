<?php namespace App\Transformers;

use Coolcode\Shared\Entities\User;
use League\Fractal\TransformerAbstract;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginTransformer extends TransformerAbstract {

  public function transform(User $user) {
    $classId = isset($user->aClass->class_id) ? $user->aClass->class_id : 0;
    return [
      'id'         => $user->id,
      'class_id'   => $classId,
      'mobile'     => $user->mobile,
      'email'      => $user->email,
      'nickname'   => $user->info->nickname,
      'avatar_url' => $user->info->avatar_url,
      'token'      => JWTAuth::fromUser($user),
    ];
  }
}