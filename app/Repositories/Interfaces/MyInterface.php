<?php namespace App\Repositories\Interfaces;


interface MyInterface {

  public function getTechStars($userId, $categoryId);

  public function getArticles($userId);

  public function getCourses($userId);

  public function getClasses($userId);

  public function getMentees($userId);
}


