@extends('backend.layouts.app')

@section('content')

  <div class="container">

    @component('backend.components.breadcrumb')
        @slot('title') Order list @endslot
        @slot('parent') Dashboard @endslot
        @slot('active') Orders @endslot
    @endcomponent

    <hr>

    <a href="{{ route('admin.order.create') }}" class="btn btn-primary pull-right"><i class="fas fa-plus"></i> Add order</a>
     
    <table class="table table-striped">
      <thead>
        <th>Title</th>
        <th>User</th>
        <th>Amount</th>
        <th>Status</th>
        <th class="text-right">Action</th>
      </thead>
      <tbody>

        @forelse ($orders as $order)

          <tr>
            <td>Order #{{ $order->id }}</td>
            <td>{{ $users[ $order->telegram_user_id ] }}</td>
            <td>{{ $order->amount }} RUB</td>
            <td>@if ($order->status) Paid @else Awaiting payment @endif</td>
            <td class="text-right">
              <form method="post" onsubmit="if (confirm('Delete?')){ return true } else { return false }" action="{{ route('admin.order.destroy', $order) }}">
                <input type="hidden" name="_method" value="DELETE">
                {{ csrf_field() }}
  
                <a class="btn btn-default" href="{{ route('admin.order.edit', $order) }}"><i class="fas fa-edit"></i></a>
  
                <button type="submit" class="btn btn-default"><i class="fas fa-trash-alt"></i></button>
              </form>
            </td>
          </tr>
        @empty
            <tr>
              <td colspan="3" class="text-center"><h2>No data</h2></td>
            </tr>
        @endforelse
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3">
            <ul class="pagination pull-right">
              {{ $orders->links() }}
            </ul>
          </td>
        </tr>
      </tfoot>
    </table>


  </div>
@endsection