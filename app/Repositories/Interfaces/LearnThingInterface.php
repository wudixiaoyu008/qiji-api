<?php namespace App\Repositories\Interfaces;

interface LearnThingInterface {
  public function storeLearnThing($userId, $techCategoryId, $content);
}