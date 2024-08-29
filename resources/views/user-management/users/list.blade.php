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
          <h1>Users</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item">User Management</li>
            <li class="breadcrumb-item active">Users</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
          <a href="{{ route('users.create') }}" class="btn btn-success btn-block">
            <i class="fas fa-plus"></i> Create
          </a>
        </div>
      </div>
      <div class="card-body">
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Roles</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>
                            @foreach ($user->roles as $role)
                            <span class="badge bg-info">{{ $role->name }}</span>
                            @endforeach
                    </td>
                    <td>{{ $user->is_active == 1 ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <div class="btn-group">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning"> <i class="fas fa-pen"></i> </a>
                        <button type="button" onclick="confirmDelete({{$user->id}})" class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                        <form id='delete-form{{$user->id}}' action='{{route('users.destroy', $user->id)}}' method='POST'>
                            <input type='hidden' name='_token' value='{{ csrf_token()}}'>
                            <input type='hidden' name='_method' value='DELETE'>
                        </form>
                        </div>
                    </td>
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
@endpush
