@extends('layouts.master')
@section('title', 'Customers')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-calculator"></i> Customers</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Customers</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                @include('customers.filter')
            </div>
            <div class="card-body">
                @if(count($customers) > 0)
                <table id="customers" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>State</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($customers as $customer)
                            <tr>
                                <td>{{ $customer->id }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->mobile }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->state }}</td>
                                <td>
                                    <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <ul class="dropdown-menu text-center">
                                        <a href="{{ route('customers.edit', $customer->id) }}">
                                            <li class="dropdown-item">Edit</li>
                                        </a>
                                        <a href="{{ route('estimates.index', array_merge(\Request::query(), ['filter_customer' => $customer->id])) }}" target="_blank">
                                            <li class="dropdown-item">Estimates</li>
                                        </a>
                                        <a href="{{  route('bookings.index', array_merge(\Request::query(), ['filter_customer' => $customer->id]))  }}" target="_blank">
                                            <li class="dropdown-item">Bookings</li>
                                        </a>
                                        <a href="javascript:void(0)" onclick="confirmDelete({{ $customer->id }})">
                                            <li class="dropdown-item">
                                                Delete
                                            </li>
                                            <form id='delete-form{{ $customer->id }}'
                                                action='{{ route('customers.destroy', $customer->id) }}' method='POST'>
                                                <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                            </form>
                                        </a>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-center">No Customer found.</p>
                @endif
            </div>
            <div class="mt-2">
                {{$customers->appends(request()->query())->links("pagination::bootstrap-4")}}
            </div>
        </div>
    </section>
    @include('customers.create')
@endsection
@push('scripts')
    @include('layouts.utilities')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
@endpush
