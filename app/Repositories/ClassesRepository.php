<?php namespace App\Repositories;

use App\Repositories\Interfaces\ClassesInterface;
use Coolcode\Shared\Entities\Classes;
use Coolcode\Shared\Entities\ClassMenteeRecord;
use Coolcode\Shared\Enums\StatusOfClass;
use Coolcode\Shared\Enums\TeachMode;

class ClassesRepository implements ClassesInterface {

  public function getAllClasses($params)
  {
    $classes = Classes::with('mentor')->where('status', StatusOfClass::ENABLE);

    //筛选线上线下
    if (array_key_exists('mode', $params)) {
      $classes->where('mode', $params['mode']);

      //如果是线下，则需要选择区域
      if ($params['mode'] == TeachMode::OFFLINE && array_key_exists('area_id', $params)) {
        $classes->where('area_id', $params['area_id']);
      }
    }

    //按照技术分类筛选
    if (array_key_exists('tech_category_id', $params)) {
      $classes->whereHas('techCategory', function($query) use ($params) {
        $query->where('id', $params['tech_category_id']);
      });
    }

    //筛选导师
    if (array_key_exists('is_full_time', $params)) {
      $classes->whereHas('mentor', function($query) use ($params) {
        $query->where('is_full_time', $params['is_full_time']);
      });
    }

    $classes = $classes->orderBy('id', 'asc')->get();

    //结业学员评论
    foreach ($classes as $class) {
      $class['comments'] = ClassMenteeRecord::with('menteeInfo')
        ->where('class_id', $class->id)
        ->take(3)
        ->get();
    }

    return $classes;
  }

  public function getClassDetails($classId)
  {
    return Classes::find($classId);
  }

  public function getClassIntro($classId)
  {
    return Classes::where('id', $classId)->value('intro');
  }

}

