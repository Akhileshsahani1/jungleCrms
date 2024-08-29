@extends('layouts.master')
@section('title', 'Leads')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection
@section('content')
    <div class="alert alert-danger bg-danger text-white" id="assign-message" role="alert" style="display: none;">
        <strong>No Leads Selected !</strong> Please select lead(s) to assign.
    </div>
    <div class="alert alert-danger bg-danger text-white" id="delete-message" role="alert" style="display: none;">
        <strong>No Leads Selected !</strong> Please select lead(s) to delete.
    </div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1>Leads</h1>
                </div>
                <div class="col-sm-8">
                    <div class="form-group">
                        <div class="input-group">
                        <div class="input-group-append" style="margin-right: 5px;">
                                <a href="{{asset('dist/lead_template.xlsx')}}" class="btn btn-secondary py-2" id="leadTemplate">Template <i class="fas fa-download"> </i></a>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="import_lead_button">Import</button>
                            </div>
                            <div class="input-group-prepend">
                                <button class="btn btn-danger" id="delete_button">Delete Selected</button>
                            </div>
                            <select id="userlist" class="form-control">
                                <option value="">Assign lead</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="assign_button">Assign</button>
                            </div>
                            <div class="btn-group ml-2" role="group" aria-label="Basic example">
                                <button type="submit" form="filterForm" class="btn btn-info" id="button-filter"><i
                                        class="fa fa-filter"></i></button>
                                <button type="submit" form="filterassignedForm" class="btn btn-warning" title="Un Assigned"
                                    id="button-filter-unassigned">N/A</button>
                                <a href="{{ route('leads.index') }}" class="btn btn-secondary" id="reset-filter"><i
                                        class="fa fa-undo"></i></a>
                                <a href="{{ route('leads.create') }}" class="btn btn-success ml-2">Create</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <form action="{{ route('leads.index') }}" id="filterForm">
                    <div class="form-row mb-2">
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="inputEmail4">Customer</label>
                            <input type="text" class="form-control form-control-sm" id="inputEmail4" placeholder="Customer Name"
                                name="filter_name" @if (null !== @$filter_name) value="{{ $filter_name }}" @endif
                                id="input-name">
                        </div>
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="inputEmail4">Mobile</label>
                            <input type="text" class="form-control form-control-sm" id="inputEmail4" placeholder="Mobile"
                                name="filter_mobile" @if (null !== @$filter_mobile) value="{{ $filter_mobile }}" @endif
                                id="input-mobile">
                        </div>
                        @if (Auth::user()->hasRole('administrator'))
                            <div class="col-sm-3 col-3">
                                <label class="col-form-label" for="inputEmail4">Email Id</label>
                                <input type="email" class="form-control form-control-sm" id="inputEmail4" placeholder="Email Id"
                                    name="filter_email"
                                    @if (null !== @$filter_email) value="{{ $filter_email }}" @endif id="input-email">
                            </div>
                        @endif
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="inputState">Status</label>
                            <select id="toggle-class" class="form-control form-control-sm" name="filter_status">
                                <option value="">Select Status</option>
                                @foreach ($statuses as $status)
                                    <option @if ($filter_status == $status->id) selected @endif value="{{ $status->id }}">
                                        {{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if (Auth::user()->hasRole('administrator|agent|team-lead'))
                            <div class="col-sm-3 col-3">
                                <label class="col-form-label" for="inputEmail4">Website</label>
                                <select class="form-control form-control-sm" name="filter_website">
                                    <option value="">Select website</option>
                                    <option @if (@$filter_website == 'ranthamboretigerreserve.in') selected @endif
                                        value="ranthamboretigerreserve.in">ranthamboretigerreserve.in</option>
                                    <option @if (@$filter_website == 'jimcorbettnationalparkonline.in') selected @endif
                                        value="jimcorbettnationalparkonline.in">jimcorbettnationalparkonline.in</option>
                                    <option @if (@$filter_website == 'girsafaribooking.com') selected @endif value="girsafaribooking.com">
                                        girsafaribooking.com</option>
                                    <option @if (@$filter_website == 'jimcorbett.in') selected @endif value="jimcorbett.in">
                                        jimcorbett.in</option>
                                    <option @if (@$filter_website == 'girlionsafari.com') selected @endif value="girlionsafari.com">
                                        girlionsafari.com</option>
                                    <option @if (@$filter_website == 'girlion.in') selected @endif value="girlion.in">
                                        girlion.in</option>
                                    <option @if (@$filter_website == 'bandhavgarh.com') selected @endif value="bandhavgarh.com">
                                        bandhavgarh.com</option>
                                    <option @if (@$filter_website == 'travelwalacab.com') selected @endif value="travelwalacab.com">
                                        travelwalacab.com</option>
                                    <option @if (@$filter_website == 'dailytourandtravel.com') selected @endif
                                        value="dailytourandtravel.com">dailytourandtravel.com</option>
                                        <option @if (@$filter_website == 'rajasthan.dailytourandtravel.com') selected @endif
                                            value="rajasthan.dailytourandtravel.com">rajasthan.dailytourandtravel.com</option>
                                               <option @if (@$filter_website == 'himachal.dailytourandtravel.com') selected @endif
                                            value="himachal.dailytourandtravel.com">himachal.dailytourandtravel.com</option>
                                            <option @if (@$filter_website == 'internationaltrips.in') selected @endif
                                            value="internationaltrips.in">internationaltrips.in</option>
                                             <option @if (@$filter_website == 'tadobapark.com') selected @endif
                                            value="tadobapark.com">tadobapark.com</option>
                                            <option @if (@$filter_website == 'SMO') selected @endif
                                            value="SMO">SMO</option>
                                </select>
                            </div>
                        @endif                       
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="filter_date_from">Date from</label>
                            <input type="date" id="filter_date_from" name="filter_date_from"
                                @if (null !== @$filter_date_from) value="{{ $filter_date_from }}" @endif
                                class="form-control form-control-sm floating-label" placeholder="Select Date">
                        </div>
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="filter_date_to">Date to</label>
                            <input type="date" id="filter_date_to" name="filter_date_to"
                                @if (null !== @$filter_date_to) value="{{ $filter_date_to }}" @endif width="276"
                                class="datepickers form-control form-control-sm" placeholder="Select Date">
                        </div>
                        @if (Auth::user()->hasRole('administrator|agent|team-lead'))                            
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="filter_date_assigned">Date Assigned</label>
                            <input type="date" id="filter_date_assigned" name="filter_date_assigned"
                                @if (null !== @$filter_date_assigned) value="{{ $filter_date_assigned }}" @endif
                                class="form-control form-control-sm floating-label" placeholder="Select Date">
                        </div>
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="inputEmail4">User</label>                               
                            <select class="form-control form-control-sm" name="filter_user" id="filter_user">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                    @if ($user->is_active == 1)
                                        <option @if (@$filter_user == $user->id) selected @endif
                                            value="{{ $user->id }}">
                                            {{ $user->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    @endif
                    </div>
                </form>

                <form action="{{ route('leads.index') }}" id="filterassignedForm">
                    <div class="col" style="display:none;">
                        <label for="filter_date_assigned">Un Assigned</label>
                        <input type="text" id="filter_user_assigned" value="2" name="filter_user_assigned"
                            @if (null !== @$filter_user_assigned) value="{{ $filter_user_assigned }}" @endif
                            class="form-control floating-label" placeholder="Select Date">
                    </div>
                </form>
            </div>
            <div class="card-body">
                <table id="leadDataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            @can('assign-leads')
                                <td><input type="checkbox" name="checkbox" id="checkAll" class="checkbox" value="">
                                </td>
                            @endcan
                            <th>Id</th>
                            <th>Name</th>
                            <th>Assigned By</th>
                            <th>Mobile</th>
                            <th>Website</th>
                            <th>Lead Status</th>
                            <th>Assign To</th>
                            <th>Time(ago)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr>
                                @can('assign-leads')
                                    <td><input type="checkbox" name="checkbox" id="{{ $lead->id }}" class="checkbox"
                                            value="{{ $lead->id }}"></td>
                                @endcan
                                <td>{{ $lead->id }}</td>
                                @if($lead->assigned_by && $lead->view == 0)
                                <td style=" background-color:#ff000047; {{ $lead->counter ? 'background-color:#cfeb34 !important' : '' }}">
                                    {{ $lead->name }}<br>
                                    @if ($lead->source == 'crm')
                                        <span class="badge bg-dark">Created</span>
                                    @endif
                                </td>
                                @else
                                <td style=" {{ $lead->assigned_to === 2 ? 'background-color:#9EF395;' : '' }} {{ $lead->counter ? 'background-color:#cfeb34 !important' : '' }}">
                                    {{ $lead->name }}<br>
                                    @if ($lead->source == 'crm')
                                        <span class="badge bg-dark">Created</span>
                                    @endif
                                </td>
                                @endif
                                
                               @isset($lead->assigned_by)
                               <td>{{ $lead->assigned_by == Auth::user()->id ? "Self" : \App\Models\User::find($lead->assigned_by)->name}}</td>
                               @else
                               <td>N/A</td>
                               @endisset
                                <td>{{ $lead->mobile }}</td>
                                <td><span class="badge bg-danger">{{ $lead->website }}</span><br/><span class="badge bg-danger">{{ $lead->destination }}</span></td>
                                <td>{{ $lead->lead_status == 0 ? 'Generated' : \App\Models\LeadStatus::find($lead->lead_status)->name }}
                                    @isset($lead->estimate)
                                        <br>
                                        <span class="badge bg-purple">
                                            <a href="{{ route('estimates.show', $lead->estimate->id) }}">
                                                Estimate
                                            </a>
                                        </span>
                                        <span class="badge bg-grey">{{ ucfirst($lead->estimate->payment_status) }}</span>
                                    @endisset
                                    @isset($lead->booking)
                                        <br>
                                        <span class="badge bg-success">
                                            <a href="{{ route('bookings.show', $lead->booking->id) }}">
                                                Booking
                                            </a>
                                        </span>
                                        @if ($lead->booking->transactions->sum('amount') > 0)
                                            @if ($lead->booking->transactions->sum('amount') >= $lead->booking->items->sum('amount'))
                                                <span class="badge bg-grey">Paid</span><br>
                                            @else
                                                <span class="badge bg-grey">Partial</span><br>
                                            @endif
                                        @else
                                            <span class="badge bg-grey">Unpaid</span><br>
                                        @endif
                                    @endisset
                                </td>
                                <td>{{ $lead->assigned_to == 2 ? 'Developer' : $lead->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($lead->updated_at)->diffForHumans() }}</td>
                                <td>
                                    <div class="btn-group">
                                        @hasanyrole('administrator|team-lead')
                                            <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-info"> <i
                                                    class="fas fa-pen"></i></a>
                                            <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-warning"> <i
                                                    class="fas fa-eye"></i> </a>
                                            <a href="{{ route('lead-history', $lead->mobile) }}" class="btn btn-info">
                                                History </a>
                                            <button type="button" onclick="confirmDeleteLead({{ $lead->id }})"
                                                class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                            <form id='delete-form{{ $lead->id }}'
                                                action='{{ route('leads.destroy', $lead->id) }}' method='POST'>
                                                <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                            </form>
                                        @else
                                            @if ($lead->source == 'website')
                                                @php
                                                    
                                                    $current = strtotime(date('Y-m-d'));
                                                    $date = strtotime($lead->date);
                                                    
                                                    $datediff = $date - $current;
                                                    $difference = floor($datediff / (60 * 60 * 24));
                                                    
                                                    $dbtimestamp = strtotime($lead->created_at);
                                                    if ($difference == 0) {
                                                        if (time() - $dbtimestamp > 10 * 60) {
                                                            $disabled = false;
                                                        } else {
                                                            $disabled = true;
                                                        }
                                                    } else {
                                                        $disabled = false;
                                                    }
                                                @endphp

                                                <a href="{{ route('leads.show', $lead->id) }}"
                                                    class="btn btn-info  @if ($disabled) disabled @endif">
                                                    <i class="fas fa-eye"></i> </a>
                                            @else
                                                <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-info"> <i
                                                        class="fas fa-eye"></i> </a>
                                            @endif
                                        @endhasanyrole
                                    </div>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="mt-2">
                {{ $leads->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>

    @include('leads.assign-modal')
@endsection
@push('scripts')
    @include('layouts.utilities')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#filter_user').select2({
                theme: 'bootstrap4',
                placeholder: "Select",
                width: 'auto',
			    dropdownAutoWidth: true,
                allowClear: true,
            })
        });

        // $("#assign_button").on('click', function() {

        //     var user_id = $("#userlist").val();

        //     var arr = [];
        //     $.each($("input[name='checkbox']:checked"), function() {
        //         arr.push($(this).val());
        //     });

        //     if (arr.length === 0) {
        //         $('#assign-message').css('display', 'block');
        //     } else {
        //         swal.fire({
        //                 title: `Are you sure you want to assign selected leads?`,
        //                 text: "If you choose to assign, it will be assigned forever.",
        //                 icon: "warning",
        //                 buttons: true,
        //                 showCancelButton: true,
        //                 confirmButtonClass: "btn-success",
        //                 confirmButtonText: "Yes, assign it!",
        //                 closeOnConfirm: true
        //             })
        //             .then((result) => {

        //                 if (result.isConfirmed) {
        //                     $.ajax({
        //                         url: "{{ route('assign-leads') }}",
        //                         dataType: 'json',
        //                         data: {
        //                             user_id: user_id,
        //                             arr: arr,
        //                             "_token": "{{ csrf_token() }}",
        //                         },
        //                         type: "POST",
        //                         success: function(data) {

        //                             location.reload();

        //                         }
        //                     });
        //                 }

        //             });
        //     }



        // });
        $("#assign_button").on('click', function() {

        var user_id = $("#userlist").val();

        var assign_estimate = 'no';

        var assign_booking = 'no';

        var arr = [];
        $.each($("input[name='checkbox']:checked"), function() {
            arr.push($(this).val());
        });

if (arr.length === 0) {
    $('#assign-message').css('display', 'block');
} else {
    swal.fire({
            title: `Are you sure you want to assign selected leads?`,
            text: "If you choose to assign, it will be assigned forever.",
            icon: "warning",
            buttons: true,
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Yes, assign it!",
            closeOnConfirm: true,
            html: `
            <p>What do you want to assign along with lead ?</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="checkbox1">
                <label class="form-check-label" for="checkbox1">
                    Estimates
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="checkbox2">
                <label class="form-check-label" for="checkbox2">
                    Bookings
                </label>
            </div>
    `,
    focusConfirm: false,
    preConfirm: () => {
        if(document.getElementById('checkbox1').checked){
            assign_estimate = 'yes';
        }else{
            assign_estimate = 'no';
        }

        if(document.getElementById('checkbox2').checked){
            assign_booking = 'yes';
        }else{
            assign_booking = 'no';
        }
        
    }
        })
        .then((result) => {

            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('assign-leads') }}",
                    dataType: 'json',
                    data: {
                        user_id: user_id,
                        arr: arr,
                        "_token": "{{ csrf_token() }}",
                        "assign_booking" : assign_booking,
                        "assign_estimate" : assign_estimate,
                    },
                    type: "POST",
                    success: function(data) {

                        location.reload();

                    }
                });
            }

        });
}



});
    </script>
    <script>
       
        $("#import_lead_button").on('click', function() {

                
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            });
            swal.fire({
                title: `Please Upload a File?`,
                input: 'file',
                inputAttributes: {
                    name:"upload",
                    id:"fileToUpload",
                    class:"form form-control"
                },
                showCloseButton: true,
                showCancelButton: true
                ,
                focusConfirm: false,
                onBeforeOpen: () => {
                    $(".swal2-file").change(function () {
                        var reader = new FileReader();
                        reader.readAsDataURL(this.files[0]);
                    });
                }
            }).then((result) => {

                    var formData = new FormData();
                    var file = $('.swal2-file')[0].files[0];
                    formData.append('fileToUpload', file);
                     $.ajax({
                        type:"POST",
                        url:"{{ route('leads.import') }}",
                        enctype: 'multipart/form-data',
                        data: formData,
                        processData: false,
                        contentType: false,
                        async:false,
                        success:function(resp){
                            // console.log(resp.status)
                           let res =  JSON.parse(resp);
                            swal.fire({
                                title: "Success!", 
                                text: res.message, 
                                type: "success",
                                icon:"success"
                            }).then((result) => {
                            // Reload the Page
                            location.reload();
                            });
                        }
                    });

                });




        });
    </script>
    <script>
        $("#delete_button").on('click', function() {


            var arr = [];
            $.each($("input[name='checkbox']:checked"), function() {
                arr.push($(this).val());
            });

            if (arr.length === 0) {
                $('#delete-message').css('display', 'block');
            } else {
                swal.fire({
                        title: `Reason!`,
                        text: "Reason for Delete:",
                        input: 'text',
                        showCancelButton: true   
                    })
                    .then((result) => {
                        if (result.value) {
                            $.ajax({
                                url: "{{ route('delete-leads') }}",
                                dataType: 'json',
                                data: {
                                    arr: arr,
                                    reason:result.value,
                                    "_token": "{{ csrf_token() }}",
                                },
                                type: "POST",
                                success: function(data) {

                                    location.reload();

                                }
                            });
                        }
                    });
            }

        });
    </script>
    <script>
        function filterGlobal(inp) {

            $.ajax({
                url: "{{ route('search-leads') }}",
                dataType: 'json',
                data: {
                    inp: inp,
                    "_token": "{{ csrf_token() }}",
                },
                type: "POST",
                success: function(res) {

                    var htm = '';

                    if (res.data != 404) {
                        $('#leadDataTable tbody tr').remove();
                        for (var i = 0; i < res.data.length; i++) {

                            var d = res.data[i];
                            (i % 2 == 0) ? cls = 'even': cls = 'odd';

                            htm = '<tr class="' + cls + '">';
                            htm +=
                                '<td class="dtr-control" tabindex="0"><input type="checkbox" name="checkbox" id=' +
                                d.id + ' class="checkbox" value="' + d.id + '"></td>';
                            htm += '   <td>' + d.id + '</td>';
                            htm += '   <td>' + d.name + '<br>';
                            htm += '        <span class="badge bg-dark">Created</span>';
                            htm += '    </td>';
                            htm += '   <td>' + d.mobile + '</td>';
                            htm += '   <td><span class="badge bg-danger">' + d.website + '</span></td>';
                            htm += '    <td>' + d.leadstatus_name + '</td>';
                            htm += '    <td>' + d.assign_name + '</td>';
                            htm += '    <td>' + d.lead_time_now + '</td>';
                            htm += '    <td>';
                            htm += '        <div class="btn-group">';
                            htm += '           <a href="/leads/' + d.id +
                                '/edit" class="btn btn-info"> <i class="fas fa-pen"></i> </a>';
                            htm += '           <a href="/leads/' + d.id +
                                '" class="btn btn-warning"> <i class="fas fa-eye"></i> </a>';
                            htm +=
                                '           <button type="button" onclick="confirmDelete(35)" class="btn btn-danger"><i class="fas fa-trash"></i> </button>';
                            htm += '            <form id="delete-form35" action="/leads/' + d.id +
                                '" method="POST">';
                            htm +=
                                '                <input type="hidden" name="_token" value="{{ csrf_token() }}">';
                            htm += '                <input type="hidden" name="_method" value="DELETE">';
                            htm += '            </form>';
                            htm += '        </div>';
                            htm += '    </td>';
                            htm += '    </tr>';

                            $('#leadDataTable tbody').append(htm);

                        }

                    }

                }

            });


        }

        $(function() {

            $('#checkAll').click(function() {
                if ($(this).prop('checked')) {
                    $('.checkbox').prop('checked', true);
                } else {
                    $('.checkbox').prop('checked', false);
                }
            });

        });

        $(document).ready(function($) {

            $('input[type="search"]').on('input', function() {
                filterGlobal($(this).val());
                if ($(this).val() == '') {
                    location.reload();
                }
            });


        });
    </script>
    <script type="text/javascript">
        function confirmDeleteLead(no){
           Swal.fire({
                title: "Reason!",
                text: "Reason for Delete:",
                input: 'text',
                showCancelButton: true        
            }).then((result) => {
                if (result.value) {
                    let html ='<input type="hidden" value="'+result.value+'" name="reason"/>';
                    $('#delete-form'+no).append(html);
                    document.getElementById('delete-form'+no).submit();
                }
            });
        };
    </script>
@endpush
