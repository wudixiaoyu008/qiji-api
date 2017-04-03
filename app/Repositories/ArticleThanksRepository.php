<?php namespace App\Repositories;

use App\Repositories\Interfaces\ArticleThanksInterface;
use Coolcode\Shared\Entities\ArticleThanks;

class ArticleThanksRepository implements ArticleThanksInterface {

  private function storeArticleThanks($userId, $articleId)
  {
    $articleThanks = ArticleThanks::create([
      'article_id' => $articleId,
      'created_user_id' => $userId
    ]);

    return $articleThanks;
  }

  private function ifExistsArticleThanks($userId, $articleId)
  {
    $articleThanks = ArticleThanks::where('created_user_id', $userId)
      ->where('article_id', $articleId)
      ->get();

    return $articleThanks;
  }

  private function deleteArticleThanks($userId, $articleId)
  {
    $this->ifExistsArticleThanks($userId, $articleId)[0]->delete();
  }

  public function storeOrDeleteArticleThanks($userId, $articleId)
  {
    $articleThanks = $this->ifExistsArticleThanks($userId, $articleId);
    if ($articleThanks->count()) {
      $this->deleteArticleThanks($userId, $articleId);

      return false;
    }
    $this->storeArticleThanks($userId, $articleId);

    return ture;
  }

}