<?php

namespace App\Http\Controllers\Backend;

use App\TelegramUser;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TelegramUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 

     return view('backend.telusers.index', [
       'telusers' => TelegramUser::orderBy('created_at', 'desc')->paginate(7)
     ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('backend.telusers.create', [
        'teluser' => []
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
      
      TelegramUser::create($request->all());

      return redirect()->route('admin.telegramuser.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TelegramUser  $telegramuser
     * @return \Illuminate\Http\Response
     */
    public function show(TelegramUser $telegramuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TelegramUser  $telegramUser
     * @return \Illuminate\Http\Response
     */
    public function edit(TelegramUser $telegramuser)
    {

      return view('backend.telusers.edit', [
        'teluser' => $telegramuser,
        'products' => Product::all()->toArray()
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TelegramUser  $telegramUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TelegramUser $telegramuser)
    {
      $telegramuser->update($request->except('id'));

      return redirect()->route('admin.telegramuser.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TelegramUser  $telegramUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(TelegramUser $telegramuser)
    {
      $telegramuser->delete();
      
      return redirect()->route('admin.telegramuser.index');
    }
}
