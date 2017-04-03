<?php namespace App\Repositories;

use Coolcode\Shared\Entities\Course;
use Coolcode\Shared\Entities\TechCategory;
use Coolcode\Shared\Enums\StatusOfCourse;
use App\Repositories\Interfaces\CourseInterface;

class CourseRepository implements CourseInterface
{
  public function getCourseDetail($id, $comment_count)
  {
    $course = Course::findOrFail($id);
    $comments = $course->comments()->limit($comment_count)->get();
    foreach ($comments as $comment) {
      $comment->user = $comment->audienceUser()->first();
    }
    $course->comments = $comments;
    return $course;
  }
  
  public function getCoursesList($para)
  {
    if ($para['last_id'] == null) $para['last_id'] = 0;
    if ($para['last_slot_begin'] == null) $para['last_slot_begin'] = 0;
    if ($para['per_page'] == null) $para['per_page'] = 10;
    if ($para['tech_category_id'] != null) {
      $query = TechCategory::find($para['tech_category_id'])->courses()
                           ->with('lecturer', 'techCategories');
    } else {
      $query = Course::with('lecturer', 'techCategories');
    }
    $query->where('status', StatusOfCourse::REVIEWED);
    if ($para['teaching_way'] != null) {
      $query->where('teaching_way', $para['teaching_way']);
    }
    if ($para['area_id'] != null) {
      $query->where('teaching_area_ids', 'like', '%|'.$para['area_id'].'|%');
    }
    if ($para['duration'] != null) {
      $query->where('duration', $para['duration']);
    }

    return $query->where('slot_begin', '>=', $para['last_slot_begin'])
                 ->where('id', '>' ,$para['last_id'])
                 ->orderBy('slot_begin', 'asc')
                 ->orderBy('id', 'asc')
                 ->limit($para['per_page'])
                 ->get();
  }
}