<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditTeluserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('telegram_users', function (Blueprint $table) {
        $table->dateTime('subscribe_date')->nullable();
        $table->text('products')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('telegram_users', function (Blueprint $table) {
        $table->dropColumn('subscribe_date');
        $table->dropColumn('products');
      });
    }
}
