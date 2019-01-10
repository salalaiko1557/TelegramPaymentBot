<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Http\Controllers\Backend\NoticeController;
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

      \Log::info('schedule');
//Если недельная подписка
      $schedule->call(function () {
        NoticeController::subscription_expired(7);
      })->everyMinute();
//Если месячная подписка
      $schedule->call(function () {
        NoticeController::subscription_expired(30);
      })->everyMinute();
//Если годовая подписка
      $schedule->call(function () {
        NoticeController::subscription_expired(360);
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
