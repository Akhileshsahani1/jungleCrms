@extends('layouts.master')
@section('title', 'Show Cab Booking')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-taxi"></i> Cab Booking </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Bookings</a></li>
                        <li class="breadcrumb-item active">Show Cab Booking</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@php
$cancellation_exists = App\Models\BookingCancellationRequest::where('booking_id', $booking->id)->where('cancel_status','Cancel')->exists();
@endphp
    <section class="content">
        <div class="card">
            <div class="card-header">
            @if( $booking->status == 0)
            <button class="btn btn-danger">Cancellation Request </button>
            @endif
                <div class="card-tools">
                     <a href="{{ route('booking-reminders.index', array_merge(\Request::query(), ['booking_id' => $booking->id])) }}" class="btn btn-warning">
                        Reminders</a>
                    <a href="{{ route('booking-transactions.index', array_merge(\Request::query(), ['booking_id' => $booking->id])) }}" class="btn btn-secondary">
                        Transactions</a>
                    <a href="{{ route('invoices.show', $booking->id) }}" class="btn bg-orange">
                            Invoices</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-voucher">
                        Voucher
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
                    @if( $cancellation_exists )
                    <div class="text-center m-2">
                        <button class="btn btn-danger">Full Booking Cancellation Request </button>
                    </div>
                    @endif
                        <div class="card-header bg-warning">
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
                        <div class="card-header bg-warning">
                            <h3 class="card-title">Trip Details</h3>
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
                                        <td class="text-right">{{ ucfirst($booking->cab->pickup_medium) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Vehicle</td>
                                        <td class="text-right">{{ $booking->cab->vehicle_type }}</td>
                                    </tr>
                                    <tr>
                                        <td>Journey Start Date</td>
                                        <td class="text-right">
                                            {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pickup Point</td>
                                        <td class="text-right">{{ $booking->cab->pick_up }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pickup Time</td>
                                        <td class="text-right">{{ \Carbon\Carbon::parse($booking->cab->pickup_time)->format('g:i A'); }}</td>
                                    </tr>
                                    <tr>
                                        <td>Journey End Date</td>
                                        <td class="text-right">
                                            {{ \Carbon\Carbon::parse($booking->cab->end_date)->format('d-m-Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td>Drop Point</td>
                                        <td class="text-right">{{ $booking->cab->drop }}</td>
                                    </tr> 
                                    <tr>
                                        <td>No. of Days</td>
                                        <td class="text-right">{{ $booking->cab->days }}</td>
                                    </tr>
                                                                                                          
                                    <tr>
                                        <td>No. of Riders</td>
                                        <td class="text-right">{{ $booking->cab->total_riders }}</td>
                                    </tr>
                                    <tr>
                                        <td>No. of Cabs</td>
                                        <td class="text-right">{{ $booking->cab->no_of_cab }}</td>
                                    </tr>
                                     <tr>
                                        <td>Contact Person</td>
                                        <td class="text-right">{{ $booking->cab->vendor_name }}</td>
                                    </tr>
                                     <tr>
                                        <td>Contact Person No.</td>
                                        <td class="text-right">{{ $booking->cab->vendor_mobile }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Amount</td>
                                        <td class="text-right">₹{{ $booking->cab->amount }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cab Due Amount</td>
                                        <td class="text-right">₹{{ $booking->cab->cab_due_amount }}</td>
                                    </tr>
                                    <tr>
                                        <td>Note</td>
                                        <td>{!! $booking->cab->note !!}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="card-header bg-warning">
                            <h3 class="card-title">Cab Halts</h3>
                        </div>
                        <div class="card-body">
                            @if (isset($booking->cab->halts) && count($booking->cab->halts) > 0)
                                <table id="halts" class="table table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Halt Destination</th>
                                            <th>Starts from</th>
                                            <th>Ends on</th>                                        
                                        </tr>
                                    </thead>
                                    <tbody>                                    
                                        @foreach ($booking->cab->halts as $key => $halt)                                        
                                                <tr>
                                                    <td>{{ $halt->halt }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($halt->start)->format('d-m-Y') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($halt->end)->format('d-m-Y') }}</td>
                                                </tr>                                        
                                            @endforeach                                   
                                    </tbody>
                                </table>
                                @else
                                <p class="text-center mt-5 mb-5">No Halts found</p>
                            @endif
                        </div>

                        <div class="card-header bg-warning">
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
                    @if($booking->voucher_generated == 'yes')
                    <a href="{{ route('cab-booking.voucher', $booking->id) }}" class="btn btn-warning btn-block" >Download Voucher</a>
                    <a href="{{ route('send.voucher', $booking->id) }}" class="btn btn-primary btn-block" >Send Voucher</a>
                    @else
                    <a href="{{ route('cab-booking.voucher', $booking->id) }}" class="btn btn-warning btn-block" >Generate Voucher</a>
                    <!-- <form action="{{ route('cab-booking.voucher', $booking->id) }}" method="post"> @csrf
                        <div class="form-group">
                     <label>Contact Person Name</label><input type="text" name="contact_person_name" class="form-control" required>
                 </div>
                     <div class="form-group">
                     <label>Contact Person Number</label><input type="text" name="contact_person_number" class="form-control" required></div>
                     <button type="submit" class="btn btn-info btn-block">Generate Voucher</button>
                    </form> -->
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
