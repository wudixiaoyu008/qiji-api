<?php namespace App\Repositories;

use App\Repositories\Interfaces\ClassMenteesInterface;
use Coolcode\Shared\Entities\ClassMenteeRecord;
use Coolcode\Shared\Enums\StatusOfMentee;

class ClassMenteesRepository implements ClassMenteesInterface {

  public function getCurrentClassMenteeInfo($classId)
  {

    return ClassMenteeRecord::with('menteeInfo', 'techLevel.techCategory')
      ->where('class_id', $classId)
      ->where('status', StatusOfMentee::STUDY)
      ->get();

  }

  public function getExitedClassMenteeInfo($classId)
  {

    return ClassMenteeRecord::with('menteeInfo', 'techLevel.techCategory')
      ->where('class_id', $classId)
      ->where('status', StatusOfMentee::GRADUATION)
      ->get();
  }

}