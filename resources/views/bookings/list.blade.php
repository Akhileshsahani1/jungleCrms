@extends('layouts.master')
@section('title', 'Bookings')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="alert alert-danger bg-danger text-white" id="generate-link" role="alert" style="display: none;">
        <strong>No Booking Selected !</strong> Please select Booking(s) to Generate Permit link.
    </div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-check-circle"></i> Bookings</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-warning" type="button" onclick="generatePermitLink();">Generate Permit
                        Link</button>
                    {{-- <div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown"
                            aria-expanded="false">
                            Create Booking
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item text-center" href="{{ route('cab-booking.create') }}">Cab Booking</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="{{ route('hotel-booking.create') }}">Hotel Booking</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="{{ route('safari-booking.create') }}">Safari
                                Booking</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="{{ route('tour-booking.create') }}">Tour Booking</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-center" href="{{ route('package-booking.create') }}">Package Booking</a>
                        </div>
                    </div> --}}
                    <div class="btn-group">
                        <button type="submit" class="btn btn-info" form="form-filter"><i class="fa fa-filter"></i></button>
                        <a href="{{ route('bookings.index') }}" class="btn btn-secondary ml-1" id="reset-filter"><i
                                class="fa fa-undo"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                @include('bookings.filter')
            </div>
            <div class="card-body">
                @if (count($bookings) > 0)
                    <table id="bookings" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                @if ($filter_booking_status != 'cancel')
                                    <th><input type="checkbox" onclick="$('input[name*=\'checkbox\']').trigger('click');">
                                    </th>
                                @endif
                               
                                <th>Id</th>
                                <th>Date Time</th>
                                <th>Customer</th>
                                <th>Mobile</th>
                                <th>Type</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Destination</th>
                                <th>Assigned</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                @php
                                    $booking_type = bookingType($booking->id);
                                @endphp
                                <tr>
                                    @if ($filter_booking_status != 'cancel')
                                        <td><input type="checkbox" name="checkbox" id="{{ $booking->id }}" class="checkbox"
                                                value="{{ $booking->id }}"
                                                @if (count($booking->permits) < 1) disabled @endif></td>
                                    @endif
                                   
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('d-m-Y') }} <br> {{ \Carbon\Carbon::parse($booking->created_at)->format('h:i A') }}</td>
                                    <td style="font-size:14px;">
                                        {{ isset($booking->customer->name) ? $booking->customer->name : '' }}
                                        @if ($booking->type == 'safari')
                                            @isset($booking->safari->vendor)
                                                <br>
                                                <span
                                                    class="badge bg-secondary">{{ \App\Models\Vendor::find($booking->safari->vendor)->name }}</span><br>
                                            @endisset
                                        @endif
                                        @if ($booking->type == 'tour')
                                            @if (in_array('safari', $booking_type))
                                                @isset($booking->safari->vendor)
                                                    <br>
                                                    <span
                                                        class="badge bg-secondary">{{ \App\Models\Vendor::find($booking->safari->vendor)->name }}</span><br>
                                                @endisset
                                            @endif
                                        @endif
                                        @if ($booking->type == 'package')
                                            @if (in_array('safari', $booking_type))
                                                @foreach ($booking->safaris as $safari)
                                                    @isset($safari->vendor)
                                                        <br>
                                                        <span
                                                            class="badge bg-secondary">{{ \App\Models\Vendor::find($safari->vendor)->name }}</span><br>
                                                    @endisset
                                                @endforeach
                                            @endif
                                        @endif
                                    </td>
                                    <td style="font-size:14px;">
                                        {{ isset($booking->customer->mobile) ? $booking->customer->mobile : '' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ ucfirst($booking->type) }}</span><br>
                                        @if ($booking->source == 'custom')
                                            <span class="badge bg-grey">{{ ucfirst($booking->source) }}</span><br>
                                        @elseif($booking->source == 'direct')
                                            <span class="badge bg-indigo">{{ ucfirst($booking->source) }}</span><br>
                                        @else
                                            <span class="badge bg-dark">{{ ucfirst($booking->source) }}</span><br>
                                        @endif
                                        @if ($booking->Cancel)
                                            <span class="badge bg-orange">Cancel</span><br>
                                        @else
                                            <span class="badge bg-orange">Booked</span><br>
                                        @endif
                                        <span
                                            class="badge bg-grey">{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</span><br>
                                    </td>
                                    <td style="font-size:14px;">₹ {{ $booking->items->sum('amount') }}<br>
                                        <!-- @if ($booking->transactions->sum('amount') > 0)
                                            @if ($booking->transactions->sum('amount') >= $booking->items->sum('amount'))
                                            <span class="badge bg-success">Paid</span><br>
@else
    <span class="badge bg-warning">Partial</span><br>
                                            @endif
@else
    <span class="badge bg-indigo">Unpaid</span><br>
                                    @endisset -->
                                    @if ($booking->payment_status == 'paid')
                                        <span class="badge bg-success">Paid</span><br>
                                    @elseif($booking->payment_status == 'unpaid')
                                        <span class="badge bg-indigo">Unpaid</span><br>
                                    @else
                                        <span class="badge bg-warning">Partial</span><br>
                                    @endisset
                            </td>
                            @if ($booking->type == 'cab')
                                <td style="font-size:14px;">
                                    <i class="fas fa-calendar-alt" data-toggle="tooltip" title="Pickup Date"></i>
                                    {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}<br>
                                    <i class="fa fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($booking->cab->pickup_time)->format('h:i A') }}
                                </td>
                            @endif
                            @if ($booking->type == 'hotel')
                                <td style="font-size:14px;">
                                    <i class="fas fa-calendar-alt" data-toggle="tooltip" title="Checkin Date"> </i>
                                    {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}
                                </td>
                            @endif
                            @if ($booking->type == 'safari')
                                <td style="font-size:14px;">
                                    <i class="fas fa-calendar-alt" data-toggle="tooltip" title="Safari Date"> </i>
                                    @isset($booking->safari->date)
                                    {{ \Carbon\Carbon::parse($booking->safari->date)->format('d-m-Y') }} @endisset
                                    <br>
                                    <i class="fa fa-clock" data-toggle="tooltip" title="Safari Date"> </i>
                                    @isset($booking->safari->time) {{ $booking->safari->time }} @endisset
                                </td>
                            @endif
                            @if ($booking->type == 'tour')
                                <td style="font-size:14px;">
                                    @if (in_array('hotel', $booking_type))
                                        <i class="fas fa-hotel" data-toggle="tooltip" title="Checkin Date"></i>
                                        {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}<br>
                                    @endif
                                    @if (in_array('cab', $booking_type))
                                        <i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Date"></i>
                                        {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}
                                        <i class="fa fa-clock" data-toggle="tooltip" title="Pickup Date"></i>
                                        {{ \Carbon\Carbon::parse($booking->cab->pickup_time)->format('h:i A') }}<br>
                                    @endif

                                    @if (in_array('safari', $booking_type))
                                        @foreach ($booking->safaris as $safari)
                                            <i class="fas fa-paw" data-toggle="tooltip" title=""
                                                data-original-title="Safari Date"></i>
                                            {{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }}
                                            <i class="fa fa-clock" data-toggle="tooltip" title="Safari Date"> </i>
                                            @isset($safari->time)
                                                {{ $safari->time }}
                                            @endisset
                                            <br>
                                        @endforeach
                                    @endif
                                </td>
                            @endif
                            @if ($booking->type == 'package')
                                <td>
                                    @if (in_array('hotel', $booking_type))
                                        @foreach ($booking->hotels as $hotel)
                                            <span style="font-size:13px;"><i class="fas fa-hotel"></i>
                                                {{ \Carbon\Carbon::parse($hotel->check_in)->format('d-m-Y') }}</span><br>
                                        @endforeach
                                        </ul>
                                    @endif
                                    @if (in_array('cab', $booking_type))
                                        @foreach ($booking->cabs as $cab)
                                            <span style="font-size:13px;"><i class="fas fa-map-marker-alt"
                                                    data-toggle="tooltip" title=""
                                                    data-original-title="Pick Up"></i>
                                                {{ \Carbon\Carbon::parse($cab->start_date)->format('d-m-Y') }}</span><br>
                                        @endforeach
                                    @endif
                                    @if (in_array('safari', $booking_type))
                                        @foreach ($booking->safaris as $safari)
                                            @if (isset($filter_date))
                                                @if ($safari->date == $filter_date)
                                                    <span style="font-size:13px;"><i class="fas fa-paw"
                                                            data-toggle="tooltip" title=""
                                                            data-original-title="Safari Date"></i>
                                                        {{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }}</span><br>
                                                    <i class="fas fa-time" data-toggle="tooltip"
                                                        title="Safari Date"> </i>{{ $safari->time }} <br>
                                                @endif
                                            @elseif (isset($filter_time))
                                                @if (isset($filter_time))
                                                    @if ($safari->time == ucfirst($filter_time))
                                                        <span style="font-size:13px;"><i class="fas fa-paw"
                                                                data-toggle="tooltip" title=""
                                                                data-original-title="Safari Date"></i>
                                                            {{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }}</span><br>
                                                        <i class="fas fa-time" data-toggle="tooltip"
                                                            title="Safari Date"> </i>{{ $safari->time }} <br>
                                                    @endif
                                                @endif
                                            @else
                                                <span style="font-size:13px;"><i class="fas fa-paw"
                                                        data-toggle="tooltip" title=""
                                                        data-original-title="Safari Date"></i>
                                                    {{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }}</span><br>
                                                <i class="fas fa-time" data-toggle="tooltip" title="Safari Date">
                                                </i>{{ $safari->time }} <br>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            @endif
                            @if ($booking->type == 'cab')
                                <td style="font-size:14px;"><i class="fas fa-taxi" data-toggle="tooltip"
                                        title="Pickup Point"></i>
                                    {{ ucfirst($booking->cab->drop) }}</td>
                            @elseif ($booking->type == 'hotel')
                                <td style="font-size:14px;"><i class="fas fa-hotel" data-toggle="tooltip"
                                        title="Hotel Destination"></i>
                                    {{ ucfirst($booking->hotel->destination) }}</td>
                            @elseif($booking->type == 'safari')
                                <td style="font-size:14px;"><i class="fas fa-paw" data-toggle="tooltip"
                                        title="Sanctuary"></i>
                                    @isset($booking->safari)
                                        {{ $booking->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($booking->safari->sanctuary) }}
                                    @endisset
                                </td>
                            @elseif($booking->type == 'tour')
                                <td style="font-size:14px;">
                                    @if (in_array('hotel', $booking_type))
                                        <i class="fas fa-hotel" data-toggle="tooltip"
                                            title="Hotel Destination"></i> {{ $booking->hotel->destination }}<br>
                                    @endif
                                    @if (in_array('cab', $booking_type))
                                        <i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Point"></i>
                                        {{ $booking->cab->drop }}<br>
                                    @endif
                                    @if (in_array('safari', $booking_type))
                                        @isset($booking->safari) <i class="fas fa-paw"
                                                data-toggle="tooltip" title="Sanctuary"></i>
                                        {{ $booking->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($booking->safari->sanctuary) }}<br>@endisset
                                    @endif
                                </td>
                            @elseif($booking->type == 'package')
                                <td>
                                    @if (in_array('hotel', $booking_type))
                                        @foreach ($booking->hotels as $hotel)
                                            <span style="font-size:13px;"><i class="fas fa-hotel"></i>
                                                {{ $hotel->destination }}</span><br>
                                        @endforeach
                                        </ul>
                                    @endif
                                    @if (in_array('cab', $booking_type))
                                        @foreach ($booking->cabs as $cab)
                                            <span style="font-size:13px;"><i class="fas fa-map-marker-alt"
                                                    data-toggle="tooltip" title=""
                                                    data-original-title="Pick Up"></i> {{ $cab->pick_up }} - <i
                                                    class="fas fa-map-marker-alt" data-toggle="tooltip"
                                                    title="" data-original-title="Drop"></i>
                                                {{ $cab->drop }}</span><br>
                                        @endforeach
                                    @endif
                                    @if (in_array('safari', $booking_type))
                                        @foreach ($booking->safaris as $safari)
                                            <span style="font-size:13px;"><i class="fas fa-paw"
                                                    data-toggle="tooltip" title=""
                                                    data-original-title="Safari Date"></i>
                                                {{ $safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($safari->sanctuary) }}</span><br>
                                        @endforeach
                                    @endif
                                </td>
                            @endif
                            <td style="font-size:14px;">{{ $booking->user->name ?? 'N/A' }}</td>
                            <td>
                                <button type="button" class="btn btn-dark dropdown-toggle"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-list"></i>
                                </button>
                                <ul class="dropdown-menu text-center">
                                    @if ($booking->Cancel)
                                        <a href="{{ route('bookings.show', $booking->id) }}" target="_blank">
                                            <li class="dropdown-item">Show</li>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="confirmDelete({{ $booking->id }})">
                                            <li class="dropdown-item">
                                                Delete
                                            </li>
                                            <form id='delete-form{{ $booking->id }}'
                                                action='{{ route('bookings.destroy', $booking->id) }}'
                                                method='POST'>
                                                <input type='hidden' name='_token'
                                                    value='{{ csrf_token() }}'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                            </form>
                                        </a>
                                        <a
                                            href="{{ route('booking-transactions.index', array_merge(\Request::query(), ['booking_id' => $booking->id])) }}">
                                            <li class="dropdown-item">Refund Transactions</li>
                                        </a>
                                        <a href="javascript:void(0)" onclick="cancellationDetail();"
                                            id="cancellation-details" data-id="{{ $booking->id }}"
                                            data-reason="{{ $booking->Cancel->reason }}"
                                            data-charges="{{ $booking->Cancel->cancellation_charges }}"
                                            data-permitcharges="{{ $booking->Cancel->permit_cancellation_charges }}">
                                            <li class="dropdown-item">
                                                Cancelellation Detail
                                            </li>
                                            <form id='cancel-form{{ $booking->id }}'
                                                action='{{ route('bookings.destroy', $booking->id) }}'
                                                method='POST'>
                                                <input type='hidden' name='_token'
                                                    value='{{ csrf_token() }}'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                            </form>
                                        </a>
                                    @else
                                        <a href="{{ route('bookings.show', $booking->id) }}" target="_blank">
                                            <li class="dropdown-item">Show</li>
                                        </a>
                                        <a href="{{ route('bookings.edit', $booking->id) }}">
                                            <li class="dropdown-item">Edit</li>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="confirmDeleteBooking({{ $booking->id }})">
                                            <li class="dropdown-item">
                                                Delete
                                            </li>
                                            <form id='delete-form{{ $booking->id }}'
                                                action='{{ route('bookings.destroy', $booking->id) }}'
                                                method='POST'>
                                                <input type='hidden' name='_token'
                                                    value='{{ csrf_token() }}'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                            </form>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="confirmCancel({{ $booking->id }})">
                                            <li class="dropdown-item">
                                                Cancel
                                            </li>
                                            <form id='cancel-form{{ $booking->id }}'
                                                action='{{ route('bookings.destroy', $booking->id) }}'
                                                method='POST'>
                                                <input type='hidden' name='_token'
                                                    value='{{ csrf_token() }}'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                            </form>
                                        </a>
                                        <a
                                            href="{{ route('booking-transactions.index', array_merge(\Request::query(), ['booking_id' => $booking->id])) }}">
                                            <li class="dropdown-item">Transactions</li>
                                        </a>
                                    @endif
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-center">No Booking found.</p>
        @endif
    </div>
    <div class="mt-2">
        {{ $bookings->appends(request()->query())->links('pagination::bootstrap-4') }}
    </div>
</div>
</section>
<!-- Modal -->
<div class="modal fade" id="modal-cancel">
<div class="modal-dialog modal-transaction">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Cancel Booking</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form method="POST" id="cancelform" action="{{ route('cancel.Booking') }}">
                @csrf
                <input type="hidden" name="booking_id" value="" id="cancel_booking_id">
                <div class="form-group">
                    <label for="reason">Booking Cancel Reason</label>
                    <textarea class="form-control" id="reason" name="reason" required value=""></textarea>
                </div>
                <div class="form-group">
                    <label for="cancellation_charges">Cancellation Charges</label>
                    <input type="text" name="cancellation_charges" id="cancellation_charges"
                        class="form-control" value="" required>
                </div>
                <div class="form-group">
                    <label for="permit_cancellation_charges">Permit Cancellation Charges</label>
                    <input type="text" name="permit_cancellation_charges" id="permit_cancellation_charges"
                        class="form-control" value="" required>
                </div>
            </form>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" form="cancelform">Save</button>
        </div>
    </div>
</div>
</div>
@endsection
@push('scripts')
@include('layouts.utilities')
<script type="text/javascript">
        function confirmDeleteBooking(no){
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
<script>
    function generatePermitLink() {

        var booking_ids = [];
        $.each($("input[name='checkbox']:checked"), function() {
            booking_ids.push($(this).val());
        });

        if (booking_ids.length === 0) {
            $('#generate-link').css('display', 'block');
        } else {
            swal.fire({
                    title: `Are you sure you want to Generate Permit Link?`,
                    text: "If you choose to generate, it will be generated forever.",
                    icon: "warning",
                    buttons: true,
                    showCancelButton: true,
                    confirmButtonClass: "btn-success",
                    confirmButtonText: "Yes, Generate it!",
                    closeOnConfirm: true
                })
                .then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('generate.permit-link') }}",
                            dataType: 'json',
                            data: {
                                booking_ids: booking_ids,
                                filter_date: "{{ $filter_date }}",
                                "_token": "{{ csrf_token() }}",
                            },
                            type: "POST",
                            success: function(data) {
                                console.log(data)
                                var url = '{{ route('get.permits', ':slug') }}';
                                url = url.replace(':slug', data);

                                location.href = url;

                            }
                        });
                    }

                });
        }



    };
</script>
<script type="text/javascript">
    function confirmCancel(no) {
        $('#cancel_booking_id').val(no);
        $('#reason').val();
        $('#modal-cancel').modal('show');
    };
</script>
<script>
    function cancellationDetail() {
        var id = $("#cancellation-details").data('id')
        var reason = $("#cancellation-details").data('reason')
        var charges = $("#cancellation-details").data('charges')
        var permitcharges = $("#cancellation-details").data('permitcharges')
        $('#cancel_booking_id').val(id);
        $('#reason').val(reason);
        $('#cancellation_charges').val(charges);
        $('#permit_cancellation_charges').val(permitcharges);
        $('#modal-cancel').modal('show');
    };
</script>
@endpush
