<?php namespace App\Transformers;

use Coolcode\Shared\Entities\Classes;
use League\Fractal\TransformerAbstract;

class MyMenteeTransformer extends TransformerAbstract {

  public function transform(Classes $classes)
  {
    return [
      'name'                  => $classes->name,
      'count_current_mentees' => $classes->count_current_mentees,
      'mentees'               => $this->transformMentees($classes->mentees),
    ];
  }

  private function transformMentees($mentees)
  {
    $datas = [];
    foreach ($mentees as $key => $value) {
      $datas += [
        $key => [
          'id'          => $value->menteeInfo->user_id,
          'nickname'    => $value->menteeInfo->nickname,
          'real_name'   => $value->menteeInfo->real_name,
          'avatar_url'  => $value->menteeInfo->avatar_url,
          'count_days'  => $value->count_days,
          'joined_at'   => $value->joined_at,
          'deadline_at' => $value->deadline_at,
        ],
      ];
    }

    return $datas;
  }
}
