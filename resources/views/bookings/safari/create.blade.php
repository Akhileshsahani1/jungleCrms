@extends('layouts.master')
@section('title', 'Create Safari Booking')
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
                    <h1><i class="fab fa-safari"></i> Create Safari Booking</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Bookings</a></li>
                        <li class="breadcrumb-item active">Create Safari Booking</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <section class="content">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                        <button class="btn btn-success" type="submit" form="safariForm">Submit</button>
                    </div>
                </div>
                <form method="POST" action="{{ route('safari-booking.store') }}" id="safariForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            @include('customers.select-customer')
                        </div>
                    </div>
                    <div class="card-body mt-2">
                        <div class="row">
                            @include('bookings.safari.form')
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </section>
    @include('customers.create')
@endsection
@push('scripts')
    @include('bookings.utilities')
    <script>

        loadForm();

        function loadForm() {
            $('#jim').hide();
            $('#ranthambore').hide();
            $('#gir').hide();
            $(".gir"). prop('disabled', false);
            $(".jim"). prop('disabled', false);
            $(".ranthambore"). prop('disabled', false);
            var val = $('#sanctuary').val();

            switch (val) {
                case 'gir':
                    $('#jim').hide();
                    $('#ranthambore').hide();
                    $('#gir').show();
                    $(".jim"). prop('disabled', true);
                    $(".ranthambore"). prop('disabled', true);
                    break;
                case 'jim':
                    $('#ranthambore').hide();
                    $('#gir').hide();
                    $('#jim').show();
                    $(".gir"). prop('disabled', true);
                    $(".ranthambore"). prop('disabled', true);
                    break;
                case 'ranthambore':
                    $('#gir').hide();
                    $('#jim').hide();
                    $('#ranthambore').show();
                    $(".gir"). prop('disabled', true);
                    $(".jim"). prop('disabled', true);
                    break;

                default:
                    $('#jim').hide();
                    $('#ranthambore').hide();
                    $('#gir').hide();
            }

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('get.inclusions') }}",
                data: {
                    'type': 'safari',
                    'filter': val,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    html = '';
                    $.each(data, function(index, value) {
                        html += '<tr id="inclusion-row' + index + '">';
                        html += '<td><input type="text" name="inclusion[' + index +
                            '][content]" placeholder="Content" value="' + value.content +
                            '" class="form-control" id="content' + index + '" required></td>';
                        html +=
                            '<td class="text-right"><button type="button" onclick="$(\'#inclusion-row' +
                            index +
                            '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                        html += '</tr>';
                    });
                    $('#inclusion tbody').html(html);
                }
            });
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('get.exclusions') }}",
                data: {
                    'type': 'safari',
                    'filter': val,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    html = '';
                    $.each(data, function(index, value) {
                        html += '<tr id="exclusion-row' + index + '">';
                        html += '<td><input type="text" name="exclusion[' + index +
                            '][content]" placeholder="Content" value="' + value.content +
                            '" class="form-control" id="content' + index + '" required></td>';
                        html +=
                            '<td class="text-right"><button type="button" onclick="$(\'#exclusion-row' +
                            index +
                            '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                        html += '</tr>';
                    });
                    $('#exclusion tbody').html(html);
                }
            });
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('get.voucher.terms') }}",
                data: {
                    'type': 'safari',
                    'filter': val,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    html = '';
                    $.each(data, function(index, value) {
                        html += '<tr id="term-row' + index + '">';
                        html += '<td><input type="text" name="term[' + index +
                            '][content]" placeholder="Content" value="' + value.content +
                            '" class="form-control" id="content' + index + '" required></td>';
                        html +=
                            '<td class="text-right"><button type="button" onclick="$(\'#term-row' +
                            index +
                            '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                        html += '</tr>';
                    });
                    $('#term tbody').html(html);
                }
            });


        }
    </script>
    <script>
        @if (isset($booking) && count($booking->customer_details) > 0)
            var customer_option_row = {{ count($booking->customer_details) }};
        @else
            var customer_option_row = 1;
        @endif

        function addCustomer() {
            if (customer_option_row < 50) {
                html = '<tr id="customer-option-row' + customer_option_row +'">';
                html +=
                    '<td><input type="text" name="customer[' + customer_option_row +'][name]" placeholder="Name" class="form-control" id="name' + customer_option_row +'" required></td>';
                html +=
                    '<td><input type="text" name="customer[' + customer_option_row +'][age]" placeholder="Age" class="form-control" id="age' + customer_option_row +'" required></td>';
                html += '<td>';
                html += '<select name="customer[' + customer_option_row +'][gender]" class="form-control" id="gender' + customer_option_row +'" required>';
                html += '<option value="" selected>Gender</option>';
                html += '<option value="Male">Male</option>';
                html += '<option value="Female">Female</option>';
                html += '</select>';
                html += '</td>';
                html += '<td>';
                html += '<select name="customer[' + customer_option_row +'][nationality]" class="form-control" id="nationality' + customer_option_row +'" required onchange="getStates(' + customer_option_row + ', this.value)">';
                html += '<option value="" selected>Select</option>';
                html += '<option value="Indian">Indian</option>';
                html += '<option value="Foreigner">Foreigner</option>';
                html += '</select>';
                html += '</td>';
                html += '<td>';
                html += '<select name="customer[' + customer_option_row +'][state]" class="form-control" id="state' + customer_option_row +'" required>';
                html += '<option value="" selected>State</option>';
                html += '@foreach ($states as $state)';
                html += '<option value="{{ $state->state }}">{{ $state->state }}</option>';
                html += '@endforeach';
                html += '</select>';
                html += '</td>';
                html += '<td>';
                html += '<select name="customer[' + customer_option_row +'][idproof]" class="form-control" id="idproof' + customer_option_row +'" required>';
                html += '<option value="" selected>Type</option>';
                html += '<option value="Aadhar Card">Aadhar Card</option>';
                html += '<option value="Voter ID">Voter ID</option>';
                html += '<option value="Driving License">Driving License</option>';
                html += '<option value="Passport">Passport</option>';
                html += '</select>';
                html += '</td>';
                html += '<td><input type="text" name="customer[' + customer_option_row +'][idproof_no]" placeholder="Id No" class="form-control" id="idproof_no' + customer_option_row +'" required></td>';
                html += '<td class="text-right"><button type="button" onclick="$(\'#customer-option-row' + customer_option_row +'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>';
                html += '</td>';
                html += '</tr>';

                $('#details tbody').append(html);

                customer_option_row++;
            }
        }
    </script>
    
 <script>
    var safari_inclusion_row = {{ count($inclusions) }};

    function addSafariInclusion() {
        if (safari_inclusion_row < 50) {
            html = '<tr id="inclusion-row' + safari_inclusion_row + '">';
            html += '<td><input type="text" name="inclusion[' + safari_inclusion_row +
                '][content]" placeholder="Content" class="form-control" id="content' + safari_inclusion_row +
                '" required></td>';
            html += '<td class="text-right"><button type="button" onclick="$(\'#inclusion-row' + safari_inclusion_row +
                '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#inclusion tbody').append(html);

            safari_inclusion_row++;
        }
    }
</script>
<script>
    var safari_exclusion_row = {{ count($exclusions) }};

    function addSafariExclusion() {
        if (safari_exclusion_row < 50) {
            html = '<tr id="exclusion-row' + safari_exclusion_row + '">';
            html += '<td><input type="text" name="exclusion[' + safari_exclusion_row +
                '][content]" placeholder="Content" class="form-control" id="content' + safari_exclusion_row +
                '" required></td>';
            html += '<td class="text-right"><button type="button" onclick="$(\'#exclusion-row' + safari_exclusion_row +
                '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#exclusion tbody').append(html);

            safari_exclusion_row++;
        }
    }
</script>
<script>
    var safari_term_row = {{ count($terms) }};

    function addSafariTerm() {
        if (safari_term_row < 50) {
            html = '<tr id="term-row' + safari_term_row + '">';
            html += '<td><input type="text" name="term[' + safari_term_row +
                '][content]" placeholder="Content" class="form-control" id="content' + safari_term_row +
                '" required></td>';
            html += '<td class="text-right"><button type="button" onclick="$(\'#term-row' + safari_term_row +
                '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#term tbody').append(html);

            safari_term_row++;
        }
    }
</script>

@endpush
