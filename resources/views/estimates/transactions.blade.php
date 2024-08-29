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
                        <li class="breadcrumb-item"><a href="{{ route('estimates.index') }}">Estimates</a></li>
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
                    <button class="btn bg-grey">Total:  ₹{{ $estimate->total }}</button>
                    <button class="btn btn-success">Paid: ₹{{ $estimate->transactions->sum('amount') }}</button>
                    <button class="btn bg-orange">Balance: ₹{{ $estimate->total - $estimate->transactions->sum('amount') }}</button>
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                    <a href="javascript:void(0)" class="btn bg-indigo" data-toggle="modal" data-target="#modal-transaction">Add</a>
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
                                            action='{{ route('estimate-transactions.destroy', $transaction->id) }}' method='POST'>
                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                            <input type='hidden' name='_method' value='DELETE'>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
                    <form method="POST" id="transactionForm" action="{{ route('estimate-transactions.store') }}">
                        @csrf
                        <input type="hidden" name="estimate_id" value="{{ $estimate->id }}">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" id="date" class="form-control" placeholder="Date" required>
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter Amount" value="{{ $estimate->total - $estimate->transactions->sum('amount') }}"  required>
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
                    <form method="POST" id="updatetransactionForm" action="{{ route('estimate-transactions.store') }}">
                        @csrf
                        <input type="hidden" value="" name="id" id="transction_id">
                        <input type="hidden" name="estimate_id" value="{{ $estimate->id }}">
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
    </script>
@endpush
