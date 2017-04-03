<?php namespace App\Transformers;

use Coolcode\Shared\Entities\Area;

class AreaTransformer extends BaseTransformer {

  public function transform(Area $area)
  {
    return [
      'name'            => $area->name,
      'parent_area_id'  => $area->parent_area_id,
      'count_companies' => $area->count_companies
    ];
  }
}