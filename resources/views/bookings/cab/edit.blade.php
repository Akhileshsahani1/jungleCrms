@extends('layouts.master')
@section('title', 'Edit Cab Booking')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-taxi"></i> Edit Cab Booking </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Bookings</a></li>
                        <li class="breadcrumb-item active">Edit Cab Booking</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                </div>
            </div>
            <form method="POST" action="{{ route('cab-booking.update', $booking->id) }}" id="cabForm">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        @include('customers.select-customer')
                    </div>
                </div>
                <div class="card-body mt-2">
                    <div class="row">
                        @include('bookings.cab.form')
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('customers.create')
@endsection
@push('scripts')
    @include('bookings.utilities')
    <script>
        var cab_inclusion_row = {{ count($inclusions) }};

        function addCabInclusion() {
            if (cab_inclusion_row < 50) {
                html = '<tr id="inclusion-row' + cab_inclusion_row + '">';
                html += '<td><input type="text" name="inclusion[' + cab_inclusion_row +
                    '][content]" placeholder="Content" class="form-control" id="content' + cab_inclusion_row +
                    '" required></td>';
                html += '<td class="text-right"><button type="button" onclick="$(\'#inclusion-row' + cab_inclusion_row +
                    '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                html += '</tr>';

                $('#inclusion tbody').append(html);

                cab_inclusion_row++;
            }
        }
    </script>
    <script>
        var cab_exclusion_row = {{ count($exclusions) }};

        function addCabExclusion() {
            if (cab_exclusion_row < 50) {
                html = '<tr id="exclusion-row' + cab_exclusion_row + '">';
                html += '<td><input type="text" name="exclusion[' + cab_exclusion_row +
                    '][content]" placeholder="Content" class="form-control" id="content' + cab_exclusion_row +
                    '" required></td>';
                html += '<td class="text-right"><button type="button" onclick="$(\'#exclusion-row' + cab_exclusion_row +
                    '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                html += '</tr>';

                $('#exclusion tbody').append(html);

                cab_exclusion_row++;
            }
        }
    </script>
    <script>
        var cab_term_row = {{ count($terms) }};

        function addCabTerm() {
            if (cab_term_row < 50) {
                html = '<tr id="term-row' + cab_term_row + '">';
                html += '<td><input type="text" name="term[' + cab_term_row +
                    '][content]" placeholder="Content" class="form-control" id="content' + cab_term_row +
                    '" required></td>';
                html += '<td class="text-right"><button type="button" onclick="$(\'#term-row' + cab_term_row +
                    '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                html += '</tr>';

                $('#term tbody').append(html);

                cab_term_row++;
            }
        }
    </script>
    <script>
        @if (isset($booking) && count($booking->cab->halts) > 0)
            var cab_halt_row = {{ count($booking->cab->halts) }};
        @else
            var cab_halt_row = 1;
        @endif

        function addCabHalt() {
            if (cab_halt_row < 50) {
                html = '<tr id="cab-halt' + cab_halt_row + '">';
                html += '<td style="width:550px"><input type="text" name="halts[' + cab_halt_row +
                    '][halt]" placeholder="Halt Destination" class="form-control" id="halt-destination' + cab_halt_row +
                    '"></td>';
                html += '<td><input type="date" name="halts[' + cab_halt_row +
                    '][start]" placeholder="Start Date" class="form-control amount" id="halt-start' + cab_halt_row +
                    '"></td>';
                html += '<td><input type="date" name="halts[' + cab_halt_row +
                    '][end]" placeholder="End Date" class="form-control discount" id="halt-end' + cab_halt_row + '"></td>';
                html += '<td class="text-right"><button type="button" onclick="$(\'#cab-halt' + cab_halt_row +
                    '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                html += '</tr>';

                $('#halt tbody').append(html);

                cab_halt_row++;
            }
        }
    </script>
@endpush
