<?php namespace App\Http\V1_0\Controllers;

use App\Http\Common\BaseValidation;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class ApiController extends BaseController
{
  use Helpers;

  public function validateRequest(Request $request, BaseValidation $validation)
  {
    if (!$validation->authorize()) {
      $validation->forbiddenResponse();
    }

    $validator = $this->getValidationFactory()->make($request->all(), $validation->rules());

    if ($validator->fails()) {
      $validation->errorResponse($this->formatValidationErrors($validator));
    }
  }

}
