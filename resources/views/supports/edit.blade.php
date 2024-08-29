@extends('layouts.master')
@section('title', 'Show Ticket')
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
                    <h1><i class="nav-icon fas fa-ticket"></i> Show Ticket</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">

            <div class="card-body">
                <form action="{{ route('support.update', $ticket->id) }}" method="POST" id="ticketForm"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="col-form-label" for="subject">Subject*</label>
                            <input type="text" id="subject" class="form-control" placeholder="Subject" name="subject"
                                value="{{ old('subject', $ticket->subject) }}" readonly>
                            @error('subject')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label" for="description">Description*</label>
                            <textarea type="text" id="description" class="form-control" rows="4"
                                placeholder="Please explain about issue here" name="description" readonly>{{ old('description', $ticket->description) }}</textarea>
                            @error('description')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-3">
                            <label class="col-form-label" for="priority">Priority*</label>
                            <select name="priority" id="priority" class="form-control" disabled>
                                <option value="">Please Select</option>
                                <option value="High" {{ old('priority', $ticket->priority == 'High' ? 'selected' : '') }}>
                                    High</option>
                                <option value="Low" {{ old('priority', $ticket->priority == 'Low' ? 'selected' : '') }}>
                                    Low</option>
                                <option value="Medium"
                                    {{ old('priority', $ticket->priority == 'Medium' ? 'selected' : '') }}>Medium</option>
                            </select>
                            @error('priority')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        @isset($ticket->booking_id)
                            <div class="col-sm-3">
                                <label for="booking_idbooking_id">For Booking</label>
                                <div> <a href="{{ route('bookings.show', $ticket->booking_id) }}" target="_blank" class="btn btn-primary">
                                            Booking id : {{ $ticket->booking_id }} 
                                        </a>
                                </div>

                            </div>
                        @else
                            <div class="col-sm-3">
                                <label for="booking_id">For Booking</label>
                                <input type="text" class="form-control" value="None">
                            </div>
                        @endisset
                        @isset($ticket->attachment)
                            <div class="col-sm-6">
                                <label for="attachment">Attachment</label>

                                <ul class="list-group mt-2">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ $ticket->attachment }}
                                        <a href="{{ asset('storage/uploads/customers/tickets/' . $ticket->customer_id . '/' . $ticket->attachment) }}"
                                            class="btn btn-sm btn-warning" download><i class="fas fa-download"></i></a>
                                    </li>
                                </ul>

                            </div>
                        @else
                            <div class="col-sm-6">
                                <label for="attachment">Attachment</label>
                                <input type="text" class="form-control" value="Not added">
                            </div>
                        @endisset

                        <div class="col-sm-12">
                            <label class="col-form-label" for="status">Status*</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">Please Select</option>
                                <option value="0" {{ old('status', $ticket->status == 0 ? 'selected' : '') }}>Open
                                </option>
                                <option value="1" {{ old('status', $ticket->status == 1 ? 'selected' : '') }}>Close
                                </option>
                            </select>
                            @error('status')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('support.index') }}" class="btn btn-dark mr-1">Back</a>
                <button type="submit" class="btn btn-success" form="ticketForm">Update</button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('layouts.utilities')
@endpush
