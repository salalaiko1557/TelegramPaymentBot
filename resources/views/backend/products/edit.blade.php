@extends('backend.layouts.app')

@section('content')
    
<div class="container">

  @component('backend.components.breadcrumb')
    @slot('title') Edit Product @endslot
    @slot('parent') Dashboard @endslot
    @slot('active') Products @endslot
  @endcomponent

  <br>

  <form method="post" action="{{ route('admin.product.update', $product) }}" class="form-horizontal">
  
    <input type="hidden" name="_method" value="put">

    {{ csrf_field() }}
  
    @include('backend.products.partials.form')

  </form>

</div>

@endsection