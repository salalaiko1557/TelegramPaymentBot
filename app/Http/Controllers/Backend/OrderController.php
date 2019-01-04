<?php

namespace App\Http\Controllers\Backend;

use App\Order;
use App\TelegramUser;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {

    $users_data = [];
    $users      = TelegramUser::all()->toArray();
    foreach ($users as $user) {

      $users_data[ $user['id'] ] = $user['first_name'] . ' ' . $user['last_name'];
    } 
      
    return view('backend.orders.index', [
      'orders' => Order::orderBy('created_at', 'desc')->paginate(7),
      'users'  => $users_data
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    
    return view('backend.orders.create', [
      'order'    => [],
      'users'    => TelegramUser::all()->toArray(),
      'products' => Product::where('status', '=', 1)->get()->toArray()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    
    $order = Order::create($request->all());

    return redirect()->route('admin.order.edit', $order);
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function show(Order $order)
  {
    
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function edit(Order $order)
  {
    return view('backend.orders.edit', [
      'order'    => $order,
      'users'    => TelegramUser::all()->toArray(),
      'products' => Product::all()->toArray()
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Order $order)
  {
    $order->update($request->except('slug'));

    return redirect()->route('admin.order.edit', $order);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Order  $order
   * @return \Illuminate\Http\Response
   */
  public function destroy(Order $order)
  {
    $order->delete();
    
    return redirect()->route('admin.order.index');
  }
}
