<?php
namespace App\Helpers\Telegram;

use Illuminate\Support\Facades\DB;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use App\Http\Controllers\Backend\TelegramController;
use App\Setting;
use Telegram\Bot\Api;

class Subscribe {

        /** @var Api */
    protected $telegram;

    /**
     * BotController constructor.
    *
    * @param Api $telegram
    */
    public function __construct(Api $telegram) {

    $this->telegram = $telegram;
    }


    /**
     * @param void
     *
     * @return string
     */
    public function subscribes($days, $user, $subscription_cost, $update, $text, $tarif) {



          $subscription_cost = ($subscription_cost) ? $subscription_cost : 0;
          $merchant_id       = Setting::getSettings('merchant_id');
          $merchant_id       = ($merchant_id) ? $merchant_id->value : 0;
          $secret_word       = '0uv1cxfe';
          $order_id          = $update->getCallbackQuery()->getFrom()->getId();
          $sign              = md5($merchant_id.':'.$subscription_cost.':'.$secret_word.':'.$order_id);

          $url   = 'http://www.free-kassa.ru/merchant/cash.php?' . 'm=' . $merchant_id . '&oa=' . $subscription_cost . '&o=' . $order_id . '&s=' . $sign . '&us_type=subscribe&us_rate='.$tarif;

        $inlineLayout = [
            [
                Keyboard::inlineButton(['text' => 'Оплатить', 'url' => $url]),
            ]
        ];

        $keyboard = \Telegram::replyKeyboardMarkup([
            'inline_keyboard' => $inlineLayout
        ]);

        $this->telegram->
        sendMessage([
            'chat_id'      => $update->getCallbackQuery()->getFrom()->getId(),
            'text' => $text,
            'reply_markup' => $keyboard
          ]);
    }

}
