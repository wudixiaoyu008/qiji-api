<?php namespace App\Repositories\Interfaces;


interface ClassMenteesInterface {

  public function getCurrentClassMenteeInfo($classId);

  public function getExitedClassMenteeInfo($classId);

}