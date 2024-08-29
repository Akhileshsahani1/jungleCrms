@extends('layouts.master')
@section('title', 'Show Hotel Booking')
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
                    <h1><i class="fas fa-hotel"></i> Hotel Booking </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Bookings</a></li>
                        <li class="breadcrumb-item active">Show Hotel Booking</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <p class="card-title text-info">{{ $hotel->name }}</p>
                <div class="card-tools">
                     <a href="{{ route('trash-bookings.index') }}" class="btn btn-warning">
                        Back</a>
                   
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header bg-orange">
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
                        <div class="card-header bg-orange">
                            <h3 class="card-title">Booking Details</h3>
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
                                        <td>Check In</td>
                                        <td class="text-right">
                                            {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Check Out</td>
                                        <td class="text-right">{{ \Carbon\Carbon::parse($booking->hotel->check_out)->format('d-m-Y') }}</td>
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
                                        <td class="text-right">{{ \App\Models\HotelRoom::find($booking->hotel->room_id)->value('room') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Service</td>
                                        <td class="text-right">{{ \App\Models\HotelRoomService::find($booking->hotel->service_id)->value('service') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Package Amount</td>
                                        <td class="text-right">₹{{ $booking->hotel->amount }}</td>
                                    </tr>
                                    <tr>
                                        <td>Hotel Due Amount</td>
                                        <td class="text-right">₹{{ $booking->hotel->hotel_due_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td>Note</td>
                                        <td>{!! $booking->hotel->note !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-header bg-orange">
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
                    <div class="col-md-6">
                        <div class="card-header bg-orange">
                            <h3 class="card-title">Hotel Details</h3>
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach ($hotel->images as $key => $image)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"
                                        @if ($loop->first) class="active" @endif></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach ($hotel->images as $image)
                                    <div class="carousel-item  @if ($loop->first) active @endif">
                                        <img class="d-block w-100" src="{{ $image->path }}" alt="{{ $image->image }}"
                                            width="514" height="343">
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
                                    <h3 class="card-title" style="color: #6610f2;">{{ $room->room }}</h3>
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
                                                    <td>{{ $service->service }} @if($service->id == $booking->hotel->service_id)<br><span class="badge bg-success">Selected</span>@endif</td>
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
                    @if($booking->voucher_generated == 'yes')
                    <a href="{{ route('hotel-booking.voucher', $booking->id) }}" class="btn btn-warning btn-block" >Download Voucher</a>
                    <a href="{{ route('send.voucher', $booking->id) }}" class="btn btn-primary btn-block" >Send Voucher</a>
                    <a href="{{ route('bookings.send-voucher-link', $booking->id) }}" class="btn btn-primary btn-block" >Copy Link</a>
                    @else
                    <a href="{{ route('hotel-booking.voucher', $booking->id) }}" class="btn btn-info btn-block" >Generate Voucher</a>
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
     @if (Session::has('voucher'))
     <script>
         $('#modal-voucher').modal('show');
     </script>
 @endif
@endpush
