@extends('backend.layouts.app')

@section('content')
    
<div class="container">

  @component('backend.components.breadcrumb')
    @slot('title') Create Order @endslot
    @slot('parent') Dashboard @endslot
    @slot('active') Orders @endslot
  @endcomponent

  <br>

  <form method="post" action="{{ route('admin.order.store') }}" class="form-horizontal">
  
    {{ csrf_field() }}
  
    @include('backend.orders.partials.form')

  </form>

</div>

@endsection