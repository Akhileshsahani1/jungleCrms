@extends('layouts.master')
@section('title', 'Hotels')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-hotel"></i> Hotels</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Hotels</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                @include('hotels.filter')
            </div>
            <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Hotel Name</th>
                            <th>City</th>
                            <th>Star</th>
                            <th>Contact</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotels as $hotel)
                            <tr>
                                <td>{{ $hotel->id }}</td>
                                <td><a href="{{ route('hotels.show', $hotel->id) }}">{{ $hotel->name }}</a></td>
                                <td>{{ $hotel->city }}</td>
                                <td>{{ $hotel->rating }} Star</td>
                                <td>{{ $hotel->person }}</td>
                                <td>{{ $hotel->phone }}</td>
                                <td>{{ $hotel->status == 1 ? 'Enabled' : 'Disabled' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('rooms.show', $hotel->id) }}" class="btn btn-dark"
                                            data-toggle="tooltip" title="Show Rooms"> <i class="fas fa-list"></i></a>

                                        <a href="{{ route('hotels.edit', $hotel->id) }}" class="btn btn-warning"
                                            data-toggle="tooltip" title="Edit Hotel"> <i class="fas fa-pen"></i></a>

                                        <button type="button" onclick="confirmDelete({{ $hotel->id }})"
                                            class="btn btn-danger" data-toggle="tooltip" title="Delete Hotel"><i
                                                class="fas fa-trash"></i> </button>
                                        <form id='delete-form{{ $hotel->id }}'
                                            action='{{ route('hotels.destroy', $hotel->id) }}' method='POST'>
                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
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
