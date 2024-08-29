<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js">
</script>
<script type="text/javascript">
    var route = "{{ url('search/customers') }}";
    $('#autocomplete').typeahead({
        display: 'value',
        minLength: 3,
        source: function (query, process) {
            return $.get(route, {
                query: query
            }, function (data) {
                return process(data);
            });
        },

        updater: function(item) {
            $('#customer_id').val(item.id);
            $('#customer_name').text(item.name);
            $('#customer_email').text(item.email);
            $('#customer_mobile').text(item.mobile);
            $('#customer_state').text(item.state);
            $('#customer_address').text(item.address);
            $('#customer-detail').slideDown();
            $('#customer-choose').css('display', 'none');
        return item;
    }
    });
</script>
<script>
    function initializesummer(){
        $('.summernote').summernote({
            height: 150,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true                  // set focus to editable area after initializing summernote
        });
    };
    $(function() {
        $('.summernote').summernote({
            height: 150,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: true                  // set focus to editable area after initializing summernote
        })

        // $('#customer_id').select2({
        //     theme: 'bootstrap4',
        //     placeholder: "Select Customer",
        //     allowClear: true,
        // })

        $('#payment_mode').select2({
            theme: 'bootstrap4',
            placeholder: "Select Payment Mode",
            allowClear: true,
        })

        $('#hotel_id').select2({
            theme: 'bootstrap4',
            placeholder: "Select Hotel",
            allowClear: true,
        })

        $('.select_hotel').select2({
            theme: 'bootstrap4',
            placeholder: "Select Hotel",
            allowClear: true,
        })

        setTimeout(function() {
            $('.alert').slideUp();
        }, 4000);

        // $('#customer_id').change(function(e) {
        //     e.preventDefault();
        //     var customer_id = $(this).val();
        //     if (customer_id) {
        //         var url = '{{ route('customers.show', ':id') }}';
        //         url = url.replace(':id', customer_id);
        //         $('#customer-detail').slideUp();
        //         $.ajax({
        //             type: "get",
        //             url: url,
        //             dataType: "json",
        //             success: function(response) {
        //                 $('#customer_name').text(response.name);
        //                 $('#customer_email').text(response.email);
        //                 $('#customer_mobile').text(response.mobile);
        //                 $('#customer_state').text(response.state);
        //                 $('#customer_address').text(response.address);
        //                 $('#customer-detail').slideDown();
        //                 $('#customer-choose').css('display', 'none');
        //             }
        //         });
        //     } else {
        //         $('#customer-detail').css('display', 'none');
        //         $('#customer-choose').css('display', 'block');
        //     }
        // });
    });

    function getRooms(value) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('get.rooms') }}",
            data: {
                'hotel_id': value
            },
            success: function(data) {
                $('#hotel_room').html(data);
            }
        });
    }

    function getServices(value) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('get.services') }}",
            data: {
                'room_id': value
            },
            success: function(data) {
                $('#service').html(data);
            }
        });
    }

    function getDestinationRooms(hotel_row_id, value) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('get.rooms') }}",
            data: {
                'hotel_id': value
            },
            success: function(data) {
                $('#hotel_room' + hotel_row_id).html(data);
            }
        });
    }

    function getDestinationServices(hotel_row_id, value) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('get.services') }}",
            data: {
                'room_id': value
            },
            success: function(data) {
                $('#service' + hotel_row_id).html(data);
            }
        });
    }

    function loadTimings(listindex) {
        switch (listindex) {
            case "Gir Jungle Trail":
                document.getElementById("time").options[0] = new Option("Select Time", "");
                document.getElementById("time").options[1] = new Option("6:00 AM - 9:00 AM", "6:00 AM - 9:00 AM");
                document.getElementById("time").options[2] = new Option("6:30 AM - 9:30 AM", "6:30 AM - 9:30 AM");
                document.getElementById("time").options[3] = new Option("6:45 AM - 9:45 AM", "6:45 AM - 9:45 AM");
                document.getElementById("time").options[4] = new Option("8:30 AM - 11:30 AM", "8:30 AM - 11:30 AM");
                document.getElementById("time").options[5]= new Option("9:00 AM - 12:00 PM", "9:00 AM - 12:00 PM");
                document.getElementById("time").options[6]= new Option("9:30 AM - 12:30 PM", "9:30 AM - 12:30 PM");
                document.getElementById("time").options[7] = new Option("3:00 PM - 6:00 PM", "3:00 PM - 6:00 PM");
                document.getElementById("time").options[8] = new Option("4:00 PM - 7:00 PM", "4:00 PM - 7:00 PM");
                break;

            case "Devalia Safari Park":
                document.getElementById("time").options[0] = new Option("Select Time", "");
                document.getElementById("time").options[1] = new Option("7:00 AM - 7:55 AM", "7:00 AM - 7:55 AM");
                document.getElementById("time").options[2] = new Option("8:00 AM - 8:55 AM", "8:00 AM - 8:55 AM");
                document.getElementById("time").options[3] = new Option("9:00 AM - 9:55 AM", "9:00 AM - 9:55 AM");
                document.getElementById("time").options[4] = new Option("10:00 AM - 10:55 AM", "10:00 AM - 10:55 AM");
                document.getElementById("time").options[5] = new Option("3:00 PM - 3:55 PM", "3:00 PM - 3:55 PM");
                document.getElementById("time").options[6] = new Option("4:00 PM - 4:55 PM", "4:00 PM - 4:55 PM");
                document.getElementById("time").options[7] = new Option("5:00 PM - 5:55 PM", "5:00 PM - 5:55 PM");
                break

            case "Kankai Nature Safari":
                document.getElementById("time").options[0] = new Option("Select Time", "");
                document.getElementById("time").options[1] = new Option("6:00 AM - 11:00 AM", "6:00 AM - 11:00 AM");
                document.getElementById("time").options[2] = new Option("1:00 PM - 5:00 PM", "1:00 PM - 5:00 PM");
                break;

            case "Devalia Bus Safari" :
                document.getElementById("time").options[0]=new Option("Select Time","");
                document.getElementById("time").options[1]=new Option("7:30 AM - 8:00 AM", "7:30 AM - 8:00 AM");
                document.getElementById("time").options[2]=new Option("8:00 AM - 8:30 AM", "8:00 AM - 8:30 AM");
                document.getElementById("time").options[3]=new Option("8:30 AM - 9:00 AM", "8:30 AM - 9:30 AM");
                document.getElementById("time").options[4]=new Option("9:00 AM - 9:30 AM", "9:00 AM - 9:30 AM");
                document.getElementById("time").options[5]=new Option("9:30 AM - 10:00 AM", "9:30 AM - 10:00 AM");
                document.getElementById("time").options[6]=new Option("10:00 AM - 10:30 AM", "10:00 AM - 10:30 AM");
                document.getElementById("time").options[7]=new Option("10:30 AM - 11:00 AM", "10:30 AM - 11:00 AM");
                document.getElementById("time").options[8]=new Option("3:00 PM - 3:30 PM", "3:00 PM - 3:30 PM");
                document.getElementById("time").options[9]=new Option("3:30 PM - 4:00 PM", "3:30 PM - 4:00 PM");
                document.getElementById("time").options[10]=new Option("4:00 PM - 4:30 PM", "4:00 PM - 4:30 PM");
                document.getElementById("time").options[11]=new Option("4:30 PM -5:00 PM", "4:30 PM -5:00 PM");
                break;


            default:

                document.getElementById("time").options[0] = new Option("Select Time", "");
                document.getElementById("time").options[1] = new Option("Morning");
                document.getElementById("time").options[2] = new Option("Evening");

                return true;
        }
    }

    function loadJimCorbettTimings(listindex)
    {
        $('#jim_time').empty();
        switch (listindex)
        {
            case "Jeep" :
                    document.getElementById("jim_time").options[0] = new Option("Select Time", "");
                    document.getElementById("jim_time").options[1] = new Option("Morning", "Morning");
                    document.getElementById("jim_time").options[2] = new Option("Evening", "Evening");
                break;

            case "Canter" :
                    document.getElementById("jim_time").options[0] = new Option("Select Time", "");
                    document.getElementById("jim_time").options[1] = new Option("Morning", "Morning");
                    document.getElementById("jim_time").options[2] = new Option("Evening", "Evening");
            break;


            case "Elephant" :
                document.getElementById("jim_time").options[0]=new Option("Select Time","");
                document.getElementById("jim_time").options[1]=new Option("6AM to 7AM", "6AM to 7AM");
                document.getElementById("jim_time").options[2]=new Option("7AM to 8AM", "7AM to 8AM");
                document.getElementById("jim_time").options[3]=new Option("8AM to 9AM", "8AM to 9AM");
                document.getElementById("jim_time").options[4]=new Option("9AM to 10AM", "9AM to 10AM");
                document.getElementById("jim_time").options[5]=new Option("10AM to 11AM", "10AM to 11AM");
                document.getElementById("jim_time").options[6]=new Option("11AM to 12PM", "11AM to 12PM");
                document.getElementById("jim_time").options[7]=new Option("12PM to 1PM", "12PM to 1PM");
                document.getElementById("jim_time").options[8]=new Option("1PM to 2PM", "1PM to 2PM");
                document.getElementById("jim_time").options[9]=new Option("2PM to 3PM", "2PM to 3PM");
                document.getElementById("jim_time").options[10]=new Option("3PM to 4PM", "3PM to 4PM");
                document.getElementById("jim_time").options[11]=new Option("4PM to 5PM", "4PM to 5PM");
                break;


        default:

                document.getElementById("jim_time").options[0] = new Option("Select Time", "");
                document.getElementById("jim_time").options[1] = new Option("Morning", "Morning");
                document.getElementById("jim_time").options[2] = new Option("Evening", "Evening");

        return true;
        }
    }
