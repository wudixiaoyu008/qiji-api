<?php namespace App\Transformers;

use Coolcode\Shared\Entities\ClassMenteeRecord;

class ClassExitedMenteesTransformer extends BaseTransformer {

  public function transform(ClassMenteeRecord $classMentees)
  {
    $joinedTimestamp = strtotime($classMentees->joined_at);
    $deadlineTimestamp = strtotime($classMentees->deadline_at);

    return [
      'mentee_info'        => $this->userTransform($classMentees->menteeInfo),
      'expecting_to_study' => $classMentees->expecting_to_study,
      'tech_level'         => $this->transformTechLevel($classMentees->techLevel),
      'joined_at'          => $classMentees->joined_at,
      'deadline_at'        => $classMentees->deadline_at,
      'learned_day'        => intval(($deadlineTimestamp - $joinedTimestamp) / 86400),
      'class_evaluation'   => strlen($classMentees->class_evaluation) > 30 ? substr($classMentees->class_evaluation, 0, 28) . "……" : $classMentees->class_evaluation,
    ];
  }

  private function transformTechLevel($items)
  {
    $data = [];
    foreach ($items as $key => $value) {
      $data += [
        $key => [
          'tech_level' => $value['techCategory']['name'] . $value['name'],
        ],
      ];
    }

    return collect($data)->implode('tech_level', "、");
  }
}