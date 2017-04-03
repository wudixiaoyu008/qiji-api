<?php namespace App\Repositories\Interfaces;

interface TaskInterface {

  public function evaluateTask($data);
  public function getTaskComments($taskId);
  public function getTaskList($userId);

}