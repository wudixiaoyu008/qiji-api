<?php namespace App\Repositories\Interfaces;

interface CourseInterface {

  public function getCourseDetail($id,$comment_count);
  
  public function getCoursesList($para);
}