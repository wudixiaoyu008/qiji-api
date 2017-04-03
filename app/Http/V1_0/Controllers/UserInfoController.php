<?php namespace App\Http\V1_0\Controllers;

use App\Transformers\UserInfoTransformer;
use App\Repositories\Interfaces\UserInterface;
use App\Entity\User;

class UserInfoController extends ApiController {
	
  public function __construct(UserInterface $userInterface)
  {
    $this->userInterface = $userInterface;
  }
	
  public function show($id)
  {
    $user = $this->userInterface->getUser($id);
    return $this->response->item($user, new UserInfoTransformer());
  }
}
