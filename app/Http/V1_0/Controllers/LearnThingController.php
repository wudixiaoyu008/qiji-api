<?php namespace App\Http\V1_0\Controllers;

use App\Repositories\Interfaces\LearnThingInterface;
use App\Transformers\LearnThingTransformer;
use Illuminate\Http\Request;
use JWTAuth;

class LearnThingController extends ApiController {

  public function __construct(LearnThingInterface $learnThingInterface)
  {
    $this->learnThingInterface = $learnThingInterface;
  }

  public function store(Request $request)
  {
    $this->validate($request, [
      'tech_category_id' => 'required|numeric',
      'content'          => 'required',
    ]);
    $user = JWTAuth::parseToken()->authenticate();
    $userId = $user->id;
    $techCategoryId = $request->tech_category_id;
    $content = $request->content;

    $learnThing = $this->learnThingInterface->storeLearnThing($userId, $techCategoryId, $content);

    return $this->response->item($learnThing, new LearnThingTransformer());
  }
}