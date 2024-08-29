
@extends('layouts.master')
@section('title', 'Permits')
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
                    <h1><i class="nav-icon fas fa-check-circle"></i> Permits</h1>
                </div>
                <div class="col-sm-6 text-right">
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
            <div class="card-body">
                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Links</th>
                                            <th>Created Date And Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     @foreach ($per_links as $link)
                                      <tr>
                                         <td>{{ $loop->iteration }}</td>
                                          <td><a href="{{ url('permits') }}/{{ $link->slug }}" target="_blank">{{ url('permits') }}/{{ $link->slug }}</a></td>
                                          <td>{{ \Carbon\Carbon::parse($link->created_at)->format('d-m-Y g:i:A') }}</td>
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
