@extends('layouts.master')
@section('title', 'Sales| Companies')
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
          <h1>Companies</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Sales</li>
            <li class="breadcrumb-item active">Companies</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
          <a href="{{ route('companies.create') }}" class="btn btn-success btn-block">
            <i class="fas fa-plus"></i> Create
          </a>
        </div>
      </div>
      <div class="card-body">
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Id</th>
              <th>Company Name</th>
              <th>Phone</th>
              <th>Address</th>
              <th>Default</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ ucfirst($company->name) }}</td>
                    <td>{{ $company->phone }}</td>
                    <td>
                        Address 1 <span class="float-right"> {{ $company->address_1 }}</span><br>
                        Address 2 <span class="float-right"> {{ $company->address_2 }}</span><br>
                        State <span class="float-right"> {{ $company->state }}</span><br>
                        Pincode <span class="float-right"> {{ $company->pincode }}</span><br>
                    </td>
                    <td><input type="checkbox" name="active" {{ $company->default == 'yes' ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success" onchange="changeStatus(this, {{ $company->id }})"></td>
                    <td>
                        <div class="btn-group">
                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning"> <i class="fas fa-pen"></i> </a>
                        <button type="button" onclick="confirmDelete({{$company->id}})" class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                        <form id='delete-form{{$company->id}}' action='{{route('companies.destroy', $company->id)}}' method='POST'>
                            <input type='hidden' name='_token' value='{{ csrf_token()}}'>
                            <input type='hidden' name='_method' value='DELETE'>
                        </form>
                        </div>
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
<script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<script>

$("input[data-bootstrap-switch]").bootstrapSwitch();


    function changeStatus(event, id) {
        if($(event).prop('checked') == true){
        var url = '{{ route("companies.show", ":id") }}';
        url = url.replace(':id', id);
        location = url;
        }else{
            var url = '{{ route("companies.show", ":id") }}';
        url = url.replace(':id', id);
        location = url;
        }

    }
</script>
@endpush
