<?php namespace App\Http\V1_0\Controllers;

use App\Repositories\Interfaces\JobInterface;
use App\Transformers\JobTransformer;
use Coolcode\Shared\Enums\JobGrade;
use Illuminate\Http\Request;

class JobController extends ApiController {

  public function __construct(JobInterface $jobInterface)
  {
    $this->jobInterface = $jobInterface;
  }

  public function index(Request $request, JobTransformer $jobTransformer)
  {
    $grade = $request->has('grade') ? $request->grade : JobGrade::ALL;
    $jobs = $this->jobInterface->getJobs($grade);

    return $this->response->collection($jobs, $jobTransformer);
  }
}