<?php namespace App\Http\V1_0\Controllers;

use App\Repositories\Interfaces\MyInterface;
use App\Transformers\ArticleTransformer;
use App\Transformers\MyClassesTransformer;
use App\Transformers\MyCourseTransformer;
use App\Transformers\MyMenteeTransformer;
use App\Transformers\UserTechStarTransformer;
use JWTAuth;


class MyController extends ApiController {

  private $userId;

  public function __construct(MyInterface $myInterface)
  {
    $this->myInterface = $myInterface;

    # Every method in this Controller should use this user ID.
    $this->userId = JWTAuth::parseToken()->authenticate()->id;
  }

  public function techStars(UserTechStarTransformer $techStarTransformer, $categoryId)
  {

    $results = $this->myInterface->getTechStars($this->userId, $categoryId);

    return $this->response->collection($results, $techStarTransformer);

  }

  public function articles(ArticleTransformer $articleTransformer)
  {
    $articles = $this->myInterface->getArticles($this->userId);

    return $this->response->collection($articles, $articleTransformer);

  }

  public function classes(MyClassesTransformer $myClassesTransformer)
  {
    $myClasses = $this->myInterface->getClasses($this->userId);

    return $this->response->collection($myClasses, $myClassesTransformer);
  }

  public function courses(MyCourseTransformer $myCourseTransformer)
  {
    $myCourse = $this->myInterface->getCourses($this->userId);

    return $this->response->collection($myCourse, $myCourseTransformer);
  }

  public function mentees(MyMenteeTransformer $myMenteeTransformer)
  {
    $mentees = $this->myInterface->getMentees($this->userId);

    return $this->response->collection($mentees, $myMenteeTransformer);
  }
}