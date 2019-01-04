<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //
    // factory(App\User::class, 'admin', 1)->create();
  //  factory(App\User::class, 'ignet', 'project.ignet@gmail.com', 'teamignet', 1)->create();
    DB::table('users')->insert([
      'name'      => 'ignet',
      'email'    => 'project.ignet@gmail.com',
      'password' => bcrypt('teamignet'),
    ]);
  }
}
