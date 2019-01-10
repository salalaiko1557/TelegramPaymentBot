@extends('backend.layouts.app')

@section('content')
    
<div class="container">

  @component('backend.components.breadcrumb')
    @slot('title') Edit User @endslot
    @slot('parent') Dashboard @endslot
    @slot('active') Users @endslot
  @endcomponent

  <br>

  <form method="post" action="{{ route('admin.telegramuser.update', $teluser) }}" class="form-horizontal">
  
    <input type="hidden" name="_method" value="put">

    {{ csrf_field() }}
  
    @include('backend.telusers.partials.form')

  </form>

</div>

@endsection