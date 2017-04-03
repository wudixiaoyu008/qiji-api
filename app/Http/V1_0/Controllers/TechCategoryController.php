<?php namespace App\Http\V1_0\Controllers;

use App\Repositories\Interfaces\TechCategoryInterface;
use Illuminate\Http\Request;

class TechCategoryController extends ApiController {
  public function __construct(TechCategoryInterface $techCategory)
  {
    $this->techCategory = $techCategory;
  }

  /**
   * 获取技术分类列表信息
   * @param Request $request
   * @param int $parentCategoryId
   * @return mixed
   */
  public function index(Request $request, $parentCategoryId = 0)
  {
    $parentCategoryId = $request->has('parent_category_id') ? $request->parent_category_id : $parentCategoryId;
    $techCategories = $this->techCategory->findSubcategories($parentCategoryId);
    return $this->response->collection($techCategories, new TechCategoryTransformer());
  }
}