</script>



@if ($errors->has('name') || $errors->has('email') || $errors->has('phone') || $errors->has('state') || $errors->has('address'))
    <script>
        $('#myModal').modal('show');
    </script>
@endif
<script>
    @if (isset($booking) && count($booking->items) > 0)
        var item_option_row = {{ count($booking->items) }};
    @else
        var item_option_row = 1;
    @endif

    @if (isset($booking) && count($booking->items) > 0)
        var cab_item_option_row = {{ count($booking->items) }};
    @else
        var cab_item_option_row = 1;
    @endif

    function addItem() {
        if (item_option_row < 50) {
            html = '<tr id="item-option-row' + item_option_row + '">';
            html += '<td style="width:350px"><input type="text" name="item[' + item_option_row +
                '][particular]" placeholder="Particular" class="form-control" id="content' + item_option_row +
                '" required></td>';
            html += '<td><input type="number" name="item[' + item_option_row +
                '][amount]" placeholder="Amount" class="form-control amount" id="amount' + item_option_row +
                '" value="0" required></td>';
            html += '<td><input type="number" name="item[' + item_option_row +
                '][rate]" placeholder="Rate" class="form-control rate" id="rate' + item_option_row +
                '" value="0" required></td>';
            html += '<td class="text-right"><button type="button" onclick="$(\'#item-option-row' + item_option_row +
                '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#option tbody').append(html);

            item_option_row++;
        }
    }

    function cabaddItem() {
        if (cab_item_option_row < 50) {
            html = '<tr id="cab_item-option-row' + cab_item_option_row + '">';
            html += '<td style="width:140px"><input type="date" name="cab_item[' + cab_item_option_row +
                '][pickup_date]" placeholder="Pick Up Date" class="form-control" id="content' + cab_item_option_row +
                '" required></td>';
            html += '<td><input type="text" name="cab_item[' + cab_item_option_row +
                '][pickup_point]" placeholder="Pickup Point" class="form-control amount" id="pickup_point' + cab_item_option_row +
                '" required></td>';
            html += '<td><input type="text" name="cab_item[' + cab_item_option_row +
                '][drop_point]" placeholder="Drop Point" class="form-control rate" id="drop_point' + item_option_row +
                '" required></td>';
            html += '<td><input type="time" name="cab_item[' + cab_item_option_row +
                '][pickup_time]" placeholder="Pickup Time" class="form-control rate" id="pickup_time' + item_option_row +
                '" required></td>';
            html += '<td><input type="text" name="cab_item[' + cab_item_option_row +
                '][vendor_name]" placeholder="Vendor Name" class="form-control rate" id="vendor_name' + item_option_row +
                '" required></td>';
           
            html += '<td><input type="number" name="cab_item[' + cab_item_option_row +
                '][vendor_mobile]" placeholder="Vendor Mobile" class="form-control rate" id="vendor_mobile' + cab_item_option_row +
                '" required></td>';  
            html += '<td><input type="number" name="cab_item[' + cab_item_option_row +
                '][no_of_cab]" placeholder="No of Cab" class="form-control rate" id="no_of_cab' + cab_item_option_row +
                '" required></td>';  
            html += '<td><input type="number" name="cab_item[' + cab_item_option_row +
                '][riders]" placeholder="Riders" class="form-control rate" id="riders' + cab_item_option_row +
                '" required></td>';
            html += '<td><input type="number" name="cab_item[' + cab_item_option_row +
                '][extra_amount]" placeholder="Amount" class="form-control rate" id="extra_amount' + cab_item_option_row +
                '" required></td>';
            html += '<td><input type="number" name="cab_item[' + cab_item_option_row +
                '][cab_due_amount]" placeholder="Cab Due Amount" class="form-control rate" id="cab_due_amount' + cab_item_option_row +
                '" required></td>';
            html += '<td class="text-right"><button type="button" onclick="$(\'#cab_item-option-row' + cab_item_option_row +
                '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#cab-option tbody').append(html);

            cab_item_option_row++;
        }
    }
