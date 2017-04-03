<?php namespace App\Http\V1_0\Controllers;

use App\Repositories\Interfaces\AreaInterface;
use App\Transformers\AreaTransformer;

class AreaController extends ApiController {

  public function __construct(AreaInterface $area)
  {
    $this->area = $area;
  }

  public function index()
  {
    $areas = $this->area->getAllArea();
    return $this->response->collection($areas, new AreaTransformer());
  }
}