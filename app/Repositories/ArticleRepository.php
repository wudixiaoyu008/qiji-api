<?php namespace App\Repositories;

use Coolcode\Shared\Entities\ArticleNohelp;
use App\Repositories\Interfaces\ArticleInterface;
use Coolcode\Shared\Entities\User;
use Coolcode\Shared\Entities\Article;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Coolcode\Shared\Entities\ArticleCollection;
use Coolcode\Shared\Entities\ArticleComment;
use Coolcode\Shared\Entities\ArticleThanks;
use Tymon\JWTAuth\Facades\JWTAuth;

class ArticleRepository implements ArticleInterface {

  public function changeNohelps($articleId,$createdUserId)
  {

    if(!Article::find($articleId)) {
      throw new HttpException(404,trans('failure.article.article_not_found'));
    }

    if(!User::find($createdUserId)) {
      throw new HttpException(500,trans('failure.article.user_not_found'));
    }

    $articleNohelpToChange = ArticleNohelp::where('article_id', $articleId)
      ->where('created_user_id', $createdUserId);

    if($articleNohelpToChange-> first()) {
      $articleNohelpToChange = ArticleNohelp::where('article_id', $articleId)
        ->where('created_user_id', $createdUserId)->first();

      $articleNohelpToChange-> articles()->decrement('count_nohelps');
      $articleNohelpToChange-> delete();

      return true;
    }

    $articleNohelpToChange = ArticleNohelp::create([
      'article_id'      => $articleId,
      'created_user_id' => $createdUserId,
    ]);

    $articleNohelpToChange->articles()->increment('count_nohelps');

    return false;
  }

  public function  getArticleById($articleId)
  {
    $token = JWTAuth::getToken();
    $article = Article::with('writer', 'reviewerEvaluation', 'thanked', 'nohelped', 'collectioned')
      ->findOrFail($articleId);
    $article->thanked = false;
    $article->collectioned = false;
    $article->nohelped = false;
    if($token){
      $userId = JWTAuth::parseToken()->authenticate()->id;
      $article->thanked = ArticleThanks::where(['article_id' => $articleId, 'created_user_id' => $userId])
        ->exists();
      $article->collectioned = ArticleCollection::where(['article_id' => $articleId, 'created_user_id' => $userId])
        ->exists();
      $article->nohelped = ArticleNohelp::where(['article_id' => $articleId, 'created_user_id' => $userId])
        ->exists();
    }
    $article->reviewerEvaluation = ArticleComment::with('user')
      ->where('article_id', $articleId)
      ->first();

    return $article;
  }
}
