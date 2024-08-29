@extends('layouts.master')
@section('title', 'Show Safari Booking')
@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><i class="fab fa-safari"></i> Safari Booking </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Bookings</a></li>
                    <li class="breadcrumb-item active">Show Safari Booking</li>
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
                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-permit">
                    Permit
                </button>
                <div class="btn-group">
                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-dark" data-toggle="tooltip" title="Edit Booking"> <i class="fas fa-pen"></i> </a>
                    <button type="button" onclick="confirmDelete({{ $booking->id }})" class="btn btn-danger" data-toggle="tooltip" title="Delete Booking"><i class="fas fa-trash"></i> </button>
                    <form id='delete-form{{ $booking->id }}' action='{{ route('bookings.destroy', $booking->id) }}' method='POST'>
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
                    <div class="card-header bg-brown">
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
                                    <td class="text-right"> {{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</td>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-header bg-brown">
                        <h3 class="card-title">Safari Details</h3>
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
                                    @elseif($booking->safari->sanctuary == 'tadoba')
                                    <td class="text-right">Tadoba National Park</td>
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
                                        {{ \Carbon\Carbon::parse($booking->safari->date)->format('d-m-Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Safari Time</td>
                                    <td class="text-right">
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
                                    <td>Website</td>
                                    <td class="text-right">{{ $booking->website }}</td>
                                </tr>
                                <tr>
                                    <td>Total Amount</td>
                                    <td class="text-right">₹{{ $booking->safari->amount }}</td>
                                </tr>
                                <tr>
                                    <td>Safari Due Amount</td>
                                    <td class="text-right">₹{{ $booking->safari->safari_due_amount }}</td>
                                </tr>
                                <tr>
                                    <td>Vendor</td>
                                    <td class="text-right">{{ isset($booking->safari->vendor) ? \App\Models\Vendor::find($booking->safari->vendor)->name : '' }}</td>
                                </tr>
                                <tr>
                                    <td>Note</td>
                                    <td>{!! $booking->safari->note !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-header bg-brown">
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
                    <div class="card-header bg-brown">
                        <h3 class="card-title">Booked Customers</h3>
                    </div>
                    <div class="card-body">
                        @isset($booking->image)
                        <a href={{ asset('storage/uploads/bookings/customers/'.$booking->id.'/'.$booking->image) }} class="mb-2 input-group-text" download><i class="fa fa-download mr-1"></i> Download 1st Member Image</a>
                        @endisset
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
                                @if (isset($booking) && count($booking->customer_details) > 0)
                                @foreach ($booking->customer_details as $key => $detail)

                                <tr id="item-option-row{{ $key }}" @if( isset($cancel->members) && in_array($detail->name, array_column($cancel->members->toArray(), 'name') )) style="background-color:#a52a2a42;" @endif>
                                    <td><input type="checkbox" id="customer_{{ $key }}" name="customer[]" class="select_customers"></td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $detail->name }}</td>
                                    <td>{{ $detail->age }}</td>
                                    <td>{{ $detail->gender }}</td>
                                    <td>{{ $detail->nationality }}</td>
                                    <td>{{ ($detail->state)? $detail->state : $booking->customer->state }}</td>
                                    <td>{{ $detail->idproof }}</td>
                                    <td>{{ $detail->idproof_no }}</td>
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
                <a href="{{ route('safari-booking.voucher', $booking->id) }}" class="btn btn-warning btn-block">Download Voucher</a>
                <a href="{{ route('send.voucher', $booking->id) }}" class="btn btn-primary btn-block">Send Voucher</a>
                <a href="{{ route('bookings.send-voucher-link', $booking->id) }}" class="btn btn-primary btn-block">Copy Link</a>
                @else
                <a href="{{ route('safari-booking.voucher', $booking->id) }}" class="btn btn-info btn-block">Generate Voucher</a>
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
                <form method="POST" action="{{ route('booking.upload-permit', $booking->id) }}" id="permitForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="permit">Upload Permit</label>

                        <div class="custom-file">
                            <input type="file" id="permit" name="permits[]" multiple>
                            <label class="" for="permit"></label>
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
                                    <a href="{{ asset('storage/uploads/bookings/permits/' . $booking->id . '/' . $permit->permit) }}" download class="btn btn-dark" data-toggle="tooltip" title="Download Permit">
                                        <i class="fas fa-download"> </i>
                                    </a>
                                    <button type="button" onclick="confirmPermitDelete({{ $permit->id }})" class="btn btn-danger" data-toggle="tooltip" title="Delete Permit"><i class="fas fa-trash"></i> </button>
                                    <form id='delete-permit-form{{ $permit->id }}' action='{{ route('safari-booking.destroy', $permit->id) }}' method='POST'>
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
    <script>
        $('#select_all').change(function() {
            if (this.checked) {
                $('.select_customers').prop("checked", true);
            } else {
                $('.select_customers').prop("checked", false);
            }
        });
    </script>
    @endpush