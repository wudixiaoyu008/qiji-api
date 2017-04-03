<?php namespace App\Repositories\Interfaces;

interface TechCategoryInterface {

  public function findSubcategories($parentCategoryId);

}