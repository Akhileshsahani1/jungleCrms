@extends('front.layouts.app')
@section('title', 'Bookings')
@section('head')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-12">
                <h1><i class="nav-icon fas fa-times"></i> Cancelled Bookings</h1>
            </div>
        </div>
    </div>
</section>
<marquee class="">Please click on action and approve the refund amount if processed.</marquee>
<section class="content">
    <div class="card">
        <div class="card-body">
            @if (count($bookings) > 0)
            <table id="bookings" class="table table-bordered table-striped">
                <thead>
                    <tr>

                        <th>Id</th>
                        <th>Date Time</th>
                        <th>Customer</th>
                        <th>Type</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Destination</th>
                        <th>Cancellation Status</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                    @php
                    $booking_type = bookingType($booking->id);
                    @endphp
                    <tr>
                        <td>{{ $booking->id }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('d-m-Y') }} <br>
                            {{ \Carbon\Carbon::parse($booking->created_at)->format('h:i A') }}
                        </td>
                        <td style="font-size:14px;">
                            {{ isset($booking->customer->name) ? $booking->customer->name : '' }}
                            <br>
                            {{ isset($booking->customer->mobile) ? $booking->customer->mobile : '' }}
                            <br>
                            {{ isset($booking->customer->email) ? $booking->customer->email : '' }}
                        </td>
                        <td>
                            <span class="badge bg-danger">{{ ucfirst($booking->type) }}</span><br>
                            <span class="badge bg-grey">{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</span><br>

                            @if($booking->Cancel()->exists() )
                            <span class="badge bg-orange">
                                Cancel
                            </span>
                            @elseif ($booking->cancellationRequest()->exists())
                                @if($booking->refundtransactions()->exists())
                                <span class="badge bg-orange">
                                    Cancel Complete
                                </span>
                                @else
                                 <span class="badge bg-orange">
                                    Cancel Request
                                </span>
                                @endif
                            @endif
                            @if($booking->refundtransactions()->exists())
                            <span class="badge bg-danger">
                                Refund
                            </span>
                            @endif

                        </td>
                        <td style="font-size:14px;">₹ {{ $booking->items->sum('amount') }}<br>
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
                            <i class="fas fa-paw" data-toggle="tooltip" title="" data-original-title="Safari Date"></i>
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
                            <span style="font-size:13px;"><i class="fas fa-map-marker-alt" data-toggle="tooltip" title="" data-original-title="Pick Up"></i>
                                {{ \Carbon\Carbon::parse($cab->start_date)->format('d-m-Y') }}</span><br>
                            @endforeach
                            @endif
                            @if (in_array('safari', $booking_type))
                            @foreach ($booking->safaris as $safari)
                            @if (isset($filter_date))
                            @if ($safari->date == $filter_date)
                            <span style="font-size:13px;"><i class="fas fa-paw" data-toggle="tooltip" title="" data-original-title="Safari Date"></i>
                                {{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }}</span><br>
                            <i class="fas fa-time" data-toggle="tooltip" title="Safari Date"> </i>{{ $safari->time }} <br>
                            @endif
                            @elseif (isset($filter_time))
                            @if (isset($filter_time))
                            @if ($safari->time == ucfirst($filter_time))
                            <span style="font-size:13px;"><i class="fas fa-paw" data-toggle="tooltip" title="" data-original-title="Safari Date"></i>
                                {{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }}</span><br>
                            <i class="fas fa-time" data-toggle="tooltip" title="Safari Date"> </i>{{ $safari->time }} <br>
                            @endif
                            @endif
                            @else
                            <span style="font-size:13px;"><i class="fas fa-paw" data-toggle="tooltip" title="" data-original-title="Safari Date"></i>
                                {{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }}</span><br>
                            <i class="fas fa-time" data-toggle="tooltip" title="Safari Date">
                            </i>{{ $safari->time }} <br>
                            @endif
                            @endforeach
                            @endif
                        </td>
                        @endif
                        @if ($booking->type == 'cab')
                        <td style="font-size:14px;"><i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Point"></i>
                            {{ ucfirst($booking->cab->drop) }}
                        </td>
                        @elseif ($booking->type == 'hotel')
                        <td style="font-size:14px;"><i class="fas fa-hotel" data-toggle="tooltip" title="Hotel Destination"></i>
                            {{ ucfirst($booking->hotel->destination) }}
                        </td>
                        @elseif($booking->type == 'safari')
                        <td style="font-size:14px;"><i class="fas fa-paw" data-toggle="tooltip" title="Sanctuary"></i>
                            @isset($booking->safari)
                            {{ $booking->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($booking->safari->sanctuary) }}
                            @endisset
                        </td>
                        @elseif($booking->type == 'tour')
                        <td style="font-size:14px;">
                            @if (in_array('hotel', $booking_type))
                            <i class="fas fa-hotel" data-toggle="tooltip" title="Hotel Destination"></i> {{ $booking->hotel->destination }}<br>
                            @endif
                            @if (in_array('cab', $booking_type))
                            <i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Point"></i>
                            {{ $booking->cab->drop }}<br>
                            @endif
                            @if (in_array('safari', $booking_type))
                            @isset($booking->safari) <i class="fas fa-paw" data-toggle="tooltip" title="Sanctuary"></i>
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
                            <span style="font-size:13px;"><i class="fas fa-map-marker-alt" data-toggle="tooltip" title="" data-original-title="Pick Up"></i> {{ $cab->pick_up }} - <i class="fas fa-map-marker-alt" data-toggle="tooltip" title="" data-original-title="Drop"></i>
                                {{ $cab->drop }}</span><br>
                            @endforeach
                            @endif
                            @if (in_array('safari', $booking_type))
                            @foreach ($booking->safaris as $safari)
                            <span style="font-size:13px;"><i class="fas fa-paw" data-toggle="tooltip" title="" data-original-title="Safari Date"></i>
                                {{ $safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($safari->sanctuary) }}</span><br>
                            @endforeach
                            @endif
                        </td>
                        @endif
                          <td>{{ $booking->cancellationRequest->cancel_status ? $booking->cancellationRequest->cancel_status : 'Full' }}</td>
                        <td>
                             @if($booking->cancellationRequest->status == 1)
                            <span class="badge bg-success">Completed</span>
                            @elseif( $booking->cancellationRequest->approval_status == 0 && $booking->cancellationRequest->approval_amount > 0)
                            <span class="badge bg-info">Added Refund approval  : {{ $booking->cancellationRequest->approval_amount}}</span>
                            @elseif( $booking->cancellationRequest->approval_status == 1)
                            <span class="badge bg-success">Refund accepted : {{ $booking->cancellationRequest->approval_amount}}</span>
                            @elseif( $booking->cancellationRequest->approval_status == 2)
                            <span class="badge bg-danger">Refund rejected : {{ $booking->cancellationRequest->approval_amount}}</span>
                            @elseif( $booking->cancellationRequest->approval_status == 3 )
                            <span class="badge bg-danger">Expired : {{ $booking->cancellationRequest->approval_amount }}</span>
                            @else
                            <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-list"></i>
                            </button>
                            <ul class="dropdown-menu text-center">
                                <a href="{{ route('dashboard.bookings.show', $booking->id) }}" target="_blank">
                                    <li class="dropdown-item">Show</li>
                                </a>

                                @if($booking->refundtransactions()->exists())
                                <a href="{{ route('dashboard.booking.refund', $booking->id) }}" target="_blank">
                                    <li class="dropdown-item">Refund</li>
                                    @else
                                    <a onclick="refundApprove({{ $booking->cancellationRequest }},{{ $booking->refund_history }},{{ $booking->items->sum('amount') }})">
                                        <li class="dropdown-item">Approve refund</li>
                                    </a>
                                    @endif
                                </a>

                                <a href="{{ route('dashboard.approval-history', $booking->id) }}" target="_blank">
                                    <li class="dropdown-item">Refund Approval History</li>
                                </a>
                                <!-- <a href="{{ route("dashboard.bookings.cancel", $booking->id) }}" onclick1="confirmCancel({{ $booking->id }})">
                                        <li class="dropdown-item">Cancel Booking</li>
                                    </a> -->


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
                <div class="r_form">
                    <form method="post" action="{{ route('dashboard.refund-accept') }}" id="acceptRefundForm">
                        @csrf
                        <input type="hidden" name="id" value="" id="cancel_booking_id">
                        <input type="hidden" name="history_id" id="history_id" value="">
                        <input type="hidden" name="approval_status" id="approval_status">

                        <div class="form-group">
                            <label for="cancellation_charges">Refundable Amount</label>
                            <input type="text" id="refundable_amount" class="form-control" readonly value="">
                        </div>

                        <div class="form-group cdiv">
                            <label for="cancellation_charges">Cancellation Charges</label>
                            <input type="text" id="cancellation_charges" class="form-control" value="" readonly>
                        </div>

                        <div class="form-group">
                            <label for="reason"> Reason <small class="text-danger">  (Mandatory for Reject ) </small></label>
                            <textarea class="form-control" name="note" id="note" value=""></textarea>
                        </div>

                </div>
                <div class="r_msg">
                    <h4>Please wait untill the request processed.</h4>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary acp" onClick="confirm(1)">Accept</button>
                <button type="button" class="btn btn-danger rcp" onClick="confirm(2)">Reject</button>

            </div>
        </div>
    </div>
</div>

<!-- Modal Refund-->

@endsection
@push('scripts')
@include('layouts.utilities')
<script type="text/javascript">
    function confirm(status) {
        if( status == 2 && $('#note').val() == ''){
            alert('Please enter Reason');
            return;
        }
        Swal.fire({
            title: 'Are you sure?',
            text: (status == 1) ? "You accepting this refund amount" : "You rejecting this refund amount",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: (status == 1) ? 'Yes, Accept Refund!' : 'Yes, Reject Refund!',
        }).then((result) => {
            if (result.isConfirmed) {
                $('#approval_status').val(status);
                $('#acceptRefundForm').submit();

            }
        })
    };

    function refundApprove(booking,history_id,total) {

        console.log(total);
        let hid = history_id.length > 0 ? history_id[0]['id'] : 0;
        
        if (booking.approval_amount == null) {

            $('.r_form').hide();
            $('.acp').hide();
            $('.rcp').hide();
            $('.r_msg').show();

            $('#modal-cancel').modal('show');

        } else {

            if (booking.approval_status == 1) {

                $('.acp').hide();
                $('.rcp').hide();
                $('.cbtns').remove();
                $('#modal-cancel .modal-footer').append('<button type="submit" class="btn btn-success cbtns">Accepted</button>');

            }
            if (booking.approval_status == 2) {

                $('.acp').hide();
                $('.rcp').hide();
                $('.cbtns').remove();
                $('#modal-cancel .modal-footer').append('<button type="submit" class="btn btn-danger cbtns">Rejected</button>');

            }

            $('#cancel_booking_id').val(booking.id);
            $('#reason').val(booking.reason);

           
                $('#cancellation_charges').val(total-booking.approval_amount);
          

            $('#refundable_amount').val(booking.approval_amount);
            $('#history_id').val(hid);

            $('.r_form').show();
            if (booking.approval_status == 0) {
                $('.acp').show();
                $('.rcp').show();
            }
            $('.r_msg').hide();

            $('#modal-cancel').modal('show');

        }

    }
</script>
@endpush