@extends('layouts.master')
@section('title', 'Tickets')
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
                    <h1><i class="nav-icon fas fa-ticket"></i> Tickets</h1>
                </div>
                <div class="col-sm-2">
                    <h4> Total : {{ $open_ticket_count + $closed_ticket_count }}</h4>
                </div>
                <div class="col-sm-2">
                    <h4> Open : {{ $open_ticket_count }}</h4>
                </div>
                <div class="col-sm-2">
                    <h4> Closed : {{ $closed_ticket_count }}</h4>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                @include('supports.filter')
                 <div class="card-header text-right">
                <a class="btn btn-warning" href="{{ route('support.create') }}">New Ticket</a>
           
            </div>
            <div class="card-body">
                @if (count($tickets) > 0)
                    <table id="estimateDataTable" class="table table-bordered table-striped">
                        <thead>
                            <tr> 
                                <th>Id</th>                              
                                <th>Customer</th>
                                <th>Booking Id</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td>{{ $ticket->id }}</td> 
                                    <td style="font-size:14px;">
                                        {{ isset($ticket->customer->name) ? $ticket->customer->name : '' }}
                                        <br>
                                        {{ isset($ticket->customer->mobile) ? $ticket->customer->mobile : '' }}
                                        <br>
                                        {{ isset($ticket->customer->email) ? $ticket->customer->email : '' }}
                                    </td>                                     
                                    <td>
                                        @if ($ticket->booking_id)
                                        <a href="{{ route('bookings.show', $ticket->booking_id) }}" target="_blank" class="btn btn-primary">
                                            Booking id : {{ $ticket->booking_id }}
                                        </a>
                                        @else
                                          N/A
                                        @endif
                                    </td>                 
                                    <td>
                                        {!! $ticket->subject !!}
                                    </td>

                                    @if ($ticket->status == 0)
                                        <td><button
                                                class="btn btn-sm bg-success">Open</button>
                                                <br>
                                                @if(count($ticket->unseenadmin) > 0)
                                                <span title="{{ count($ticket->unseenadmin) }} New Message" class="badge bg-primary">{{ count($ticket->unseenadmin) }} New Message</span>
                                                @endif
                                        </td>
                                    @else
                                        <td><button class="btn btn-sm bg-danger">Closed</button>
                                            <br>
                                            @if(count($ticket->unseenadmin) > 0)
                                            <span title="{{ count($ticket->unseenadmin) }} New Message" class="badge bg-primary">{{ count($ticket->unseenadmin) }}  New Message</span>
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ \Carbon\Carbon::parse($ticket->created_at)->format('d-m-Y') }}<br>
                                        {{ \Carbon\Carbon::parse($ticket->created_at)->format('H:i A') }}</td>  
                                        
                                     @if ($ticket->user_id)
                                        <td>
                                            {{ ($ticket->user->name)? $ticket->user->name : 'N/A' }}
                                        </td>
                                    @else
                                        <td> Customer
                                        </td>
                                    @endif
                                  
                                    <td>
                                        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fas fa-list"></i>
                                        </button>
                                        <ul class="dropdown-menu text-center">      
                                            <a href="{{ route('support.show', $ticket->id) }}">
                                                <li class="dropdown-item">Chat</li>
                                            </a>                                      
                                            <a href="{{ route('support.edit', $ticket->id) }}">
                                                <li class="dropdown-item">Show</li>
                                            </a>
                                            <a href="javascript:void(0)" onclick="confirmDelete({{ $ticket->id }})">
                                                <li class="dropdown-item">
                                                    Delete
                                                </li>
                                                <form id='delete-form{{ $ticket->id }}'
                                                    action='{{ route('support.destroy', $ticket->id) }}' method='POST'>
                                                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                    <input type='hidden' name='_method' value='DELETE'>
                                                </form>
                                            </a>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center">No Ticket added.</p>
                @endif
            </div>
            <div class="mt-2">
                {{ $tickets->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('layouts.utilities')
@endpush