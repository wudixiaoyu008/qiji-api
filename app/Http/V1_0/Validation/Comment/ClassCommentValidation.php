<?php namespace App\Http\V1_0\Validation\Comment;

use App\Http\Common\BaseValidation;

class ClassCommentValidation extends BaseValidation {

  public function rules()
  {
    return [
      'class_id' => 'required',
      'content' => 'required'
    ];
  }

  public function forbiddenResponse() {
    return $this->response->errorForbidden(trans('validation.parameters.invalid'));
  }
}