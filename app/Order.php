<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $fillable = [
    'telegram_user_id',
    'amount',
    'products',
    'status',
    'created_by',
    'modified_by',
    'description'
  ];

  public function setProductsAttribute($value) {

    $this->attributes['products'] = serialize($value);
  }
}
