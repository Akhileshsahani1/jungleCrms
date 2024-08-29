@extends('layouts.master')
@section('title', 'Show Package Booking')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-globe-asia"></i> Package Booking </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Bookings</a></li>
                        <li class="breadcrumb-item active">Show Package Booking</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <p class="card-title text-info">Total Amount : ₹ {{ $booking->items->sum('amount') }}</p>
                <div class="card-tools">
                    <a href="{{ route('booking-transactions.index', array_merge(\Request::query(), ['booking_id' => $booking->id])) }}" class="btn btn-secondary">
                        Transactions</a>
                    <a href="{{ route('invoices.show', $booking->id) }}" class="btn bg-orange">
                            Invoices</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-voucher">
                        Voucher
                    </button>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-permit">
                        Permit
                    </button>
                    <div class="btn-group">
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-dark" data-toggle="tooltip"
                            title="Edit Booking"> <i class="fas fa-pen"></i> </a>
                        <button type="button" onclick="confirmDelete({{ $booking->id }})" class="btn btn-danger"
                            data-toggle="tooltip" title="Delete Booking"><i class="fas fa-trash"></i> </button>
                        <form id='delete-form{{ $booking->id }}' action='{{ route('bookings.destroy', $booking->id) }}'
                            method='POST'>
                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                            <input type='hidden' name='_method' value='DELETE'>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header bg-indigo">
                            <h3 class="card-title">Customer Details</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td>Name</td>
                                        <td class="text-right">{{ $booking->customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td class="text-right">{{ $booking->customer->email }}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td class="text-right">{{ $booking->customer->mobile }}</td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td class="text-right">{{ $booking->customer->address }}</td>
                                    </tr>
                                    <tr>
                                        <td>State</td>
                                        <td class="text-right">{{ $booking->customer->state }}</td>
                                    </tr>
                                    <tr>
                                        <td>Order Date</td>
                                        <td class="text-right"> {{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @if (in_array('hotel', $booking_type))
                            <div class="card-header bg-orange">
                                <h3 class="card-title">Hotel Booking Details</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Number of Adults</td>
                                            <td class="text-right">{{ $booking->hotel->adult }} Adults</td>
                                        </tr>
                                        <tr>
                                            <td>Number of Children</td>
                                            <td class="text-right">{{ $booking->hotel->child }} Child</td>
                                        </tr>
                                        <tr>
                                            <td>Number of Rooms</td>
                                            <td class="text-right">{{ $booking->hotel->room }}</td>
                                        </tr>
                                        <tr>
                                            <td>Extra Beds</td>
                                            <td class="text-right">{{ $booking->hotel->bed }}</td>
                                        </tr>
                                        <tr>
                                            <td>Note</td>
                                            <td>{!! $booking->hotel->note !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            @foreach ($booking->destinations as $destination)
                                @foreach ($destination->options as $option)
                                    @php
                                        $hotel = \App\Models\Hotel::find($option->hotel_id);
                                    @endphp
                                    <div class="row">
                                    <div @if(count($hotel->images) < 1) class="col-md-12"  @else class="col-md-6" @endif>
                                        <div class="card-header bg-orange">
                                            <h3 class="card-title">Destination : {{ $destination->destination }} (Hotel Details)</h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-sm">
                                                <tbody>
                                                    <tr>
                                                        <td>Hotel Name</td>
                                                        <td>{{ $hotel->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Rating</td>
                                                        <td>{{ $hotel->rating }} Star</td>
                                                    </tr>
                                                    <tr>
                                                        <td>State</td>
                                                        <td>{{ $hotel->state }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>City</td>
                                                        <td>{{ $hotel->city }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Contact Person</td>
                                                        <td>{{ $hotel->person }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Contact Number</td>
                                                        <td>{{ $hotel->phone }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Contact Email</td>
                                                        <td>{{ isset($hotel->email) ? $hotel->email : 'N/A' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status</td>
                                                        <td>{{ $hotel->status == 1 ? 'Enabled' : 'Disabled' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Check In</td>
                                                        <td>{{  \Carbon\Carbon::parse($destination->check_in)->format('d-m-Y')  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Check Out</td>
                                                        <td>{{  \Carbon\Carbon::parse($destination->check_out)->format('d-m-Y')  }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Hotel Due Amount</td>
                                                        <td>₹ {{ $destination->hotel_due_amount}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                @foreach ($hotel->images as $key => $image)
                                                    <li data-target="#carouselExampleIndicators"
                                                        data-slide-to="{{ $key }}"
                                                        @if ($loop->first) class="active" @endif></li>
                                                @endforeach
                                            </ol>
                                            <div class="carousel-inner">
                                                @foreach ($hotel->images as $image)
                                                @php
                                                    $image->path = asset('storage/uploads/hotels/' . $hotel->id . '/' . $image->image);
                                                @endphp
                                                    <div
                                                        class="carousel-item  @if ($loop->first) active @endif">
                                                        <img class="d-block w-100" src="{{ $image->path }}"
                                                            alt="{{ $image->image }}" width="514" height="343">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                                data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Previous</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                                data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Next</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mt-4">
                                        <div class="card-header bg-orange">
                                            <h3 class="card-title">Room Details</h3>
                                        </div>
                                        @foreach ($hotel->rooms as $room)
                                            <div class="card">
                                                <div class="card-header">
                                                    <h3 class="card-title" style="color: #6610f2;">{{ $room->room }}
                                                    </h3>
                                                </div>
                                                <div class="card-body p-0">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Service</th>
                                                                <th>Base Price</th>
                                                                <th>Adult(Extra Bed)</th>
                                                                <th>Child(Extra Bed)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($room->services as $service)
                                                                <tr>
                                                                    <td>{{ $service->service }} @if ($service->id == $option->service_id)
                                                                            <br><span
                                                                                class="badge bg-success">Selected</span>
                                                                        @endif
                                                                    </td>
                                                                    <td>₹{{ $service->price }}</td>
                                                                    <td>₹{{ $service->extra_adult_price }}</td>
                                                                    <td>₹{{ $service->extra_child_price }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    </div>
                                @endforeach
                            @endforeach
                        @endif

                        @if (in_array('cab', $booking_type))
                            <div class="card-header bg-warning">
                                <h3 class="card-title">Cab Booking Details</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm">
                                    <tbody>
                                        <tr>
                                            <td>Trip Type</td>
                                            <td class="text-right">{{ $booking->cab->trip_type }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pickup Medium</td>
                                            <td class="text-right">{{ $booking->cab->pickup_medium }}</td>
                                        </tr>
                                        <tr>
                                            <td>Vehicle</td>
                                            <td class="text-right">{{ $booking->cab->vehicle_type }}</td>
                                        </tr>
                                        <tr>
                                            <td>Journey Start Date</td>
                                            <td class="text-right">
                                                {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Journey End Date</td>
                                            <td class="text-right">
                                                {{ \Carbon\Carbon::parse($booking->cab->end_date)->format('d-m-Y') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>No. of Days</td>
                                            <td class="text-right">{{ $booking->cab->days }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pickup Point</td>
                                            <td class="text-right">{{ $booking->cab->pick_up }}</td>
                                        </tr>
                                        <tr>
                                            <td>Drop Point</td>
                                            <td class="text-right">{{ $booking->cab->drop }}</td>
                                        </tr>
                                        <tr>
                                            <td>Pickup Time</td>
                                            <td class="text-right">
                                                {{ \Carbon\Carbon::parse($booking->cab->pickup_time)->format('g:i A') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>No. of Riders</td>
                                            <td class="text-right">{{ $booking->cab->total_riders }}</td>
                                        </tr>
                                        <tr>
                                            <td>Cab Due Amount</td>
                                            <td class="text-right">
                                                ₹{{  $booking->cab->cab_due_amount }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Note</td>
                                            <td>{!! $booking->cab->note !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if (in_array('safari', $booking_type))
                            <div class="card-header bg-brown">
                                <h3 class="card-title">Safari Booking Details</h3>
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
                                        <tr>
                                            <td>Vehicle Mode</td>
                                            <td class="text-right">{{ $booking->safari->mode }}</td>
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
                                        @if ($booking->safari->sanctuary == 'ranthambore')
                                            <tr>
                                                <td>Vehicle Booking Type</td>
                                                <td class="text-right">{{ $booking->safari->vehicle_type }}</td>
                                            </tr>
                                        @endif
                                        @if ($booking->safari->sanctuary == 'gir')
                                            <tr>
                                                <td>No. of Adults</td>
                                                <td class="text-right">{{ $booking->safari->adult }}</td>
                                            </tr>
                                            <tr>
                                                <td>No. of Children</td>
                                                <td class="text-right">{{ $booking->safari->child }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>No of Person</td>
                                            <td class="text-right">{{ $booking->safari->total_person }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nationality</td>
                                            <td class="text-right">{{ $booking->safari->nationality }}</td>
                                        </tr>
                                        <tr>
                                            <td>Safari Date</td>
                                            <td class="text-right">
                                                {{ \Carbon\Carbon::parse($booking->safari->date)->format('d-m-Y') }}</td>
                                        </tr>
                                        <tr>
                                            <td>Safari Time</td>
                                            <td class="text-right">
                                                {{ $booking->safari->time }}</td>
                                        </tr>
                                        @if ($booking->safari->sanctuary == 'gir' || $booking->safari->sanctuary == 'ranthambore')
                                            <tr>
                                                <td>Booking Type</td>
                                                <td class="text-right">{{ $booking->safari->type }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>Website</td>
                                            <td class="text-right">{{ $booking->website }}</td>
                                        </tr>
                                        <tr>
                                            <td>Safari Due Amount</td>
                                            <td class="text-right">
                                                ₹{{  $booking->safari->safari_due_amount }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Note</td>
                                            <td>{!! $booking->safari->note !!}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-header bg-brown">
                                <h3 class="card-title">Safari Booked Customers</h3>
                            </div>
                            <div class="card-body">
                                <table id="option" class="table table-bordered">
                                    <thead>
                                        <tr>
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
                                        @if (isset($booking) && count($booking->customer_details) > 0)
                                            @foreach ($booking->customer_details as $key => $detail)
                                                <tr id="item-option-row{{ $key }}">
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $detail->name }}</td>
                                                    <td>{{ $detail->age }}</td>
                                                    <td>{{ $detail->gender }}</td>
                                                    <td>{{ $detail->nationality }}</td>
                                                    <td>{{ $detail->state }}</td>
                                                    <td>{{ $detail->idproof }}</td>
                                                    <td>{{ $detail->idproof_no }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <div class="card-header bg-indigo">
                            <h3 class="card-title">Payment Details</h3>
                        </div>
                        <div class="card-body">
                            <table id="option" class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th>Particular</th>
                                        <th>Amount</th>
                                        <th>Rate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($booking) && count($booking->items) > 0)
                                        @foreach ($booking->items as $key => $item)
                                            <tr id="item-option-row{{ $key }}">
                                                <td>{{ $item->particular }}</td>
                                                <td>₹{{ $item->amount }}</td>
                                                <td>{{ $item->rate }}%</td>
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
    </section>
    <div class="modal fade" id="modal-voucher" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 class="modal-title">Voucher</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($message = Session::get('voucher'))
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    @if ($booking->voucher_generated == 'yes')
                        <a href="{{ route('package-booking.voucher', $booking->id) }}"
                            class="btn btn-warning btn-block">Download Voucher</a>
                        <a href="{{ route('send.voucher', $booking->id) }}" class="btn btn-primary btn-block">Send
                            Voucher</a>
                    @else
                        <a href="{{ route('package-booking.voucher', $booking->id) }}"
                            class="btn btn-info btn-block">Generate Voucher</a>
                    @endif
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modal-permit" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h4 class="modal-title">Permit</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($message = Session::get('permit'))
                        <div class="alert alert-success" role="alert">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('booking.upload-permit', $booking->id) }}" id="permitForm"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="permit">Upload Permit</label>

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="permit" name="permits[]" multiple>
                                <label class="custom-file-label" for="permit"></label>
                            </div>
                            @error('permits')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </form>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Download Permit</h3>
                        </div>
                        <div class="card-body">
                            @if (isset($booking) && count($booking->permits) > 0)
                                @foreach ($booking->permits as $key => $permit)
                                    <div class="col-sm-12 mb-4">
                                        <strong>{{ $permit->permit }}</strong>
                                        <span class="float-right">
                                            <div class="btn-group">
                                                <a href="{{ asset('storage/uploads/bookings/permits/' . $booking->id . '/' . $permit->permit) }}"
                                                    download class="btn btn-dark" data-toggle="tooltip"
                                                    title="Download Permit">
                                                    <i class="fas fa-download"> </i>
                                                </a>
                                                <button type="button" onclick="confirmPermitDelete({{ $permit->id }})"
                                                    class="btn btn-danger" data-toggle="tooltip" title="Delete Permit"><i
                                                        class="fas fa-trash"></i> </button>
                                                <form id='delete-permit-form{{ $permit->id }}'
                                                    action='{{ route('safari-booking.destroy', $permit->id) }}'
                                                    method='POST'>
                                                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                    <input type='hidden' name='_method' value='DELETE'>
                                                </form>
                                            </div>
                                        </span>
                                    </div>
                                    <div class="clearfix"></div>
                                @endforeach
                            @else
                                <p class="text-center"> No Permit found.</p>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" form="permitForm" class="btn btn-primary">Upload</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    @endsection
    @push('scripts')
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript">
            function confirmDelete(no) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form' + no).submit();
                    }
                })
            };
        </script>
        <script type="text/javascript">
            function confirmPermitDelete(no) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-permit-form' + no).submit();
                    }
                })
            };
        </script>
        @error('permits')
            <script>
                $('#modal-permit').modal('show');
            </script>
        @enderror
        @if (Session::has('permit'))
            <script>
                $('#modal-permit').modal('show');
            </script>
        @endif
        @if (Session::has('voucher'))
            <script>
                $('#modal-voucher').modal('show');
            </script>
        @endif
    @endpush
