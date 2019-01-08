<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MadelineController extends Controller
{
  public function index() {

    dd(env('TELEGRAM_SESSION_FILE'));
    if(file_exists( env('TELEGRAM_SESSION_FILE') ) ) {
      $madeline = new \danog\MadelineProto\API( env('TELEGRAM_SESSION_FILE') );
      $Chat = $MadelineProto->get_pwr_chat('-1001422407913');
      dd($Chat);
    } else {
      echo 'Config file don\'t exist';
    }
  }
}
