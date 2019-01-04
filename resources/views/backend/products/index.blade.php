@extends('backend.layouts.app')

@section('content')

  <div class="container">

    @component('backend.components.breadcrumb')
      @slot('title') Product list @endslot
      @slot('parent') Dashboard @endslot
      @slot('active') Products @endslot
    @endcomponent

    <hr>

    <a href="{{ route('admin.product.create') }}" class="btn btn-primary pull-right"><i class="fas fa-plus"></i> Add product</a>
     
    <table class="table table-striped">
      <thead>
        <th>Title</th>
        <th>Status</th>
        <th>Price</th>
        <th class="text-right">Action</th>
      </thead>
      <tbody>
        @forelse ($products as $product)
              
          <tr>
            <td>{{ $product->title }}</td>
            <td>@if ($product->status) Published @else Draft @endif</td>
            <td>{{ $product->price }}</td>
            <td class="text-right">
              <form method="post" onsubmit="if (confirm('Delete?')){ return true } else { return false }" action="{{ route('admin.product.destroy', $product) }}">
               <input type="hidden" name="_method" value="DELETE">
               {{ csrf_field() }}

               <a class="btn btn-default" href="{{ route('admin.product.edit', $product) }}"><i class="fas fa-edit"></i></a>

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
              {{ $products->links() }}
            </ul>
          </td>
        </tr>
      </tfoot>
    </table>


  </div>
@endsection