<?php namespace App\Http\V1_0\Controllers;

use App\Repositories\Interfaces\CourseInterface;
use App\Transformers\CourseListTransformer;
use App\Transformers\CourseTransformer;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class CourseController extends ApiController {

  public function __construct(CourseInterface $courseInterface)
  {
    $this->courseInterface = $courseInterface;
  }

  public function show($id)
  {
    $comments_count = Input::get('comments_count');
    $comments_count == null ? $comments_count = 5 : null;
    $course = $this->courseInterface->getCourseDetail($id, $comments_count);

    return $this->response->item($course, new CourseTransformer());
  }

  public function index(Request $request)
  {
    $para['last_slot_begin'] = $request->input('last_slot_begin', 0);
    $para['last_id'] = $request->input('last_id', 0);
    $para['per_page'] = $request->input('per_page', 10);
    $para['tech_category_id'] = $request->input('tech_category_id');
    $para['teaching_way'] = $request->input('teaching_way');
    $para['area_id'] = $request->input('area_id');
    $para['duration'] = $request->input('duration');

    $courses = $this->courseInterface->getCoursesList($para);

    return $this->response->collection($courses, new CourseListTransformer());
  }
}