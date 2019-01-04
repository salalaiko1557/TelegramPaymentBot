<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;
use App\Http\Controllers\Backend\TelegramController;
use App\Setting;
use App\Helpers\Telegram\Subscribe;

/**
 * Class StartCommand.
 */
class StartCommand extends Command
{

  /**
   * @var string Command Name
   */
  protected $name = 'start';

  /**
   * @var string Command Description
   */
  protected $description = 'Start command';

  /**
   * Handle
   */
  public function handle($arguments) {

    $this->replyWithChatAction([
      'action' => Actions::TYPING
    ]);
    $update = $this->getUpdate();
    $name   = $update->getMessage()->getFrom()->getFirstName();
    $user   = TelegramController::getUserData($update->getMessage()->getFrom());

    $text = sprintf('%s, %s.' . PHP_EOL, 'Приветствую', $name);

      $subscription_cost_week = Setting::getSettings('subscription_cost_week');
      $subscription_cost_week = ($subscription_cost_week) ? $subscription_cost_week->value : 0;
      $subscription_cost_month = Setting::getSettings('subscription_cost_month');
      $subscription_cost_month = ($subscription_cost_month) ? $subscription_cost_month->value : 0;
      $subscription_cost_year = Setting::getSettings('subscription_cost_year');
      $subscription_cost_year = ($subscription_cost_year) ? $subscription_cost_year->value : 0;

      $text .= sprintf('%s' . PHP_EOL, 'Оплатите подписку');
      $text .= sprintf('%s' . PHP_EOL, '1 неделя: Стоимость: ' . $subscription_cost_week . ' руб');
      $text .= sprintf('%s' . PHP_EOL, '1 месяц: Стоимость: ' . $subscription_cost_month . ' руб');
      $text .= sprintf('%s' . PHP_EOL, '1 год: Стоимость: ' . $subscription_cost_year . ' руб');

      $inlineLayout = [
        [
            Keyboard::inlineButton(['text' => 'Недельная подписка', 'callback_data' => 'subscribe_week']),
            Keyboard::inlineButton(['text' => 'Месячная подписка', 'callback_data' => 'subscribe_month']),
            Keyboard::inlineButton(['text' => 'Годовая подписка', 'callback_data' => 'subscribe_year']),
        ]
    ];

    $keyboard = \Telegram::replyKeyboardMarkup([
        'inline_keyboard' => $inlineLayout
    ]);
    $this->replyWithMessage(['text' => $text, 'reply_markup' => $keyboard]);
  }
}
