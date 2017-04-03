<?php namespace App\Transformers;

use Coolcode\Shared\Entities\CourseAudience;

class MyCourseTransformer extends BaseTransformer {
  public function transform(CourseAudience $courseAudience)
  {
    return [
      'title'                         => $courseAudience->lecture->title,
      'lecturer_user_id'              => $courseAudience->lecturer_user_id,
      'name'                          => $courseAudience->user->realname,
      'mobile'                        => $courseAudience->mobile->mobile,
      'icon_url'                      => $courseAudience->lecture->icon_url,
      'duration'                      => $courseAudience->lecture->duration,
      'duration_text'                 => $courseAudience->lecture->duration_text,
      'slot_begin'                    => $courseAudience->lecture->slot_begin,
      'slot_end'                      => $courseAudience->lecture->slot_end,
      'teaching_way'                  => $courseAudience->lecture->teaching_way,
      'teaching_location'             => $courseAudience->lecture->teaching_location,
      'intro'                         => $courseAudience->lecture->intro,
    ];
  }
}