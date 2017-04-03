<?php namespace App\Repositories\Interfaces;

interface ClassesInterface {
  public function getAllClasses($params);

  public function getClassDetails($classId);

  public function getClassIntro($classId);
}