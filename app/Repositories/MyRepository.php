<?php namespace App\Repositories;

use App\Repositories\Interfaces\MyInterface;
use Coolcode\Shared\Entities\Article;
use Coolcode\Shared\Entities\Classes;
use Coolcode\Shared\Entities\ClassMenteeRecord;
use Coolcode\Shared\Entities\ClassMentor;
use Coolcode\Shared\Entities\CourseAudience;
use Coolcode\Shared\Entities\MenteeMentor;
use Coolcode\Shared\Entities\Task;
use Coolcode\Shared\Entities\UserInfo;

class MyRepository implements MyInterface {

  public function getTechStars($userId, $categoryId)
  {
    $result = Task::with(
      [
        'project',
        'images',
        'comments'   => function($query) use ($userId) {
          return $query->where('task_developer_id', '=', $userId)
            ->where('is_evaluation', '=', 1);
        },
        'developers' => function($query) use ($userId) {
          return $query->where('developer_user_id', '=', $userId);
        },
      ])
      ->join('task_developers', function($join) use ($userId) {
        $join->on('task_developers.task_id', '=', 'tasks.id')
          ->where('task_developers.developer_user_id', '=', $userId);
      })
      ->select('tasks.*')
      ->where('tech_category_id', $categoryId)
      ->orderBy('tasks.id')
      ->get()
      ->unique();

    return $result;
  }

  public function getArticles($userId)
  {
    $articles = Article::with(['writer', 'techCategory', 'reviewerEvaluations'])
      ->where('created_user_id', $userId)
      ->get();

    return $articles;
  }

  public function getClasses($userId)
  {
    $myClasses = ClassMenteeRecord::where('mentee_user_id', $userId)->get();

    foreach ($myClasses as $myClass) {
      $mentorId = MenteeMentor::where('mentee_user_id', $myClass->mentee_user_id)
        ->where('class_id', $myClass->class_id)->value('mentor_user_id');

      $myClass['mentor'] = UserInfo::where('user_id', $mentorId)
        ->select('user_id as id', 'real_name as realname', 'nickname', 'avatar_url')
        ->first();
    }

    return $myClasses;
  }

  public function getCourses($userId)
  {
    $myCourse = CourseAudience::where('audience_user_id', $userId)->get();

    return $myCourse;
  }

  public function getMentees($userId)
  {
    $classId = ClassMentor::where('mentor_user_id', $userId)->pluck('class_id')->toArray();

    return Classes::with('mentees')->findOrFail($classId);
  }
}