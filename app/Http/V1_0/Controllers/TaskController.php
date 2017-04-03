<?php namespace App\Http\V1_0\Controllers;


use App\Transformers\TaskCommentsTransformer;
use App\Repositories\Interfaces\TaskInterface;
use App\Transformers\TobeCommentTasksTransformer;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends ApiController {

  public function __construct(TaskInterface $taskInterface)
  {
    $this->taskInterface = $taskInterface;
  }

  public function evaluateTask(Request $request, $taskId)
  {
    $this->validate($request, [
      'content'           => 'required',
      'task_developer_id' => 'required|numeric'
    ]);

    $data['content']           = $request->input('content');
    $data['task_developer_id'] = $request->input('task_developer_id');
    $data['image_urls']        = $request->input('image_urls', []);
    $data['task_id']           = $taskId;
    $data['user_id']           = JWTAuth::parseToken()->authenticate()->id;

    $this->taskInterface->evaluateTask($data);

    return $this->response()->array(['message' => trans('success.comment.done')]);
  }

  public function index(TaskCommentsTransformer $taskCommentsTransformer, $taskId)
  {
    $taskComments = $this->taskInterface->getTaskComments($taskId);

    return $this->response->collection($taskComments, $taskCommentsTransformer);
  }

  public function unCommentTask()
  {
    $user = \JWTAuth::parseToken()->authenticate();
    $userId = $user->id;
    $toBecommentTasks = $this->taskInterface->getTaskList($userId);

    return $this->response->collection($toBecommentTasks, new TobeCommentTasksTransformer);
  }

}