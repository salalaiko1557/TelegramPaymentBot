<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram\Bot\Api;
use App\TelegramUser;
use App\Chat;
use App\Product;
use App\Order;
use App\Setting;
use Telegram\Bot\Keyboard\Keyboard;
use App\Helpers\Telegram\Subscribe;


class TelegramController extends Controller
{

 /** @var Api */
 protected $telegram;

  /**
   * BotController constructor.
   *
   * @param Api $telegram
   */
  public function __construct(Api $telegram, Subscribe $subscribe) {

    $this->telegram = $telegram;
    $this->subscribe = $subscribe;
  }

  /**
   * Get user data
   */
  public static function getUserData($user_data) {

    $user = TelegramUser::find($user_data->getId());
    if ( ! $user) {
      $user = TelegramUser::create(json_decode($user_data, true));
    }

    return $user;
  }

  /**
   * Handles incoming webhook updates from Telegram.
   */
  public function webhookHandler() {

   $update  = $this->telegram->commandsHandler(true);
	$type = $update->detectType();
	if($type == 'callback_query'){
		$telegram_user_id = $update->getCallbackQuery()->getFrom()->getId();
		$user = TelegramUser::find($telegram_user_id);
		if(! $user){
		       $response = $this->telegram->sendMessage([
         		'chat_id'      => $telegram_user_id,
         		'text'         => 'Нажмите /start что-бы зарегистрироваться'
		       ]);
		}
	}
	if($type == 'message'){
 		$telegram_user_id = $update->getMessage()->getFrom()->getId();
                $user = TelegramUser::find($telegram_user_id);
                if(! $user){
                       $response = $this->telegram->sendMessage([
                        'chat_id'      => $telegram_user_id,
                        'text'         => 'Нажмите /start что-бы зарегистрироваться'
                       ]);
                }
	}
   $this->subscribe($update);

    return 'Ok';
  }

  public function subscribe($query){


    $subscription_cost_week = Setting::getSettings('subscription_cost_week');
    $subscription_cost_week = ($subscription_cost_week) ? $subscription_cost_week->value : 0;
    $subscription_cost_month = Setting::getSettings('subscription_cost_month');
    $subscription_cost_month = ($subscription_cost_month) ? $subscription_cost_month->value : 0;
    $subscription_cost_year = Setting::getSettings('subscription_cost_year');
    $subscription_cost_year = ($subscription_cost_year) ? $subscription_cost_year->value : 0;

    if($query->getCallbackQuery()){
       $inline_action = $query->getCallbackQuery()->getData();
       if ($inline_action == 'subscribe_week'){
            $user_id       = $query->getCallbackQuery()->getFrom()->getId();
            $user          = TelegramUser::find($user_id);
            $text = 'Для недельной оплаты подписки, перейдите по ссылке';
            $tarif = 'week';
	    $text = 'ВНИМАНИЕ! Ссылка действительна в течении дня, для генерации новой ссылки введите /start и произведите оплату';
            $this->subscribe->subscribes(7, $user, $subscription_cost_week, $query, $text, $tarif);
       }
       if ($inline_action == 'subscribe_month'){
            $user_id       = $query->getCallbackQuery()->getFrom()->getId();
            $user          = TelegramUser::find($user_id);
            $text = 'Для месячной оплаты подписки, перейдите по ссылке';
            $tarif = 'month';
	    $text = 'ВНИМАНИЕ! Ссылка действительна в течении дня, для генерации новой ссылки введите /start и произведите оплату';            
	    $this->subscribe->subscribes(30, $user, $subscription_cost_month, $query, $text, $tarif);
        }
        if ($inline_action == 'subscribe_year'){
            $user_id       = $query->getCallbackQuery()->getFrom()->getId();
            $user          = TelegramUser::find($user_id);
            $text = 'Для годовой оплаты подписки, перейдите по ссылке';
            $tarif = 'year';
	    $text = 'ВНИМАНИЕ! Ссылка действительна в течении дня, для генерации новой ссылки введите /start и произведите оплату';            
	    $this->subscribe->subscribes(360, $user, $subscription_cost_year, $query, $text, $tarif);
        }

    }
  }

  /**
   * Vebinars button handler
   */
//   public function vebinars($query) {

//     $text = 'Выберите действие';

//     $vebinar_buy = Keyboard::inlineButton([
//       'text'          => 'Купить вебинары',
//       'callback_data' => 'buy_vebinars',
//     ]);

//     $my_vebinars = Keyboard::inlineButton([
//       'text'          => 'Мои покупки',
//       'callback_data' => 'my_vebinars',
//     ]);

//     $reply_markup = new Keyboard();
//     $reply_markup->inline();
//     $reply_markup->row(
//       $vebinar_buy,
//       $my_vebinars
//     );

//     $response = $this->telegram->sendMessage([
//       'chat_id'      => $query->getFrom()->getId(),
//       'text'         => $text,
//       'reply_markup' => $reply_markup
//     ]);

//     $response = $this->telegram->answerCallbackQuery([
//       'callback_query_id' => $query->getId()
//     ]);
//   }


