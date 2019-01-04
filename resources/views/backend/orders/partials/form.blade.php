<label for="status">Status</label>
<select name="status" class="form-control">

  @if (isset($order->id))
    
    <option value="0" @if (0 == $order->status) selected="" @endif> Awaiting payment</option>
    <option value="1" @if (1 == $order->status) selected="" @endif> Paid</option>
  @else
      
    <option value="0"> Awaiting payment</option>
    <option value="1"> Paid</option>
  @endif
</select>

<label for="telegram_user_id">Сustomer</label>
<select name="telegram_user_id" class="form-control">

  @if (isset($order->id))

    @foreach ($users as $user)
          
    <option value="{{ $user['id'] }}" @if ($user['id'] == $order->telegram_user_id) selected="" @endif> {{ $user['first_name'] . ' ' . $user['last_name'] }}</option>
    @endforeach
  @else

    @foreach ($users as $user)
        
     <option value="{{ $user['id'] }}"> {{ $user['first_name'] . ' ' . $user['last_name'] }}</option>
    @endforeach
  @endif
</select>

<label for="amount">Amount</label>
<input type="number" pattern="[0-9]+([\.,][0-9]+)?" step="0.01" class="form-control" name="amount" placeholder="1.00" value="{{ $order->amount or "" }}" required>

<label for="products">Products</label>
<select name="products[]" class="form-control" required>

  @if (isset($order->id))

    @foreach ($products as $product)
      <option value="{{ $product['id'] }}" @if (in_array($product['id'], unserialize($order->products))) selected="" @endif> {{ $product['title'] }}</option>
    @endforeach
  @else

    @foreach ($products as $product)
      <option value="{{ $product['id'] }}"> {{ $product['title'] }}</option>
    @endforeach
  @endif
</select>

<label for="description">Link</label>
<input type="url" class="form-control" name="description" placeholder="http://vebinar.com" value="{{ $order->description or "" }}" required>

@if (isset($order->description) && '' != $order->description)
  <p> 
    <a class="btn btn-default" href="{{ route('admin.notice.user', $order) }}"><i class="fas fa-envelope"></i> Отправить ссылку пользователю</a>
  </p>
@endif
<br>

<input class="btn btn-primary" type="submit" value="Save">