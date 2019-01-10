<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\TelegramUser;

class MadelineStart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'madeline:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start MadlineProto';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {

      // Если файл с сессией уже существует, использовать его
      if(file_exists( env('TELEGRAM_SESSION_FILE') ) ) {
        $madeline = new \danog\MadelineProto\API( env('TELEGRAM_SESSION_FILE') );
      } else {
        // Иначе создать новую сессию
        $madeline = new \danog\MadelineProto\API([
            'app_info' => [
              'api_id' => env('TELEGRAM_API_ID'),
              'api_hash' => env('TELEGRAM_API_HASH'),
            ]
        ]);

        // Задать имя сессии
        $madeline->session = env('TELEGRAM_SESSION_FILE');

        // Принудительно сохранить сессию
        $madeline->serialize();

        // Начать авторизацию по номеру мобильного телефона
        $madeline->phone_login( env('TELEGRAM_PHONE') );
        // Запросить код с помощью консоли
        $code = readline('Enter the code you received: ');
        $madeline->complete_phone_login($code);
      }
/*
      $participants = $madeline->channels->getParticipants([
        'channel' => env('TELEGRAM_GROUP_URL'), 
        'filter'  => [
          '_' => 'channelParticipantsRecent'
        ], 
        'offset'  => 0, 
        'limit'   => 0, 
        'hash'    => [0, 0], 
      ]);*/

      $chat_data = $madeline->get_pwr_chat(env('TELEGRAM_GROUP_URL'));
      if (isset($chat_data['participants'])) {

        $participants = $chat_data['participants'];
        foreach ($participants as $participant) {

          $user    = $participant['user'];
          $teluser = TelegramUser::find($user['id']);
          if ( ! $teluser) {

            $id         = $user['id'];
            $first_name = (isset($user['first_name'])) ? $user['first_name'] : '';
            $last_name  = (isset($user['last_name']))  ? $user['last_name']  : '';
            $username   = (isset($user['username']))   ? $user['username']   : '';

            $user = TelegramUser::create([
              'id'         => $id,
              'first_name' => $first_name,
              'last_name'  => $last_name,
              'username'   => $username,
            ]);
          }
        }
      }
     
     
    \Log::info('chat_data');
    \Log::info(print_r($chat_data, true));

    }
}
