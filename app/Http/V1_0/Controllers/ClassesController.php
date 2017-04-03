<?php namespace App\Http\V1_0\Controllers;

use App\Repositories\Interfaces\ClassesInterface;
use App\Transformers\ClassDetailsTransformers;
use App\Transformers\ClassesListsTransformer;
use Illuminate\Http\Request;

class ClassesController extends ApiController {

  public function __construct(ClassesInterface $classesInterface)
  {
    $this->classesInterface = $classesInterface;
  }

  public function index(Request $request)
  {
    $this->validate($request, [
      'mode'             => 'numeric',
      'area_id'          => 'numeric',
      'tech_category_id' => 'numeric',
      'is_full_time'     => 'numeric',
    ]);

    $params = $request->all();
    $classes = $this->classesInterface->getAllClasses($params);

    return $this->response->collection($classes, new ClassesListsTransformer());

  }

  public function show($classId)
  {
    $details = $this->classesInterface->getClassDetails($classId);

    return $this->response->item($details, new ClassDetailsTransformers());
  }

  public function showIntro($classId)
  {
    $intro = $this->classesInterface->getClassIntro($classId);

    return view('intro', ['intro' => $intro]);
  }

  //显示班级报名规则HTML页面
  public function registrationRules()
  {
    return view('registrationRules');
  }

  //
  public function renewalRules()
  {
    return view('renewalRules');
  }


}