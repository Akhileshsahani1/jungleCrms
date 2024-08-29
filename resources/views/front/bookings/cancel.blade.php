@extends('front.layouts.app')
@section('title', 'Cancel Booking')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Cancel Booking </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.bookings') }}">Bookings</a></li>
                    <li class="breadcrumb-item active">Cancel Booking</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">
    @if ($booking->type == 'cab')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header bg-orange">
                                <h3 class="card-title">{{ ucfirst($booking->type) }} Booking Details</h3>
                                <button class="btn btn-sm btn-dark float-right">Total Amount: ₹ {{ $booking->items->sum('amount') }}</button>
                            </div>

                            <div class="card-body">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Trip Type</td>
                                            <td class="text-right">{{ $booking->cab->trip_type }}</td>
                                        </tr>
                                        <tr>
                                            <td>Journey Starts at</td>
                                            <td class="text-right">
                                                {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}
                                                {{ \Carbon\Carbon::parse($booking->cab->pickup_time)->format('g:i A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Journey End Date</td>
                                            <td class="text-right">
                                                {{ \Carbon\Carbon::parse($booking->cab->end_date)->format('d-m-Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Pickup Point</td>
                                            <td class="text-right">{{ $booking->cab->pick_up }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Amount</td>
                                            <td class="text-right">₹{{ $booking->cab->amount }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cab Due Amount</td>
                                            <td class="text-right">₹{{ $booking->cab->cab_due_amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card pb-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header bg-orange">
                                <h3 class="card-title">{{ ucfirst($booking->type) }} Cancellation Policy</h3>
                            </div>

                            <div class="card-body">
                                {!! $content->content !!}
                                <form action="{{ route('dashboard.cancel.booking', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label for="amount" class="form-label">Refundable Amount</label>
                                        <input type="text" class="form-control" name="amount" id="amount" value="{{ $cancellation_exists ? \App\Models\BookingCancellationRequest::where('booking_id', $booking->id)->first()->refundable_amount : $amount }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="reason" class="form-label">Cancellation Reason</label>
                                        <textarea name="reason" id="reason" rows="4" class="form-control">{{ $cancellation_exists ? \App\Models\BookingCancellationRequest::where('booking_id', $booking->id)->first()->reason : '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        @if($cancellation_exists)
                                        <button type="submit" class="btn btn-block btn-success" disabled>Cancellation Request Already Sent!</button>
                                        @else
                                        <button type="submit" class="btn btn-block btn-success">Send Cancellation Request</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($booking->type == 'hotel')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header bg-orange">
                                <h3 class="card-title">{{ ucfirst($booking->type) }} Booking Details</h3>
                                <button class="btn btn-sm btn-dark float-right">Total Amount: ₹ {{ $booking->items->sum('amount') }}</button>
                            </div>

                            <div class="card-body">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Check In</td>
                                            <td class="text-right">
                                                {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Check Out</td>
                                            <td class="text-right">
                                                {{ \Carbon\Carbon::parse($booking->hotel->check_out)->format('d-m-Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Destination</td>
                                            <td class="text-right">{{ $booking->hotel->destination }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hotel</td>
                                            <td class="text-right">{{ $hotel->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hotel Room</td>
                                            <td class="text-right">
                                                {{ \App\Models\HotelRoom::find($booking->hotel->room_id)->value('room') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Service</td>
                                            <td class="text-right">
                                                {{ \App\Models\HotelRoomService::find($booking->hotel->service_id)->value('service') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Total Package Amount</td>
                                            <td class="text-right">₹{{ $booking->hotel->amount }}</td>
                                        </tr>
                                        <tr>
                                            <td>Hotel Due Amount</td>
                                            <td class="text-right">₹{{ $booking->hotel->hotel_due_amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card pb-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header bg-orange">
                                <h3 class="card-title">{{ ucfirst($booking->type) }} Cancellation Policy</h3>
                            </div>

                            <div class="card-body">
                                {!! $content->content !!}
                                <form action="{{ route('dashboard.cancel.booking', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <!-- <div class="form-group">
                                        <label for="amount" class="form-label">Refundable Amount</label>
                                        <input type="text" class="form-control" name="amount" id="amount" value="{{ $cancellation_exists ? \App\Models\BookingCancellationRequest::where('booking_id', $booking->id)->first()->refundable_amount : $amount }}" readonly>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="reason" class="form-label">Cancellation Reason</label>
                                        <textarea name="reason" id="reason" rows="4" class="form-control">{{ $cancellation_exists ? \App\Models\BookingCancellationRequest::where('booking_id', $booking->id)->first()->reason : '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        @if($cancellation_exists)
                                        <button type="submit" class="btn btn-block btn-success" disabled>Cancellation Request Already Sent!</button>
                                        @else
                                        <button type="submit" class="btn btn-block btn-success">Send Cancellation Request</button>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($booking->type == 'safari')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header bg-orange">
                                <h3 class="card-title">{{ ucfirst($booking->type) }} Booking Details</h3>
                                <button class="btn btn-sm btn-dark float-right">Total Amount: ₹ {{ $booking->items->sum('amount') }}</button>
                            </div>

                            <div class="card-body">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Sanctuary</td>
                                            @if ($booking->safari->sanctuary == 'gir')
                                            <td class="text-right">Gir National Park</td>
                                            @elseif($booking->safari->sanctuary == 'jim')
                                            <td class="text-right">Jim Corbett National Park</td>
                                            @elseif($booking->safari->sanctuary == 'ranthambore')
                                            <td class="text-right">Ranthambore National Park</td>
                                            @endif
                                        </tr>
                                        @if ($booking->safari->sanctuary == 'jim' || $booking->safari->sanctuary == 'ranthambore')
                                        <tr>
                                            <td>Safari Area</td>
                                            <td class="text-right">{{ $booking->safari->area }}</td>
                                        </tr>
                                        @endif
                                        @if ($booking->safari->sanctuary == 'gir' || $booking->safari->sanctuary == 'ranthambore')
                                        <tr>
                                            <td>Safari Zone</td>
                                            <td class="text-right">{{ $booking->safari->zone }}</td>
                                        </tr>
                                        @endif


                                        <tr>
                                            <td>Safari Date</td>
                                            <td class="text-right">
                                                {{ \Carbon\Carbon::parse($booking->safari->date)->format('d-m-Y') }}
                                                {{ $booking->safari->time }}
                                            </td>
                                        </tr>
                                        @if ($booking->safari->sanctuary == 'gir' || $booking->safari->sanctuary == 'ranthambore')
                                        <tr>
                                            <td>Booking Type</td>
                                            <td class="text-right">{{ $booking->safari->type }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>Total Amount</td>
                                            <td class="text-right">₹{{ $booking->safari->amount }}</td>
                                        </tr>
                                        <tr>
                                            <td>Safari Due Amount</td>
                                            <td class="text-right">₹{{ $booking->safari->safari_due_amount }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header bg-orange">
                                <h3 class="card-title">Select Members to Cancel</h3>
                            </div>

                            <div class="card-body">
                                <table id="option" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px"><input type="checkbox" id="select_all" onchange="selectAllCheckbox()"></th>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Nationality</th>
                                            <th>State</th>
                                            <th>Id Proof</th>
                                            <th>Id Proof No</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @if( count($members) > 0 )
                                        @foreach( $members as $k => $m)


                                        <tr id="item-option-row{{ $k }}" @if( isset($cancel->members) && in_array($m->name, array_column($cancel->members->toArray(), 'name') )) style="background-color:#a52a2a42;" @endif>
                                            <td><input type="checkbox" id="customer_{{$k}}" name="customer[]" class="select_customers"></td>
                                            <td>{{ $k+1 }}</td>
                                            <td>{{ $m->name }}</td>
                                            <td>{{ $m->age }}</td>
                                            <td>{{ $m->gender }}</td>
                                            <td>{{ $m->nationality }}</td>
                                            <td>{{ $m->state }}</td>
                                            <td>{{ $m->idproof }}</td>
                                            <td>{{ $m->idproof_no }}</td>

                                        </tr>

                                        @endforeach
                                        @endif

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card pb-1">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header bg-orange">
                                <h3 class="card-title">{{ ucfirst($booking->type) }} Cancellation Policy</h3>
                            </div>

                            <div class="card-body">
                                {!! $content->content !!}
                                <form id="cancel-safari" action="{{ route('dashboard.cancel.booking', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="type" value="safari">
                                    <!-- <div class="form-group">
                                        <label for="amount" class="form-label">Refundable Amount</label>
                                        <input type="text" class="form-control" name="amount" id="amount" value="{{ $cancellation_exists ? \App\Models\BookingCancellationRequest::where('booking_id', $booking->id)->first()->refundable_amount : $amount }}" readonly>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="reason" class="form-label">Cancellation Reason</label>
                                        <textarea name="reason" id="reason" rows="4" class="form-control">{{ $cancellation_exists ? \App\Models\BookingCancellationRequest::where('booking_id', $booking->id)->first()->reason : '' }}</textarea>
                                    </div>

                                </form>

                                <div class="form-group">
                                    @if($cancellation_exists)
                                    <button type="submit" class="btn btn-block btn-success" disabled>Cancellation Request Already Sent!</button>
                                    @else
                                    <button type="submit" class="btn btn-block btn-success" onclick="cancel()">Send Cancellation Request</button>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($booking->type == 'tour')
    <div class="row">
        <div class="col-lg-12">
        @if( !$cancellation_exists)
        <div class="text-center m-2">
            <a class="btn btn-danger" href="#fullcancel">Cancel Full Booking</a>
        </div>
        @endif
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card-header bg-orange">
                                <h3 class="card-title">{{ ucfirst($booking->type) }} Booking Details</h3>
                                <button class="btn btn-sm btn-dark float-right">Total Amount: ₹ {{ $booking->items->sum('amount') }}</button>
                            </div>

                            <div class="card-body">
                                @if (in_array('hotel', $booking_type))
                                <div class="card-header bg-orange">
                                    <h3 class="card-title">Hotel Booking Details</h3>
                                </div>
                                
                                <div class="text-center m-2">
                                        @if( $booking->hotel->status == 1 && !$cancellation_exists)
                                        <button class="btn btn-danger" onclick="cancelPartialPackage({{ $booking->hotel->id }},'hotel')">Cancel Hotel</button>
                                        @else
                                        <button class="btn btn-success" >Cancellation processing</button>
                                        @endif
                                </div>

                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Check In</td>
                                                <td class="text-right">
                                                    {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Check Out</td>
                                                <td class="text-right">
                                                    {{ \Carbon\Carbon::parse($booking->hotel->check_out)->format('d-m-Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Destination</td>
                                                <td class="text-right">{{ $booking->hotel->destination }}</td>
                                            </tr>
                                            <tr>
                                                <td>Hotel</td>
                                                <td class="text-right">{{ $hotel->name }}</td>
                                            </tr>
                                            <tr>
                                                <td>Hotel Room</td>
                                                <td class="text-right">
                                                    {{ \App\Models\HotelRoom::find($booking->hotel->room_id)->value('room') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Service</td>
                                                <td class="text-right">
                                                    {{ \App\Models\HotelRoomService::find($booking->hotel->service_id)->value('service') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Total Package Amount</td>
                                                <td class="text-right">₹{{ $booking->hotel->amount }}</td>
                                            </tr>
                                            <tr>
                                                <td>Hotel Due Amount</td>
                                                <td class="text-right">
                                                    ₹{{ $booking->hotel->hotel_due_amount }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif

                                @if (in_array('cab', $booking_type))
                                <div class="card-header bg-warning">
                                    <h3 class="card-title">Cab Booking Details</h3>
                                </div>

                                <div class="text-center m-2">
                                        @if( $booking->cab->status == 1 && !$cancellation_exists)
                                        <button class="btn btn-danger" onclick="cancelPartialPackage({{ $booking->cab->id }},'cab')">Cancel Cab</button>
                                        @else
                                        <button class="btn btn-success" >Cancellation processing</button>
                                        @endif
                                </div>

                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tbody>
                                            <tr>
                                                <td>Trip Type</td>
                                                <td class="text-right">{{ $booking->cab->trip_type }}</td>
                                            </tr>
                                            <tr>
                                                <td>Journey Starts at</td>
                                                <td class="text-right">
                                                    {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}
                                                    {{ \Carbon\Carbon::parse($booking->cab->pickup_time)->format('g:i A') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Journey End Date</td>
                                                <td class="text-right">
                                                    {{ \Carbon\Carbon::parse($booking->cab->end_date)->format('d-m-Y') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Pickup Point</td>
                                                <td class="text-right">{{ $booking->cab->pick_up }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Amount</td>
                                                <td class="text-right">₹{{ $booking->cab->amount }}</td>
                                            </tr>
                                            <tr>
                                                <td>Cab Due Amount</td>
                                                <td class="text-right">₹{{ $booking->cab->cab_due_amount }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif

                                @if (in_array('safari', $booking_type))
                                <div class="card">
                                    <div class="card-header bg-warning">
                                        <h3 class="card-title">Safari Booking Details</h3>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($booking->safaris as $key => $safari)
                                        <div class="card">

                                        <div class="text-center m-2">
                                        @if( $safari->status == 1 && !$cancellation_exists)
                                        <button class="btn btn-danger" onclick="cancelPartialPackage({{ $safari->id }},'safari')">Cancel Safari {{ $safari->time }}</button>
                                        @else
                                        <button class="btn btn-success" >Cancellation processing</button>
                                        @endif
                                        </div>

                                            <div class="card-header bg-dark">
                                                <h3 class="card-title">
                                                    {{ $safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($safari->sanctuary) }}
                                                    National Park
                                                </h3>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td>Sanctuary</td>
                                                            @if ($safari->sanctuary == 'gir')
                                                            <td class="text-right">Gir National Park
                                                            </td>
                                                            @elseif($safari->sanctuary == 'jim')
                                                            <td class="text-right">Jim Corbett National
                                                                Park</td>
                                                            @elseif($safari->sanctuary == 'ranthambore')
                                                            <td class="text-right">Ranthambore National
                                                                Park</td>
                                                            @endif
                                                        </tr>

                                                        @if ($safari->sanctuary == 'jim' || $safari->sanctuary == 'ranthambore')
                                                        <tr>
                                                            <td>Safari Area</td>
                                                            <td class="text-right">{{ $safari->area }}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @if ($safari->sanctuary == 'gir' || $safari->sanctuary == 'ranthambore')
                                                        <tr>
                                                            <td>Safari Zone</td>
                                                            <td class="text-right">{{ $safari->zone }}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @if ($safari->sanctuary == 'ranthambore')
                                                        <tr>
                                                            <td>Vehicle Booking Type</td>
                                                            <td class="text-right">
                                                                {{ $safari->vehicle_type }}
                                                            </td>
                                                        </tr>
                                                        @endif

                                                        <tr>
                                                            <td>Safari Date</td>
                                                            <td class="text-right">
                                                                {{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Safari Time</td>
                                                            <td class="text-right">
                                                                {{ $safari->time }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Safari Due Amount</td>
                                                            <td class="text-right">
                                                                ₹{{ $safari->safari_due_amount }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card pb-1">
                <div class="card-body">
                    <div class="row" id="fullcancel">
                        <div class="col-md-12">
                            <div class="card-header bg-orange">
                                <h3 class="card-title">{{ ucfirst($booking->type) }} Cancellation Policy</h3>
                            </div>

                            <div class="card-body">
                                @if ($booking->safari->sanctuary == 'gir')
                                {{ $content->content }}
                                @elseif($booking->safari->sanctuary == 'jim')
                                {{ $content->content }}
                                @elseif($booking->safari->sanctuary == 'ranthambore')
                                <p>We are sorry! No refund or cancellation is permitted on confirmed bookings
                                    for safari or tour package
                                </p>
                                @endif
                                <form action="{{ route('dashboard.cancel.booking', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <!-- <div class="form-group">
                                        <label for="amount" class="form-label">Refundable Amount</label>
                                        <input type="text" class="form-control" name="amount" id="amount" value="{{ $cancellation_exists ? \App\Models\BookingCancellationRequest::where('booking_id', $booking->id)->first()->refundable_amount : $amount }}" readonly>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="reason" class="form-label">Cancellation Reason</label>
                                        <textarea name="reason" id="reason" rows="4" class="form-control">{{ $cancellation_exists ? \App\Models\BookingCancellationRequest::where('booking_id', $booking->id)->first()->reason : '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        @if($cancellation_exists)
                                        <button type="submit" class="btn btn-block btn-success" disabled>Cancellation Request Already Sent!</button>
                                        @else
                                        <button type="submit" class="btn btn-block btn-success">Send Full Booking Cancellation Request</button>
                                        @endif
                                    </div>
                                </form>

                                <form id="patial-package-cancel" action="{{ route('dashboard.cancel.booking', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input type="hidden" name="type">
                                    <input type="hidden" name="type_id">
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if ($booking->type == 'package')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-12">
                            <div class="card-header bg-orange">
                                <h3 class="card-title">{{ ucfirst($booking->type) }} Booking Details</h3>
                                <button class="btn btn-sm btn-dark float-right">Total Amount: ₹ {{ $booking->items->sum('amount') }}</button>
                            </div>

                            <div class="card-body">
                                @if( !$cancellation_exists)
                                <div class="text-center m-2">
                                    <a class="btn btn-danger" href="#fullcancel">Cancel Full Booking</a>
                                </div>
                                @endif
                                @if (in_array('cab', $booking_type))
                                <div class="card">
                                    <div class="card-header bg-warning">
                                        <h3 class="card-title">Cab Details</h3>
                                    </div>
                                    <div class="card-body">

                                        @foreach ($booking->cabs as $key => $cab)
                                        <div class="card">
                                            <div class="card-header bg-dark">
                                                <h3 class="card-title">Trip {{ $key + 1 }}</h3>
                                            </div>
                                            <div class="text-center m-2">
                                                @if( $cab->status == 1 && !$cancellation_exists)
                                                <button class="btn btn-danger" onclick="cancelPartialPackage({{ $cab->id }},'cab')">Cancel Trip {{ $key +1 }}</button>
                                                @else
                                                <button class="btn btn-success" >Cancellation processing</button>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td>Trip Type</td>
                                                            <td class="text-right">{{ $cab->trip_type }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Journey Start Date</td>
                                                            <td class="text-right">
                                                                {{ \Carbon\Carbon::parse($cab->start_date)->format('d-m-Y') }}
                                                                {{ \Carbon\Carbon::parse($cab->pickup_time)->format('g:i A') }}
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td>Journey End Date</td>
                                                            <td class="text-right">
                                                                {{ \Carbon\Carbon::parse($cab->end_date)->format('d-m-Y') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Cab Due Amount</td>
                                                            <td class="text-right">
                                                                ₹{{ $cab->cab_due_amount }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                @if (in_array('hotel', $booking_type))
                                <div class="card">
                                    <div class="card-header bg-orange">
                                        <h3 class="card-title">Hotel Details</h3>
                                    </div>

                                    <div class="card-body">
                                        @foreach ($booking->hotels as $key => $row)
                                        @php
                                        $hotel = \App\Models\Hotel::find($row->option->hotel_id);
                                        @endphp
                                        <div class="card">
                                            <div class="card-header bg-dark">
                                                <h3 class="card-title">Hotel Destination :
                                                    {{ $row->destination }}
                                                </h3>
                                            </div>
                                            <div class="text-center m-2">
                                                @if( $row->status == 1 && !$cancellation_exists)
                                                <button class="btn btn-danger" onclick="cancelPartialPackage({{ $row->id }},'hotel')">Cancel Hotel {{ $row->destination }}</button>
                                                @else
                                                <button class="btn btn-success" >Cancellation processing</button>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td>Check In</td>
                                                            <td class="text-right">
                                                                {{ \Carbon\Carbon::parse($row->check_in)->format('d-m-Y') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Check Out</td>
                                                            <td class="text-right">
                                                                {{ \Carbon\Carbon::parse($row->check_out)->format('d-m-Y') }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                @if (in_array('safari', $booking_type))
                                <div class="card">
                                    <div class="card-header bg-warning">
                                        <h3 class="card-title">Safari Details</h3>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($booking->safaris as $key => $safari)
                                        <div class="card">
                                            <div class="card-header bg-dark">
                                                <h3 class="card-title">
                                                    {{ $safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($safari->sanctuary) }}
                                                    National Park
                                                </h3>
                                            </div>
                                            <div class="text-center m-2">
                                            
                                                @if( $safari->status == 1 && !$cancellation_exists )
                                                <button class="btn btn-danger" onclick="cancelPartialPackage({{ $safari->id }},'safari')">Cancel Safari {{ $safari->time }}</button>
                                                @else
                                                <button class="btn btn-success" >Cancellation processing</button>
                                                @endif
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td>Sanctuary</td>
                                                            @if ($safari->sanctuary == 'gir')
                                                            <td class="text-right">Gir National Park
                                                            </td>
                                                            @elseif($safari->sanctuary == 'jim')
                                                            <td class="text-right">Jim Corbett National
                                                                Park</td>
                                                            @elseif($safari->sanctuary == 'ranthambore')
                                                            <td class="text-right">Ranthambore National
                                                                Park</td>
                                                            @endif
                                                        </tr>
                                                        <tr>
                                                            <td>Vehicle Mode</td>
                                                            <td class="text-right">{{ $safari->mode }}
                                                            </td>
                                                        </tr>
                                                        @if ($safari->sanctuary == 'jim' || $safari->sanctuary == 'ranthambore')
                                                        <tr>
                                                            <td>Safari Area</td>
                                                            <td class="text-right">{{ $safari->area }}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @if ($safari->sanctuary == 'gir' || $safari->sanctuary == 'ranthambore')
                                                        <tr>
                                                            <td>Safari Zone</td>
                                                            <td class="text-right">{{ $safari->zone }}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        <tr>
                                                            <td>Safari Date</td>
                                                            <td class="text-right">
                                                                {{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Safari Time</td>
                                                            <td class="text-right">
                                                                {{ $safari->time }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Safari Due Amount</td>
                                                            <td class="text-right">
                                                                ₹{{ $safari->safari_due_amount }}
                                                            </td>
                                                        </tr>
                                                        @if ($booking->safari->package_name)
                                                        <tr>
                                                            <td>Package Name</td>
                                                            <td class="text-right">
                                                                {{ $booking->safari->package_name }}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                        @if ($booking->safari->package_type)
                                                        <tr>
                                                            <td>Package Type</td>
                                                            <td class="text-right">
                                                                {{ $booking->safari->package_type }}
                                                            </td>
                                                        </tr>
                                                        @endif
                                                </table>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card pb-1">
                <div class="card-body">
                    <div class="row" id="fullcancel">
                        <div class="col-md-12">
                            <div class="card-header bg-orange">
                                <h3 class="card-title">{{ ucfirst($booking->type) }} Cancellation Policy</h3>
                            </div>

                            <div class="card-body">
                                @if ($booking->safari->sanctuary == 'gir')
                                {!! $content->content !!}
                                @elseif($booking->safari->sanctuary == 'jim')
                                {!! $content->content !!}
                                @elseif($booking->safari->sanctuary == 'ranthambore')
                                <p>We are sorry! No refund or cancellation is permitted on confirmed
                                    bookings for safari or Package
                                </p>
                                @endif
                                <form action="{{ route('dashboard.cancel.booking', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <!-- <div class="form-group">
                                        <label for="amount" class="form-label">Refundable Amount</label>
                                        <input type="text" class="form-control" name="amount" id="amount" value="{{ $cancellation_exists ? \App\Models\BookingCancellationRequest::where('booking_id', $booking->id)->first()->refundable_amount : $amount }}" readonly>
                                    </div> -->
                                    <div class="form-group">
                                        <label for="reason" class="form-label">Cancellation Reason</label>
                                        <textarea name="reason" id="reason" rows="4" class="form-control">{{ $cancellation_exists ? \App\Models\BookingCancellationRequest::where('booking_id', $booking->id)->first()->reason : '' }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        @if($cancellation_exists)
                                        <button type="submit" class="btn btn-block btn-success" disabled>Cancellation Request Already Sent!</button>
                                        @else
                                        <button type="submit" class="btn btn-block btn-success">Send Full Booking Cancellation Request</button>
                                        @endif
                                    </div>
                                </form>

                                <form id="patial-package-cancel" action="{{ route('dashboard.cancel.booking', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                    <input type="hidden" name="type">
                                    <input type="hidden" name="type_id">
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</section>
@endsection

@push('scripts')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $('#select_all').change(function() {
        if (this.checked) {
            $('.select_customers').prop("checked", true);
        } else {
            $('.select_customers').prop("checked", false);
        }
    });

    function cancelPartialPackage(id, type) {

        Swal.fire({
            title: 'Are you sure to cancel ' + type + ' ?',
            text: "You won't be able to revert this! ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel ' + type
        }).then((result) => {
            if (result.isConfirmed) {
                $('input[name="type"]').val('package-' + type);
                $('input[name="type_id"]').val(id);
                document.getElementById('patial-package-cancel').submit();
            }
        })

    }


    function cancel() {

        let cus = document.querySelectorAll('.select_customers:checked');
        let mem = 0;
        $('input[name="cancel_persons[]"]').remove();
        cus.forEach((e, i) => {
            let n = e.parentNode.nextElementSibling.nextElementSibling.innerText;

            $("<input />").attr("type", "hidden")
                .attr("name", "cancel_persons[]")
                .attr("value", n)
                .appendTo("#cancel-safari");

            mem += 1;
        });

        if (mem == 0) {
            swal('Please select members to cancel', '', 'info');
            return;
        }

        Swal.fire({
            title: 'Are you sure to cancel?',
            text: "You cancelling the booking of " + mem + " member(s) ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancel-safari').submit();
            }
        })
    };
</script>
@endpush