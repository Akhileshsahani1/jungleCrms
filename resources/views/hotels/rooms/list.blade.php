@extends('layouts.master')
@section('title', 'Hotel Rooms')
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
                    <h1>Hotel Rooms</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}">Hotels</a></li>
                        <li class="breadcrumb-item active">Hotel Rooms</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $hotel->name }}</h3>
                <div class="card-tools">
                    <form action={{ route('rooms.create') }}>
                        <input type="hidden" name="id" value="{{ $hotel->id }}">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fas fa-plus"></i> Create
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Room Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hotel->rooms as $room)
                            <tr>
                                <td>{{ $room->id }}</td>
                                <td>{{ $room->room }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning" data-toggle="tooltip" title="Edit Room"> <i
                                                class="fas fa-pen"></i> </a>
                                        <button type="button" onclick="confirmDelete({{ $room->id }})"
                                            class="btn btn-danger" data-toggle="tooltip" title="Delete Room"><i class="fas fa-trash"></i> </button>
                                        <form id='delete-form{{ $room->id }}'
                                            action='{{ route('rooms.destroy', $room->id) }}' method='POST'>
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
