<?php namespace App\Http\V1_0\Controllers;

use App\Repositories\Interfaces\ClassMenteesInterface;
use App\Transformers\ClassCurrentMenteesTransformer;
use App\Transformers\ClassExitedMenteesTransformer;

class MenteeController extends ApiController {

  public function __construct(ClassMenteesInterface $classMentees)
  {
    $this->classMentees = $classMentees;
  }

  public function getCurrentMentees($classId)
  {

    $currentMenteeRecord = $this->classMentees->getCurrentClassMenteeInfo($classId);

    return $this->response->collection($currentMenteeRecord, new ClassCurrentMenteesTransformer());
  }

  public function getExitedMentees($classId)
  {

    $exitedMenteeRecord = $this->classMentees->getExitedClassMenteeInfo($classId);

    return $this->response->collection($exitedMenteeRecord, new ClassExitedMenteesTransformer());

  }

}