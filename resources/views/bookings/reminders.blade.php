@extends('layouts.master')
@section('title', 'Reminders')
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
                    <h1>Reminders</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('bookings.index') }}">Bookings</a></li>
                        <li class="breadcrumb-item active">Reminders</li>
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
                    <a href="javascript:void(0)" class="btn bg-indigo" data-toggle="modal" data-target="#modal-reminder">Add</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reminders as $reminder)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($reminder->date)->format('d-m-Y') }}</td>
                                <td>₹{{ $reminder->amount }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="javascript:void(0)" class="btn btn-warning edit-reminder" data-toggle="modal" data-target="#modal-edit-reminder" data-id="{{ $reminder->id }}" data-date="{{ $reminder->date }}" data-amount="{{ $reminder->amount }}" ><i class="fas fa-pen"></i></a>
                                        <button type="button" onclick="confirmDelete({{ $reminder->id }})"
                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                        <form id='delete-form{{ $reminder->id }}'
                                            action='{{ route('booking-reminders.destroy', $reminder->id) }}' method='POST'>
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
    <div class="modal fade" id="modal-reminder">
        <div class="modal-dialog modal-reminder">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add reminder</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="reminderForm" action="{{ route('booking-reminders.store') }}">
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
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="reminderForm">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-reminder">
        <div class="modal-dialog modal-edit-reminder">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit reminder</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updatereminderForm" action="{{ route('booking-reminders.store') }}">
                        @csrf
                        <input type="hidden" value="" name="id" id="reminder_id">
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <div class="form-group">
                            <label for="edit_date">Date</label>
                            <input type="date" name="date" id="edit_date" class="form-control" placeholder="Date" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_amount">Amount</label>
                            <input type="number" name="amount" id="edit_amount" class="form-control" placeholder="Enter Amount"  required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="updatereminderForm">Update</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @include('layouts.utilities')
    <script>
        $(".edit-reminder").click(function () {
                var id = $(this).data('id');
                var date = $(this).data('date');
                var amount = $(this).data('amount');

                $('#edit_date').val(date);
                $("#edit_amount").val(amount).change();
                $('#reminder_id').val(id);
            });

    </script>
@endpush
