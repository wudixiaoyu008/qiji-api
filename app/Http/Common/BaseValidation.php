<?php namespace App\Http\Common;

use Dingo\Api\Exception\ResourceException;

abstract class BaseValidation
{

  protected $response;

  public function __construct()
  {
    $this->response = app('Dingo\Api\Http\Response\Factory');
  }

  public function rules()
  {
    return [];
  }

  public function authorize()
  {
    return true;
  }

  public function forbiddenResponse()
  {
    return $this->response->errorForbidden(trans('validation.forbidden.use'));
  }

  public function errorResponse(array $errors)
  {
    throw new ResourceException(trans('validation.parameters.invalid'), $errors);
  }
}