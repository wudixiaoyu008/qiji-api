<?php namespace App\Transformers;

use Coolcode\Shared\Entities\User;
use League\Fractal\TransformerAbstract;

class UserInfoTransformer extends TransformerAbstract {
  public function transform(User $user)
  {
    $userInfo = $user->info;
    return [
      'id'               => $userInfo->user_id,
      'realname'         => $userInfo->real_name,
      'avatar_url'       => $userInfo->avatar_url,
      'gender'           => $userInfo->gender,
      'intro'            => $userInfo->intro,
      'tech_levels'      => $this->transformTechLevels($user->techLevels),
      'tech_stars'       => $this->transformTechStars($user->userTechStars),
      'schools'          => $user->schools,
      'areas'            => $user->areaUsers,
    ];
  }

  public function transformTechStars($userTechStars)
  {
    $data = [];

    foreach($userTechStars as $key => $userTechStar) {
      $data += [
        $key => [
          'id'               => $userTechStar->id,
          'count_tech_stars' => $userTechStar->count_tech_stars,
          'tech_category'    => $userTechStar->techCategory,
        ]
      ];
    }

    return $data;
  }

  public function transformTechLevels($techLevels)
  {
    $data = [];

    foreach($techLevels as $key => $techLevel) {
      $data += [
        $key => [
          'id'              => $techLevel->id,
          'name'            => $techLevel->name,
          'tech_category'   => $techLevel->techCategory,
        ]
      ];
    }

    return $data;
  }
}
