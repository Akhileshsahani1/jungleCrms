@extends('layouts.master')
@section('title', 'Create Cab Estimate')
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
                    <h1><i class="fas fa-taxi"></i> Create Cab Estimate </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('estimates.index') }}">Estimates</a></li>
                        <li class="breadcrumb-item active">Create Cab Estimate</li>
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
                    <button class="btn btn-success" type="submit" form="cabForm">Submit</button>
                </div>
            </div>
            <form method="POST" action="{{ route('cab-estimate.store') }}" id="cabForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        @include('customers.select-customer')
                    </div>
                </div>
                <div class="card-body mt-2">
                    <div class="row">
                        @include('estimates.cab.form')
                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('customers.create')
@endsection
@push('scripts')
    @include('estimates.utilities')
    <script>
        var cab_option_row = 1;

            function addCabOption() {
                if(cab_option_row < 50){
                    html    = '<tr id="cab-option' + cab_option_row + '">';
                    html   += '<td style="width:350px"><input type="text" name="option['+ cab_option_row +'][content]" placeholder="Content" class="form-control" id="content'+ cab_option_row +'" required></td>';
                    html   += '<td><input type="number" name="option['+ cab_option_row +'][amount]" placeholder="Amount" class="form-control amount" id="amount'+ cab_option_row +'" value="0" required></td>';
                    html   += '<td><input type="number" name="option['+ cab_option_row +'][discount]" placeholder="Discount" class="form-control discount" id="discount'+ cab_option_row +'" value="0" required></td>';
                    html   += '<td class="text-right"><button type="button" onclick="$(\'#cab-option' + cab_option_row + '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                    html   += '</tr>';

                    $('#option tbody').append(html);

                    cab_option_row++;
                }
            }
    </script>
    <script>
        var cab_halt_row = 1;

            function addCabHalt() {
                if(cab_halt_row < 50){
                    html    = '<tr id="cab-halt' + cab_halt_row + '">';
                    html   += '<td style="width:550px"><input type="text" name="halts['+ cab_halt_row +'][halt]" placeholder="Halt Destination" class="form-control" id="halt-destination'+ cab_halt_row +'"></td>';
                    html   += '<td><input type="date" name="halts['+ cab_halt_row +'][start]" placeholder="Start Date" class="form-control amount" id="halt-start'+ cab_halt_row +'"></td>';
                    html   += '<td><input type="date" name="halts['+ cab_halt_row +'][end]" placeholder="End Date" class="form-control discount" id="halt-end'+ cab_halt_row +'"></td>';
                    html   += '<td class="text-right"><button type="button" onclick="$(\'#cab-halt' + cab_halt_row + '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                    html   += '</tr>';

                    $('#halt tbody').append(html);

                    cab_halt_row++;
                }
            }
    </script>
    <script>
        var cab_inclusion_row = {{ count($inclusions) }};

            function addCabInclusion() {
                if(cab_inclusion_row < 50){
                    html    = '<tr id="inclusion-row' + cab_inclusion_row + '">';
                    html   += '<td><input type="text" name="inclusion['+ cab_inclusion_row +'][content]" placeholder="Content" class="form-control" id="content'+ cab_inclusion_row +'" required></td>';
                    html   += '<td class="text-right"><button type="button" onclick="$(\'#inclusion-row' + cab_inclusion_row + '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                    html   += '</tr>';

                    $('#inclusion tbody').append(html);

                    cab_inclusion_row++;
                }
            }
    </script>
    <script>
        var cab_exclusion_row = {{ count($exclusions) }};

            function addCabExclusion() {
                if(cab_exclusion_row < 50){
                    html    = '<tr id="exclusion-row' + cab_exclusion_row + '">';
                    html   += '<td><input type="text" name="exclusion['+ cab_exclusion_row +'][content]" placeholder="Content" class="form-control" id="content'+ cab_exclusion_row +'" required></td>';
                    html   += '<td class="text-right"><button type="button" onclick="$(\'#exclusion-row' + cab_exclusion_row + '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                    html   += '</tr>';

                    $('#exclusion tbody').append(html);

                    cab_exclusion_row++;
                }
            }
    </script>
    <script>
        var cab_term_row = {{ count($terms) }};

            function addCabTerm() {
                if(cab_term_row < 50){
                    html    = '<tr id="term-row' + cab_term_row + '">';
                    html   += '<td><input type="text" name="term['+ cab_term_row +'][content]" placeholder="Content" class="form-control" id="content'+ cab_term_row +'" required></td>';
                    html   += '<td class="text-right"><button type="button" onclick="$(\'#term-row' + cab_term_row + '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                    html   += '</tr>';

                    $('#term tbody').append(html);

                    cab_term_row++;
                }
            }
    </script>
     <script>
    function getIternaries() {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('get.iternaries') }}",
            data: {
                'state': $('#iternary_state').val(),
                'duration': $('#iternary_duration').val(),
            },
            success: function(data) {
                $('#iternary').html(data);
            }
        });
    }
    function showIternaries(value) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('show.iternaries') }}",
            data: {
                'id': value,
            },
            success: function(data) {
                $('#iternaries_show').html(data.output);
                iternaries_option_row = data.count;
            }
        });
    }
    </script>
     <script>
        var iternaries_option_row =1
    function addIternary() {
        if (iternaries_option_row < 50) {
            html = '<tr id="iternaries-option-row' + iternaries_option_row + '">';
            html += '<td style="width:350px"><input type="text" name="iternaries[' + iternaries_option_row +
                '][title]" placeholder="Iternary title" class="form-control" id="content' + iternaries_option_row +
                '" required></td>';
            html += '<td><textarea name="iternaries[' + iternaries_option_row +
                '][text]" placeholder="Iternary text" class="form-control rate" id="rate' + iternaries_option_row +
                '" value="0" required></textarea></td>';
            html += '<td class="text-right"><button type="button" onclick="$(\'#iternaries-option-row' + iternaries_option_row +
                '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#iternaries_show tbody').append(html);

            iternaries_option_row++;
        }
    }
</script>
@endpush
