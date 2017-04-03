<?php namespace App\Http\V1_0\Controllers;

class ApiTestController extends ApiController
{
  public function test()
  {
    return $this->response()->array(['api 项目运行成功']);
  }
}
