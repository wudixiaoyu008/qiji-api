<?php namespace App\Transformers;

use Coolcode\Shared\Entities\Classes;

class ClassesListsTransformer extends BaseTransformer {

  public function transform(Classes $classes)
  {
    return [
      'id'                    => $classes->id,
      'mentor'                => $this->tranformMentor($classes->mentor),
      'name'                  => $classes->name,
      'intro'                 => $classes->intro,
      'price'                 => $classes->price,
      'tech_categories'       => $classes->tech_categories,
      'philosophy'            => $classes->philosophy,
      'mode'                  => $classes->mode,
      'location'              => $classes->location,
      'count_current_mentees' => $classes->count_current_mentees,
      'count_max_mentees'     => $classes->count_max_mentees,
      'comments'              => $this->transformClassComments($classes->comments),
    ];
  }

  //TODO: 先暂时返回第一个导师信息，后续用role进行管理
  private function tranformMentor($data)
  {
    if (count($data) > 0) {
      return [
        'id'           => $data[0]->user_id,
        'realname'     => $data[0]->real_name,
        'nickname'     => $data[0]->nickname,
        'avatar_url'   => $data[0]->avatar_url,
        'intro'        => $data[0]->intro,
        'is_full_time' => $data[0]->pivot->is_full_time ? true : false,
      ];
    }

    return null;
  }

  private function transformClassComments($comments)
  {
    $datas = [];
    foreach ($comments as $key => $value) {
      $datas += [
        $key => [
          'commenter' => $this->userTransform($value->menteeInfo),
          'content'   => strlen($value->class_evaluation) > 30 ? substr($value->class_evaluation, 0, 28) . "……" : $value->class_evaluation,
        ],
      ];
    }

    return $datas;
  }
}
