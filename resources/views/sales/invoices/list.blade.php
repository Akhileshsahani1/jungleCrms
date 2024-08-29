@extends('layouts.master')
@section('title', 'Invoices')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="alert alert-danger bg-danger text-white" id="generate-link" role="alert" style="display: none;">
        <strong>No Invoice Selected !</strong> Please select Invoice(s) to Generate Permit link.
    </div>
    @if ($message = Session::get('success'))

        <strong>{{ $message }}</strong>

    @endif
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-check-circle"></i> Invoices</h1>
                </div>
                {{-- <div class="col-sm-6 text-right">
                    <button class="btn btn-warning" type="button" onclick="generatePInvoice();">Generate Invoice</button>
                </div> --}}
            </div>
        </div>
    </section>

    <section class="content">

        <div class="card">
            <div class="card-header">
                @include('sales.invoices.filter')
            </div>
            <div class="card-body">
                @if (count($bookings) > 0)
                    <table id="invoices" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Id</th>
                                <th>Customer</th>
                                <th>Mobile</th>
                                <th>Type</th>
                                <th>Total</th>
                                <th>Website</th>
                                <th>Invoice</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                @php
                                    $booking_type = bookingType($booking->id);
                                @endphp
                                <tr>
                                    <td><input type="checkbox" name="checkbox" id="{{ $booking->id }}" class="checkbox"
                                            value="{{ $booking->id }}" @if (count($booking->permits) < 1) disabled @endif>
                                    </td>
                                    <td>{{ $booking->id }}</td>
                                    <td style="font-size:14px;">{{ $booking->customer->name }}</td>
                                    <td style="font-size:14px;">{{ $booking->customer->mobile }}</td>
                                    <td>

                                        <span class="badge bg-danger">{{ ucfirst($booking->type) }}</span><br>
                                        @if ($booking->source == 'custom')

                                            <span class="badge bg-grey">{{ ucfirst($booking->source) }}</span>
                                        @elseif($booking->source == 'direct')
                                            <span class="badge bg-indigo">{{ ucfirst($booking->source) }}</span>
                                        @else
                                            <span class="badge bg-dark">{{ ucfirst($booking->source) }}</span>
                                        @endif
                                        <br>
                                        @isset($booking->reason)
                                            <span class="badge bg-orange">Cancel</span><br>
                                        @else
                                            <span class="badge bg-orange">Booked</span><br>
                                        @endisset
                                    </td>

                                    <td style="font-size:14px;">₹ {{ $booking->items->sum('amount') }}<br>
                                        @if ($booking->transactions->sum('amount') > 0)

                                            @if ($booking->transactions->sum('amount') >= $booking->items->sum('amount'))
                                                <span class="badge bg-success">Paid</span><br>
                                            @else
                                                <span class="badge bg-warning">Partial</span><br>
                                            @endif
                                        @else
                                            <span class="badge bg-indigo">Unpaid</span><br>
                                        @endisset
                                </td>
                                <td style="font-size:14px;">
                                    <span class="badge badge-primary">{{ $booking->website ?? 'N/A' }} </span>
                                </td>
                                <td>
                                    @foreach ($booking->transactions as $transaction)
                                        @if ($transaction->invoice_generated == 'yes')
                                            <a href="{{ route('download.invoice', $transaction->id) }}">
                                                <li class="dropdown-item">
                                                    <span class="badge badge-success">Invoice
                                                        {{ count($booking->transactions) > 1 ? $loop->iteration : '' }}
                                                        Generated</span>
                                                </li>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)"
                                                onclick="confirmGenerateInvoice({{ $transaction->id }});">
                                                <li class="dropdown-item">
                                                    <span class="badge badge-secondary">Invoice
                                                        {{ count($booking->transactions) > 1 ? $loop->iteration : '' }}
                                                        Pending</span>
                                                </li>
                                            </a>

                                            {{-- <a href="javascript:void(0)" class="btn bg-indigo" onclick="confirmGenerateInvoice('{{$transaction->id}}')">Add</a> --}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <ul class="dropdown-menu text-center">
                                        <a href="{{ route('bookings.edit', $booking->id) }}">
                                            <li class="dropdown-item">Edit</li>
                                        </a>
                                        <a href="{{ route('invoices.show', $booking->id) }}">
                                            <li class="dropdown-item">Performa Invoice</li>
                                        </a>
                                        {{-- download.invoice --}}
                                        {{-- tax.invoice --}}
                                        {{-- @if ($booking->invoice_generated == 'no')
                                        @if ($booking->transactions->sum('amount') >= $booking->items->sum('amount'))
                                        <a href="javascript:void(0)" onclick="confirmGenerateInvoice({{ $booking->id }});">
                                            <li class="dropdown-item">Generate Invoice</li>
                                        </a>
                                        @endif
                                        @else
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('tax.invoice', $booking->id) }}">
                                            <li class="dropdown-item">View Invoice</li>
                                        </a>
                                        @endif --}}
                                        @foreach ($booking->transactions as $transaction)
                                            <div class="dropdown-divider"></div>
                                            @if ($transaction->invoice_generated == 'yes')
                                                <a href="{{ route('Printinvoice', $transaction->id) }}">
                                                    <li class="dropdown-item">
                                                        View Invoice
                                                        {{ count($booking->transactions) > 1 ? $loop->iteration : '' }}
                                                    </li>
                                                </a>
                                                @isset($booking->reason)
                                                    @if ($transaction->credit_note_generated == 'no')
                                                        <a href="javascript:void(0)"
                                                            onclick="confirmGenerateNote({{ $transaction->id }});">
                                                            <li class="dropdown-item">
                                                                Generate Credit Note
                                                                {{ count($booking->transactions) > 1 ? $loop->iteration : '' }}
                                                            </li>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('credit.note', $transaction->id) }}">
                                                            <li class="dropdown-item">
                                                                View Credit Note
                                                                {{ count($booking->transactions) > 1 ? $loop->iteration : '' }}
                                                            </li>
                                                        </a>
                                                    @endif
                                                @endisset
                                            @else
                                                <a href="javascript:void(0)"
                                                    onclick="confirmGenerateInvoice({{ $transaction->id }});">
                                                    <li class="dropdown-item">
                                                        Generate Invoice
                                                        {{ count($booking->transactions) > 1 ? $loop->iteration : '' }}
                                                    </li>
                                                </a>
                                            @endif
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">No Invoice found.</p>
            @endif
        </div>
        <div class="mt-2">
            {{ $bookings->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </div>
</section>



@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
@include('layouts.utilities')

 <script type="text/javascript">

    function confirmGenerateInvoice (no) {

            const inputOptions = new Promise((resolve) => {
        setTimeout(() => {
            resolve({
                '1': 'Select Non-Taxable Invoice',
                // '2': 'Green'
            });
        }, 1000);
    });

    Swal.fire({
        // title: 'Are you sure?',
        input: 'radio',
        text: "You want to generate Invoice!",
        icon: 'warning',
        inputOptions: inputOptions,
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Generate it!',
        preConfirm: () => {
            const selectedValue = $('input[name="swal2-radio"]:checked').val();
            if (selectedValue === '1' || selectedValue === '2') {
                return selectedValue;
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show a new Swal instance with a text input based on the selected radio button
            const selectedValue = result.value;
            console.log('selectedValue',selectedValue)
            if(selectedValue){
                Swal.fire({
                    title: 'Are you sure?',
                    input: 'text',
                    inputPlaceholder: `Enter ${selectedValue === '1' ? 'amount' : 'color'}`,
                    text: "You want to generate Tax Invoice!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Generate it!',
                }).then((textResult) => {
                    if (textResult.isConfirmed) {
                        const inputValue = textResult.value;
                        console.log('Selected Value:', selectedValue);
                        console.log('Entered Value:', inputValue);
                        // Add your logic to handle the selected and entered values
                        var url = '{{ route('tax.invoice', ':id') }}';
                        url = url.replace(':id', no);
                        url = url +'?inputValue='+inputValue
                        location.href = url;
                        // console.log('var url', url);
                    }
                });
            }else{
                if (result.isConfirmed) {
                    var url = '{{ route('tax.invoice', ':id') }}';
                    url = url.replace(':id', no);
                    location.href = url;
                }
            }
        }
    });


    };
</script>


<script type="text/javascript">
    function confirmGenerateNote(no) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to generate Credit Note!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Generate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '{{ route('credit.note', ':id') }}';
                url = url.replace(':id', no);
                location.href = url;
            }
        })
    };
</script>
@endpush
