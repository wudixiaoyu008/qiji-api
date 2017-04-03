<?php namespace App\Transformers;

use Coolcode\Shared\Entities\Task;
use League\Fractal\TransformerAbstract;

class UserTechStarTransformer extends TransformerAbstract {

  public function transform(Task $task)
  {
    return [
      'id'                   => $task->id,
      'developer'            => $task->developers[0]->developer,
      'project'              => $task->project,
      'name'                 => $task->name,
      'completion_days'      => $task->developers[0]->completion_days,
      'tech_stars'           => $task->tech_stars,
      'images'               => $task->images,
      'reviewer_evaluations' => $this->transformReviews($task->comments)
    ];
  }

  public function transformReviews($items)
  {
    $data = [];

    foreach ($items as $key => $item) {
      $data += [
        $key => [
          'created_user' => $item->reviewer,
          'content'      => $item->content,
          'created_at'   => $item->updated_at
        ]
      ];
    }

    return $data;
  }
}