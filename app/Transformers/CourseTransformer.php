<?php namespace App\Transformers;

use Coolcode\Shared\Entities\Course;

class CourseTransformer extends BaseTransformer {

  public function transform(Course $course)
  {
    return [
      'title'                   => $course->title,
      'lecture_user_id'         => $course->lecture_user_id,
      'price'                   => $course->price,
      'icon_url'                => $course->icon_url,
      'duration_text'           => $course->duration_text,
      'slot_end'                => $course->slot_begin,
      'teaching_way'            => $course->teaching_way,
      'teaching_location'       => $course->teaching_location,
      'intro'                   => $course->intro,
      'count_current_audiences' => $course->count_current_audiences,
      'upper_limit_audiences'   => $course->upper_limit_audiences,
      'comment'                 => $course->comments
    ];
  }
}