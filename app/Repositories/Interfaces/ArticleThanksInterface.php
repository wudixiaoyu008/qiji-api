<?php namespace App\Repositories\Interfaces;

interface ArticleThanksInterface {

  public function storeOrDeleteArticleThanks($userId, $articleId);

}