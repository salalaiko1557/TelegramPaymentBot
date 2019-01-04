<?php

namespace App\Http\Controllers\Backend;

use App\Setting;
use App\Chat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Telegram;

class SettingController extends Controller
{
  public function index() {

    $data          = Setting::getSettings();
    $data['chats'] = Chat::all()->toArray();

    return view('backend.setting', $data);
  }

  public function store(Request $request) {

    Setting::where('key', '!=', null)->delete();
    foreach($request->except('_token') as $key => $val) {

      $setting        = new Setting();
      $setting->key   = $key;
      $setting->value = $request->$key;
      $setting->save();
    }

    return redirect()->route('admin.setting.index');
  }

  public function setwebhook(Request $request) {

    $token  = Telegram::getAccessToken();
    $result = $this->sendTelegramData('setwebhook', [
      'query' => [
        'url' => $request->url . '/' . $token
      ]
    ]);

    return redirect()->route('admin.setting.index')->with('status', $result);
  }

  public function getwebhookinfo(Request $request) {

    $result = $this->sendTelegramData('getWebhookInfo');

    return redirect()->route('admin.setting.index')->with('status', $result);
  }

  public function sendTelegramData($route = '', $params = [], $method = 'post') {

    $token  = Telegram::getAccessToken();
     info($token);
    $client = new \GuzzleHttp\Client([
      'base_uri' => 'https://api.telegram.org/bot' . $token . '/'
    ]);
    $result = $client->request($method, $route, $params);

    return (string) $result->getBody();
  }
}
