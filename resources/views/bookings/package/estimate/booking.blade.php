@extends('layouts.master')
@section('title', 'Package Booking')
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
                    <h1><i class="fas fa-globe-asia"></i> Package Booking</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('estimates.index') }}">Estimates</a></li>
                        <li class="breadcrumb-item active">Package Booking</li>
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
            <form method="POST" action="{{ route('package-booking.store') }}" id="tourForm" enctype="multipart/form-data">
                @csrf
                @isset($booking->lead_id)
                <input type="hidden" value="{{ $booking->lead_id }}" name="lead_id">
                @endisset
                <input type="hidden" name="estimate_id" value="{{ $id }}">
                <input type="hidden" name="website" value="{{ $booking->website }}">
                <div class="card-body">
                    <div class="row">
                        @include('customers.select-customer')
                    </div>
                </div>
                <div class="card-body mt-2">
                    <div class="row">
                        @include('bookings.package.estimate.form')
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
        $(document).on('keyup', '.guest', function(){

            var hotel_row = $(this).attr("data-hotel_row");
            var allowed = 4;

            var adults = parseInt($('#adults'+hotel_row).val());

            var children = parseInt($('#childs'+hotel_row).val());

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
            $('#bed'+hotel_row).val(extra_beds);

            $('#room'+hotel_row).val(rooms_no);

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
                var booking_type = $(this).val();
                if (booking_type.includes('safari')) {
                    $('#safari').show();
                    $(".safari").prop('disabled', false);

                }
                if (!booking_type.includes('safari')) {
                    $('#safari').hide();
                    $(".safari").prop('disabled', true);

                }
                if (booking_type.includes('hotel')) {
                    $('#hotel').show();
                    $(".hotel").prop('disabled', false);

                }
                if (!booking_type.includes('hotel')) {
                    $('#hotel').hide();
                    $(".hotel").prop('disabled', true);

                }
                if (booking_type.includes('cab')) {
                    $('#cab').show();
                    $(".cab").prop('disabled', false);

                }
                if (!booking_type.includes('cab')) {
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
            $('#tadoba').hide();
            $(".gir").prop('disabled', false);
            $(".jim").prop('disabled', false);
            $(".ranthambore").prop('disabled', false);
            $(".tadoba").prop('disabled', false);
            var val = $('#sanctuary').val();

            switch (val) {
                case 'gir':
                    $('#jim').hide();
                    $('#ranthambore').hide();
                    $('#tadoba').hide();
                    $('#gir').show();
                    $(".jim").prop('disabled', true);
                    $(".ranthambore").prop('disabled', true);
                    $(".tadoba").prop('disabled', true);
                    $('.ranthamborediv').remove();
                    $('.jimdiv').remove();
                    $('.tadobadiv').remove();
                    break;
                case 'jim':
                    $('#ranthambore').hide();
                    $('#gir').hide();
                    $('#tadoba').hide();
                    $('#jim').show();
                    $(".gir").prop('disabled', true);
                    $(".ranthambore").prop('disabled', true);
                    $(".tadoba").prop('disabled', true);
                    $('.girdiv').remove();
                    $('.ranthamborediv').remove();
                    $('.tadobadiv').remove();
                    break;
                case 'ranthambore':
                    $('#gir').hide();
                    $('#jim').hide();
                    $('#tadoba').hide();
                    $('#ranthambore').show();
                    $(".gir").prop('disabled', true);
                    $(".jim").prop('disabled', true);
                    $(".tadoba").prop('disabled', true);
                    $('.girdiv').remove();
                    $('.jimdiv').remove();
                    $('.tadobadiv').remove();
                    break;

                case 'tadoba':
                    $('#gir').hide();
                    $('#jim').hide();
                    $('#ranthambore').hide();
                    $('#tadoba').show();
                    $(".gir").prop('disabled', true);
                    $(".jim").prop('disabled', true);
                    $(".ranthambore").prop('disabled', true);
                    $('.girdiv').remove();
                    $('.jimdiv').remove();
                    $('.ranthamborediv').remove();
                    break;

                default:
                    $(".gir").prop('disabled', true);
                    $(".jim").prop('disabled', true);
                    $(".ranthambore").prop('disabled', true);
                    $(".tadoba").prop('disabled', true);
                    $('#jim').hide();
                    $('#tadoba').hide();
                    $('#ranthambore').hide();
                    $('#gir').hide();
            }
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
                html += '<select name="customer[' + customer_option_row +'][nationality]" class="form-control" id="nationality' + customer_option_row +'" required  onchange="getStates(' + customer_option_row + ', this.value)">';
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
      @if (isset($booking) && in_array('safari', $booking_type) && count($booking->safaris) > 0)
      @foreach($booking->safaris as $key => $safari)
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
              document.getElementById("time"+safari_row).options[1]=new Option("6:00 AM - 11:00 AM", "6:00 AM - 11:00 AM");
              document.getElementById("time"+safari_row).options[2]=new Option("1:00 PM - 5:00 PM", "1:00 PM - 5:00 PM");
              break;


          default:

              document.getElementById("time"+safari_row).options[0]=new Option("Select Time","");
              document.getElementById("time"+safari_row).options[1]=new Option("Morning");
              document.getElementById("time"+safari_row).options[2]=new Option("Evening");

          return true;
          }
          @if(in_array('safari', $booking_type))
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

        function getHotels(hotel_term_row, value) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('get.hotels') }}",
            data: {
                'destination': value
            },
            success: function(data) {
                $('#hotel'+hotel_term_row).html(data);
                $('#hotel'+hotel_term_row).select2({
                theme: 'bootstrap4',
                placeholder: "Select Hotel",
                allowClear: true,
        })
            }
        });
    }
    </script>
    <script>
        @if (isset($booking)&& in_array('hotel', $booking_type) && count($booking->hotels) > 0)
             var hotel_row = {{ count($booking->hotels) }};
         @else
             var hotel_row = 1;
         @endif
     function addHotel() {
         if (hotel_row < 50) {
             html ='<div class="card" id="hotels' + hotel_row + '">';
             html +='<div class="card-header bg-dark">';
             html +='<h3 class="card-title">Hotel</h3>';
             html +='<div class="card-tools">';
             html +='<a href="javascript:void(0)" class="btn bg-danger btn-sm" onclick="$(\'#hotels' + hotel_row + '\').remove();">Remove</a>';
             html +='</div>';
             html +='</div>';
             html +='<div class="card-body">';
             html +='<div class="row">';
             html +='<div class="form-group col-sm-12">';
             html +='<label for="destination' + hotel_row + '">Destination</label>';
             html +='<select id="destination' + hotel_row + '" class="form-control hotel" placeholder="Destination"  name="hotel[' + hotel_row + '][destination]" onchange="getHotels('+ hotel_row +', this.value)" required>';
             html +='<option value="">Select Destination</option>';
             html +='@foreach ($destinations as $destination)';
             html +='<option value="{{ $destination->destination }}">{{ $destination->destination }}</option>';
             html +='@endforeach';
             html +='</select>';
             html +='</div>';
             html +='<div class="form-group col-sm-3">';
             html +='<label for="adults' + hotel_row + '">No of Adults</label>';
             html +='<input type="number" id="adults' + hotel_row + '" class="form-control adult hotel guest" data-hotel_row="' + hotel_row + '" placeholder="No of Adults" name="hotel[' + hotel_row + '][adults]" value="0" required>';
             html +='</div>';
             html +='<div class="form-group col-sm-3">';
             html +='<label for="childs' + hotel_row + '">No of Children</label>';
             html +='<input type="number" id="childs' + hotel_row + '" class="form-control child hotel guest" data-hotel_row="' + hotel_row + '" placeholder="No of Children" name="hotel[' + hotel_row + '][childs]" value="0" required>';
             html +='</div>';
             html +='<div class="form-group col-sm-3">';
             html +='<label for="room' + hotel_row + '">No of Rooms</label>';
             html +='<input type="number" id="room' + hotel_row + '" class="form-control room hotel" placeholder="No of Rooms" name="hotel[' + hotel_row + '][room]" value="0" required>';
             html +='</div>';
             html +='<div class="form-group col-sm-3">';
             html +='<label for="bed' + hotel_row + '">No of Beds</label>';
             html +='<input type="number" id="bed' + hotel_row + '" class="form-control bed hotel" placeholder="No of Beds" name="hotel[' + hotel_row + '][bed]" value="0">';
             html +='</div>';
             html +='<div class="form-group col-sm-6">';
             html +='<label for="check_in' + hotel_row + '">Check In</label>';
             html +='<input type="date" id="check_in' + hotel_row + '" class="form-control hotel" placeholder="Check In" name="hotel[' + hotel_row + '][check_in]" value="" required>';
             html +='</div>';
             html +='<div class="form-group col-sm-6">';
             html +='<label for="check_out' + hotel_row + '">Check Out</label>';
             html +='<input type="date" id="check_out' + hotel_row + '" class="form-control hotel" placeholder="Check Out" name="hotel[' + hotel_row + '][check_out]" value="" required>';
             html +='</div>';
             html +='<div class="form-group col-sm-4">';
             html +='<label for="hotel' + hotel_row + '">Hotel</label>';
             html +='<select class="form-control hotel hotelid" name="hotel[' + hotel_row + '][hotel]" id="hotel' + hotel_row + '" onchange="getDestinationRooms('+ hotel_row +', this.value)" required>';
             html +='<option></option>';
             html +='@foreach ($hotels as $hotel)';
             html +='<option value="{{ $hotel->id }}">{{ $hotel->name }}</option>';
             html +='@endforeach';
             html +='</select>';
             html +='</div>';
             html +='<div class="form-group col-sm-4">';
             html +='<label for="hotel_room' + hotel_row + '">Room</label>';
             html +='<select class="form-control hotel" name="hotel[' + hotel_row + '][hotel_room]" id="hotel_room' + hotel_row + '" onchange="getDestinationServices('+ hotel_row +', this.value)" required>';
             html +='<option>Select Room</option>';
             html +='</select>';
             html +='</div>';
             html +='<div class="form-group col-sm-4">';
             html +='<label for="service' + hotel_row + '">Service</label>';
             html +='<select class="form-control hotel" name="hotel[' + hotel_row + '][service]" id="service' + hotel_row + '" required>';
             html +='<option>Select Service</option>';
             html +='</select>';
             html +='</div>';
             html +='<div class="form-group col-sm-12">';
             html +='<label for="hotel_due_amount' + hotel_row + '">Hotel Due Amount (₹)</label>';
             html +='<input type="number" id="hotel_due_amount' + hotel_row + '" class="form-control hotel" placeholder="Hotel Due Amount" name="hotel[' + hotel_row + '][hotel_due_amount]" value="0" required>';
             html +='</div>';
             html +='<div class="form-group col-sm-12">';
             html +='<label for="note' + hotel_row + '">Hotel Note</label>';
             html +='<textarea class="form-control hotel summernote" id="note' + hotel_row + '" name="hotel[' + hotel_row + '][hotel_note]"></textarea>';
             html +='</div>';
             html +='</div>';
             html +='</div>';
             html +='</div>';
             $('#main-hotel-div').append(html);
             initializesummer();
         hotel_row++;
         }

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
                document.getElementById("time"+safari_row).options[1]=new Option("6:00 AM - 12:00 PM", "6:00 AM - 12:00 PM");
                document.getElementById("time"+safari_row).options[2]=new Option("1:00 AM - 5:00 PM", "1:00 AM - 5:00 PM");
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
   @if (isset($booking) && in_array('cab', $booking_type) && count($booking->cabs) > 0)
        var trip_row = {{ count($booking->cabs) }};
    @else
        var trip_row = 1;
    @endif
function addTrip() {
    if (trip_row < 50) {
        html = '<div class="card" id="trip' + trip_row + '">';
        html += '<div class="card-header bg-dark">';
        html += '<h3 class="card-title">Trip</h3>';
        html += '<div class="card-tools"><a href="javascript:void(0)" class="btn bg-danger btn-sm" onclick="$(\'#trip' + trip_row + '\').remove();">Remove</a></div>';
        html += '</div>';
        html += '<div class="card-body">';
        html += '<div class="row">';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="trip_type' + trip_row + '">Trip Type</label>';
        html += '<input type="text" id="trip_type' + trip_row + '" class="form-control cab" placeholder="Trip Type" name="trip[' + trip_row + '][trip_type]" required>';
        html += '</div>';
        // html += '<div class="form-group col-sm-4">';
        // html += '<label for="pickup_medium' + trip_row + '">Pickup Medium</label>';
        // html += '<select type="text" class="form-control cab" id="pickup_medium' + trip_row + '" name="trip[' + trip_row + '][pickup_medium]" required>';
        // html += '<option value="">Select Pickup Medium</option>';
        // html += '<option value="Hatchback">Hatchback</option>';
        // html += '<option value="MPV">MPV</option>';
        // html += '<option value="Sedan">Sedan</option>';
        // html += '<option value="Suv">Suv</option>';
        // html += '<option value="Traveller">Traveller</option>';
        // html += '</select>';
        // html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="cab_type' + trip_row + '">Vehicle Type</label>';
        html += '<select type="text" class="form-control cab" id="cab_type' + trip_row + '" name="trip[' + trip_row + '][cab_type]" required>';
        html += '<option value="">Select Vehicle Type</option>';
        html += '<optgroup label="Hatchback">';
        html += '<option value="Maruti Suzuki WagonR">Maruti Suzuki WagonR</option>';
        html += '<option value="Maruti Suzuki Swift">Maruti Suzuki Swift</option>';
        html += '<option value="Maruti Suzuki Celerio">Maruti Suzuki Celerio</option>';
        html += '</optgroup>';
        html += '<optgroup label="MPV">';
        html += '<option value="Maruti Suzuki Eeco">Maruti Suzuki Eeco</option>';
        html += '<option value="Maruti Suzuki Ertiga">Maruti Suzuki Ertiga</option>';
        html += '<option value="Maruti Suzuki XL6">Maruti Suzuki XL6</option>';
        html += '<option value="Toyota Innova Crysta">Toyota Innova Crysta</option>';
        html += '<option value="Innova">Innova</option>';
        html += '</optgroup>';
        html += '<optgroup label="Sedan">';
        html += '<option value="Swift Dezire">Swift Dezire</option>';
        html += '<option value="Toyota Etios">Toyota Etios</option>';
        html += '</optgroup>';
        html += '<optgroup label="SUV">';
        html += '<option value="Tata Safari">Tata Safari</option>';
        html += '<option value="Mahindra Scorpio">Mahindra Scorpio</option>';
        html += '<option value="Hyundai Creta">Hyundai Creta</option>';
        html += '<option value="Jeep">Jeep</option>';
        html += '</optgroup>';
        html += '<optgroup label="Traveller">';
        html += '<option value="Force Traveller">Force Traveller</option>';
        html += '<option value="Mini Bus">Mini Bus</option>';
        html += '<option value="Canter">Canter</option>';
        html += '</optgroup>';
        html += '</select>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="start_date' + trip_row + '">Journey Start Date</label>';
        html += '<input type="date" id="start_date' + trip_row + '" class="form-control cab" placeholder="Journey Start Date" name="trip[' + trip_row + '][start_date]" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="end_date' + trip_row + '">Journey End Date</label>';
        html += '<input type="date" id="end_date' + trip_row + '" class="form-control cab" placeholder="Journey End Date" name="trip[' + trip_row + '][end_date]" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="days' + trip_row + '">No of Days</label>';
        html += '<input type="number" id="days' + trip_row + '" class="form-control cab" placeholder="No of Days" name="trip[' + trip_row + '][days]" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="pick_up' + trip_row + '">Pickup Point</label>';
        html += '<input type="text" id="pick_up' + trip_row + '" class="form-control cab" placeholder="Pickup Point" name="trip[' + trip_row + '][pick_up]" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="drop' + trip_row + '">Drop Point</label>';
        html += '<input type="text" id="drop' + trip_row + '" class="form-control cab" placeholder="Drop Point" name="trip[' + trip_row + '][drop]" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="pickup_time' + trip_row + '">Pickup Time</label>';
        html += '<input type="time" id="pickup_time' + trip_row + '" class="form-control cab" placeholder="Pickup Time" name="trip[' + trip_row + '][pickup_time]" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="total_riders' + trip_row + '">No of Riders</label>';
        html += '<input type="number" id="total_riders' + trip_row + '" class="form-control cab" placeholder="No of Riders" name="trip[' + trip_row + '][total_riders]" value="2" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="vendor_name' + trip_row + '">Vendor Name</label>';
        html += '<input type="text" id="vendor_name' + trip_row + '" class="form-control cab" placeholder="Vendor Name" name="trip[' + trip_row + '][vendor_name]" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="vendor_mobile' + trip_row + '">Vendor Mobile Number</label>';
        html += '<input type="text" id="vendor_mobile' + trip_row + '" class="form-control cab" placeholder="Vendor Mobile Number" name="trip[' + trip_row + '][vendor_mobile]" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-4">';
        html += '<label for="no_of_cab' + trip_row + '">No. of Cab</label>';
        html += '<input type="number" id="no_of_cab' + trip_row + '" class="form-control cab" placeholder="No. of Cab" name="trip[' + trip_row + '][no_of_cab]" value="1" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-8">';
        html += '<label for="cab_due_amount' + trip_row + '">Cab Due Amount (₹)</label>';
        html += '<input type="number" id="cab_due_amount' + trip_row + '" class="form-control cab" placeholder="Cab Due Amount" name="trip[' + trip_row + '][cab_due_amount]" value="0" required>';
        html += '</div>';
        html += '<div class="form-group col-sm-12">';
        html += '<label for="cab_note' + trip_row + '">Cab Note</label>';
        html += '<textarea class="form-control cab summernote" id="cab_note' + trip_row + '" name="trip[' + trip_row + '][cab_note]"></textarea>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        html += '<div class="card card-warning">';
        html += '<div class="card-header">';
        html += '<h3 class="card-title">Cab Halts</h3>';
        html += '</div>';
        html += '<div class="card-body">';
        html += '<table id="halt' + trip_row + '" class="table table-striped">';
        html += '<thead>';
        html += '<tr>';
        html += '<th>Halt</th>';
        html += '<th>Starts from</th>';
        html += '<th>Ends on</th>';
        html += '</tr>';
        html += '</thead>';
        html += '<tbody>';
        html += '</tbody>';
        html += '<tfoot>';
        html += '<td class="text-right" colspan="5">';
        html += '<button type="button" onclick="addCabHalt(' + trip_row + ');" data-toggle="tooltip" title="Add Halt" class="btn btn-secondary" data-original-title="Add Halt"><i class="fas fa-plus-circle"></i></button>';
        html += '</td>';
        html += '</tfoot>';
        html += '</table>';
        html += '</div>';
        html += '</div>';

        $('#main-cab-div').append(html);
        initializesummer();
        trip_row++;
    }
}
</script>
<script>
   @if (isset($booking) && in_array('safari', $booking_type) && count($booking->safaris) > 0)
        var safari_row = {{ count($booking->safaris) }};
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
        html += '<option value="Jeep">Jeep</option>';
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
        html += '<div class="form-group col-sm-4">';
        html += '<label for="jeeps' + safari_row + '">No. of Jeeps/Canter</label>';
        html += '<input type="number" id="jeeps' + safari_row + '" class="form-control gir" placeholder="No. of Jeeps/Canter" name="safari[' + safari_row + '][jeeps]" value="1" required>';
        html += '</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="vendor' + safari_row + '">Choose Vendor</label>';
        html +='<select id="vendor' + safari_row + '" class="form-control gir" name="safari[' + safari_row + '][vendor]" required>';
        html +='@foreach ($vendors as $vendor)';
        html +='@if($vendor->sanctuary == "gir")';
        html +='<option value="{{ $vendor->id }}" @if($vendor->default == "yes") selected @endif>{{ $vendor-> name}} ({{ $vendor-> phone}})</option>';
        html +='@else';
        html +='@continue;';
        html +='@endif';
        html +='@endforeach';
        html +='</select>';
        html +='</div >';
        html +='<div class="form-group col-sm-12">';
        html +='<label for="safari_due_amount' + safari_row + '">Safari Due Amount (₹)</label>';
        html +='<input type="number" id="safari_due_amount' + safari_row + '" class="form-control gir" placeholder="Safari Due Amount" name="safari[' + safari_row + '][safari_due_amount]" value="0" required>';
        html +='</div>';
        html += '<div class="form-group col-sm-12">';
        html += '<label for="note' + safari_row + '">Safari Note</label>';
        html += '<textarea class="form-control gir summernote" id="note' + safari_row + '" name="safari[' + safari_row + '][note]"></textarea>';
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
        html +='<option value="1">Zone 1</option>';
        html +='<option value="2">Zone 2</option>';
        html +='<option value="3">Zone 3</option>';
        html +='<option value="4">Zone 4</option>';
        html +='<option value="5">Zone 5</option>';
        html +='<option value="6">Zone 6</option>';
        html +='<option value="7">Zone 7</option>';
        html +='<option value="8">Zone 8</option>';
        html +='<option value="9">Zone 9</option>';
        html +='<option value="10">Zone 10</option>';
        html +='<option value="Zone Not Confirmed">Zone Not Confirmed</option>';
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
        html +='<div class="form-group col-sm-4">';
        html +='<label for="jeeps' + safari_row + '">No. of Jeeps/Canter</label>';
        html +='<input type="number" id="jeeps' + safari_row + '" class="form-control ranthambore" placeholder="No. of Jeeps/Canter" name="safari[' + safari_row + '][jeeps]" value="1" required>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="vendor' + safari_row + '">Choose Vendor</label>';
        html +='<select id="vendor' + safari_row + '" class="form-control ranthambore" name="safari[' + safari_row + '][vendor]" required>';
        html +='@foreach ($vendors as $vendor)';
        html +='@if($vendor->sanctuary == "ranthambore")';
        html +='<option value="{{ $vendor->id }}" @if($vendor->default == "yes") selected @endif>{{ $vendor-> name}} ({{ $vendor-> phone}})</option>';
        html +='@else';
        html +='@continue;';
        html +='@endif';
        html +='@endforeach';
        html +='</select>';
        html +='</div >';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="safari_due_amount' + safari_row + '">Safari Due Amount (₹)</label>';
        html +='<input type="number" id="safari_due_amount' + safari_row + '" class="form-control ranthambore" placeholder="Safari Due Amount" name="safari[' + safari_row + '][safari_due_amount]" value="0" required>';
        html +='</div>';
        html +='<div class="form-group col-sm-12">';
        html +='<label for="note' + safari_row + '">Safari Note</label>';
        html +='<textarea class="form-control ranthambore summernote" id="note' + safari_row + '" name="safari[' + safari_row + '][note]"></textarea>';
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
        html +='<select id="mode' + safari_row + '" class="form-control jim" name="safari[' + safari_row + '][mode]" onchange="javascript: loadJimCorbettSafariPackageTimings(' + safari_row + ', this.options[this.selectedIndex].value);" required>';
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
        html +='<div class="form-group col-sm-4">';
        html +='<label for="jeeps' + safari_row + '">No. of Jeeps/Canter</label>';
        html +='<input type="number" id="jeeps' + safari_row + '" class="form-control jim" placeholder="No. of Jeeps/Canter" name="safari[' + safari_row + '][jeeps]" value="1" required>';
        html +='</div>';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="vendor' + safari_row + '">Choose Vendor</label>';
        html +='<select id="vendor' + safari_row + '" class="form-control jim" name="safari[' + safari_row + '][vendor]" required>';
        html +='@foreach ($vendors as $vendor)';
        html +='@if($vendor->sanctuary == "jim")';
        html +='<option value="{{ $vendor->id }}" @if($vendor->default == "yes") selected @endif>{{ $vendor-> name}} ({{ $vendor-> phone}})</option>';
        html +='@else';
        html +='@continue;';
        html +='@endif';
        html +='@endforeach';
        html +='</select>';
        html +='</div >';
        html +='<div class="form-group col-sm-4">';
        html +='<label for="safari_due_amount' + safari_row + '">Safari Due Amount (₹)</label>';
        html +='<input type="number" id="safari_due_amount' + safari_row + '" class="form-control jim" placeholder="Safari Due Amount" name="safari[' + safari_row + '][safari_due_amount]" value="0" required>';
        html +='</div>';
        html +='<div class="form-group col-sm-12">';
        html +='<label for="note' + safari_row + '">Safari Note</label>';
        html +='<textarea class="form-control jim summernote" id="note' + safari_row + '" name="safari[' + safari_row + '][note]"></textarea>';
        html +='</div>';
        html +='</div>';
        html +='</div>';
        html +='</div>';
       }
       $('#main-safari-div').append(html);
       initializesummer();
       safari_row++;
   }
   </script>
 @if (in_array('safari', $booking_type) && count($booking->safaris) > 0)
 @foreach ($booking->safaris as $key => $safari)
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
    var cab_inclusion_row = {{ count($inclusions) }};

        function addTourInclusion() {
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

        function addTourExclusion() {
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

        function addTourTerm() {
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
    var cab_halt_row = {{ in_array('cab', $booking_type) ? count($booking->halts) : 1 }};

        function addCabHalt(cab_row) {
            if(cab_halt_row < 50){
                html    = '<tr id="cab-halt-' + cab_row + '-row' + cab_halt_row + '">';
                html   += '<td style="width:550px"><input type="text" name="trip['+ cab_row +'][halts]['+ cab_halt_row +'][halt]" placeholder="Halt Destination" class="form-control" id="halt-destination-'+ cab_row +'-row'+ cab_halt_row +'"></td>';
                html   += '<td><input type="date" name="trip['+ cab_row +'][halts]['+ cab_halt_row +'][start]" placeholder="Start Date" class="form-control amount" id="halt-start-'+ cab_row +'-row'+ cab_halt_row +'"></td>';
                html   += '<td><input type="date" name="trip['+ cab_row +'][halts]['+ cab_halt_row +'][end]" placeholder="End Date" class="form-control discount" id="halt-end-'+ cab_row +'-row'+ cab_halt_row +'"></td>';
                html   += '<td class="text-right"><button type="button" onclick="$(\'#cab-halt-'+ cab_row +'-row'+ cab_halt_row + '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                html   += '</tr>';

                $('#halt'+ cab_row+' tbody').append(html);

                cab_halt_row++;
            }
        }
</script>
@endpush
