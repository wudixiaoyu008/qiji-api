<?php namespace App\Http\V1_0\Controllers;


use App\Repositories\Interfaces\ArticleThanksInterface;
use JWTAuth;

class ArticleThanksController extends ApiController {

  public function __construct(ArticleThanksInterface $articleThanksInterface)
  {
    $this->articleThanksInterface = $articleThanksInterface;
  }

  public function thanks($articleId)
  {
    $user = JWTAuth::parseToken()->authenticate();
    $userId = $user->id;

    if ($this->articleThanksInterface->storeOrDeleteArticleThanks($userId, $articleId)) {
      return $this->response->array([
        'message' => trans('success.article_thanks.thanks'),
      ]);
    }

    return $this->response->array([
      'message' => trans('success.article_thanks.delete'),
    ]);
  }

}