</script>

<script>
    function getStates(row, value) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('countries') }}",
            data: {
                'nationality': value
            },
            success: function(data) {
                $('#state'+row).html(data);
            }
        });
    }
</script>
<script>
function loadJimCorbettSafariTourTimings(safari_row, listindex)
{
    $('#jim_time'+safari_row).empty();
    switch (listindex)
    {
        case "Jeep" :
                document.getElementById("jim_time"+safari_row).options[0] = new Option("Select Time", "");
                document.getElementById("jim_time"+safari_row).options[1] = new Option("Morning", "Morning");
                document.getElementById("jim_time"+safari_row).options[2] = new Option("Evening", "Evening");
            break;

        case "Canter" :
                document.getElementById("jim_time"+safari_row).options[0] = new Option("Select Time", "");
                document.getElementById("jim_time"+safari_row).options[1] = new Option("Morning", "Morning");
                document.getElementById("jim_time"+safari_row).options[2] = new Option("Evening", "Evening");
        break;


        case "Elephant" :
            document.getElementById("jim_time"+safari_row).options[0]=new Option("Select Time","");
            document.getElementById("jim_time"+safari_row).options[1]=new Option("6AM to 7AM", "6AM to 7AM");
            document.getElementById("jim_time"+safari_row).options[2]=new Option("7AM to 8AM", "7AM to 8AM");
            document.getElementById("jim_time"+safari_row).options[3]=new Option("8AM to 9AM", "8AM to 9AM");
            document.getElementById("jim_time"+safari_row).options[4]=new Option("9AM to 10AM", "9AM to 10AM");
            document.getElementById("jim_time"+safari_row).options[5]=new Option("10AM to 11AM", "10AM to 11AM");
            document.getElementById("jim_time"+safari_row).options[6]=new Option("11AM to 12PM", "11AM to 12PM");
            document.getElementById("jim_time"+safari_row).options[7]=new Option("12PM to 1PM", "12PM to 1PM");
            document.getElementById("jim_time"+safari_row).options[8]=new Option("1PM to 2PM", "1PM to 2PM");
            document.getElementById("jim_time"+safari_row).options[9]=new Option("2PM to 3PM", "2PM to 3PM");
            document.getElementById("jim_time"+safari_row).options[10]=new Option("3PM to 4PM", "3PM to 4PM");
            document.getElementById("jim_time"+safari_row).options[11]=new Option("4PM to 5PM", "4PM to 5PM");
            break;


    default:

            document.getElementById("jim_time"+safari_row).options[0] = new Option("Select Time", "");
            document.getElementById("jim_time"+safari_row).options[1] = new Option("Morning", "Morning");
            document.getElementById("jim_time"+safari_row).options[2] = new Option("Evening", "Evening");

    return true;
    }
}

