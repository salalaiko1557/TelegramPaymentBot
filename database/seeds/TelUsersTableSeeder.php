<?php

use Illuminate\Database\Seeder;

class TelUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('telegram_users')->insert([
        'id'       => 1,
        'is_bot'   => 0,
        'first_name' => 'Alex',
        'last_name' => 'Salalaiko',
        'language_code' => 'ru'
      ]);
    }
}
