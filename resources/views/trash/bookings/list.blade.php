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
                    <div class="btn-group">
                        <button type="submit" class="btn btn-info" form="form-filter"><i class="fa fa-filter"></i></button>
                        <a href="{{ route('trash-bookings.index') }}" class="btn btn-secondary ml-1" id="reset-filter"><i
                                class="fa fa-undo"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                @include('trash.bookings.filter')
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
                                <th>Reason</th>
                                <th>Deleted By</th>
                                <th>Type</th>
                                <th>Total</th>
                                <th>Deleted Date</th>
                                <th>Destination</th>
                                <th>Assigned</th>
                                @if ($filter_booking_status == 'cancel')
                                    <th>Reason</th>
                                @endif
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
                                    <td style="font-size:14px;">
                                        {{ isset($booking->reason) ? $booking->reason : '' }}
                                    </td>
                                    <td style="font-size:14px;">
                                        {{ isset($booking->deleteduser) ? $booking->deleteduser->name : '' }}
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
                                        @if ($filter_booking_status == 'cancel')
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
                            
                            <td style="font-size:14px;">
                                <i class="fas fa-calendar-alt" data-toggle="tooltip" title="Pickup Date"></i>
                                {{ \Carbon\Carbon::parse($booking->deleted_at)->format('d-m-Y') }}<br>
                                <i class="fa fa-clock"></i>
                                {{ \Carbon\Carbon::parse($booking->deleted_at)->format('h:i A') }}
                            </td>
                           
                           
                           
                           
                            
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
                            @if ($filter_booking_status == 'cancel')
                                <td>{{ $booking->cancel->reason }}</td>
                            @endif
                            <td>
                                <button type="button" class="btn btn-dark dropdown-toggle"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-list"></i>
                                </button>
                                <ul class="dropdown-menu text-center">
                                  
                                        <a href="{{ route('trash-booking.show', $booking->id) }}" target="_blank">
                                            <li class="dropdown-item">Show</li>
                                        </a>
                                        <a href="{{ route('trash-booking.restore', $booking->id) }}" >
                                            <li class="dropdown-item">Restore</li>
                                        </a>
                                        <a href="javascript:void(0)"
                                            onclick="confirmDelete({{ $booking->id }})">
                                            <li class="dropdown-item">
                                                Delete
                                            </li>
                                            <form id='delete-form{{ $booking->id }}'
                                                action='{{ route('trash-booking.delete', $booking->id) }}'
                                                method='POST'>
                                                <input type='hidden' name='_token'
                                                    value='{{ csrf_token() }}'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                            </form>
                                        </a>
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
@endsection
@push('scripts')
@include('layouts.utilities')
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
