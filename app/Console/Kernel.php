<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Http\Controllers\Backend\NoticeController;
use App\TelegramUser;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//Если недельная подписка, кикаем
      $schedule->call(function () {
        NoticeController::subscription_expired(7, 'week');
      })->everyMinute();
//Если неделя - 2 дня то предупреждаем
      $schedule->call(function () {
        NoticeController::subscription_expires(7, 'week');
      })->everyMinute();
//Если месячная подписка, кикаем
      $schedule->call(function () {
        NoticeController::subscription_expired(30, 'month');
      })->everyMinute();
//Если месяц - 2 дня то предупреждаем
      $schedule->call(function () {
        NoticeController::subscription_expires(30, 'month');
      })->everyMinute();
//Если годовая подписка, кикаем
      $schedule->call(function () {
        NoticeController::subscription_expired(360, 'year');
      })->everyMinute();
//Если год - 2 дня то предупреждаем
      $schedule->call(function () {
        NoticeController::subscription_expires(360, 'year');
      })->everyMinute();

    //   $schedule->call(function () {
    //     NoticeController::subscription_expired();
    //   })->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
