<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TelegramUser extends Model
{

  protected $fillable = [
    'id',
    'is_bot',
    'first_name',
    'last_name',
    'username',
    'language_code',
    'products',
    'subscribe_date',
    'sub_notice',
    'in_chat',
    'created_at',
    'updated_at',
  ];
}
