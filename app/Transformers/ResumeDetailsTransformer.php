<?php namespace App\Transformers;

use Coolcode\Shared\Entities\Resume;
use League\Fractal\TransformerAbstract;

class ResumeDetailsTransformer extends TransformerAbstract {

  public function transform(Resume $resume)
  {
    return [
      'id'                        => $resume->id,
      'price'                     => $resume->price,
      'user_info'                 => $resume->learningOutcomes,
      'is_coolcode_mentee'        => $resume->is_coolcode_mentee,
      'realname'                  => $resume->realname,
      'age'                       => $resume->age,
      'tech_level_names'          => $resume->tech_level_names,
      'desired_salary'            => $resume->desired_salary,
      'desired_salary_pay_way'    => $resume->desired_salary_pay_way,
      'price'                     => $resume->price,
      'trait'                     => $resume->trait,
      'desired_working_condition' => $resume->desired_working_condition,
      'degree'                    => $resume->degree,
      'professional'              => $resume->professional,
      'graduate_school'           => $resume->graduate_school,
      'skills'                    => $resume->skills,
      'experience'                => $resume->experience,
    ];
  }
}