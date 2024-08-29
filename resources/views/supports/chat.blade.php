@extends('layouts.master')
@section('title', 'Chat')
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
                    <h1><i class="nav-icon fas fa-ticket"></i> Chat</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card mb-5">
            <div class="card-header">
                <h3 class="card-title">Ticket Details
                </h3>
            </div>

            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-4">Subject</dt>
                    <dd class="col-sm-8">{{ $ticket->subject }}</dd>
                    <dt class="col-sm-4">Description</dt>
                    <dd class="col-sm-8">{{ $ticket->description }}</dd>
                    <dt class="col-sm-4">Priority</dt>
                    <dd class="col-sm-8">{{ $ticket->priority }}</dd>
                    <dt class="col-sm-4">For Booking</dt>
                    @if($ticket->booking_id)
                    <dd class="col-sm-8"><a href="{{ route('bookings.show', $ticket->booking_id) }}" target="_blank" class="btn btn-primary"> Booking Id : {{ $ticket->booking_id }} </a></dd>
                    @else
                    <dd class="col-sm-8">None</dd>
                    @endif
                    <dt class="col-sm-4">Status</dt>
                    @if ($ticket->status == 0)
                        <dt class="col-sm-8"><button class="btn btn-sm bg-success">Open</button></dt>
                    @else
                        <dt class="col-sm-8"><button class="btn btn-sm bg-danger">Closed</button></dt>
                    @endif
                </dl>
            </div>

        </div>
        <div class="card card-primary card-outline direct-chat direct-chat-primary">
            <div class="card-header">
                <h3 class="card-title">Direct Chat</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>

            <div class="card-body">

                <div class="direct-chat-messages">

                    @forelse ($ticket->chats as $chat)
                        @if ($chat->sender == 'admin')
                            <div class="direct-chat-msg right">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-right">Support Team</span>
                                    <span class="direct-chat-timestamp float-left">{{ \Carbon\Carbon::parse($chat->created_at)->format('d-m-Y h:i A') }}</span>
                                </div>

                                <img class="direct-chat-img" src="{{ asset('dist/img/user3-128x128.jpg') }}"
                                    alt="Message User Image">

                                <div class="direct-chat-text">
                                    {{ $chat->message }}
                                </div>

                            </div>
                        @else
                            <div class="direct-chat-msg">
                                <div class="direct-chat-infos clearfix">
                                    <span class="direct-chat-name float-left">{{ \App\Models\Customer::where('id', $chat->customer_id)->first()->name }}</span>
                                    <span class="direct-chat-timestamp float-right">{{ \Carbon\Carbon::parse($chat->created_at)->format('d-m-Y h:i A') }}</span>
                                </div>

                                <img class="direct-chat-img" src="{{ asset('dist/img/user1-128x128.jpg') }}"
                                    alt="Message User Image">

                                <div class="direct-chat-text">
                                    {{ $chat->message }}
                                </div>

                            </div>
                        @endif
                    @empty
                    <p class="text-center py-5"> No Chat found</p>
                    @endforelse






                </div>

            </div>
             @if ($ticket->status==0)
            <div class="card-footer">
                <form action="{{ route('supports.send-message', $ticket->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="input-group">
                        <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-primary">Send</button>
                        </span>
                    </div>
                    @error('message')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                </form>
            </div>
            @endif

        </div>
    </section>
@endsection
@push('scripts')
    @include('layouts.utilities')
@endpush
