@extends('layouts.master')
@section('title', 'Bookings')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-check-circle"></i> Bookings</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-info" form="form-filter"><i class="fa fa-filter"></i></button>
                        <a href="{{ route('reports_partialbooking.index') }}" class="btn btn-secondary ml-1" id="reset-filter">
                            <i class="fa fa-undo"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                @include('reports.bookingtotalpartialfilter')
            </div>
            <div class="card-body">
                @if(count($bookings) > 0)
                <table id="bookings" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            @if ($filter_booking_status != 'cancel')
                            <th><input type="checkbox" onclick="$('input[name*=\'checkbox\']').trigger('click');"></th>
                            @endif
                            <th>Id</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Type</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Destination</th>
                            <th>Assigned</th>
                             @if ($filter_booking_status == 'cancel')
                             <th>Reason</th>
                             @endif
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
                                        value="{{ $booking->id }}" @if(count($booking->permits) < 1) disabled @endif></td>
                                 @endif
                                <td>{{ $booking->id }}</td>
                                <td style="font-size:14px;">{{ isset($booking->customer->name) ? $booking->customer->name : '' }}
                                    @if($booking->type == 'safari')
                                    @isset($booking->safari->vendor)
                                    <br>
                                    <span class="badge bg-secondary">{{ \App\Models\Vendor::find($booking->safari->vendor)->name }}</span><br>
                                    @endisset
                                    @endif
                                    @if($booking->type == 'tour')
                                        @if (in_array('safari', $booking_type))
                                        @isset($booking->safari->vendor)
                                        <br>
                                        <span class="badge bg-secondary">{{ \App\Models\Vendor::find($booking->safari->vendor)->name }}</span><br>
                                        @endisset
                                        @endif
                                    @endif
                                    @if($booking->type == 'package')
                                        @if (in_array('safari', $booking_type))
                                            @foreach ($booking->safaris as $safari)
                                            @isset($safari->vendor)
                                            <br>
                                            <span class="badge bg-secondary">{{ \App\Models\Vendor::find($safari->vendor)->name }}</span><br>
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
                                @if ($filter_booking_status == 'cancel')
                                <span class="badge bg-orange">Cancel</span><br>
                                @else
                                <span class="badge bg-orange">Booked</span><br>
                                @endif
                                <span class="badge bg-grey">{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</span><br>
                                </td>
                                <td style="font-size:14px;">₹ {{ $booking->items->sum('amount') }}<br>
                                    <!-- @if($booking->transactions->sum('amount') > 0)
                                    @if($booking->transactions->sum('amount') >= $booking->items->sum('amount'))
                                    <span class="badge bg-success">Paid</span><br>
                                    @else
                                    <span class="badge bg-warning">Partial</span><br>
                                    @endif
                                    @else
                                    <span class="badge bg-indigo">Unpaid</span><br>
                                    @endisset -->
                                    @if($booking->payment_status == 'paid')
                                    <span class="badge bg-success">Paid</span><br>
                                    @elseif($booking->payment_status == 'unpaid')
                                    <span class="badge bg-indigo">Unpaid</span><br>
                                    @else
                                    <span class="badge bg-warning">Partial</span><br>
                                    @endisset
                                </td>
                                @if ($booking->type == 'cab')
                                    <td style="font-size:14px;">
                                        <i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Date"></i> {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}--
                                        <i class="fas fa-solid fa-timer"></i> {{ $booking->cab->pickup_time }}
                                    </td>
                                @endif
                                @if ($booking->type == 'hotel')
                                    <td style="font-size:14px;">
                                        <i class="fas fa-hotel" data-toggle="tooltip" title="Checkin Date"> </i> {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}</td>
                                @endif
                                @if ($booking->type == 'safari')
                                    <td style="font-size:14px;">
                                        <i class="fas fa-paw" data-toggle="tooltip" title="Safari Date"> </i>@isset($booking->safari->date) {{ \Carbon\Carbon::parse($booking->safari->date)->format('d-m-Y') }} @endisset
                                        <i class="fas fa-timer" data-toggle="tooltip" title="Safari Date"> </i>@isset($booking->safari->time) {{ $booking->safari->time }} @endisset

                                    </td>
                                @endif
                                @if ($booking->type == 'tour')
                                    <td style="font-size:14px;">
                                        @if (in_array('cab', $booking_type))
                                            <i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Date"></i> {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}--
                                             <i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Date"></i> {{ $booking->cab->pickup_time }}<br>
                                        @endif
                                        @if (in_array('hotel', $booking_type))
                                            <i class="fas fa-hotel" data-toggle="tooltip" title="Checkin Date"></i> {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}<br>
                                        @endif
                                        @if(in_array('safari', $booking_type))
                                            @foreach($booking->safaris as $safari)
                                            <i class="fas fa-paw" data-toggle="tooltip" title="" data-original-title="Safari Date"></i> {{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }}--
                                        <i class="fas fa-time" data-toggle="tooltip" title="Safari Date"> </i>@isset($safari->time) {{ $safari->time }} @endisset<br>
                                            @endforeach
                                        @endif
                                    </td>
                                @endif

                                @if($booking->type == 'package')
                                    <td>
                                        @if(in_array('hotel', $booking_type))
                                                @foreach($booking->hotels as $hotel)
                                                <span style="font-size:13px;"><i class="fas fa-hotel"></i> {{ \Carbon\Carbon::parse($hotel->check_in)->format('d-m-Y') }}</span><br>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if(in_array('cab', $booking_type))
                                                @foreach($booking->cabs as $cab)
                                                <span style="font-size:13px;"><i class="fas fa-map-marker-alt"  data-toggle="tooltip" title="" data-original-title="Pick Up"></i> {{ \Carbon\Carbon::parse($cab->start_date)->format('d-m-Y') }}</span><br>
                                                @endforeach
                                        @endif
                                        @if(in_array('safari', $booking_type))
                                            @foreach($booking->safaris as $safari)
                                            <span style="font-size:13px;"><i class="fas fa-paw" data-toggle="tooltip" title="" data-original-title="Safari Date"></i> {{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }}</span><br>
                                            @endforeach
                                        @endif
                                    </td>
                                @endif
                                @if ($booking->type == 'cab')
                                    <td style="font-size:14px;"><i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Point"></i>
                                        {{ ucfirst($booking->cab->drop) }}</td>
                                @elseif ($booking->type == 'hotel')
                                    <td style="font-size:14px;"><i class="fas fa-hotel" data-toggle="tooltip" title="Hotel Destination"></i>
                                        {{ ucfirst($booking->hotel->destination) }}
                                    </td>
                                @elseif($booking->type == 'safari')
                                    <td style="font-size:14px;"><i class="fas fa-paw" data-toggle="tooltip" title="Sanctuary"></i>
                                       @isset($booking->safari) {{ $booking->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($booking->safari->sanctuary) }} @endisset
                                    </td>
                                @elseif($booking->type == 'tour')
                                    <td style="font-size:14px;">
                                        @if (in_array('cab', $booking_type))
                                            <i class="fas fa-taxi"  data-toggle="tooltip" title="Pickup Point"></i> {{ $booking->cab->drop }}<br>
                                        @endif
                                        @if (in_array('hotel', $booking_type))
                                            <i class="fas fa-hotel"  data-toggle="tooltip" title="Hotel Destination"></i> {{ $booking->hotel->destination }}<br>
                                        @endif
                                        @if (in_array('safari', $booking_type))
                                        @isset($booking->safari)  <i class="fas fa-paw" data-toggle="tooltip" title="Sanctuary"></i> {{ $booking->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($booking->safari->sanctuary) }}<br>@endisset
                                        @endif
                                    </td>
                                @elseif($booking->type == 'package')
                                    <td>
                                        @if(in_array('hotel', $booking_type))
                                                @foreach($booking->hotels as $hotel)
                                                <span style="font-size:13px;"><i class="fas fa-hotel"></i> {{ $hotel->destination}}</span><br>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if(in_array('cab', $booking_type))
                                                @foreach($booking->cabs as $cab)
                                                <span style="font-size:13px;"><i class="fas fa-map-marker-alt"  data-toggle="tooltip" title="" data-original-title="Pick Up"></i> {{$cab->pick_up}} - <i class="fas fa-map-marker-alt"  data-toggle="tooltip" title="" data-original-title="Drop"></i> {{$cab->drop}}</span><br>
                                                @endforeach
                                        @endif
                                        @if(in_array('safari', $booking_type))
                                            @foreach($booking->safaris as $safari)
                                            <span style="font-size:13px;"><i class="fas fa-paw" data-toggle="tooltip" title="" data-original-title="Safari Date"></i> {{$safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($safari->sanctuary)}}</span><br>
                                            @endforeach
                                        @endif
                                    </td>
                                @endif
                                <td style="font-size:14px;">{{ $booking->user->name ?? 'N/A' }}</td>
                                @if ($filter_booking_status == 'cancel')
                                <td>{{ $booking->cancel->reason }}</td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total Partial  Paid Amount</th>
                            <th><i class="fa fa-inr"></i> {{ number_format($totalBookingPartialPaidAmount,2) }}</th>
                        </tr>
                    </tfoot>
                </table>
                @else
                <p class="text-center">No Booking found.</p>
                @endif
            </div>
            <div class="mt-2">
                {{$bookings->appends(request()->query())->links("pagination::bootstrap-4")}}
            </div>
        </div>
        @role('administrator')
        <div class="container px-4 mx-auto">
            <div class="p-6 m-20 bg-white rounded shadow">
                {!! $chart->container() !!}
            </div>
        </div>
        @endrole
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
                        <div class="form-group" >
                            <label for="reason">Booking Cancel Reason</label>
                             <textarea class="form-control" id="reason"
                        name="reason" required value=""></textarea>
                        </div>
                        <div class="form-group" >
                            <label for="cancellation_charges">Cancellation Charges</label>
                             <input type="text" name="cancellation_charges" id="cancellation_charges" class="form-control" value="" required>
                        </div>
                        <div class="form-group" >
                            <label for="permit_cancellation_charges">Permit Cancellation Charges</label>
                             <input type="text" name="permit_cancellation_charges" id="permit_cancellation_charges" class="form-control" value="" required>
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
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(function() {
  $('input[name="filter_daterange"]').daterangepicker({
    opens: 'left',
    autoUpdateInput: false,
    locale: {
      format: 'YYYY-MM-DD',
      cancelLabel: 'Clear'
    },
  }, function(start, end, label) {
  });


  $('input[name="filter_daterange"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
  });

});
</script>
@include('layouts.utilities')
@endpush


