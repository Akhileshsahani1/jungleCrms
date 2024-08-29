@extends('layouts.master')
@section('title', 'Edit Tour Estimate')
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
                    <h1><i class="fas fa-globe-asia"></i> Edit Tour Estimate</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('estimates.index') }}">Estimates</a></li>
                        <li class="breadcrumb-item active">Edit Tour Estimate</li>
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
                    <button class="btn btn-success" type="submit" form="tourForm">Submit</button>
                </div>
            </div>
            <form method="POST" action="{{ route('tour-estimate.update', $estimate->id) }}" id="tourForm">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="row">
                        @include('customers.select-customer')
                    </div>
                </div>
                <div class="card-body mt-2">
                    <div class="row">
                        @include('estimates.tour.form')
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

            var adults = parseInt($('#adults').val());

            var children = parseInt($('#childs').val());

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
        $(function() {
            $('#type').select2({
                theme: 'bootstrap4',
                placeholder: "Select Type",
                allowClear: true,
            });

            $("#cab").hide();
            $(".cab").prop('disabled', true);

            $("#hotel").hide();
            $(".hotel").prop('disabled', true);

            $("#safari").hide();
            $(".safari").prop('disabled', true);


            loadForm();



            $("#type").change(function() {
                var estimate_type = $(this).val();
                if (estimate_type.includes('safari')) {
                    $('#safari').show();
                    $(".safari").prop('disabled', false);

                }
                if (!estimate_type.includes('safari')) {
                    $('#safari').hide();
                    $(".safari").prop('disabled', true);

                }
                if (estimate_type.includes('hotel')) {
                    $('#hotel').show();
                    $(".hotel").prop('disabled', false);

                }
                if (!estimate_type.includes('hotel')) {
                    $('#hotel').hide();
                    $(".hotel").prop('disabled', true);

                }
                if (estimate_type.includes('cab')) {
                    $('#cab').show();
                    $(".cab").prop('disabled', false);

                }
                if (!estimate_type.includes('cab')) {
                    $('#cab').hide();
                    $(".cab").prop('disabled', true);

                }
            }).change();
        });
    </script>
    <script>
        function loadForm() {
            $('#jim').hide();
            $('#ranthambore').hide();
            $('#gir').hide();
            $(".gir").prop('disabled', false);
            $(".jim").prop('disabled', false);
            $(".ranthambore").prop('disabled', false);
            var val = $('#sanctuary').val();

            switch (val) {
                case 'gir':
                    $('#jim').hide();
                    $('#ranthambore').hide();
                    $('#gir').show();
                    $(".jim").prop('disabled', true);
                    $(".ranthambore").prop('disabled', true);
                    $('.ranthamborediv').remove();
                    $('.jimdiv').remove();
                    break;
                case 'jim':
                    $('#ranthambore').hide();
                    $('#gir').hide();
                    $('#jim').show();
                    $(".gir").prop('disabled', true);
                    $(".ranthambore").prop('disabled', true);
                    $('.girdiv').remove();
                    $('.ranthamborediv').remove();
                    break;
                case 'ranthambore':
                    $('#gir').hide();
                    $('#jim').hide();
                    $('#ranthambore').show();
                    $(".gir").prop('disabled', true);
                    $(".jim").prop('disabled', true);
                    $('.girdiv').remove();
                    $('.jimdiv').remove();
                    break;

                default:
                $(".gir").prop('disabled', true);
                $(".jim").prop('disabled', true);
                $(".ranthambore").prop('disabled', true);
                    $('#jim').hide();
                    $('#ranthambore').hide();
                    $('#gir').hide();
            }
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('get.terms') }}",
                data: {
                    'type': 'tour',
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
        @if (isset($estimate) && in_array('cab', $estimate_type) && count($estimate->cab_options) > 0)
            var cab_option_row = {{ count($estimate->cab_options) }};
        @else
            var cab_option_row = 1;
        @endif


        function addCabOption() {
            if (cab_option_row < 50) {
                html = '<tr id="cab-option-row' + cab_option_row + '">';
                html += '<td style="width:350px"><input type="text" name="cab_option[' + cab_option_row +
                    '][content]" placeholder="Content" class="form-control cab" id="cab_content' + cab_option_row +
                    '" required></td>';
                html += '<td><input type="number" name="cab_option[' + cab_option_row +
                    '][amount]" placeholder="Amount" class="form-control cab" id="cab_amount' + cab_option_row +
                    '" value="0" required></td>';
                html += '<td><input type="number" name="cab_option[' + cab_option_row +
                    '][discount]" placeholder="Discount" class="form-control cab" id="cab_discount' + cab_option_row +
                    '" value="0" required></td>';
                html += '<td class="text-right"><button type="button" onclick="$(\'#cab-option-row' + cab_option_row +
                    '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                html += '</tr>';

                $('#cab_option tbody').append(html);

                cab_option_row++;
            }
        }
    </script>
    <script>
        @if (isset($estimate) && in_array('hotel', $estimate_type) && count($estimate->hotel_options) > 0)
            var hotel_option_row = {{ count($estimate->hotel_options) }};
        @else
            var hotel_option_row = 1;
        @endif

        function addHotelOption() {
            if (hotel_option_row < 50) {
                html = '<tr id="hotel-option' + hotel_option_row + '">';
                html += '<td>';
                html += '<select class="form-control hotel hotelid" name="option[' + hotel_option_row +
                    '][hotel_id]" id="hotel_id' + hotel_option_row + '" onchange="getRooms(' + hotel_option_row +
                    ', this.value)">';
                html += '<option></option>';
                html += '@foreach ($hotels as $hotel)';
                html += '<option value="{{ $hotel->id }}">{{ $hotel->name }}</option>';
                html += '@endforeach';
                html += '</select>';
                html += '</td>';
                html += '<td>';
                html += '<select class="form-control hotel" name="option[' + hotel_option_row + '][room_id]" id="room_id' +
                    hotel_option_row + '" onchange="getServices(' + hotel_option_row + ', this.value)">';
                html += '<option>Select Room</option>';
                html += '</select>';
                html += '</td>';
                html += '<td>';
                html += '<select class="form-control hotel" name="option[' + hotel_option_row +
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

                $('#hotel_option tbody').append(html);

                hotel_option_row++;
                initializeSelect2()
            }
        }
    </script>
    <script>
        @if (isset($estimate) && in_array('safari', $estimate_type) && count($estimate->safari_options) > 0)
            var safari_option_row = {{ count($estimate->safari_options) }};
        @else
            var safari_option_row = 1;
        @endif

        function addSafariOption() {
            if (safari_option_row < 50) {
                html = '<tr id="safari-option-row' + safari_option_row + '">';
                html += '<td style="width:350px"><input type="text" name="safari_option[' + safari_option_row +
                    '][content]" placeholder="Content" class="form-control safari" id="safari_content' + safari_option_row +
                    '" required></td>';
                html += '<td><input type="number" name="safari_option[' + safari_option_row +
                    '][amount]" placeholder="Amount" class="form-control safari" id="safari_amount' + safari_option_row +
                    '" value="0" required></td>';
                html += '<td><input type="number" name="safari_option[' + safari_option_row +
                    '][discount]" placeholder="Discount" class="form-control safari" id="safari_discount' +
                    safari_option_row +
                    '" value="0" required></td>';
                html += '<td class="text-right"><button type="button" onclick="$(\'#safari-option-row' + safari_option_row +
                    '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                html += '</tr>';

                $('#safari_option tbody').append(html);

                safari_option_row++;
            }
        }
    </script>
    <script>
        var cab_inclusion_row = {{ count($inclusions) }};

        function addTourInclusion() {
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

        function addTourExclusion() {
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

        function addTourTerm() {
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
    @if (isset($estimate) && in_array('safari', $estimate_type) && count($estimate->safaris) > 0)
    @foreach($estimate->safaris as $key => $safari)
   <script>
       $(document).ready(function (){
           var safari_row = '{{ $key }}';
        var zone = $('#zone'+safari_row).val();

        switch (zone)
        {
        case "Gir Jungle Trail" :
            document.getElementById("time"+safari_row).options[0]=new Option("Select Time","");
            document.getElementById("time"+safari_row).options[1]=new Option("6:00 AM - 9:00 AM", "6:00 AM - 9:00 AM");
            document.getElementById("time"+safari_row).options[2]=new Option("6:45 AM - 9:45 AM", "6:45 AM - 9:45 AM");
            document.getElementById("time"+safari_row).options[3]=new Option("8:30 AM - 11:30 AM", "8:30 AM - 11:30 AM");
            document.getElementById("time"+safari_row).options[4]=new Option("3:00 PM - 6:00 PM", "3:00 PM - 6:00 PM");
            document.getElementById("time"+safari_row).options[5]=new Option("4:00 PM - 7:00 PM", "4:00 PM - 7:00 PM");
            break;

        case "Devalia Safari Park" :
            document.getElementById("time"+safari_row).options[0]=new Option("Select Time","");
            document.getElementById("time"+safari_row).options[1]=new Option("7:00 AM - 7:55 AM", "7:00 AM - 7:55 AM");
            document.getElementById("time"+safari_row).options[2]=new Option("8:00 AM - 8:55 AM", "8:00 AM - 8:55 AM");
            document.getElementById("time"+safari_row).options[3]=new Option("9:00 AM - 9:55 AM", "9:00 AM - 9:55 AM");
            document.getElementById("time"+safari_row).options[4]=new Option("10:00 AM - 10:55 AM", "10:00 AM - 10:55 AM");
            document.getElementById("time"+safari_row).options[5]=new Option("3:00 PM - 3:55 PM", "3:00 PM - 3:55 PM");
            document.getElementById("time"+safari_row).options[6]=new Option("4:00 PM - 4:55 PM", "4:00 PM - 4:55 PM");
            document.getElementById("time"+safari_row).options[7]=new Option("5:00 PM - 5:55 PM", "5:00 PM - 5:55 PM");
            break

        case "Kankai Nature Safari" :
            document.getElementById("time"+safari_row).options[0]=new Option("Select Time","");
            document.getElementById("time"+safari_row).options[1]=new Option("6:00 AM - 12:00 PM", "6:00 AM - 12:00 PM");
            document.getElementById("time"+safari_row).options[2]=new Option("1:00 AM - 5:00 PM", "1:00 AM - 5:00 PM");
            break;


        default:

            document.getElementById("time"+safari_row).options[0]=new Option("Select Time","");
            document.getElementById("time"+safari_row).options[1]=new Option("Morning");
            document.getElementById("time"+safari_row).options[2]=new Option("Evening");

        return true;
        }
        @if(in_array('safari', $estimate_type))
        var time = '{{ $safari->time }}';
        $('#time'+safari_row).val(time);
        @endif

    });
    </script>
    @endforeach
    @endif
         <script>
            function getTotal(id, value) {

                var room = $('#room').val();
                var checkin = $('#check_in').val();
                var checkout = $('#check_out').val();
                var bed = $('#bed').val();
                var date1 = new Date(checkin);
                var date2 = new Date(checkout);
                var days = parseInt((date2 - date1) / (1000 * 60 * 60 * 24), 10);
                var adult = parseInt($('#adults').val());
                var child = parseInt($('#childs').val());

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
    <script>
        @if (isset($estimate) && in_array('safari', $estimate_type) && count($estimate->safaris) > 0)
        var safari_row = {{ count($estimate->safaris) }};
    @else
        var safari_row = 1;
    @endif

    function addSafari() {
       var sanctuary = $('#sanctuary').val();
       if( !sanctuary ) {
            alert('Please Select Sanctuary first !');
            return false
       }

       if (sanctuary == 'gir') {

        html = '<div class="card girdiv" id="safaris' + safari_row + '">';
        html += '<div class="card-header bg-dark">';
        html += '<h3 class="card-title">Gir National Park Safari</h3>';
        html += '<div class="card-tools">';
        html += '<a href="javascript:void(0)" class="btn bg-danger btn-sm" onclick="$(\'#safaris' + safari_row + '\').remove();">Remove</a>';
        html += '</div>';
        html += '</div>';
        html += '<div class="card-body">';
        html += '<div class="row">';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="mode' + safari_row + '">Mode of Vehicle</label>';
        html += '<select id="mode' + safari_row + '" class="form-control gir" name="safari[' + safari_row + '][mode]" required>';
        html += '<option value="" selected>Select Mode of Vehicle</option>';
        html += '<option value="Jeep">Jeep</option>';
        html += '<option value="Car">Car</option>';
        html += '<option value="Bus">Bus</option>';
        html += '</select>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="zone' + safari_row + '">Safari Zone</label>';
        html += '<select name="safari[' + safari_row + '][zone]" class="form-control gir" id="zone' + safari_row + '" onchange="javascript: loadSafariTimings(' + safari_row + ', this.options[this.selectedIndex].value);" required>';
        html += '<option value="">Select Safari Zone</option>';
        html += '<option value="Gir Jungle Trail">Gir Jungle Trail</option>';
        html += '<option value="Devalia Safari Park">Devalia Safari Park</option>';
        html += '<option value="Kankai Nature Safari">Kankai Nature Safari </option>';
        html += '<option value="Devalia Bus Safari">Devalia Bus Safari</option>';
        html += '</select>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="adult' + safari_row + '">No of Adults</label>';
        html += '<input type="number" id="adult' + safari_row + '" class="form-control gir" placeholder="No of Adults" name="safari[' + safari_row + '][adult]" value="1" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="child' + safari_row + '">No of Children</label>';
        html += '<input type="number" id="child' + safari_row + '" class="form-control gir" placeholder="No of Children" name="safari[' + safari_row + '][child]" value="0" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="nationality' + safari_row + '">Nationality</label>';
        html += '<select name="safari[' + safari_row + '][nationality]" id="nationality' + safari_row + '" class="form-control gir" required>';
        html += '<option value="">Select Nationality</option>';
        html += '<option value="Indian">Indian</option>';
        html += '<option value="Foreigner">Foreigner</option>';
        html += '</select>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="date' + safari_row + '">Safari Date</label>';
        html += '<input type="date" id="date' + safari_row + '" class="form-control gir" placeholder="Safari Date" name="safari[' + safari_row + '][date]" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="time' + safari_row + '">Safari Time</label>';
        html += '<select name="safari[' + safari_row + '][time]" id="time' + safari_row + '" class="form-control gir" required>';
        html += '<option value="">Select Time</option>';
        html += '</select>';
        html += '</div>';
        html += '<div class="form-group col-sm-8">';
        html += '<label for="jeeps' + safari_row + '">No. of Jeeps/Canter</label>';
        html += '<input type="number" id="jeeps' + safari_row + '" class="form-control gir" placeholder="No. of Jeeps/Canter" name="safari[' + safari_row + '][jeeps]" value="1" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-12">';
        html += '<label for="note' + safari_row + '">Safari Note</label>';
        html += '<textarea class="form-control summernote gir" id="note' + safari_row + '" name="safari[' + safari_row + '][note]"></textarea>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';

       }

       if(sanctuary == 'ranthambore') {
        html ='<div class="card ranthamborediv" id="safaris' + safari_row + '">';
        html +='<div class="card-header bg-dark">';
        html +='<h3 class="card-title">Ranthambore National Park Safari</h3>';
        html +='<div class="card-tools">';
        html +='<a href="javascript:void(0)" class="btn bg-danger btn-sm" onclick="$(\'#safaris' + safari_row + '\').remove();">Remove</a>';
        html +='</div>';
        html +='</div>';
        html +='<div class="card-body">';
        html +='<div class="row">';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="mode' + safari_row + '">Mode of Vehicle</label>';
        html +='<select id="mode' + safari_row + '" class="form-control ranthambore" name="safari[' + safari_row + '][mode]" required>';
        html +='<option value="" selected>Select Mode of Vehicle</option>';
        html +='<option value="Jeep">Jeep</option>';
        html +='<option value="Jeep Half Day Safari">Jeep Half Day Safari</option>';
        html +='<option value="Jeep Full Day Safari">Jeep Full Day Safari</option>';
        html +='<option value="Canter">Canter</option>';
        html +='<option value="Boat">Boat</option>';
        html +='<option value="Tatkal Gypsy">Tatkal Gypsy</option>';
        html +='</select>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="area' + safari_row + '">Safari Area</label>';
        html +='<select name="safari[' + safari_row + '][area]" id="area' + safari_row + '" class="form-control ranthambore" required>';
        html +='<option value="">Select Safari Area</option>';
        html +='<option value="Ranthambore National Park">Ranthambore National Park</option>';
        html +='<option value="Chambal Motor Boat Safari">Chambal Motor Boat Safari</option>';
        html +='</select>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="zone' + safari_row + '">Safari Zone</label>';
        html +='<select name="safari[' + safari_row + '][zone]" id="zone' + safari_row + '" class="form-control ranthambore" required>';
        html +='<option value="">Select Safari Zone</option>';
        html +='<option value="All Zone">All Zone</option>';
        html +='<option value="1/2/3/4/5/6/7">Zone 1/2/3/4/5/6/7</option>';
        html +='<option value="8/9/10">Zone 8/9/10</option>';
        html +='<option value="1/2/3/4/5/6/7/8/9/10">Zone 1/2/3/4/5/6/7/8/9/10</option>';
        html +='</select>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="vehicle_type' + safari_row + '">Vehicle Booking Type</label>';
        html +='<select name="safari[' + safari_row + '][vehicle_type]" id="vehicle_type' + safari_row + '" class="form-control ranthambore" required>';
        html +='<option value="">Select Vehicle Booking Type</option>';
        html +='<option value="Private">Private</option>';
        html +='<option value="Sharing">Sharing</option>';
        html +='</select>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="total_person' + safari_row + '">No of Person</label>';
        html +='<input type="number" id="total_person' + safari_row + '" class="form-control ranthambore" placeholder="No of Person" name="safari[' + safari_row + '][total_person]" value="1" required>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="nationality' + safari_row + '">Nationality</label>';
        html +='<select name="safari[' + safari_row + '][nationality]" id="nationality' + safari_row + '" class="form-control ranthambore" required>';
        html +='<option value="">Select Nationality</option>';
        html +='<option value="Indian">Indian</option>';
        html +='<option value="Foreigner">Foreigner</option>';
        html +='</select>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="date' + safari_row + '">Safari Date</label>';
        html +='<input type="date" id="date' + safari_row + '" class="form-control ranthambore" placeholder="Safari Date" name="safari[' + safari_row + '][date]" required>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="time' + safari_row + '">Time</label>';
        html +='<select name="safari[' + safari_row + '][time]" id="time' + safari_row + '" class="form-control ranthambore" required>';
        html +='<option value="">Select Time</option>';
        html +='<option value="Morning">Morning</option>';
        html +='<option value="Evening">Evening</option>';
        html +='<option value="Half Day: Morning (06:00 AM - 12:30 PM)">Half Day: Morning (06:00 AM - 12:30PM)</option>';
        html +='<option value="Half Day: Evening (12:30 PM - 05:00 PM)">Half Day: Evening (12:30 PM - 05:00 PM)</option>';
        html +='<option value="Full Day: (06:00 AM - 05:00 PM)">Full Day: (06:00 AM - 05:00 PM)</option>';
        html += '<optgroup label="Chambal Timings"></optgroup>';
        html += '<option value="8:00 am to 9:00 am">8:00 AM to 9:00 AM</option>';
        html += '<option value="9:00 am to 10:00 am">9:00 AM to 10:00 AM</option>';
        html += '<option value="10:00 am to 11:00 am">10:00 AM to 11:00 AM</option>';
        html += '<option value="11:00 am to 12:00 pm">11:00 AM to 12:00 PM</option>';
        html += '<option value="12:00 pm to 01:00 pm">12:00 PM to 01:00 PM</option>';
        html += '<option value="01:00 pm to 02:00 pm">01:00 PM to 02:00 PM</option>';
        html += '<option value="02:00 pm to 03:00 pm">02:00 PM to 03:00 PM</option>';
        html += '<option value="03:00 pm to 04:00 pm">03:00 PM to 04:00 PM</option>';
        html += '<option value="04:00 pm to 05:00 pm">04:00 PM to 05:00 PM</option>';
        html += '<option value="05:00 pm to 06:00 pm">05:00 PM to 06:00 PM</option>';
        html +='</select>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="type' + safari_row + '">Booking Type</label>';
        html +='<select name="safari[' + safari_row + '][type]" id="type' + safari_row + '" class="form-control ranthambore" required>';
        html +='<option value="">Select Booking Type</option>';
        html +='<option value="Advance Booking">Advanced Booking</option>';
        html +='<option value="Current Booking">Current Booking</option>';
        html +='</select>';
        html +='</div>';
        html +='<div class="form-group col-sm-12">';
        html +='<label for="jeeps' + safari_row + '">No. of Jeeps/Canter</label>';
        html +='<input type="number" id="jeeps' + safari_row + '" class="form-control ranthambore" placeholder="No. of Jeeps/Canter" name="safari[' + safari_row + '][jeeps]" value="1" required>';
        html +='</div>';
        html +='<div class="form-group col-sm-12">';
        html +='<label for="note' + safari_row + '">Safari Note</label>';
        html +='<textarea class="form-control summernote ranthambore" id="note' + safari_row + '" name="safari[' + safari_row + '][note]"></textarea>';
        html +='</div>';
        html +='</div>';
        html +='</div>';
        html +='</div>';

        }

       if (sanctuary == 'jim') {

        html ='<div class="card jimdiv" id="safaris'+safari_row+'">';
        html +='<div class="card-header bg-dark">';
        html +='<h3 class="card-title">Jim Corbett National Park Safari</h3>';
        html +='<div class="card-tools">';
        html +='<a href="javascript:void(0)" class="btn bg-danger btn-sm" onclick="$(\'#safaris' + safari_row + '\').remove();">Remove</a>';
        html +='</div>';
        html +='</div>';
        html +='<div class="card-body">';
        html +='<div class="row">';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="mode' + safari_row + '">Mode of Vehicle</label>';
        html +='<select id="mode' + safari_row + '" class="form-control jim" name="safari[' + safari_row + '][mode]" onchange="javascript: loadJimCorbettSafariTourTimings(' + safari_row + ', this.options[this.selectedIndex].value);" required>';
        html +='<option value="" selected>Select Mode of Vehicle</option>';
        html +='<option value="Jeep">Jeep</option>';
        html +='<option value="Canter">Canter</option>';
        html +='<option value="Elephant">Elephant</option>';
        html +='</select>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="area' + safari_row + '">Safari Area</label>';
        html +='<select name="safari[' + safari_row + '][area]" class="form-control jim" id="area' + safari_row + '" required>';
        html +='<option value="">Select Safari Area</option>';
        html +='<option value="Buffer Zone">Buffer Zone</option>';
        html +='<option value="Bijrani">Bijrani</option>';
        html +='<option value="Jhirna">Jhirna</option>';
        html +='<option value="Dhela">Dhela</option>';
        html +='<option value="Garjia">Garjia</option>';
        html +='<option value="Durga Devi">Durga Devi</option>';
        html +='<option value="Dhikala">Dhikala</option>';
        html +='<option value="Sitabani">Sitabani</option>';
        html +='<option value="Phato">Phato</option>';
        html +='<option value="Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato">Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato</option>';
        html +='<option value="Jhirna Range Phato/Sitabani">Jhirna Range Phato/Sitabani</option>';
        html +='<option value="Jhirna/Dhela/Phato">Jhirna/Dhela/Phato</option>';
        html +='<option value="Sitabani Bhandarpani gate">Sitabani Bhandarpani gate</option>';
        html +='<option value="Jhirna Range Phato/Sitabani Bhandarpani gate">Jhirna Range Phato/Sitabani Bhandarpani gate</option>';
        html +='<option value="Jhirna/Dhela/Garjia">Jhirna/Dhela/Garjia</option>';
        html +='<option value="Jhirna/Dhela/Garjia/Sitabani Bhandarpani">Jhirna/Dhela/Garjia/Sitabani Bhandarpani</option>';
        html +='<option value="Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato">Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato</option>';
        html +='</select>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="total_person' + safari_row + '">No of Person</label>';
        html +='<input type="number" id="total_person' + safari_row + '" class="form-control jim" placeholder="No of Person" name="safari[' + safari_row + '][total_person]" value="1" required>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="nationality' + safari_row + '">Nationality</label>';
        html +='<select name="safari[' + safari_row + '][nationality]" id="nationality' + safari_row + '" class="form-control jim" required>';
        html +='<option value="">Select Nationality</option>';
        html +='<option value="Indian">Indian</option>';
        html +='<option value="Foreigner">Foreigner</option>';
        html +='</select>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="date' + safari_row + '">Safari Date</label>';
        html +='<input type="date" id="date' + safari_row + '" class="form-control jim" placeholder="Safari Date" name="safari[' + safari_row + '][date]" required>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="jim_time' + safari_row + '">Time</label>';
        html +='<select name="safari[' + safari_row + '][time]" id="jim_time' + safari_row + '" class="form-control jim" required>';
        html +='<option value="">Select Time</option>';
        html +='<option value="Morning">Morning</option>';
        html +='<option value="Evening">Evening</option>';
        html +='</select>';
        html +='</div>';
        html +='<div class="form-group col-sm-12">';
        html +='<label for="jeeps' + safari_row + '">No. of Jeeps/Canter</label>';
        html +='<input type="number" id="jeeps' + safari_row + '" class="form-control jim" placeholder="No. of Jeeps/Canter" name="safari[' + safari_row + '][jeeps]" value="1" required>';
        html +='</div>';
        html +='<div class="form-group col-sm-12">';
        html +='<label for="note' + safari_row + '">Safari Note</label>';
        html +='<textarea class="form-control summernote jim" id="note' + safari_row + '" name="safari[' + safari_row + '][note]"></textarea>';
        html +='</div>';
        html +='</div>';
        html +='</div>';
        html +='</div>';
       }
       $('#main-safari-div').append(html);
       initializesummer()
       safari_row++;
    }
    </script>
    <script>
        function loadSafariTimings(safari_row, listindex)
{
    switch (listindex)
    {
    case "Gir Jungle Trail" :
        document.getElementById("time"+safari_row).options[0]=new Option("Select Time","");
                document.getElementById("time"+safari_row).options[1]=new Option("6:00 AM - 9:00 AM", "6:00 AM - 9:00 AM");
                document.getElementById("time"+safari_row).options[2]=new Option("6:30 AM - 9:30 AM", "6:30 AM - 9:30 AM");
                document.getElementById("time"+safari_row).options[3]=new Option("6:45 AM - 9:45 AM", "6:45 AM - 9:45 AM");
                document.getElementById("time"+safari_row).options[4]=new Option("8:30 AM - 11:30 AM", "8:30 AM - 11:30 AM");
                document.getElementById("time"+safari_row).options[5]=new Option("9:00 AM - 12:00 PM", "9:00 AM - 12:00 PM");
                document.getElementById("time"+safari_row).options[6]=new Option("9:30 AM - 12:30 PM", "9:30 AM - 12:30 PM");
                document.getElementById("time"+safari_row).options[7]=new Option("3:00 PM - 6:00 PM", "3:00 PM - 6:00 PM");
                document.getElementById("time"+safari_row).options[8]=new Option("4:00 PM - 7:00 PM", "4:00 PM - 7:00 PM");
                break;

    case "Devalia Safari Park" :
        document.getElementById("time"+safari_row).options[0]=new Option("Select Time","");
        document.getElementById("time"+safari_row).options[1]=new Option("7:00 AM - 7:55 AM", "7:00 AM - 7:55 AM");
        document.getElementById("time"+safari_row).options[2]=new Option("8:00 AM - 8:55 AM", "8:00 AM - 8:55 AM");
        document.getElementById("time"+safari_row).options[3]=new Option("9:00 AM - 9:55 AM", "9:00 AM - 9:55 AM");
        document.getElementById("time"+safari_row).options[4]=new Option("10:00 AM - 10:55 AM", "10:00 AM - 10:55 AM");
        document.getElementById("time"+safari_row).options[5]=new Option("3:00 PM - 3:55 PM", "3:00 PM - 3:55 PM");
        document.getElementById("time"+safari_row).options[6]=new Option("4:00 PM - 4:55 PM", "4:00 PM - 4:55 PM");
        document.getElementById("time"+safari_row).options[7]=new Option("5:00 PM - 5:55 PM", "5:00 PM - 5:55 PM");
        break

    case "Kankai Nature Safari" :
        document.getElementById("time"+safari_row).options[0]=new Option("Select Time","");
        document.getElementById("time"+safari_row).options[1]=new Option("6:00 AM - 11:00 AM", "6:00 AM - 11:00 AM");
        document.getElementById("time"+safari_row).options[2]=new Option("1:00 PM - 5:00 PM", "1:00 PM - 5:00 PM");
        break;

        case "Devalia Bus Safari" :
            document.getElementById("time"+safari_row).options[0]=new Option("Select Time","");
            document.getElementById("time"+safari_row).options[1]=new Option("7:30 AM - 8:00 AM", "7:30 AM - 8:00 AM");
            document.getElementById("time"+safari_row).options[2]=new Option("8:00 AM - 8:30 AM", "8:00 AM - 8:30 AM");
            document.getElementById("time"+safari_row).options[3]=new Option("8:30 AM - 9:00 AM", "8:30 AM - 9:30 AM");
            document.getElementById("time"+safari_row).options[4]=new Option("9:00 AM - 9:30 AM", "9:00 AM - 9:30 AM");
            document.getElementById("time"+safari_row).options[5]=new Option("9:30 AM - 10:00 AM", "9:30 AM - 10:00 AM");
            document.getElementById("time"+safari_row).options[6]=new Option("10:00 AM - 10:30 AM", "10:00 AM - 10:30 AM");
            document.getElementById("time"+safari_row).options[7]=new Option("10:30 AM - 11:00 AM", "10:30 AM - 11:00 AM");
            document.getElementById("time"+safari_row).options[8]=new Option("3:00 PM - 3:30 PM", "3:00 PM - 3:30 PM");
            document.getElementById("time"+safari_row).options[9]=new Option("3:30 PM - 4:00 PM", "3:30 PM - 4:00 PM");
            document.getElementById("time"+safari_row).options[10]=new Option("4:00 PM - 4:30 PM", "4:00 PM - 4:30 PM");
            document.getElementById("time"+safari_row).options[11]=new Option("4:30 PM -5:00 PM", "4:30 PM -5:00 PM");
            break;


    default:

        document.getElementById("time"+safari_row).options[0]=new Option("Select Time","");
        document.getElementById("time"+safari_row).options[1]=new Option("Morning");
        document.getElementById("time"+safari_row).options[2]=new Option("Evening");

    return true;
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
        var iternaries_option_row ={{ count($estimate->iternaries) }};
    function addIternary() {
        if (iternaries_option_row < 50) {
            html = '<tr id="iternaries-option-row' + iternaries_option_row + '">';
            html += '<td><input type="text" name="iternaries[' + iternaries_option_row +
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
@if (in_array('safari', $estimate_type) && count($estimate->safaris) > 0)
    @foreach ($estimate->safaris as $key => $safari)
    <script>
        $(document).ready(function () {          
            var mode = "{{ $safari->mode }}";
            switch (mode)
        {
            case "Jeep" :
                    document.getElementById("jim_time"+{{ $key }}).options[0] = new Option("Select Time", "");
                    document.getElementById("jim_time"+{{ $key }}).options[1] = new Option("Morning", "Morning");
                    document.getElementById("jim_time"+{{ $key }}).options[2] = new Option("Evening", "Evening");
                break;

            case "Canter" :
                    document.getElementById("jim_time"+{{ $key }}).options[0] = new Option("Select Time", "");
                    document.getElementById("jim_time"+{{ $key }}).options[1] = new Option("Morning", "Morning");
                    document.getElementById("jim_time"+{{ $key }}).options[2] = new Option("Evening", "Evening");
            break;


            case "Elephant" :
                document.getElementById("jim_time"+{{ $key }}).options[0]=new Option("Select Time","");
                document.getElementById("jim_time"+{{ $key }}).options[1]=new Option("6AM to 7AM", "6AM to 7AM");
                document.getElementById("jim_time"+{{ $key }}).options[2]=new Option("7AM to 8AM", "7AM to 8AM");
                document.getElementById("jim_time"+{{ $key }}).options[3]=new Option("8AM to 9AM", "8AM to 9AM");
                document.getElementById("jim_time"+{{ $key }}).options[4]=new Option("9AM to 10AM", "9AM to 10AM");
                document.getElementById("jim_time"+{{ $key }}).options[5]=new Option("10AM to 11AM", "10AM to 11AM");
                document.getElementById("jim_time"+{{ $key }}).options[6]=new Option("11AM to 12PM", "11AM to 12PM");
                document.getElementById("jim_time"+{{ $key }}).options[7]=new Option("12PM to 1PM", "12PM to 1PM");
                document.getElementById("jim_time"+{{ $key }}).options[8]=new Option("1PM to 2PM", "1PM to 2PM");
                document.getElementById("jim_time"+{{ $key }}).options[9]=new Option("2PM to 3PM", "2PM to 3PM");
                document.getElementById("jim_time"+{{ $key }}).options[10]=new Option("3PM to 4PM", "3PM to 4PM");
                document.getElementById("jim_time"+{{ $key }}).options[11]=new Option("4PM to 5PM", "4PM to 5PM");
                break;


        default:

                document.getElementById("jim_time"+{{ $key }}).options[0] = new Option("Select Time", "");
                document.getElementById("jim_time"+{{ $key }}).options[1] = new Option("Morning", "Morning");
                document.getElementById("jim_time"+{{ $key }}).options[2] = new Option("Evening", "Evening");

        return true;
        }
        var time = '{{ $safari->time }}';
         $('#jim_time'+{{ $key }}).val(time);
        });
     </script>
    @endforeach
@endif
<script>
    @if (isset($estimate->cab->halts) && count($estimate->cab->halts) > 0)
         var cab_halt_row = {{ count($estimate->cab->halts) }};
     @else
         var cab_halt_row = 1;
     @endif

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
@endpush
