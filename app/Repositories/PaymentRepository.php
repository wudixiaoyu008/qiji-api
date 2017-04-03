<?php namespace App\Repositories;

use Coolcode\Shared\Entities\Classes;
use Coolcode\Shared\Entities\Course;
use Coolcode\Shared\Entities\Payment;
use Coolcode\Shared\Entities\UserInfo;
use Coolcode\Shared\Enums\SubjectType;
use App\Repositories\Interfaces\PaymentInterface;

class PaymentRepository implements PaymentInterface {

  public function createOrder($userId, $params)
  {
    $order = new Payment();
    $order->subject_type = $params['subject_type'];
    $order->subject_id = $params['subject_id'];
    $order->user_device_id = $params['user_device_id'];
    $order->user_ip = $params['user_ip'];
    $order->channel_order_num = $params['channel_order_num'];
    $order->channel_expired_time = '30m'; //失效时间，暂时设置为30分钟
    $order->paied_user_id = $userId;
    $order->status = 0;
    $order->channel = 0;

    $user = UserInfo::where('user_id', $userId)->value('real_name');
    switch ($params['subject_type']) {
      case SubjectType::TEACHING:
        $className = Classes::where('id', $params['subject_id'])->value('name');
        $order->subject_title = '导师制教学费用';
        $order->subject_intro = $user . '学员支付' . $className . '班级费用';
        $order->amount = 59900;
        break;
      case SubjectType::PROJECT:
        $order->subject_title = '项目制教学费用';
        $order->subject_intro = $user . '学员支付项目制教学费用';
        $order->amount = 150000;
        break;
      case SubjectType::COURSE:
        $course = Course::where('id', $params['subject_id'])->value('title');
        $order->subject_title = '听课费用';
        $order->subject_intro = $user . '学员支付' . $course . '课堂费用';
        $order->amount = 1500;
        break;
    }

    $order->save();

    return $order;

  }

  public function checkOrder($params)
  {
    $order = Payment::where('channel_order_num', $params['out_trade_no'])->get();

    return $order->isEmpty();
  }

  public function changeOrderStatus($params, $status = 1)
  {
    return Payment::where('channel_order_num', $params['out_trade_no'])
      ->where('subject_intro', $params['body'])
      ->where('status', 0)
      ->update(['status' => $status]);
  }


}
