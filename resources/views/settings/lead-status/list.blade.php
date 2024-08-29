@extends('layouts.master')
@section('title', 'Lead Status')
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
          <h1>Lead Status</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Settings</li>
            <li class="breadcrumb-item active">Lead Status</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
          <a href="{{ route('lead-status.create') }}" class="btn btn-success btn-block">
            <i class="fas fa-plus"></i> Create
          </a>
        </div>
      </div>
      <div class="card-body">
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Id</th>
              <th>Lead Status</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($statuses as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->name }}</td>
                    <td>
                        <div class="btn-group">
                        <a href="{{ route('lead-status.edit', $status->id) }}" class="btn btn-warning"> <i class="fas fa-pen"></i> </a>
                        <button type="button" onclick="confirmDelete({{$status->id}})" class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                        <form id='delete-form{{$status->id}}' action='{{route('lead-status.destroy', $status->id)}}' method='POST'>
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
