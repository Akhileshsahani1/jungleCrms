<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js">
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
    });
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

    function openHotelModal(row_id){
            let old_val=$('#amount'+row_id).val();
            $('#model_amount').val(old_val);
            $('#model_amount').attr('data-row-id',row_id);
            $('#modal-amount').modal('show');
        }

        $('#modal-amount-save').on('click',function(){
          let row_id=$('#model_amount').attr('data-row-id')
          let new_value = $('#model_amount').val();
              $('#amount'+row_id).val(new_value);
              $('#amount-button' + row_id).html(new_value);
              $('#modal-amount').modal('hide');

        });

        function openHotelDestinationModal(destination_id, hotel_id){
            let old_val=$('#destination'+destination_id+'amount'+hotel_id).val();
            $('#model_package_amount').val(old_val);
            $('#model_package_amount').attr('data-destination-id', destination_id);
            $('#model_package_amount').attr('data-hotel-id', hotel_id);
            $('#modal-package-amount').modal('show');
        }

        $('#modal-package-amount-save').on('click',function(){
          let destination_id=$('#model_package_amount').attr('data-destination-id');
          let hotel_id=$('#model_package_amount').attr('data-hotel-id');
          let new_value = $('#model_package_amount').val();
              $('#destination'+destination_id+'amount'+hotel_id).val(new_value);
              $('#destination'+destination_id+'-amount-button' + hotel_id).html(new_value);
              $('#modal-package-amount').modal('hide');

        });

    $(function() {

        
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
        $('#payment_type').select2({
            theme: 'bootstrap4',
            placeholder: "Select Payment Type",
            allowClear: true,
        })


        $('.hotelid').select2({
            theme: 'bootstrap4',
            placeholder: "Select Hotel",
            allowClear: true,
        })



        initializeSelect2()

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

        $('#vehicle_type').change(function(e) {
            e.preventDefault();
            var content = $(this).val();
            $('#content0').val(content);
        });

    });
</script>

@if ($errors->has('name') || $errors->has('email') || $errors->has('phone') || $errors->has('state') || $errors->has('address'))
    <script>
        $('#myModal').modal('show');
    </script>
@endif
<script>
    function getRooms(id, value) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('get.rooms') }}",
            data: {
                'hotel_id': value
            },
            success: function(data) {
                $('#room_id' + id).html(data);
            }
        });
    }

    function getServices(id, value) {
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "{{ route('get.services') }}",
            data: {
                'room_id': value
            },
            success: function(data) {
                $('#service_id' + id).html(data);
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
            url: "{{ route('get.terms') }}",
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

    function initializeSelect2() {
        $('.hotel_id').select2({
            theme: 'bootstrap4',
            placeholder: "Select Hotel",
            allowClear: true,
        })
        $('.hotelid').select2({
            theme: 'bootstrap4',
            placeholder: "Select Hotel",
            allowClear: true,
        })

    }


    function loadTimings(listindex)
    {
        switch (listindex)
        {
        case "Gir Jungle Trail" :
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

        case "Devalia Safari Park" :
            document.getElementById("time").options[0]=new Option("Select Time","");
            document.getElementById("time").options[1]=new Option("7:00 AM - 7:55 AM", "7:00 AM - 7:55 AM");
            document.getElementById("time").options[2]=new Option("8:00 AM - 8:55 AM", "8:00 AM - 8:55 AM");
            document.getElementById("time").options[3]=new Option("9:00 AM - 9:55 AM", "9:00 AM - 9:55 AM");
            document.getElementById("time").options[4]=new Option("10:00 AM - 10:55 AM", "10:00 AM - 10:55 AM");
            document.getElementById("time").options[5]=new Option("3:00 PM - 3:55 PM", "3:00 PM - 3:55 PM");
            document.getElementById("time").options[6]=new Option("4:00 PM - 4:55 PM", "4:00 PM - 4:55 PM");
            document.getElementById("time").options[7]=new Option("5:00 PM - 5:55 PM", "5:00 PM - 5:55 PM");
            break

        case "Kankai Nature Safari" :
            document.getElementById("time").options[0]=new Option("Select Time","");
            document.getElementById("time").options[1]=new Option("6:00 AM - 11:00 AM", "6:00 AM - 11:00 AM");
            document.getElementById("time").options[2]=new Option("1:00 PM - 5:00 PM", "1:00 PM - 5:00 PM");
            break;

            case "Devalia Bus Safari" :
                document.getElementById("time").options[0]=new Option("Select Time","");
                document.getElementById("time").options[1]=new Option("7:30 AM - 8:00 AM", "7:30 AM - 8:00 AM");
                document.getElementById("time").options[2]=new Option("8:00 AM - 8:30 AM", "8:00 AM - 8:30 AM");
                document.getElementById("time").options[3]=new Option("8:30 AM - 9:00 AM", "8:30 AM - 9:00 AM");
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

            document.getElementById("time").options[0]=new Option("Select Time","");
            document.getElementById("time").options[1]=new Option("Morning");
            document.getElementById("time").options[2]=new Option("Evening");

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
</script>




