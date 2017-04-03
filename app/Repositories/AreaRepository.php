<?php namespace App\Repositories;

use App\Repositories\Interfaces\AreaInterface;
use Coolcode\Shared\Entities\Area;

class AreaRepository implements AreaInterface {


  public function getAreaById($areaId)
  {
    return Area::where('id', $areaId)->get();
  }

  public function getAllArea()
  {
    return Area::all();
  }
}