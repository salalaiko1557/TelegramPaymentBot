@extends('backend.layouts.app')

@section('content')

<div class="container">
@if (Session::has('status'))
  <div class="alert alert-info">
    <span>{{ Session::get('status') }}</span>
  </div>
@endif

<form action="{{ route('admin.setting.store') }}" method="post">
  {{ csrf_field() }}
  <div class="form-group">
    <label>Url callback for Telegram</label>
    <div class="input-group">
      <div class="input-group-btn">
        <button type="button" class="btn btn-default dropdowm-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
          <li><a href="#" onclick="document.getElementById('url_callback_bot').value = '{{ url('') }}'"> Вставить url</a></li>
          <li><a href="#" onclick="event.preventDefault(); document.getElementById('setwebhook').submit();">Отправить url</a></li>
          <li><a href="#" onclick="event.preventDefault(); document.getElementById('getwebhookinfo').submit();"> Получить информацию</a></li>
        </ul>
      </div>
      <input type="url" class="form-control" id="url_callback_bot" name="url_callback_bot" value="{{ $url_callback_bot or '' }}" required>
    </div>
  </div>
  <div class="form-group">
    <label>Invite link to channel</label>
    <div class="input-group">
      <input type="text" class="form-control" id="chat_link" name="chat_link" value="{{ $chat_link or '' }}" required>
    </div>
  </div>
  <div class="form-group">
    <label>Merchant id</label>
    <div class="input-group">
      <input type="number" class="form-control" id="merchant_id" name="merchant_id" value="{{ $merchant_id or '' }}" required>
    </div>
  </div>
  <div class="form-group">
    <label>Weekly subscription price</label>
    <div class="input-group">
      <input type="number" class="form-control" id="subscription_cost_week" name="subscription_cost_week" value="{{ $subscription_cost_week or '' }}" required>
    </div>
  </div>
  <div class="form-group">
    <label>Monthly subscription price</label>
    <div class="input-group">
      <input type="number" class="form-control" id="subscription_cost_month" name="subscription_cost_month" value="{{ $subscription_cost_month or '' }}" required>
    </div>
  </div>
  <div class="form-group">
    <label>Yearly subscription price</label>
    <div class="input-group">
      <input type="number" class="form-control" id="subscription_cost_year" name="subscription_cost_year" value="{{ $subscription_cost_year or '' }}" required>
    </div>
  </div>
  <div class="form-group">
    <label>Invite chat link</label>
    <div class="input-group">
      <input type="url" class="form-control" id="chat_link" name="chat_link" value="{{ $chat_link or '' }}" required>
    </div>
  </div>
  <div class="form-group">
    <label>Chat</label>
    <div class="input-group">
      <select name="chat_id" class="form-control">
        @if (isset($chat_id))

          @foreach ($chats as $chat)
            <option value="{{ $chat['id'] }}" @if ($chat['id'] == $chat_id) selected="" @endif> {{ $chat['title'] }}</option>
          @endforeach
        @else

          @foreach ($chats as $chat)
            <option value="{{ $chat['id'] }}"> {{ $chat['title'] }}</option>
          @endforeach
        @endif
      </select>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Сохранить</button>
</form>

<form action="{{ route('admin.setting.setwebhook') }}" id="setwebhook" method="post" style="display: none;">
  {{ csrf_field() }}
  <input type="hidden" name="url" value="{{ $url_callback_bot or '' }}">
</form>

<form action="{{ route('admin.setting.getwebhookinfo') }}" id="getwebhookinfo" method="post" style="display: none;">
  {{ csrf_field() }}
</form>

</div>

@endsection
