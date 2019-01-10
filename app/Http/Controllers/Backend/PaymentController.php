<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;
use App\Order;
use App\TelegramUser;
use App\Product;

class PaymentController extends Controller
{
  public function handle() {

    //http://77.222.60.8/payment/response?MERCHANT_ID=97957&AMOUNT=15.30&MERCHANT_ORDER_ID=1&SIGN=dgd&us_type=vebiinar

    \Log::info('test');
    \Log::info(print_r($_REQUEST, true));

    $available_ip = ['136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '88.198.88.98'];
    $ip           = isset($_SERVER['HTTP_X_REAL_IP']) ? $_SERVER['HTTP_X_REAL_IP'] : $_SERVER['REMOTE_ADDR'];
    if ( ! in_array($ip, $available_ip)) {
     die('hacking attempt!');
    }

    $merchant_id = Setting::getSettings('merchant_id');
    $merchant_id = ($merchant_id) ? $merchant_id->value : 0;
    $secret_word = '0uv1cxfe';

    $sign = md5($merchant_id.':'.$_REQUEST['AMOUNT'].':'.$secret_word.':'.$_REQUEST['MERCHANT_ORDER_ID']);

    if ($sign != $_REQUEST['SIGN']) {
      die('wrong sign');
    }

    if ( ! isset($_REQUEST['us_type'])) {

      die('wrong request');
    }

    if ( ! isset($_REQUEST['count'])) {

        die('wrong tarif');
      }

    $type     = $_REQUEST['us_type'];
    $tarif = $_REQUEST['count'];
    $amount   = $_REQUEST['AMOUNT'];
    $order_id = $_REQUEST['MERCHANT_ORDER_ID'];

    if ('subscribe' == $type && 'count' == $tarif) {

    $subscription_cost_week = Setting::getSettings('subscription_cost_week');
    $subscription_cost_week = ($subscription_cost_week) ? $subscription_cost_week->value : 0;
    $subscription_cost_month = Setting::getSettings('subscription_cost_month');
    $subscription_cost_month = ($subscription_cost_month) ? $subscription_cost_month->value : 0;
    $subscription_cost_year = Setting::getSettings('subscription_cost_year');
    $subscription_cost_year = ($subscription_cost_year) ? $subscription_cost_year->value : 0;


    //   $subscription_cost = Setting::getSettings('subscription_cost');
    //   $subscription_cost = ($subscription_cost) ? $subscription_cost->value : 0;
      if (($subscription_cost_week != $amount) || ($subscription_cost_month != $amount) || ($subscription_cost_year != $amount)) {
        die('wrong amount');
      }

      $teluser = TelegramUser::find($_REQUEST['MERCHANT_ORDER_ID']);
      if ( ! $teluser) {
        die('wrong user id');
      }

      $now = new \DateTime();
      $now->format('Y-m-d H:i:s');

      $teluser->subscribe_date = $now;
      $teluser->sub_notice     = 0;
      $teluser->tarif = $tarif;
      $teluser->save();

      NoticeController::subscription_paid($teluser);
     }
    //else {

    //   $order = Order::find($_REQUEST['MERCHANT_ORDER_ID']);
    //   if ( ! $order) {
    //     die('wrong order id');
    //   }

    //   if (floatval($amount) < floatval($order->amount)) {
    //     die('wrong amount');
    //   }

    //   $order->status = 1;
    //   $order->save();

    //   $products      = unserialize($order->products);
    //   $teluser       = TelegramUser::find($order->telegram_user_id);
    //   $paid_products = unserialize($teluser->products);
    //   $paid_products = ( ! is_array($paid_products)) ? [] : $paid_products;
    //   $result        = array_unique(array_merge($products, $paid_products));

    //   $teluser->products = serialize($result);
    //   $teluser->save();

      //NoticeController::vebinar_paid($order);
    //}

    die('ok');
   }
}
