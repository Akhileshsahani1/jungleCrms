@extends('layouts.master')
@section('title', 'Transactions')
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
                    <h1>Transactions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Bookings</a></li>
                        <li class="breadcrumb-item active">Transactions</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button class="btn bg-grey">Total:  ₹{{ $booking->items->sum('amount') }}</button>
                    <button class="btn btn-success">Paid: ₹{{ $booking->transactions->sum('amount') }}</button>
                    <button class="btn bg-orange">Balance: ₹{{ $booking->items->sum('amount') - $booking->transactions->sum('amount') }}</button>
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                    @if($filter_booking_status != 'cancel')
                    <a href="javascript:void(0)" class="btn bg-indigo" data-toggle="modal" data-target="#modal-transaction">Add</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Payment Mode</th>
                            <th>Transaction Id</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d-m-Y') }}</td>
                                <td>₹{{ $transaction->amount }}</td>
                                <td>{{ ucfirst($transaction->mode) }}</td>
                                <td>{{ $transaction->transaction_id }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" class="btn btn-warning edit-transaction" data-toggle="modal" data-target="#modal-edit-transaction" data-id="{{ $transaction->id }}" data-date="{{ $transaction->date }}" data-amount="{{ $transaction->amount }}" data-mode="{{ $transaction->mode }}" data-transaction="{{ $transaction->transaction_id }}"><i class="fas fa-pen"></i></a>
                                        <button type="button" onclick="confirmDelete({{ $transaction->id }})"
                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                        <form id='delete-form{{ $transaction->id }}'
                                            action='{{ route('booking-transactions.destroy', $transaction->id) }}' method='POST'>
                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                            <input type='hidden' name='_method' value='DELETE'>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                 @if($filter_booking_status == 'cancel')
                 <hr stye="width="100%">
                 <h4 style="float:left;">Refund Transaction</h4>
                 @if($cancel_req)
                 <a href="javascript:void(0)" class="btn bg-indigo" data-toggle="modal" data-target="#modal-refund-transaction" style="margin:10px;float:right;"> Add Refund</a>
                 @endif
                <table class="table table-bordered table-striped" style="margin-top: 10px;">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Payment Mode</th>
                            <th>Transaction Id</th>
                            <th>Attachment</th>
                             <th>Note</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($refund_transactions as $transaction)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d-m-Y') }}</td>
                                <td>₹{{ $transaction->amount }}</td>
                                <td>{{ ucfirst($transaction->mode) }}</td>
                                <td>{{ $transaction->transaction_id }}</td>
                                 @isset($transaction->attachment)
                                    <td>
                                          {{ $transaction->attachment }}      
                                        <a href="{{ asset('storage/uploads/bookings/refund/' . $transaction->booking_id . '/' . $transaction->attachment) }}"
                                                    class="btn btn-sm btn-warning" download><i class="fas fa-download"></i></a>
                                    </td>
                                @else
                                    <td>N/A</td>
                                @endisset
                                <td>{{ $transaction->note }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" class="btn btn-warning edit-refund-transaction" data-toggle="modal" data-target="#modal-edit-refund-transaction" data-id="{{ $transaction->id }}" data-date="{{ $transaction->date }}" data-amount="{{ $transaction->amount }}" data-mode="{{ $transaction->mode }}" data-transaction="{{ $transaction->transaction_id }}" data-note="{{ $transaction->note }}"><i class="fas fa-pen"></i></a>
                                        <button type="button" onclick="confirmDelete({{ $transaction->id }})"
                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                        <form id='delete-form{{ $transaction->id }}'
                                            action='{{ route('booking-refund-transactions.destroy', $transaction->id) }}' method='POST'>
                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                            <input type='hidden' name='_method' value='DELETE'>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-transaction">
        <div class="modal-dialog modal-transaction">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Transaction</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="transactionForm" action="{{ route('booking-transactions.store') }}">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control" placeholder="Date" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter Amount" value="{{ $booking->items->sum('amount') - $booking->transactions->sum('amount') }}"  required>
                        </div>
                        <div class="form-group">
                            <label for="mode">Payment Mode</label>
                            <input type="text" name="mode" id="mode" class="form-control" placeholder="Enter Payment Mode"  required>
                        </div>
                        <div class="form-group">
                            <label for="transaction_id">Transaction ID</label>
                            <input type="text" name="transaction_id" id="transaction_id" class="form-control" placeholder="Enter Transaction ID"  required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="transactionForm">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-transaction">
        <div class="modal-dialog modal-edit-transaction">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Transaction</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updatetransactionForm" action="{{ route('booking-transactions.store') }}">
                        @csrf
                        <input type="hidden" value="" name="id" id="transction_id">
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <div class="form-group">
                            <label for="edit_date">Date</label>
                            <input type="date" name="date" id="edit_date" class="form-control" placeholder="Date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_amount">Amount</label>
                            <input type="number" name="amount" id="edit_amount" class="form-control" placeholder="Enter Amount"  required>
                        </div>
                        <div class="form-group">
                            <label for="edit_mode">Payment Mode</label>
                            <input type="text" name="mode" id="edit_mode" class="form-control" placeholder="Enter Payment Mode"  required>
                        </div>
                        <div class="form-group">
                            <label for="edit_transaction_id">Transaction ID</label>
                            <input type="text" name="transaction_id" id="edit_transaction_id" class="form-control" placeholder="Enter Transaction ID"  required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="updatetransactionForm">Update</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-refund-transaction">
        <div class="modal-dialog modal-transaction">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Refund Transaction</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="refundtransactionForm" action="{{ route('booking-refund-transactions.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                         <input type="hidden" name="cancel_id" value="{{ ($cancel_req)?$cancel_req->id:0 }}">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control" placeholder="Date" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter Amount" value="{{ ($cancel_req)?$cancel_req->approval_amount:0 }}"  required readonly>
                        </div>
                        <div class="form-group">
                            <label for="mode">Payment Mode</label>
                            <input type="text" name="mode" id="mode" class="form-control" placeholder="Enter Payment Mode"  required>
                        </div>
                        <div class="form-group">
                            <label for="transaction_id">Transaction ID</label>
                            <input type="text" name="transaction_id" id="transaction_id" class="form-control" placeholder="Enter Transaction ID"  required>
                        </div>
                        <div class="form-group">
                            <label for="attachment">Attachment</label>
                            <input type="file" name="attachment" id="attachment" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label for="transaction_id">Note</label>
                            <textarea  name="note" id="note" class="form-control" placeholder="Enter Note">
                            </textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="refundtransactionForm">Save</button>
                </div>
            </div>
        </div>
    </div>
     <div class="modal fade" id="modal-edit-refund-transaction">
        <div class="modal-dialog modal-edit-transaction">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Refund</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updaterefundtransactionForm" action="{{ route('booking-refund-transactions.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="" name="id" id="edit_refund_id">
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <div class="form-group">
                            <label for="edit_date">Date</label>
                            <input type="date" name="date" id="edit_refund_date" class="form-control" placeholder="Date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_amount">Amount</label>
                            <input type="number" name="amount" id="edit_refund_amount" class="form-control" placeholder="Enter Amount"  required>
                        </div>
                        <div class="form-group">
                            <label for="edit_mode">Payment Mode</label>
                            <input type="text" name="mode" id="edit_refund_mode" class="form-control" placeholder="Enter Payment Mode"  required>
                        </div>
                        <div class="form-group">
                            <label for="edit_transaction_id">Transaction ID</label>
                            <input type="text" name="transaction_id" id="edit_refund_transaction_id" class="form-control" placeholder="Enter Transaction ID"  required>
                        </div>
                         <div class="form-group">
                            <label for="attachment">Attachment</label>
                            <input type="file" name="attachment" id="attachment" class="form-control" >
                        </div>
                         <div class="form-group">
                            <label for="transaction_id">Note</label>
                            <textarea  name="note" id="edit_note" class="form-control" placeholder="Enter Note">
                            </textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="updaterefundtransactionForm">Update</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @include('layouts.utilities')
    <script>
        $(".edit-transaction").click(function () {
                var id = $(this).data('id');
                var date = $(this).data('date');
                var amount = $(this).data('amount');
                var mode = $(this).data('mode');
                var transaction = $(this).data('transaction');

                $('#edit_date').val(date);
                $("#edit_amount").val(amount).change();
                $('#edit_mode').val(mode);
                $('#edit_transaction_id').val(transaction);
                $('#transction_id').val(id);
            });
        $(".edit-refund-transaction").click(function () {
                var id = $(this).data('id');
                var date = $(this).data('date');
                var amount = $(this).data('amount');
                var mode = $(this).data('mode');
                var transaction = $(this).data('transaction');
                var note = $(this).data('note');

                $('#edit_refund_date').val(date);
                $("#edit_refund_amount").val(amount).change();
                $('#edit_refund_mode').val(mode);
                $('#edit_refund_transaction_id').val(transaction);
                $('#edit_refund_id').val(id);
                $('#edit_note').text(note);
            });

    </script>
@endpush
