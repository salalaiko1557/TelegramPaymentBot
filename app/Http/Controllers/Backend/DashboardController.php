<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Order;
use App\TelegramUser;
use App\Product;

class DashboardController extends Controller
{
    //
    public function index() {

      return view('backend.index', [
        //'products' => count(Product::all()->toArray()),
        'users'    => count(TelegramUser::all()->toArray()),
        //'orders'   => count(Order::all()->toArray()),
      ]);
    }
}
