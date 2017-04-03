<?php namespace App\Transformers;

use Coolcode\Shared\Entities\Classes;
use Coolcode\Shared\Enums\TeachMode;

class ClassDetailsTransformers extends BaseTransformer {

  public function transform(Classes $classes)

  {
    return [
      'id'                       => $classes->id,
      'name'                     => $classes->name,
      'status'                   => $classes->status,
      'mentor'                   => $classes->mentor,
      'intro'                    => $classes->intro,
      'price'                    => $classes->price,
      'mode'                     => $this->transformTeachingMode($classes->mode),
      'area'                     => $classes->area,
      'location'                 => $classes->location,
      'philosophy'               => $classes->philosophy,
      'tech_categories'          => $classes->tech_categories,
      'teaching_time'            => $classes->teaching_time,
      'count_current_mentees'    => $classes->count_current_mentees,
      'count_max_mentees'        => $classes->count_max_mentees,
      'count_exit_mentees'       => $classes->count_exit_mentees,
      'count_graduation_mentees' => $classes->count_graduation_mentees,

    ];
  }

  private function transformTeachingMode($teachingMode)
  {
    if ($teachingMode == TeachMode::OFFLINE) {
      return trans('strings.classes.offline');
    } elseif ($teachingMode == TeachMode::ONLINE) {
      return trans('strings.classes.online');
    } else {
      return null;
    }
  }
}