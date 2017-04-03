<?php namespace App\Transformers;

use Coolcode\Shared\Entities\TaskComment;
use League\Fractal\TransformerAbstract;

class TaskCommentsTransformer extends TransformerAbstract {
  public function transform(TaskComment $taskComment)
  {

    return [
      'id'            => $taskComment->id,
      'is_evaluation' => $taskComment->is_evaluation,
      'content'       => $taskComment->content,
      'created_time'  => $taskComment->updated_at,
      'commenter'     => $taskComment->reviewer,
      'reply'         => $taskComment->reply == null ? null : $this->replyTransform($taskComment->reply)
    ];
  }

  public function replyTransform(TaskComment $replyComment)
  {
    if (null == $replyComment) return $replyComment;

    return [
      'id'        => $replyComment->id,
      'content'   => $replyComment->content,
      'commenter' => $replyComment->reviewer
    ];
  }

}