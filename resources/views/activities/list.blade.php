@extends('layouts.master')
@section('title', 'User Activity')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-star"></i> User Activity</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">User Activity</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <form id="form-filter" class="inline-form" action="{{ route('user-activities.index') }}">
                    <div class="form-row">
                @role('administrator')
                        <div class="col">
                            <label for="filter_user">Search By User</label>
                            <select id="filter_user" class="form-control" name="filter_user">
                                <option value=""></option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{$filter_user == $user->id ? 'selected' : ''}}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>   
                        
                        @endrole
                        <div class="col">
                            <label for="filter_type">Search By Type</label>
                            <select id="filter_type" class="form-control" name="filter_type">
                                <option value=""></option>
                                <option value='login' {{$filter_type == 'login' ? 'selected' : ''}}>Login</option>
                                <option value='logout' {{$filter_type == 'logout' ? 'selected' : ''}}>Logout</option>
                                <option value='lead generated' {{$filter_type == 'lead generated' ? 'selected' : ''}}>Lead generated</option>
                                <option value='lead updated' {{$filter_type == 'lead updated' ? 'selected' : ''}}>Lead updated</option>
                                <option value='lead status changed' {{$filter_type == 'lead status changed' ? 'selected' : ''}}>Lead status changed</option>
                                <option value='follow up added' {{$filter_type == 'follow up added' ? 'selected' : ''}}>Follow up added</option>
                                <option value='follow up done' {{$filter_type == 'follow up done' ? 'selected' : ''}}>Follow up done</option>
                                <option value='comment added' {{$filter_type == 'comment added' ? 'selected' : ''}}>Comment added</option>
                                <option value='transaction added' {{$filter_type == 'transaction added' ? 'selected' : ''}}>Transaction added</option>
                                <option value='estimate generated' {{$filter_type == 'estimate generated' ? 'selected' : ''}}>Estimate generated</option>
                                <option value='estimate updated' {{$filter_type == 'estimate updated' ? 'selected' : ''}}>Estimate updated</option>
                                <option value='booking generated' {{$filter_type == 'booking generated' ? 'selected' : ''}}>Booking generated</option>
                                <option value='booking updated' {{$filter_type == 'booking updated' ? 'selected' : ''}}>Booking updated</option>
                                <option value='customer added' {{$filter_type == 'customer added' ? 'selected' : ''}}>Customer added</option>
                                <option value='voucher generated' {{$filter_type == 'voucher generated' ? 'selected' : ''}}>Voucher generated</option>
                                <option value='voucher sent' {{$filter_type == 'voucher sent' ? 'selected' : ''}}>Voucher sent</option>
                                <option value='ticket added' {{$filter_type == 'ticket added' ? 'selected' : ''}}>Ticket Added</option>
                                <option value='ticket updated' {{$filter_type == 'ticket updated' ? 'selected' : ''}}>Ticket Updated</option>
                            </select>
                        </div>   
                
                    <div class="col">
                        <label for="">Date</label>
                        <input type="date" id="filter_date"  name="filter_date" value="{{$filter_date}}" class="form-control floating-label" placeholder="Select Date">
                    </div>
                
                    <div class="card-tools" style="margin-top: 32px;">
                        <div class="btn-group">
                            <button type="submit" class="btn btn-info" form="form-filter"><i class="fa fa-filter"></i></button>
                            <a href="{{ route('user-activities.index') }}" class="btn btn-secondary ml-2 mr-2" id="reset-filter"><i class="fa fa-undo"></i></a>                            
                        </div>
                    </div>
                </div>
                </form>
                
            </div>
            <div class="card-body">
                @if(count($activities) > 0)
                <table id="customers" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Type</th>
                            <th>Action</th>    
                            <th>Date Time</th>   
                            <th>Action</th>                          
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activities as $activity)
                            <tr>
                                <td>{{ $activity->user->name }}</td>
                                <td><span class="badge bg-danger">{{ ucfirst($activity->type) }}</span></td>
                                <td>{!! $activity->comment !!}</td>  
                                <td>{{ \Carbon\Carbon::parse($activity->created_at)->format('M d Y h:i A') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" onclick="confirmDelete({{ $activity->id }})"
                                            class="btn btn-danger" data-toggle="tooltip" title="Delete activity"><i
                                                class="fas fa-trash"></i> </button>
                                        <form id='delete-form{{ $activity->id }}'
                                            action='{{ route('user-activities.destroy', $activity->id) }}' method='POST'>
                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                            <input type='hidden' name='_method' value='DELETE'>
                                        </form>
                                    </div>
                                </td>                                                        
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center">No User activity found.</p>
                @endif
            </div>
            <div class="mt-2">
                {{$activities->appends(request()->query())->links("pagination::bootstrap-4")}}
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('layouts.utilities')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#filter_user').select2({
                theme: 'bootstrap4',
                placeholder: "Select",
                width: 'auto',
			    dropdownAutoWidth: true,
                allowClear: true,
            })
        });
        </script>
@endpush
