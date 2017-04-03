<?php namespace App\Transformers;

use Coolcode\Shared\Entities\Course;
use Coolcode\Shared\Enums\TeachMode;

class CourseListTransformer extends BaseTransformer {
  public function transform(Course $course)
  {
    return [
      'id'                       => $course->id,
      'title'                    => $course->title,
      'price'                    => $course->price,
      'slot_begin'               => strtotime($course->slot_begin),
      'duration'                 => $course->duration,
      'duration_text'            => $course->duration_text,
      'count_current_audiences'  => $course->count_current_audiences,
      'upper_limit_audiences'    => $course->upper_limit_audiences,
      'teaching_way'             => $this->transformTeachMode($course->teaching_way),
      'teaching_location'        => $course->teaching_location,
      'lecturer'                 => $this->userTransform($course->lecturer),
      'tech_categories'          => $this->transformTechCategories($course->techCategories),
    ];
  }
  
  public function transformTeachMode($teachingMode)
  {
    switch ($teachingMode) {
      case TeachMode::ONLINE:
        return trans('strings.courses.online');
      case TeachMode::OFFLINE:
        return trans('strings.courses.offline');
      default:
        return NULL;
    }
  }
  
  public function transformTechCategories($techCategories)
  {
    $ret = collect(collect());
    foreach ($techCategories as $techCategory) {
      $ret->push([
        'id'        => $techCategory->id,
        'name'      => $techCategory->name
      ]);
    }
    
    return $ret;
  }
}