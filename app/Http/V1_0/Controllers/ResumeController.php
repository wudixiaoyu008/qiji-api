<?php namespace App\Http\V1_0\Controllers;

use App\Transformers\ResumesListsTransformer;
use App\Transformers\ResumeDetailsTransformer;
use App\Repositories\Interfaces\ResumeInterface;
use Illuminate\Http\Request;

class ResumeController extends ApiController {

  public function __construct(ResumeInterface $resumeInterface)
  {
    $this->resumeInterface = $resumeInterface;
  }

  public function index(Request $request)
  {
    $this->validate($request, [
      'mix_salary'       => 'numeric',
      'max_salary'       => 'numeric',
    ]);
    $params['since_id'] = $request->input('since_id');
    $params['max_id'] = $request->input('max_id');
    //每页显示条数， 默认为 10
    $params['page_size'] = $request->input('page_size', 10);
    $params['area_id'] = $request->input('area_id');
    $params['tech_level_id'] = $request->input('tech_level_id');
    $params['salary_pay_way'] = $request->input('salary_pay_way');
    //期望工资范围， 默认为不限
    $params['mix_salary'] = $request->input('mix_salary', 0);
    $params['max_salary'] = $request->input('max_salary', PHP_INT_MAX);

    $resumes = $this->resumeInterface->getResumesLists($params);
    return $this->response->collection($resumes, new ResumesListsTransformer());
  }

  public function show($id)
  {
    $resume = $this->resumeInterface->getResume($id);
    return $this->response->item($resume, new ResumeDetailsTransformer());
  }
}