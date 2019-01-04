<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::namespace('Backend')->group(function () {
  
  Route::post('/payment/response', 'PaymentController@handle')->name('payment.response');
});

Route::middleware(['auth'])->prefix('admin')->namespace('Backend')->name('admin.')->group(function() {
  
  Route::get('/', 'DashboardController@index')->name('index');
  Route::get('/setting', 'SettingController@index')->name('setting.index');
  Route::post('/setting/store', 'SettingController@store')->name('setting.store');
  Route::post('/setting/setwebhook', 'SettingController@setwebhook')->name('setting.setwebhook');
  Route::post('/setting/getwebhookinfo', 'SettingController@getwebhookinfo')->name('setting.getwebhookinfo');

  Route::resource('/telegramuser', 'TelegramUserController');
  Route::resource('/product', 'ProductController');
  Route::resource('/order', 'OrderController');

  Route::get('/notice/user/{order}', 'NoticeController@notice_user')->name('notice.user');
});

Auth::routes();

Route::match(['post', 'get'], 'register', function() {
  Auth::logout();
  return redirect('/');
})->name('register');
