@extends('front.layouts.app')
@section('title', 'New Ticket')
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
                    <h1><i class="nav-icon fas fa-ticket"></i> New Ticket</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">

            <div class="card-body">
                <form action="{{ route('dashboard.supports.store') }}" method="POST" id="ticketForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="col-form-label" for="subject">Subject*</label>
                            <input type="text" id="subject" class="form-control" placeholder="Subject" name="subject"
                                value="{{ ($booking_id)?'Modify Booking Request ':old('subject') }}" {{ ($booking_id)?'Readonly':''  }}>
                            @error('subject')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label" for="description">Description*</label>
                            <textarea type="text" id="description" class="form-control" rows="4"
                                placeholder="Please explain about issue here" name="description" value="{{ old('description') }}"></textarea>
                            @error('description')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>                        
                        <div class="col-sm-3">
                            <label for="priority">Priority</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="">Please Select</option>
                                <option value="High">High</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
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
                                <option value="{{ $booking->id }}" @if($booking->id == $booking_id ) selected @endif>Id-{{ $booking->id }},Booking Date {{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</option>
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
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="ticketForm">Submit</button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('layouts.utilities')
@endpush
