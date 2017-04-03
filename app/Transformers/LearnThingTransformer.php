<?php namespace App\Transformers;

use Coolcode\Shared\Entities\LearnThing;

class LearnThingTransformer extends BaseTransformer {

  public function transform(LearnThing $learnThing)
  {
    return [
      'id'            => $learnThing->id,
      'created_user'  => $learnThing->user->realname,
      'tech_category' => $learnThing->techCategory->name,
      'content'       => $learnThing->content,
    ];
  }
}