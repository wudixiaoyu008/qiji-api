<?php namespace App\Transformers;

use Coolcode\Shared\Entities\ClassMenteeRecord;

class ClassCurrentMenteesTransformer extends BaseTransformer {

  public function transform(ClassMenteeRecord $classMentees)
  {
    return [

      'mentee_info'        => $this->userTransform($classMentees->menteeInfo),
      'expecting_to_study' => $classMentees->expecting_to_study,
      'tech_level'         => $this->transformTechLevel($classMentees->techLevel),
      'joined_at'          => $classMentees->joined_at,
      'joined_day'         => intval((time() - $classMentees->joined_at) / 86400),
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