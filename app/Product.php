<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
  protected $fillable = [
    'title',
    'slug',
    'status',
    'description',
    'price',
    'created_by',
    'modified_by',
  ];

  public function setSlugAttribute($value) {

    $this->attributes['slug'] = Str::slug(mb_substr($this->title, 0, 40), '-');
  }
}
