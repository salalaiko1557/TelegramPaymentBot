@extends('backend.layouts.app')

@section('content')

  <div class="container">
    <h1>Dashboard</h1>
    <br>
    <div class="row">

      <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">Users</div>
          <div class="panel-body">
            <p>Count: {{ $users }}</p>
            <a href="{{ route('admin.telegramuser.index') }}">View All Users</a>
          </div>
        </div>
      </div>
      {{-- <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">Products</div>
          <div class="panel-body">
              <p>Count: {{ $products }}</p>
              <a href="{{ route('admin.product.index') }}">View All Products</a>
          </div>
        </div>
      </div> --}}
      {{-- <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">Orders</div>
          <div class="panel-body">
              <p>Count: {{ $orders }}</p>
              <a href="{{ route('admin.order.index') }}">View All Orders</a>

          </div>
        </div>
      </div> --}}

    </div>


  </div>
@endsection
