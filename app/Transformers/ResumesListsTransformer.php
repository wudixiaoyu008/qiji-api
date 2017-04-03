<?php namespace App\Transformers;

use Coolcode\Shared\Enums\SalaryPayment;
use Coolcode\Shared\Entities\Resume;
use League\Fractal\TransformerAbstract;

class ResumesListsTransformer extends TransformerAbstract {

  public function transform(Resume $resume)
  {
    $user = $resume->user->info;
    return [
      'id'                 => $resume->id,
      'view_price'         => $resume->view_price/100,
      'user'               => [
        'id'                  => $user->user_id,
        'avatar_url'          => $user->avatar_url,
        'realname'            => $user->real_name,
        'age'                 => $user->age,
        'count_coolcode_days' => $user->count_coolcode_days,
        'count_project_tasks' => $user->count_project_tasks,
        'count_articles'      => $this->transformCountArticle($resume->user->countArticle),
      ],
      'tech_levels'        => $resume->tech_levels,
      'desired_salary'     => $this->transformDesiredSalary($resume->desired_salary, $resume->desired_salary_pay_way),
      'desired_area'       => $this->transformDesiredArea($resume->user->desiredArea),
      'mentor_evaluations' => $this->transformMenteeEvaluation($resume->user->menteeEvaluation),
    ];
  }

  private function transformDesiredSalary($desiredSalary, $salaryPayment)
  {
    if ($salaryPayment == SalaryPayment::MONTHLY) {
      $transSalary = $desiredSalary/100 . ' 元/月';
    } else {
      $transSalary = $desiredSalary/100 . ' 元/天';
    }
    return $transSalary;
  }

  private function transformCountArticle($countArticles)
  {
    $data = [];
    foreach ($countArticles as $countArticle) {
      $data[] = $countArticle->count_articles;
    }
    return array_sum($data);
  }

  private function transformDesiredArea($desiredAreas)
  {
    $data = [];
    foreach ($desiredAreas as $key => $desiredArea) {
      $data += [
        $key => [
          'id'   => $desiredArea->id,
          'name' => $desiredArea->name,
        ]
      ];
    }
    return $data;
  }

  private function transformMenteeEvaluation($menteeEvaluations)
  {
    $data = [];
    foreach ($menteeEvaluations as $key => $menteeEvaluation) {
      $data += [
        $key => [
          'id'        => $menteeEvaluation->pivot->id,
          'content'   => $menteeEvaluation->pivot->content,
          'commenter' => [
            'id'       => $menteeEvaluation->user_id,
            'realname' => $menteeEvaluation->real_name,
          ]
        ]
      ];
    }
    return $data;
  }
}