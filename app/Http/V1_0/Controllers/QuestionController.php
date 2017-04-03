<?php namespace App\Http\V1_0\Controllers;

use App\Repositories\Interfaces\QuestionInterface;
use JWTAuth;

class QuestionController extends ApiController {

  public function __construct(QuestionInterface $questionInterface)
  {
    $this->questionInterface = $questionInterface;
  }

  public function toggleCollection($answerId)
  {
    $createdUserId = JWTAuth::parseToken()->authenticate()->id;

    if($this->questionInterface->toggleCollection($answerId, $createdUserId)) {

      return response(['message' => (trans('success.answers.remove_collection'))]);
    }

    return response(['message' => (trans('success.answers.add_collection'))]);
  }
}