@extends('layouts.master')
@section('title', 'Users')
@section('head')
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Online Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item">User Management</li>
            <li class="breadcrumb-item active">Online Users</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">      
      <div class="card-body">
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>              
              <th>Phone</th>
              <th>Last Seen</th>
              <th>Status</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>@if(Cache::has('user-is-online-' . $user->id))
                      <span class="text-success" style="font-size:10px"><i class="fa fa-circle"></i></span>
                  @else
                      <span class="text-danger" style="font-size:10px"><i class="fa fa-circle"></i></span>
                  @endif{{ $user->name }}  </td>                    
                    <td>{{ $user->phone }}</td>                    
                    <td>
                      {{ $user->last_seen ? Carbon\Carbon::parse($user->last_seen)->format("d-m-Y h:i A") : "Not available" }}
                  </td>  
                  <td><input type="checkbox" name="my-checkbox" {{ $user->is_active == 1 ? 'checked' : '' }} onchange="toggleStatus(this, {{ $user->id }})"  data-bootstrap-switch ></td>               
                </tr>
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
  </section>
@endsection
@push('scripts')
@include('layouts.utilities')
<script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script>
  $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch();
    })
</script>
<script>
  function toggleStatus(element, user_id) {
    if(element.checked) {
       $.ajax({
        type: "POST",
        url: "{{ route('users.toggle-status') }}",
        data: {
          'is_active' : 1,
          'user_id' : user_id,
          "_token": "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function (response) {
          alert('User is active now')
        }
       });
    }else{
      $.ajax({
        type: "POST",       
        url: "{{ route('users.toggle-status') }}",
        data: {
          'is_active' : 0,
          'user_id' : user_id,
          "_token": "{{ csrf_token() }}"
        },
        dataType: "json",
        success: function (response) {
          alert('User is Inactive now')
        }
       });
    }
};
</script>
@endpush
