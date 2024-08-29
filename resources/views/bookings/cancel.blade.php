@extends('layouts.master')
@section('title', 'Cancellation Requests')
@section('head')
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
<section class="content">
    <div class="card">
        <div class="card-header">
            <form id="form-filter" class="inline-form" action="{{ route('cancellation.requests') }}">
                <div class="form-row mb-2">
                    <div class="col-sm-3">
                        <label for="filter_name">Name</label>
                        <input type="text" class="form-control" id="filter_name" placeholder="Name" name="filter_name" value="{{ $filter_name }}">
                    </div>
                    <div class="col-sm-3">
                        <label for="filter_mobile">Mobile</label>
                        <input type="text" class="form-control" id="filter_mobile" placeholder="Mobile" name="filter_mobile" value="{{ $filter_mobile }}">
                    </div>
                    <div class="col-sm-3">
                        <label for="">Type</label>
                        <select name="filter_type" class="form-control">
                            <option value="">All</option>
                            <option value="safari" {{ $filter_type == 'safari' ? 'selected' : '' }}>Safari</option>
                            <option value="hotel" {{ $filter_type == 'hotel' ? 'selected' : '' }}>Hotel</option>
                            <option value="cab" {{ $filter_type == 'cab' ? 'selected' : '' }}>Cab</option>
                            <option value="tour" {{ $filter_type == 'tour' ? 'selected' : '' }}>Tour</option>
                            <option value="package" {{ $filter_type == 'package' ? 'selected' : '' }}>Package</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="">Booking Date</label>
                        <input type="date" id="filter_date" name="filter_date" value="{{ $filter_date }}" class="form-control floating-label" placeholder="Select Date">
                    </div>
                </div>
                <div class="form-row mb-2">
                    <div class="col-sm-3">
                        <label for="">Request Generation Date</label>
                        <input type="date" id="filter_created_at" name="filter_created_at" value="{{ $filter_created_at }}" class="form-control floating-label" placeholder="Select Date">
                    </div>
                    <div class="col-sm-3">
                        <label for="">Request Closed Date</label>
                        <input type="date" id="filter_updated_at" name="filter_updated_at" value="{{ $filter_updated_at }}" class="form-control floating-label" placeholder="Select Date">
                    </div>

                    <div class="col-sm-3">
                        <label for="">Status</label>
                        <select name="filter_request_status" class="form-control">
                            <option value="" {{ $filter_request_status == '' ? 'selected' : '' }}>All</option>
                            <option value="0" {{ $filter_request_status == '0' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $filter_request_status == '1' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label for="" class="text-white">Action</label>
                        <div>
                            <button type="submit" class="btn btn-info" form="form-filter"><i class="fa fa-filter"></i></button>
                            <a href="{{ route('cancellation.requests') }}" class="btn btn-secondary ml-1" id="reset-filter"><i class="fa fa-undo"></i></a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <!-- <th>Id</th> -->
                        <th>Customer </th>
                        <th>Mobile </th>
                        <th>Booking Type</th>
                        <th>Request Generated</th>
                        <th>Total Amount</th>
                        <th>Cancellation charges</th>
                        <th>Request Closed</th>
                        <th>Refundable Amount</th>
                        <th>Cancellation Status</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                    @php
                    $booking_type = bookingType($request->booking_id);
                    @endphp
                    <tr>
                        <!-- <td>{{ $request->id }}</td> -->
                        <td>{{ $request->customer->name }}</a></td>
                        <td>{{ $request->customer->mobile }}</a></td>
                        <td>
                            <span class="badge bg-danger">{{ ucfirst($request->booking->type) }}</span><br>
                            @if ($request->booking->source == 'custom')
                            <span class="badge bg-grey">{{ ucfirst($request->booking->source) }}</span><br>
                            @elseif($request->booking->source == 'direct')
                            <span class="badge bg-indigo">{{ ucfirst($request->booking->source) }}</span><br>
                            @else
                            <span class="badge bg-dark">{{ ucfirst($request->booking->source) }}</span><br>
                            @endif
                            <span class="badge bg-grey">{{ \Carbon\Carbon::parse($request->booking->date)->format('d-m-Y') }}</span>
                        </td>
                        <td><small>{{ \Carbon\Carbon::parse($request->created_at)->format('M d, Y h:i A') }}</small></td>
                        <td>₹ {{ $request->booking->items->sum('amount') }}</td>
                        <td>₹ {{  $request->approval_amount ? $request->booking->items->sum('amount') - $request->approval_amount : 0 }}</td>
                        <td><small>{{ \Carbon\Carbon::parse($request->updated_at)->format('M d, Y h:i A') }}</small></td>
                        <td>₹ {{ $request->approval_amount ? $request->approval_amount : 0 }}</td>
                        <td>{{ $request->cancel_status ? $request->cancel_status : 'Full' }}</td>
                        <td>
                            @if($request->status == 1)
                            <span class="badge bg-success">Completed</span>
                            @elseif( $request->approval_status == 0 && $request->approval_amount > 0)
                            <span class="badge bg-info">Added Refund approval  : {{ $request->approval_amount}}</span>
                            @elseif( $request->approval_status == 1)
                            <span class="badge bg-success">Refund accepted : {{ $request->approval_amount}}</span>
                            @elseif( $request->approval_status == 2)
                            <span class="badge bg-danger">Refund rejected : {{ $request->approval_amount}}</span>
                            @elseif( $request->approval_status == 3 )
                            <span class="badge bg-danger">Expired : {{ $request->approval_amount }}</span>
                            @else
                            <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td><button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-list"></i>
                            </button>
                            <ul class="dropdown-menu text-center">
                                <a href="#" onclick="addAmount( '{{$request->approval_amount}}', '{{$request->id}}' )">
                                    <li class="dropdown-item">Add Approval Amount</li>
                                </a>
                                <a href="{{ route('bookings.track-refund', $request->booking_id) }}">
                                    <li class="dropdown-item">Refund Approval History</li>
                                </a>
                                <a href="{{ route('bookings.show', $request->booking_id) }}" target="_blank">
                                    <li class="dropdown-item">Show Booking</li>
                                </a>
                                <a href="{{ route('booking-transactions.index', array_merge(\Request::query(), ['booking_id' => $request->booking_id,'filter_booking_status'=>'cancel'])) }}">
                                    <li class="dropdown-item">Refund Transactions</li>
                                </a>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-cancel" class="cancel-booking" data-id={{ $request->id }} data-cancellation="{{ $request->cancellation_charges }}" data-reason="{{ $request->reason }}" data-amount="{{ $request->refundable_amount }}" style="display:none;">
                                    <li class="dropdown-item">
                                        Cancel Booking
                                    </li>
                                </a>
                            </ul>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
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
                <form method="POST" id="cancelform" action="{{ route('cancelrequest.Booking') }}">
                    @csrf
                    <input type="hidden" name="request_id" value="" id="cancel_booking_id">
                    <div class="form-group">
                        <label for="reason">Booking Cancel Reason</label>
                        <textarea class="form-control" id="reason" name="reason" required value=""></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cancellation_charges">Cancellation Charges</label>
                        <input type="text" name="cancellation_charges" id="cancellation_charges" class="form-control" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="permit_cancellation_charges">Permit Cancellation Charges</label>
                        <input type="text" name="permit_cancellation_charges" id="permit_cancellation_charges" class="form-control" value="0" required>
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

<!----ApprovalModal----->
<div class="modal fade" id="modal-approval">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Refund approval</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="approvalform" action="{{ route('cancelrequest.approval_amount') }}">
                    @csrf
                    <input type="hidden" name="request_id" value="" id="ap_booking_id">

                    <div class="form-group">
                    <label class="form-label">Amount</label>
                        <input type="number" name="amount" id="ap_amount" class="form-control" value="" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Note</label>
                        <textarea name="note" id="ap_note" class="form-control" value="" ></textarea>
                    </div>

                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="approvalform">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@include('layouts.utilities')

<script>
    $(".cancel-booking").click(function() {
        var id = $(this).data('id');
        var reason = $(this).data('reason');
        var cancellation = $(this).data('cancellation');
        $('#cancel_booking_id').val(id);
        $('#reason').val(reason);
        $('#cancellation_charges').val(cancellation);
    });

    function addAmount(amt, id) {
        $('#ap_booking_id').val(id);
        $('#ap_amount').val(amt);
        $('#ap_note').val('NOTE HERE');
        $('#modal-approval').modal('show');
    }
</script>

@endpush