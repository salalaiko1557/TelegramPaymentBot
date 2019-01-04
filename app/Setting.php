<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  public $timestamps = false;

  /**
   * Get settings
   *
   * @param string $key
   */
  public static function getSettings($key = null) {

    if ($key) {

      return self::where('key', $key)->first();
    }

    $settings = self::get();
    $collect  = collect();
    foreach ($settings as $setting) {

      $collect->put($setting->key, $setting->value);
    }
    return $collect;
  }

}
