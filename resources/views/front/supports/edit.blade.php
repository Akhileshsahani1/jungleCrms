@extends('front.layouts.app')
@section('title', 'Edit Ticket')
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
                    <h1><i class="nav-icon fas fa-ticket"></i> Edit Ticket</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
           
            <div class="card-body">
                <form action="{{ route('dashboard.supports.update', $ticket->id) }}" method="POST" id="ticketForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="col-form-label" for="subject">Subject*</label>
                            <input type="text" id="subject" class="form-control" placeholder="Subject"
                                    name="subject" value="{{ old('subject', $ticket->subject) }}">
                            @error('subject')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label" for="description">Description*</label>
                            <textarea type="text" id="description" class="form-control" rows="4" placeholder="Please explain about issue here"
                            name="description">{{ old('description', $ticket->description) }}</textarea>
                            @error('description')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-3">
                            <label class="col-form-label" for="priority">Priority*</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="">Please Select</option>
                                <option value="High" {{ old('priority', $ticket->priority == 'High' ? 'selected' : '')  }}>High</option>
                                <option value="Low" {{ old('priority', $ticket->priority == 'Low' ? 'selected' : '')  }}>Low</option>
                                <option value="Medium" {{ old('priority', $ticket->priority == 'Medium' ? 'selected' : '')  }}>Medium</option>
                            </select>
                            @error('priority')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-3">
                            <label for="booking_id">For Booking (Optional)</label>
                            <select name="booking_id" id="booking_id" class="form-control">
                                <option value="">Please Select Booking</option>
                                @foreach($bookings as $booking)
                                <option value="{{ $booking->id }}" {{ old('booking_id', $ticket->booking_id == $booking->id ? 'selected' : '')  }}>Id-{{ $booking->id }},Booking Date {{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</option>
                                @endforeach
                                
                            </select>
                            @error('booking_id')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="attachment">Attachment</label>
                            <input type="file" class="form-control" name="attachment" id="attachment">
                            @error('attachment')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                            @isset($ticket->attachment)
                            <ul class="list-group mt-2">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $ticket->attachment }}
                                    <a href="{{ asset('storage/uploads/customers/tickets/'.Auth::guard('customer')->user()->id.'/'.$ticket->attachment) }}" class="btn btn-sm btn-warning" download><i class="fas fa-download"></i></a>
                                </li>
                            </ul>
                            @endisset
                        </div>
                       
                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('dashboard.supports.index') }}" class="btn btn-dark mr-1">Back</a>
                <button type="submit" class="btn btn-success" form="ticketForm">update</button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('layouts.utilities')
@endpush
