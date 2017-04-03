<?php namespace App\Transformers;

use Coolcode\Shared\Entities\Job;
use League\Fractal\TransformerAbstract;

class JobTransformer extends TransformerAbstract {
  public function transform(Job $job)
  {
    return [
      'id'                 => $job->id,
      'name'               => $job->name,
      'company'            => $job->company,
      'tech_level_id'      => $job->tech_level_id,
      'wage_pay_way'       => $job->wage_pay_way,
      'wage'               => $job->wage,
      'required_work_time' => $this->transformWorkTime(
        $job->work_time_begin, $job->work_time_end, $job->required_work_time),
      'required_degree'    => $job->required_degree,
    ];
  }

  public function transformWorkTime($begin, $end, $workTime)
  {
    return $begin.'~'.$end.', '.$workTime;
  }
}