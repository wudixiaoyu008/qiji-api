<?php namespace App\Transformers;

use Coolcode\Shared\Entities\ClassMenteeRecord;
use Coolcode\Shared\Enums\StatusOfMentee;
use League\Fractal\TransformerAbstract;

class MyClassesTransformer extends TransformerAbstract {

  public function transform(ClassMenteeRecord $classMentee)
  {
    return [
      'class'       => $this->transformClassName($classMentee->classes->name, $classMentee->status),
      'mentor'      => $classMentee->mentor,
      'joined_at'   => $classMentee->joined_at,
      'deadline_at' => $classMentee->deadline_at,
      'rest_day'    => $this->transformRestday(intval(($classMentee->deadline_at - time()) / 86400), $classMentee->status),
    ];
  }

  private function transformClassName($name, $menteeStatus)
  {
    if ($menteeStatus == StatusOfMentee::STUDY) {
      return trans('strings.mentees.study') . $name;
    }

    if ($menteeStatus == StatusOfMentee::COMPLETION) {
      return trans('strings.mentees.completion') . $name;
    }

    if ($menteeStatus == StatusOfMentee::GRADUATION) {
      return trans('strings.mentees.graduation') . $name;
    }

    return null;
  }

  private function transformRestday($restDay, $menteeStatus)
  {
    if ($menteeStatus == StatusOfMentee::STUDY) {
      return $restDay;
    } else {
      return 0;
    }
  }

}