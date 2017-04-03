<?php namespace App\Transformers;

use Coolcode\Shared\Entities\TechCategory;

class TechCategoryTransformer extends BaseTransformer {
  public function transform(TechCategory $techCategory)
  {
    return [
      'id'           => $techCategory->id,
      'name'         => $techCategory->name,
      'english_name' => $techCategory->english_name,
      'icon_url'     => $techCategory->icon_url
    ];
  }
}