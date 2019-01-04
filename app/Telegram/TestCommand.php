<?php

namespace App\Telegram;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use App\Setting;

/**
 * Class TestCommand.
 */
class TestCommand extends Command
{
  /**
   * @var string Command Name
   */
  protected $name = 'test';

  /**
   * @var string Command Description
   */
  protected $description = 'Test command, Get a list of commands';

  /**
   * {@inheritdoc}
   */
  public function handle($arguments)
  {
  
    $update  = $this->getUpdate();
    $from_id  = $update->getMessage()->getFrom()->getId();

    $chat_id  = Setting::getSettings('chat_id');
    $chat_id  = ($chat_id) ? $chat_id->value : 0;
    if ( ! $chat_id) {
      return;
    }

    $this->telegram->unbanChatMember([
      'chat_id' => $chat_id,
      'user_id' => $from_id
    ]);

    $link = $this->telegram->exportChatInviteLink([
      'chat_id' => $chat_id
    ]);

    $text  = 'Ссылка на вступление в чат: ' . $link[0] . PHP_EOL;

    $response = $this->telegram->sendMessage([
      'chat_id' => $from_id,
      'text'    => $text
    ]);
  }
}
