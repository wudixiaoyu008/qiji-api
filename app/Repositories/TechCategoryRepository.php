<?php namespace App\Repositories;

use App\Repositories\Interfaces\TechCategoryInterface;
use Coolcode\Shared\Entities\TechCategory;

class TechCategoryRepository Implements TechCategoryInterface {
  public function findSubcategories($parentCategoryId)
  {
    $techCategories = TechCategory::where('parent_category_id', $parentCategoryId)->get();
    return $techCategories;
  }
}