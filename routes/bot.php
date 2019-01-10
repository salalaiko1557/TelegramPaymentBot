<?php
/**
 * Webhook handler
 */
$token  = Telegram::getAccessToken();

Route::post($token , function() {
  app('App\Http\Controllers\Backend\TelegramController')->webhookHandler();
})->name('bot-webhook');
