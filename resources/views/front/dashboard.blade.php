@extends('front.layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<!-- Main content -->
<section class="content">

    <!-- Stats Card -->
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $estimates_count }}<sup style="font-size: 20px"></sup></h3>

                            <p>Estimates</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <a href="{{ route('dashboard.estimates') }}" class="small-box-footer">
                            View All <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $bookings_count }}</h3>

                            <p>Bookings</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <a href="{{ route('dashboard.bookings') }}" class="small-box-footer">
                            View All <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $bookings_count }}</h3>

                            <p>Invoices</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <a href="{{ route('dashboard.invoices') }}" class="small-box-footer">
                            View All <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small card -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $tickets_count }}</h3>

                            <p>Tickets</p>
                        </div>
                        <div class="icon">
                            <i class="fas fas fa-headset"></i>
                        </div>
                        <a href="{{ route('dashboard.supports.index') }}" class="small-box-footer">
                            View All <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@if(count($rejections) > 0)

<section class="content">
    <div class="card">
        <div class="card-body">
            <h4>Rejected Refund Offers</h4>
            <table id="refund_offers" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Date Time</th>
                        <th>Booking</th>
                        <th>Booking Total</th>
                        <th>Offered Refund</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rejections as $r)
                    @php
                    $booking = $r->booking;
                    $booking_type = bookingType($booking->id);
                    @endphp
                    <tr>

                        <td>{{ \Carbon\Carbon::parse($r->created_at)->format('d-m-Y h:i:a') }}</td>

                        @if ($booking->type == 'cab')
                        <td style="font-size:14px;">
                            <span class="badge bg-danger">{{ ucfirst($booking->type) }}</span><br>
                            <span class="badge bg-grey">{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</span><br>
                            <i class="fas fa-calendar-alt" data-toggle="tooltip" title="Pickup Date"></i>
                            {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}<br>
                            <i class="fa fa-clock"></i>
                            {{ \Carbon\Carbon::parse($booking->cab->pickup_time)->format('h:i A') }}
                        </td>
                        @endif
                        @if ($booking->type == 'hotel')
                        <td style="font-size:14px;">
                            <span class="badge bg-danger">{{ ucfirst($booking->type) }}</span><br>
                            <span class="badge bg-grey">{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</span><br>
                            <i class="fas fa-calendar-alt" data-toggle="tooltip" title="Checkin Date"> </i>
                            {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}
                        </td>
                        @endif
                        @if ($booking->type == 'safari')
                        <td style="font-size:14px;">
                            <span class="badge bg-danger">{{ ucfirst($booking->type) }}</span><br>
                            <span class="badge bg-grey">{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</span><br>
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
                            <span class="badge bg-danger">{{ ucfirst($booking->type) }}</span><br>
                            <span class="badge bg-grey">{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</span><br>
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
                            <span class="badge bg-danger">{{ ucfirst($booking->type) }}</span><br>
                            <span class="badge bg-grey">{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</span><br>
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


                        <td>₹ {{ $r->booking->items->sum('amount') }}</td>
                        <td> &#8377; {{ $r->approval_amount }}</td>
                        <td><span class="badge badge-danger">{{ 'Rejected' }}</span></td>
                        <td>

                        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-list"></i>
                            </button>
                            <ul class="dropdown-menu text-center">
                                <a href="{{ route('dashboard.approval-history', $booking->id) }}" target="_blank">
                                    <li class="dropdown-item">History</li>
                                </a>
                                <a href="{{ route('dashboard.supports.index') }}" target="_blank">
                                    <li class="dropdown-item">Contact Support</li>
                                </a>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="mt-2">
            {{ $rejections->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</section>

@endif



<!-----Refund approve cards-------->

@if( count($approval_requests) > 0)
<!-- Main content -->
<section class="content">

    <!-- Stats Card -->
    <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row">

                @foreach( $approval_requests as $r)
                <div class="col-lg-12 col-12">
                    <!-- small card -->
                    <div class="small-box bg-black">
                        <div class="inner">
                            <center>
                                <h4>Refund approval request recieved<sup style="font-size: 20px"></sup></h4>
                                <div class="text-success font-weight-bold">
                                    <p>Booking date/time : {{ $r->booking->date }} {{ $r->booking->time }}</p>
                                    <p>Booking type: {{ $r->booking->type }}</p>
                                    <p>Amount request for approval :
                                    <h3> &#8377; {{ $r->approval_amount }} </h3>
                                    </p>
                                </div>
                                <p>( Please note this is issued amount you need to accept/reject it. Then the refund will processed. )</p>
                                <p>
                                    <button class="btn btn-success m-2" onclick="confirmreq(1,{{ $r->id }})"> Accept </button>
                                    <button class="btn btn-danger" onclick="confirmreq(2,{{ $r->id }})"> Reject </button>
                                </p>
                            </center>
                        </div>
                        <div class="icon">
                            <i class="fas fa-credit-card" style="color:aqua"></i>
                        </div>
                        <a href="{{ route('dashboard.cancel-bookings') }}" class="small-box-footer">
                            View Booking <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <form method="post" action="{{ route('dashboard.refund-accept') }}" id="formaccept{{ $r->id }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $r->id }}" id="acp_booking_id">
                    <input type="hidden" name="history_id" value="{{ count($r->refund_history)>0 ? $r->refund_history[0]->id : 0 }}" />
                    <input type="hidden" name="approval_status" id="approval_status{{ $r->id }}">
                    <input type="hidden" name="note" id="note{{ $r->id }}" value="" />

                </form>
                @endforeach

            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modal-reason">
    <div class="modal-dialog modal-transaction">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Please add reason</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="r_form">
                    <input type="hidden" name="n_id" id="n_id">
                    <div class="form-group">
                        <label for="reason"> Reason <small class="text-danger"> (Mandatory for Reject ) </small></label>
                        <textarea class="form-control" name="n_note" id="n_note" value=""></textarea>
                    </div>

                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-danger rcp float-right" onClick="confirm()">Reject</button>

            </div>
        </div>
    </div>
</div>


@endif
@endsection

@push('scripts')
@include('layouts.utilities')
<script>
    function confirmreq(status, id) {
        if (status == 2) {
            $('#n_id').val(id);
            $('#modal-reason').modal('show');
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

                $('#approval_status' + id).val(status);
                $('#formaccept' + id).submit();

            }
        })
    };

    function confirm(id) {
        let nval = $('#n_note').val();

        if (nval == '') {
            alert('Please add reason');
            return;
        }

        $('#note'+$('#n_id').val()).val(nval);
        $('#approval_status' + $('#n_id').val()).val(2);
        $('#formaccept' + $('#n_id').val()).submit();

    }
</script>
@endpush