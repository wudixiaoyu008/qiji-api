<?php namespace App\Transformers;

use Coolcode\Shared\Entities\Article;

class ArticleTransformer extends BaseTransformer {

  public function transform(Article $article)
  {
    return [
      'id'                   => $article->id,
      'title'                => $article->title,
      'intro'                => $article->intro,
      'writer'               => $this->userTransform($article->writer),
      'tech_category'        => $article->techCategory,
      'reviewer_evaluations' => $this->reviewerTransform($article->reviewerEvaluations),
    ];
  }

  protected function reviewerTransform($items)
  {
    $data = [];

    foreach ($items as $key => $item) {
      $data += [
        $key => [
          'commenter'    => $this->userTransform($item->reviewer),
          'content'      => $item->reviewer_remark,
          'created_time' => $item->reviewed_time,
        ],
      ];
    }

    return $data;
  }
}