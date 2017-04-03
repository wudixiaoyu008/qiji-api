<?php namespace App\Repositories\Interfaces;

interface ResumeInterface {

  public function getResumesLists($params);
  public function getResume($id);
}