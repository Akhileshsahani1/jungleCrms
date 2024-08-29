@extends('layouts.master')
@section('title', 'Create Hotel Estimate')
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
                    <h1><i class="fas fa-hotel"></i> Create Hotel Estimate</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('estimates.index') }}">Estimates</a></li>
                        <li class="breadcrumb-item active">Create Hotel Estimate</li>
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
                    <button class="btn btn-success" type="submit" form="hotelForm">Submit</button>
                </div>
            </div>
            <form method="POST" action="{{ route('hotel-estimate.store') }}" id="hotelForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        @include('customers.select-customer')
                    </div>
                </div>
                <div class="card-body mt-2">
                    <div class="row">
                        @include('estimates.hotel.form')
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
        $('.guest').keyup(function(){
            var allowed = 4;

            var adults = parseInt($('#adult').val());

            var children = parseInt($('#child').val());

            var total = adults + children;

            var quotient = Math.floor(total/allowed);
            var remainder = total%4;
            if(remainder!= '0'){
                remainder = 1;
            }
            var rooms_no = quotient + remainder;
            var extra_beds = 0
            var total_beds = rooms_no * 2;
            if(total_beds < total){
                var extra_beds = total - total_beds;
            }
            $('#bed').val(extra_beds);

            $('#room').val(rooms_no);

        });
    </script>
    <script>
        $(document).ready(function() {

            var term_filter = $('#term_filter').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('get.terms') }}",
                data: {
                    'type': 'hotel',
                    'filter': term_filter,
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

            var inclusion_filter = $('#inclusion_filter').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('get.inclusions') }}",
                data: {
                    'type': 'hotel',
                    'filter': inclusion_filter,
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

            var exclusion_filter = $('#exclusion_filter').val();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('get.exclusions') }}",
                data: {
                    'type': 'hotel',
                    'filter': exclusion_filter,
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

        });
        var hotel_option_row = 1;

        function addHotelOption() {
            if (hotel_option_row < 50) {
                html = '<tr id="hotel-option' + hotel_option_row + '">';
                html += '<td>';
                html += '<select class="form-control hotel_id" name="option[' + hotel_option_row +
                    '][hotel_id]" id="hotel_id' + hotel_option_row + '" onchange="getRooms(' + hotel_option_row +
                    ', this.value)">';
                html += '<option></option>@foreach ($hotels as $hotel)<option value="{{ $hotel->id }}">{{ $hotel->name }}</option>@endforeach ';
                html += '</select>';
                html += '</td>';
                html += '<td>';
                html += '<select class="form-control room" name="option[' + hotel_option_row + '][room_id]" id="room_id' +
                    hotel_option_row + '" onchange="getServices(' + hotel_option_row + ', this.value)">';
                html += '<option>Select Room</option>';
                html += '</select>';
                html += '</td>';
                html += '<td>';
                html += '<select class="form-control service" name="option[' + hotel_option_row +
                    '][service_id]" id="service_id' + hotel_option_row + '" onchange="getTotal(' + hotel_option_row +
                    ', this.value)">';
                html += '<option>Select Service</option>';
                html += '</select>';
                html += '</td>';
                html += '<td>';
                html += '<input type="number" name="option[' + hotel_option_row +
                    '][discount]" placeholder="Discount" class="form-control discount" id="discount' + hotel_option_row +
                    '" value="0" required>';
                html += '</td>';
                html += '<td class="text-right">';
                html += '<button type="button" class="btn bg-success" id="amount-button' + hotel_option_row +
                    '" style="display: none;" onclick="openHotelModal('+ hotel_option_row +')">Total</button>';
                html += '<input type="hidden" class="btn bg-grey" id="amount' + hotel_option_row + '" name="option[' +
                    hotel_option_row + '][amount]">';
                html += '</td>';
                html += '<td class="text-right"><button type="button" onclick="$(\'#hotel-option' + hotel_option_row +
                    '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                html += '</tr>';

                $('#option tbody').append(html);

                hotel_option_row++;
                initializeSelect2()
            }
        }
    </script>
    <script>
        var cab_inclusion_row = {{ count($inclusions) }};

        function addHotelInclusion() {
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

        function addHotelExclusion() {
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

        function addHotelTerm() {
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
        function getTotal(id, value) {

            var room = $('#room').val();
            var checkin = $('#check_in').val();
            var checkout = $('#check_out').val();
            var bed = $('#bed').val();
            var date1 = new Date(checkin);
            var date2 = new Date(checkout);
            var days = parseInt((date2 - date1) / (1000 * 60 * 60 * 24), 10);
            var adult = parseInt($('#adult').val());
            var child = parseInt($('#child').val());

            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('calculate.total') }}",
                data: {
                    'service_id': value,
                    'room': room,
                    'bed': bed,
                    'adult': adult,
                    'child': child,
                    'days': days,
                    'checkin': checkin,
                    'checkout': checkout,
                    "_token": "{{ csrf_token() }}"
                },
                success: function(data) {
                    $('#amount-button' + id).html(data);
                    $('#amount' + id).val(data);
                    $('#amount-button' + id).css('display', 'block');
                }
            });
        }
</script>

@endpush
