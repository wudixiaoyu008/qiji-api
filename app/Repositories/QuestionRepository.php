<?php namespace App\Repositories;

use App\Repositories\Interfaces\QuestionInterface;
use Coolcode\Shared\Entities\Answer;
use Coolcode\Shared\Entities\AnswerCollection;
use Coolcode\Shared\Entities\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class QuestionRepository Implements QuestionInterface {

  public function toggleCollection($answerId, $createdUserId)
  {

    if (!Answer::find($answerId)) {
      throw new HttpException(Response::HTTP_NOT_FOUND, trans('failure.answer.answer_not_exist'));
    }

    if (!User::find($createdUserId)) {
      throw new HttpException(Response::HTTP_NOT_FOUND, trans('failure.answer.user_not_found'));
    }

    $collections = AnswerCollection::where('answer_id', $answerId)
      ->where('created_user_id', $createdUserId);

    if (!$collections->get()->isEmpty()) {
        $collections->delete();      //防止出现异常重复记录，删除所有查询结果

      return true;
    }
    $questionId = Answer::where('id', $answerId)->value('question_id');
    $articleId  = Answer::where('id', $answerId)->value('article_id');
    AnswerCollection::create([
      'question_id'     => $questionId,
      'article_id'      => $articleId,
      'answer_id'       => $answerId,
      'created_user_id' => $createdUserId
    ]);

    return false;
  }
}