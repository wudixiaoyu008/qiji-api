<?php namespace App\Repositories\Interfaces;

interface PaymentInterface {

  public function createOrder($userId, $params);

  public function checkOrder($params);

  public function changeOrderStatus($params, $status = 1);
}
