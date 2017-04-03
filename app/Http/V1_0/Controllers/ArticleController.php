<?php namespace App\Http\V1_0\Controllers;

use App\Repositories\Interfaces\ArticleInterface;
use App\Transformers\ArticleTransformer;
use JWTAuth;

class ArticleController extends ApiController {

  private $articleInterface;
  
  public function __construct(ArticleInterface $articleInterface)
  {
    return $this->articleInterface = $articleInterface;
  }
  
  public function show($articleId)
  {
    $article = $this->articleInterface->getArticleById($articleId);
    return $this->response->item($article, new ArticleTransformer());
  }

  public function changeNohelps($articleId)
  {
    $createdUserId = JWTAuth::parseToken()->authenticate();

    if ($this->articleInterface->changeNohelps($articleId, $createdUserId)) {

      return response(['message' => (trans('success.article.remove_nohelps'))]);
    }

    return response(['message' => (trans('success.article.add_nohelps'))]);

  }
}
