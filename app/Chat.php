<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
  protected $fillable = [
    'id',
    'title',
    'created_by',
    'modified_by'
  ];
}
