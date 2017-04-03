<?php namespace App\Repositories\Interfaces;


interface ArticleInterface {
  
  public function getArticleById($articleId);

  public function changeNohelps($articleId,$createdUserId);
}

