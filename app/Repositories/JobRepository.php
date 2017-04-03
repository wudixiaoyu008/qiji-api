<?php namespace App\Repositories;

use App\Repositories\Interfaces\JobInterface;
use Coolcode\Shared\Entities\Job;
use Coolcode\Shared\Enums\JobGrade;

class JobRepository Implements JobInterface {

  public function getJobs($grade)
  {
    $jobs = Job::with('company');

    if ($grade != JobGrade::ALL) {
      $jobs->whereIn('tech_level_id', JobGrade::MAP_TECH_LEVELS[$grade]);
    }

    return $jobs->get();
  }
}