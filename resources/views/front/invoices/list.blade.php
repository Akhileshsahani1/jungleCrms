@extends('front.layouts.app')
@section('title', 'Invoices')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="alert alert-danger bg-danger text-white" id="generate-link" role="alert" style="display: none;">
        <strong>No Invoice Selected !</strong> Please select Invoice(s) to Generate Permit link.
    </div>
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
            <div class="card-body">
                @if (count($bookings) > 0)
                    <table id="invoices" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Customer</th>
                                <th>Type</th>
                                <th>Total</th>
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
                                    <td style="font-size:14px;">
                                        {{ isset($booking->customer->name) ? $booking->customer->name : '' }}
                                        <br>
                                        {{ isset($booking->customer->mobile) ? $booking->customer->mobile : '' }}
                                        <br>
                                        {{ isset($booking->customer->email) ? $booking->customer->email : '' }}
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ ucfirst($booking->type) }}</span><br>
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
                                <td>
                                    <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <ul class="dropdown-menu text-center">
                                        <a href="{{ route('dashboard.invoices.show', $booking->id) }}">
                                            <li class="dropdown-item">Performa Invoice</li>
                                        </a>
                                        @foreach ($booking->transactions as $transaction)
                                            <div class="dropdown-divider"></div>
                                            @if ($transaction->invoice_generated == 'yes')
                                                <a href="{{ route('dashboard.tax.invoice', $transaction->id) }}">
                                                    <li class="dropdown-item">
                                                        View Invoice
                                                        {{ count($booking->transactions) > 1 ? $loop->iteration : '' }}
                                                    </li>
                                                </a>
                                                @isset($booking->reason)
                                                    @if ($transaction->credit_note_generated == 'yes')
                                                        <a href="{{ route('dashboard.credit.note', $transaction->id) }}">
                                                            <li class="dropdown-item">
                                                                View Credit Note
                                                                {{ count($booking->transactions) > 1 ? $loop->iteration : '' }}
                                                            </li>
                                                        </a>
                                                    @endif
                                                @endisset
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
@include('layouts.utilities')
<script type="text/javascript">
    function confirmGenerateInvoice(no) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to generate Tax Invoice!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Generate it!'
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '{{ route('tax.invoice', ':id') }}';
                url = url.replace(':id', no);
                location.href = url;
            }
        })
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
