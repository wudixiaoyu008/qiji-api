<?php namespace App\Http\V1_0\Controllers;

use App\Repositories\Interfaces\PaymentInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use Omnipay\Omnipay;

class AliPayController extends ApiController {

  protected $gateway;

  public function __construct(PaymentInterface $paymentInterface)
  {
    $this->gateway = Omnipay::create('Alipay_AopApp');
    $this->gateway->setAppId(env('ALIPAY_APPID'));
    $this->gateway->setPrivateKey(env('ALIPAY_PRIVATE_KEY'));
    $this->gateway->setAlipayPublicKey(env('ALIPAY_PUBLIC_KEY'));
    $this->gateway->setNotifyUrl(env('ALIPAY_NOTIFY_URL'));
    $this->gateway->setSignType('RSA2');
    $this->gateway->setEnvironment('sandbox'); //正式环境需要设置为production
    $this->paymentInterface = $paymentInterface;
  }

  public function pay(Request $request)
  {
    $this->validate($request, [
      'subject_type' => 'required|numeric',
      'subject_id'   => 'required|numeric',
    ]);

    $agent = new Agent();

    $params = $request->all();
    $params['user_ip'] = $request->ip();
    $params['channel_order_num'] = date('YmdHis') . mt_rand(1000, 9999);
    $params['user_device_id'] = $agent->device();

    $userId = \JWTAuth::parseToken()->authenticate()->id;

    $order = $this->paymentInterface->createOrder($userId, $params);

    $result = $this->gateway->purchase();

    $result->setBizContent([
      'subject'         => $order->subject_title,
      'out_trade_no'    => $order->channel_order_num,
      'total_amount'    => $order->amount / 100.0,
      'body'            => $order->subject_intro,
      'product_code'    => 'QUICK_MSECURITY_PAY',
      'goods_type'      => 0,
      'timeout_express' => $order->channel_expired_time,
    ]);

    $response = $result->send();
    $orderString = $response->getOrderString();

    return ["order" => $orderString];
  }

  public function AlipayReturn(Request $request)
  {
    $params = $request->all();

    $result = $this->gateway->completePurchase();

    $result->setParams([
      'memo'         => $params['memo'],
      'result'       => $params['result'],
      'resultStatus' => $params['resultStatus'],
    ]);

    try {
      $response = $result->send();

      if ($response->isPaid()) {
        return $this->response->array(['message' => trans('success.alipay.return')]);
      } else {
        return $this->response->array(['message' => trans('failure.alipay.fail')]);
      }
    } catch (Exception $e) {
      return $this->response->array(['message' => trans('failure.alipay.fail')]);
    }
  }

  public function notify(Request $request)
  {
    $result = $this->gateway->completePurchase();

    $result->setParams($request->all());

    try {
      $response = $result->send();

      if ($response->isPaid()) {

        if (!$this->paymentInterface->checkOrder($request->all())) {

          $this->paymentInterface->changeOrderStatus($request->all(), 1);

          Log::info('异步通知支付成功'); // for test

          return trans('success.alipay.notify');
        }

      } else {
        $this->paymentInterface->changeOrderStatus($request->all(), 2);

        return $this->response->array(['message' => trans('failure.alipay.fail')]);
      }
    } catch (Exception $e) {
      return $this->response->array(['message' => trans('failure.alipay.fail')]);
    }
  }

}
