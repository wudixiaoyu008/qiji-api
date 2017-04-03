<?php namespace App\Repositories;

use Coolcode\Shared\Entities\Resume;
use App\Repositories\Interfaces\ResumeInterface;

class ResumeRepository implements ResumeInterface {

  public function getResumesLists($params)
  {
    $resumes = Resume::with('user');
    //根据区域id返回简历列表
    if ($params['area_id']) {
      $resumes = Resume::whereHas('user.desiredArea', function ($query) use ($params) {
        $query->where('areas.id', $params['area_id']);
      });
    }
    //根据技术级别返回简历列表
    if ($params['tech_level_id']) {
      $resumes = Resume::whereHas('user.techLevels', function ($query) use ($params) {
        $query->where('tech_levels.id', $params['tech_level_id']);
      });
    }
    //根据期待薪资支付方式及范围返回简历列表
    if (isset($params['salary_pay_way'])) {
      $resumes = $resumes->where('desired_salary_pay_way', (int)$params['salary_pay_way'])
        ->whereBetween('desired_salary', [(int)$params['mix_salary'], (int)$params['max_salary']]);
    }

    if ($params['max_id']) {
      $resumes = $resumes->where('id', '<', $params['max_id']);
    } else if ($params['since_id']) {
      $resumes = $resumes->where('id', '>', $params['since_id']);
    }

    return $resumes->orderby('updated_at', 'desc')
                 ->take($params['page_size'])
                 ->get();
  }

  public function getResume($id)
  {
    return Resume::find($id);
  }
}