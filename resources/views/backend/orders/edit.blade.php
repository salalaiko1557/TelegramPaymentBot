@extends('backend.layouts.app')

@section('content')
    
<div class="container">

  @component('backend.components.breadcrumb')
    @slot('title') Edit Order @endslot
    @slot('parent') Dashboard @endslot
    @slot('active') Orders @endslot
  @endcomponent

  <br>

  <form method="post" action="{{ route('admin.order.update', $order) }}" class="form-horizontal">
  
    <input type="hidden" name="_method" value="put">

    {{ csrf_field() }}
  
    @include('backend.orders.partials.form')

  </form>
 
</div>

@endsection