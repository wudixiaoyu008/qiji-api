<?php namespace App\Repositories;

use Coolcode\Shared\Entities\TaskComment;
use App\Repositories\Interfaces\TaskInterface;
use Coolcode\Shared\Entities\TaskDeveloper;
use Coolcode\Shared\Entities\Task;
use Coolcode\Shared\Entities\TaskImage;
use Exception;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TaskRepository implements TaskInterface {

  public function evaluateTask($data)
  {
    try {
      $task = Task::findOrFail($data['task_id']);
      $taskDeveloper = TaskDeveloper::with('developer')
        ->where('task_id', $data['task_id'])
        ->findOrFail($data['task_developer_id']);

      foreach ($data['image_urls'] as $url) {
        $taskImage = new TaskImage();
        $taskImage->task_id = $data['task_id'];
        $taskImage->image_url = $url;
        $taskImage->save();
      }

      $taskComment = new TaskComment();
      $taskComment->task()->associate($task);
      $taskComment->is_evaluation = false;
      $taskComment->content = $data['content'];
      $taskComment->created_user_id = $data['user_id'];
      $taskComment->developer()->associate($taskDeveloper);
      $taskComment->save();
    } catch (Exception $e) {
      throw new HttpException(500, trans('failure.comment.fail'));
    }

    return $taskComment;
  }

  public function getTaskComments($taskId)
  {
    $taskComments = TaskComment::where('task_id', $taskId)->get();

    return $taskComments;
  }

  public function getTaskList($userId)
  {
    $taskId=TaskDeveloper::where('reviewer_user_id', $userId)
      ->where('status', 3)
      ->pluck('task_id')
      ->toArray();
    //选出相应任务 并带有项目和开发者数据
    $tasks=Task::with(
      [
        'developers' => function($query)use($userId) {
          $query->where(['reviewer_user_id'=>$userId,'status'=>3]);
        },
        'project'
      ])
      ->find($taskId);

    return $tasks;
  }
}