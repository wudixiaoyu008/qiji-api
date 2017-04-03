<?php namespace App\Repositories;

use App\Repositories\Interfaces\LearnThingInterface;
use Coolcode\Shared\Entities\LearnThing;

class LearnThingRepository implements LearnThingInterface {
  public function storeLearnThing($userId, $techCategoryId, $content)
  {
    $learnThing = LearnThing::create([
      'created_user_id'  => $userId,
      'tech_category_id' => $techCategoryId,
      'content'          => $content
    ]);

    return $learnThing;
  }
}