  /**
   * Buy vebinars handler
   */
//   public function buy_vebinars($query) {

//     $user          = TelegramUser::find($query->getFrom()->getId());
//     $paid_vebinars = unserialize($user->products);
//     $paid_vebinars = ( ! is_array($paid_vebinars)) ? [] : $paid_vebinars;
//     $vebinars      = Product::whereNotIn('id', $paid_vebinars)->where('status', '=', 1)->get()->toArray();

//     if ( ! empty($vebinars)) {

//       $reply_markup = new Keyboard();
//       $reply_markup->inline();
//       $text = 'Выберите вебинар из списка';
//       foreach ($vebinars as $vebinar) {

//         $vebinar_btn = Keyboard::inlineButton([
//           'text'          => $vebinar['title'],
//           'callback_data' => 'vbnr_view' . $vebinar['id'],
//         ]);

//         $reply_markup->row(
//           $vebinar_btn
//         );
//       }

//       $response = $this->telegram->sendMessage([
//         'chat_id'      => $query->getFrom()->getId(),
//         'text'         => $text,
//         'reply_markup' => $reply_markup
//       ]);
//     } else {

//       $text = 'Нет доступных вебинаров';
//       $response = $this->telegram->sendMessage([
//         'chat_id'      => $query->getFrom()->getId(),
//         'text'         => $text
//       ]);
//     }

//     $response = $this->telegram->answerCallbackQuery([
//       'callback_query_id' => $query->getId()
//     ]);
//   }

  /**
   * My vebinar handler
   */
//   public function my_vebinars($query) {

//     $text = 'Веберите вебинар из списка';

//     $reply_markup = new Keyboard();
//     $reply_markup->inline();

//     $user_id       = $query->getFrom()->getId();
//     $user          = TelegramUser::find($user_id);
//     $orders        = Order::where('status', '=', 1)->where('telegram_user_id', '=', $user_id)->where('description', '!=', '')->get()->toArray();

//     if (empty($orders)) {

//       $text = 'У вас еще нет купленных вебинаров';

//       $vebinar_buy = Keyboard::inlineButton([
//         'text'          => 'Купить вебинары',
//         'callback_data' => 'buy_vebinars',
//       ]);

//       $reply_markup->row(
//         $vebinar_buy
//       );
//     } else {

//       $vebinars = [];
//       foreach ($orders as $order) {

//         $products = unserialize($order['products']);
//         $products = ( ! is_array($products)) ? [] : $products;
//         $vebinars = Product::whereIn('id', $products)->get()->toArray();
//         $url      = ( ! empty($order['description'])) ? $order['description'] : '';
//         foreach ($vebinars as $vebinar) {

//           $vebinar_btn = Keyboard::inlineButton([
//             'text' => 'Открыть вебинар ' . $vebinar['title'],
//             'url'  => $url,
//           ]);

//           $reply_markup->row(
//             $vebinar_btn
//           );
//         }
//       }
//     }

//     $response = $this->telegram->sendMessage([
//       'chat_id'      => $query->getFrom()->getId(),
//       'text'         => $text,
//       'reply_markup' => $reply_markup
//     ]);

//     $response = $this->telegram->answerCallbackQuery([
//       'callback_query_id' => $query->getId()
//     ]);
//   }

  /**
   * View vebinar handler
   */
//   public function vebinar_view($query, $id) {

//     $vebinar = Product::find($id);
//     $params  = [
//       'chat_id' => $query->getFrom()->getId(),
//     ];

//     if ($vebinar) {

//       $text  = 'Вебинар "' . $vebinar['title'] . '"'. PHP_EOL;
//       $text .= 'Цена: ' . $vebinar['price'] . ' руб' . PHP_EOL;
//       $text .= 'Описание: ' . $vebinar['description'] . PHP_EOL;

//       $reply_markup = new Keyboard();
//       $reply_markup->inline();

//       $vebinar_btn = Keyboard::inlineButton([
//         'text'          => 'Оформить заказ',
//         'callback_data' => 'vbnr_buy' . $vebinar['id'],
//       ]);

//       $reply_markup->row(
//         $vebinar_btn
//       );

//       $params['reply_markup'] = $reply_markup;
//     } else {

//       $text = 'Вебинар не найден';
//     }

//     $params['text'] = $text;

//     $response = $this->telegram->sendMessage($params);
//     $response = $this->telegram->answerCallbackQuery([
//       'callback_query_id' => $query->getId()
//     ]);
//   }

  /**
   * Buy vebinar handler
   */
//   public function vebinar_buy($query, $id) {

//     $vebinar = Product::find($id);
//     if ( ! $vebinar) {

//       $params = [
//         'chat_id' => $query->getFrom()->getId(),
//         'text'    => 'Вебинар не найден'
//       ];

//       $response = $this->telegram->sendMessage($params);
//       $response = $this->telegram->answerCallbackQuery([
//         'callback_query_id' => $query->getId()
//       ]);
//     } else {

//       $order = Order::create([
//         'telegram_user_id' => $query->getFrom()->getId(),
//         'amount'           => $vebinar->price,
//         'products'         => [$vebinar->id]
//       ]);

//       $merchant_id = Setting::getSettings('merchant_id');
//       $merchant_id = ($merchant_id) ? $merchant_id->value : 0;
//       $secret_word  = 'ignetdapassion';
//       $order_id     = $order->id;
//       $order_amount = $order->amount;
//       $sign         = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$order_id);

//       $text  = 'Заказ #' . $order_id . PHP_EOL;
//       $text .= 'Сумма: ' . $order_amount . ' руб' . PHP_EOL;
//       $url   = 'http://www.free-kassa.ru/merchant/cash.php?' . 'm=' . $merchant_id . '&oa=' . $order_amount . '&o=' . $order_id . '&s=' . $sign . '&us_type=vebinar';

//       $reply_markup = new Keyboard();
//       $reply_markup->inline();

//       $vebinar_btn = Keyboard::inlineButton([
//         'text' => 'Оплатить',
//         'url'  => $url,
//       ]);

//       $reply_markup->row(
//         $vebinar_btn
//       );

//       $params = [
//         'chat_id'      => $query->getFrom()->getId(),
//         'text'         => $text,
//         'reply_markup' => $reply_markup,
//       ];

//       $response = $this->telegram->sendMessage($params);
//       $response = $this->telegram->answerCallbackQuery([
//         'callback_query_id' => $query->getId()
//       ]);
//     }
//   }
}
