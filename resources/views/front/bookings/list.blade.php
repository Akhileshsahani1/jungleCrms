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
                    <h1><i class="nav-icon fas fa-check-circle"></i> Bookings</h1>
                </div>
            </div>
        </div>
    </section>

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
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('h:i A') }}</td>
                                    <td style="font-size:14px;">
                                        {{ isset($booking->customer->name) ? $booking->customer->name : '' }}
                                        <br>
                                        {{ isset($booking->customer->mobile) ? $booking->customer->mobile : '' }}
                                        <br>
                                        {{ isset($booking->customer->email) ? $booking->customer->email : '' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ ucfirst($booking->type) }}</span><br>
                                        <span
                                            class="badge bg-grey">{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</span><br>
                                        
                                        @if($booking->Cancel()->exists() )
                                        <span
                                            class="badge bg-orange">
                                          Cancel
                                           </span>
                                        @elseif ($booking->cancellationRequest()->exists())
                                        @if($booking->cancellationRequest->cancel_status)
                                        <span
                                            class="badge bg-orange">
                                          Partial Cancelled
                                         </span>
                                         @else
                                          <span
                                            class="badge bg-orange">
                                          Partial Cancel Request
                                         </span>
                                         @endif
                                        @endif
                                         @if($booking->refundtransactions()->exists())
                                         <span
                                            class="badge bg-danger">
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
                            <td>
                                <button type="button" class="btn btn-dark dropdown-toggle"
                                    data-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-list"></i>
                                </button>
                                <ul class="dropdown-menu text-center">
                                    <a href="{{ route('dashboard.bookings.show', $booking->id) }}" target="_blank">
                                        <li class="dropdown-item">Show</li>
                                    </a>
                                     @if($booking->refundtransactions()->exists())
                                    <a href="{{ route('dashboard.booking.refund', $booking->id) }}" target="_blank">
                                        <li class="dropdown-item">Refund</li>
                                    @endif
                                    </a>
                                    <a href="{{ route("dashboard.bookings.cancel", $booking->id) }}" onclick1="confirmCancel({{ $booking->id }})">
                                        <li class="dropdown-item">Cancel Booking</li>
                                    </a>
                                    <a  href="{{ route('dashboard.supports.create',['booking_id'=>$booking->id]) }}"><li class="dropdown-item">Modify Booking</li></a>

                                   
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

<!-- Modal Refund-->
<div class="modal fade" id="modal-refund">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Booking Refund</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
          <table style="width: 100%;">
            <tr>
                <th>Status</th>
                <td>Processing</td>
            </tr>
            <tr>
                <th>Refunded Amount</th>
                <td>---</td>
            </tr>
          </table>
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
    function confirmCancel(id){
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to proceed to cancel booking!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Proceed!'
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '{{ route("dashboard.bookings.cancel", "id") }}';
                url = url.replace('id', id);
                window.location.href = url;
            }
        })
    };
</script>
@endpush
