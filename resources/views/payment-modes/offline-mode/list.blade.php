@extends('layouts.master')
@section('title', 'Payment Mode| Offline')
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
          <h1>Offline Mode</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
            <li class="breadcrumb-item">Payment Modes</li>
            <li class="breadcrumb-item active">Offline Mode</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <div class="card-tools">
          <a href="{{ route('offline-mode.create') }}" class="btn btn-success btn-block">
            <i class="fas fa-plus"></i> Create
          </a>
        </div>
      </div>
      <div class="card-body">
        <table id="dataTable" class="table table-bordered table-striped">
            <thead>
            <tr>
              <th>Id</th>
              <th>Mode Name</th>
              <th>Details</th>
              <th>Active</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($modes as $mode)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ ucfirst($mode->name) }}</td>
                    <td>
                        Account Holder Name <span class="float-right"> {{ $mode->details['account_holder_name'] }}</span><br>
                        Account Number <span class="float-right"> {{ $mode->details['account_number'] }}</span><br>
                        IFSC Code <span class="float-right"> {{ $mode->details['ifsc_code'] }}</span><br>
                        Account Type <span class="float-right">{{ $mode->details['account_type'] }}</span><br>
                        Bank Name <span class="float-right"> {{ $mode->details['bank_name'] }}</span>
                    </td>
                    <td><input type="checkbox" name="active" {{ $mode->status == 1 ? 'checked' : '' }} data-bootstrap-switch data-off-color="danger" data-on-color="success" onchange="changeStatus(this, {{ $mode->id }})"></td>
                    <td>
                        <div class="btn-group">
                        <a href="{{ route('offline-mode.edit', $mode->id) }}" class="btn btn-warning"> <i class="fas fa-pen"></i> </a>
                        <button type="button" onclick="confirmDelete({{$mode->id}})" class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                        <form id='delete-form{{$mode->id}}' action='{{route('offline-mode.destroy', $mode->id)}}' method='POST'>
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
        var url = '{{ route("offline-mode.show", ":id") }}';
        url = url.replace(':id', id);
        location = url;
        }else{
            var url = '{{ route("offline-mode.show", ":id") }}';
        url = url.replace(':id', id);
        location = url;
        }

    }
</script>
@endpush
