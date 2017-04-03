<?php namespace App\Repositories\Interfaces;


Interface QuestionInterface {

  public function toggleCollection($answerId, $createdUserId);
}