function loadJimCorbettSafariPackageTimings(safari_row, listindex)
    {
        $('#jim_time'+safari_row).empty();
        switch (listindex)
        {
            case "Jeep" :
                    document.getElementById("jim_time"+safari_row).options[0] = new Option("Select Time", "");
                    document.getElementById("jim_time"+safari_row).options[1] = new Option("Morning", "Morning");
                    document.getElementById("jim_time"+safari_row).options[2] = new Option("Evening", "Evening");
                break;

            case "Canter" :
                    document.getElementById("jim_time"+safari_row).options[0] = new Option("Select Time", "");
                    document.getElementById("jim_time"+safari_row).options[1] = new Option("Morning", "Morning");
                    document.getElementById("jim_time"+safari_row).options[2] = new Option("Evening", "Evening");
            break;


            case "Elephant" :
                document.getElementById("jim_time"+safari_row).options[0]=new Option("Select Time","");
                document.getElementById("jim_time"+safari_row).options[1]=new Option("6AM to 7AM", "6AM to 7AM");
                document.getElementById("jim_time"+safari_row).options[2]=new Option("7AM to 8AM", "7AM to 8AM");
                document.getElementById("jim_time"+safari_row).options[3]=new Option("8AM to 9AM", "8AM to 9AM");
                document.getElementById("jim_time"+safari_row).options[4]=new Option("9AM to 10AM", "9AM to 10AM");
                document.getElementById("jim_time"+safari_row).options[5]=new Option("10AM to 11AM", "10AM to 11AM");
                document.getElementById("jim_time"+safari_row).options[6]=new Option("11AM to 12PM", "11AM to 12PM");
                document.getElementById("jim_time"+safari_row).options[7]=new Option("12PM to 1PM", "12PM to 1PM");
                document.getElementById("jim_time"+safari_row).options[8]=new Option("1PM to 2PM", "1PM to 2PM");
                document.getElementById("jim_time"+safari_row).options[9]=new Option("2PM to 3PM", "2PM to 3PM");
                document.getElementById("jim_time"+safari_row).options[10]=new Option("3PM to 4PM", "3PM to 4PM");
                document.getElementById("jim_time"+safari_row).options[11]=new Option("4PM to 5PM", "4PM to 5PM");
                break;


        default:

                document.getElementById("jim_time"+safari_row).options[0] = new Option("Select Time", "");
                document.getElementById("jim_time"+safari_row).options[1] = new Option("Morning", "Morning");
                document.getElementById("jim_time"+safari_row).options[2] = new Option("Evening", "Evening");

        return true;
        }
    }

    function changeInclusion(val) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('get.inclusions') }}",
            data: {
                'type': 'hotel',
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

    }

    function changeExclusion(val) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('get.exclusions') }}",
            data: {
                'type': 'hotel',
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

    }

    function changeTerm(val) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{ route('get.voucher.terms') }}",
            data: {
                'type': 'hotel',
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
                    html += '<td class="text-right"><button type="button" onclick="$(\'#term-row' +
                        index +
                        '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                    html += '</tr>';
                });
                $('#term tbody').html(html);
            }
        });

    }
</script>

