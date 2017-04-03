<?php namespace App\Transformers;

use Coolcode\Shared\Entities\Project;
use Coolcode\Shared\Entities\Task;
use League\Fractal\TransformerAbstract;

class TobeCommentTasksTransformer extends TransformerAbstract {

  public function transform(Task $toBeCommentTask)
  {

    return [
      'id'          => $toBeCommentTask->id,
      'name'        => $toBeCommentTask->name,
      'tech_star'   => $toBeCommentTask->tech_stars,
      'project'     => $this->transformProject($toBeCommentTask->project),
      'developer'   => $toBeCommentTask->developers[0]->developer
    ];
  }

  public function transformProject(Project $project)
  {

    return [
      "id"       =>$project->id,
      "name"     =>$project->name,
      "home_url" =>$project->home_url
    ];
  }
}