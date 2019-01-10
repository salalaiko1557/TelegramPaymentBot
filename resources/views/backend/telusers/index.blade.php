@extends('backend.layouts.app')

@section('content')

  <div class="container">

    @component('backend.components.breadcrumb')
        @slot('title') User list @endslot
        @slot('parent') Dashboard @endslot
        @slot('active') Users @endslot
    @endcomponent

    <hr>

    <table class="table table-striped">
      <thead>
        <th>User id</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Username</th>
        <th>Subscribe date</th>
        <th>In chat</th>
        <th class="text-right">Action</th>
      </thead>
      <tbody>

        @forelse ($telusers as $teluser)
              
          <tr>
            <td>{{ $teluser->id }}</td>
            <td>{{ $teluser->first_name }}</td>
            <td>{{ $teluser->last_name }}</td>
            <td>{{ $teluser->username }}</td>
            <td>{{ $teluser->subscribe_date }}</td>
            <td>@if ($teluser->in_chat) Yes @else No @endif</td>
            <td class="text-right">
                <form method="post" onsubmit="if (confirm('Delete?')){ return true } else { return false }" action="{{ route('admin.telegramuser.destroy', $teluser) }}">
                  <input type="hidden" name="_method" value="DELETE">
                  {{ csrf_field() }}

                  <a class="btn btn-default" href="{{ route('admin.telegramuser.edit', $teluser) }}"><i class="fas fa-edit"></i></a>
    
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
              {{ $telusers->links() }}
            </ul>
          </td>
        </tr>
      </tfoot>
    </table>


  </div>
@endsection