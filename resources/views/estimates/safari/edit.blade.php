@extends('layouts.master')
@section('title', 'Edit Safari Estimate')
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
                    <h1><i class="fab fa-safari"></i> Edit Safari Estimate</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('estimates.index') }}">Estimates</a></li>
                        <li class="breadcrumb-item active">Edit Safari Estimate</li>
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
            <form method="POST" action="{{ route('safari-estimate.update', $estimate->id) }}" id="safariForm">
                @csrf
                @method('PUT')
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
                         $('#tadoba').hide()
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
                         $('#tadoba').hide()
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
                        $('#ranthambore').hide()
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
                        $('#ranthambore').hide();
                        $('#gir').hide();
                        $('#tadoba').hide();
               }
            // }
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

    <script>
        $(document).ready(function (){
         var zone = $('#zone').val();

         switch (zone)
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

             document.getElementById("time").options[0]=new Option("Select Time","");
             document.getElementById("time").options[1]=new Option("Morning");
             document.getElementById("time").options[2]=new Option("Evening");

         return true;
         }

         var time = '{{ $estimate->safari->time }}';
         $('#time').val(time);


     });
     </script>
     <script>
        $(document).ready(function () {
            var mode = $('#jim_mode').val();
            console.log(mode);
            switch (mode)
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
        var time = '{{ $estimate->safari->time }}';
         $('#jim_time').val(time);
        });
     </script>
@endpush
