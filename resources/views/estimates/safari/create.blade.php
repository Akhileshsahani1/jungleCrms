@extends('layouts.master')
@section('title', 'Create Safari Estimate')
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
                    <h1><i class="fab fa-safari"></i> Create Safari Estimate</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('estimates.index') }}">Estimates</a></li>
                        <li class="breadcrumb-item active">Create Safari Estimate</li>
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
                    <button class="btn btn-success" type="submit" form="safariForm">Submit</button>
                </div>
            </div>
            <form method="POST" action="{{ route('safari-estimate.store') }}" id="safariForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        @include('customers.select-customer')
                    </div>
                </div>
                <div class="card-body mt-2">
                    <div class="row">
                        @include('estimates.safari.form')
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
                url: "{{ route('get.terms') }}",
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
        var safari_option_row = 1;

        function addSafariOption() {
            if (safari_option_row < 50) {
                html = '<tr id="safari-option-row' + safari_option_row + '">';
                html += '<td style="width:350px"><input type="text" name="option[' + safari_option_row +
                    '][content]" placeholder="Content" class="form-control" id="content' + safari_option_row +
                    '" required></td>';
                html += '<td><input type="number" name="option[' + safari_option_row +
                    '][amount]" placeholder="Amount" class="form-control amount" id="amount' + safari_option_row +
                    '" value="0" required></td>';
                html += '<td><input type="number" name="option[' + safari_option_row +
                    '][discount]" placeholder="Discount" class="form-control discount" id="discount' + safari_option_row +
                    '" value="0" required></td>';
                html += '<td class="text-right"><button type="button" onclick="$(\'#safari-option-row' + safari_option_row +
                    '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                html += '</tr>';

                $('#option tbody').append(html);

                safari_option_row++;
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
