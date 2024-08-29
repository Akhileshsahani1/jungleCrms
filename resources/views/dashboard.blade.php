@extends('layouts.master')
@section('title', 'Dashboard')
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
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Stats Card -->
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $leads_count }}</h3>

                                <p>Leads</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                            <a href="{{ route('leads.index') }}" class="small-box-footer">
                                View All <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $estimates_count }}<sup style="font-size: 20px"></sup></h3>

                                <p>Estimates</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-calculator"></i>
                            </div>
                            <a href="{{ route('estimates.index') }}" class="small-box-footer">
                                View All <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $bookings_count }}</h3>

                                <p>Bookings</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <a href="{{ route('bookings.index') }}" class="small-box-footer">
                                View All <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small card -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $customers_count }}</h3>

                                <p>Customers</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <a href="{{ route('customers.index') }}" class="small-box-footer">
                                View All <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <a href="{{ route('leads.index', array_merge(\Request::query(), ['filter_date_from' => \Carbon\Carbon::now()->format('Y-m-d'), 'filter_date_to' => \Carbon\Carbon::now()->format('Y-m-d')])) }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-list"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Today Leads</span>
                                <span class="info-box-number">{{ $leads_today }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <a href="{{ route('estimates.index', array_merge(\Request::query(), ['filter_date' => \Carbon\Carbon::now()->format('Y-m-d')])) }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fas fa-calculator"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Today Estimates</span>
                                <span class="info-box-number">{{ $estimates_today }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <a href="{{ route('bookings.index', array_merge(\Request::query(), ['filter_date' => \Carbon\Carbon::now()->format('Y-m-d')])) }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fas fa-check-circle"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Today Bookings</span>
                                <span class="info-box-number">{{ $bookings_today }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-3 col-sm-6 col-12">
                        <a href="{{ route('customers.index', array_merge(\Request::query(), ['filter_date' => \Carbon\Carbon::now()->format('Y-m-d')])) }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fas fa-users"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text">Today Customers</span>
                                <span class="info-box-number">{{ $customers_today }}</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        </a>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Today Follow Ups
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">               
                @if (count($follow_ups) > 0)
                    <table id="customers" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Follow Up</th>
                                <th>Lead</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($follow_ups as $follow_up)
                                <tr>
                                    <td>
                                        <span class="right badge badge-danger">{{ \Carbon\Carbon::parse($follow_up->datetime)->format('d-m-Y h:i A') }}</span>
                                        
                                        <br>
                                        {!! $follow_up->comment !!}
                                    </td>
                                    <td>
                                        @if($follow_up->lead->name)
                                        <a href="{{ route('leads.show',$follow_up->lead->id) }}" target="_blank">
                                            {{ $follow_up->lead->name }}
                                            
                                            <br>
                                            {{ $follow_up->lead->mobile }}
                                        </a>
                                        @else
                                        N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($follow_up->done == 1)
                                        <button class="btn btn-sm btn-success">Done</button>
                                       @elseif(\Carbon\Carbon::parse($follow_up->datetime)->isToday())                                          
                                            <a href="javascript:void(0)" class="btn btn-sm btn-primary edit-followup"  data-toggle="modal" data-target="#modal-follow-up" data-lead-id = "{{ $follow_up->lead_id }}" data-id="{{ $follow_up->id }}" data-note="{{ $follow_up->comment }}">Today</a>                                       
                                       @elseif(\Carbon\Carbon::parse($follow_up->datetime)->isPast())
                                            <button class="btn btn-sm btn-danger">Missed</button>
                                       @else
                                            <button class="btn btn-sm btn-warning">Upcoming</button>
                                       @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center">No Follow Up found.</p>
                @endif
            </div>
        </div>
        <!-- /.card -->
        @include('graph')

        <!-- Leads Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-list"></i>
                    Latest Leads
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Website</th>
                            <th>Lead Status</th>
                            <th>Assign To</th>
                            <th>Time(ago)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leads as $lead)
                            <tr>
                                <td>{{ $lead->id }}</td>
                                <td>{{ $lead->name }}<br>
                                    @if ($lead->source == 'crm')
                                        <span class="badge bg-dark">Created</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-danger">{{ $lead->website }}</span></td>
                                <td>{{ $lead->lead_status == 0 ? 'Generated' : \App\Models\LeadStatus::find($lead->lead_status)->name }}
                                    @isset($lead->estimate)
                                    <br>
                                    <span class="badge bg-purple">Estimate</span>
                                    <span class="badge bg-grey">{{ ucfirst($lead->estimate->payment_status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $lead->assigned_to  == 2 ? 'N/A' : $lead->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($lead->created_at)->diffForHumans() }}</td>
                                <td>
                                    <div class="btn-group">
                                        @role('administrator')
                                            <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-warning"> <i
                                                    class="fas fa-eye"></i> </a>
                                           
                                            <button type="button" onclick="confirmDelete({{ $lead->id }})"
                                                class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                            <form id='delete-form{{ $lead->id }}'
                                                action='{{ route('leads.destroy', $lead->id) }}' method='POST'>
                                                <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                            </form>
                                        @else
                                            @php

                                                $current = strtotime(date('Y-m-d'));
                                                $date = strtotime($lead->date);

                                                $datediff = $date - $current;
                                                $difference = floor($datediff / (60 * 60 * 24));

                                                $dbtimestamp = strtotime($lead->time);
                                                if ($difference == 0) {
                                                    if (time() - $dbtimestamp > 10 * 60) {
                                                        $disabled = false;
                                                    } else {
                                                        $disabled = true;
                                                    }
                                                } else {
                                                    $disabled = false;
                                                }
                                            @endphp
                                            <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-info  @if($disabled) disabled @endif"> <i
                                                    class="fas fa-eye"></i> </a>
                                                    
                                        @endrole
                                    </div>
            </div>
            </td>
            </tr>
            @endforeach
            </tbody>
            </table>
        </div>
        </div>
        <!-- Estimates Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calculator"></i>
                    Latest Estimates
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Source</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Destination</th>
                            <th>Assigned</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estimates as $estimate)
                            <tr>
                                <td>{{ $estimate->id }}</td>
                                <td>{{ $estimate->customer->name }}</td>
                                <td><span class="badge bg-danger">{{ ucfirst($estimate->type) }}</span></td>
                                @if ($estimate->source == 'custom')
                                    <td><span class="badge bg-grey">{{ ucfirst($estimate->source) }}</span></td>
                                @else
                                    <td><span class="badge bg-dark">{{ ucfirst($estimate->source) }}</span></td>
                                @endif
                                @if ($estimate->payment_status == 'unpaid')
                                    <td><button
                                            class="btn btn-sm bg-indigo">{{ ucfirst($estimate->payment_status) }}</button>
                                    </td>
                                @elseif($estimate->payment_status == 'paid')
                                    <td><button
                                            class="btn btn-sm btn-success">{{ ucfirst($estimate->payment_status) }}</button>
                                    </td>
                                @elseif($estimate->payment_status == 'partially paid')
                                    <td><button
                                            class="btn btn-sm bg-orange">Partial</button>
                                    </td>
                                @endif
                                <td style="font-size:14px;">{{ ucfirst($estimate->estimate_status) }}</td>
                                @if ($estimate->type == 'cab')
                                    <td style="font-size:14px;"><i class="fas fa-taxi"></i>  {{ ucfirst($estimate->cab->drop) }}</td>
                                @elseif ($estimate->type == 'hotel')
                                    <td style="font-size:14px;"><i class="fas fa-hotel"></i>  {{ ucfirst($estimate->hotel->destination) }}</td>
                                @elseif($estimate->type == 'safari')
                                    <td style="font-size:14px;"><i class="fab fa-safari"></i>  {{$estimate->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($estimate->safari->sanctuary)}}</td>
                                @elseif($estimate->type == 'tour')
                                @php
                                $estimate_type = estimateType($estimate->id);
                                @endphp
                                    <td>
                                        @if(in_array('hotel', $estimate_type))<span style="font-size:13px;"><i class="fas fa-hotel"></i> {{$estimate->hotel->destination}}</span><br>@endif
                                    @if(in_array('cab', $estimate_type))<span style="font-size:13px;"><i class="fas fa-taxi"></i> {{$estimate->cab->drop}}</span><br>@endif
                                    @if(in_array('safari', $estimate_type))<span style="font-size:13px;"><i class="fab fa-safari"></i> {{$estimate->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($estimate->safari->sanctuary)}}</span><br>@endif
                                    </td>
                                @elseif($estimate->type == 'package')
                                @php
                                $estimate_type = estimateType($estimate->id);
                                @endphp
                                    <td>
                                        @if(in_array('hotel', $estimate_type))
                                        @foreach($estimate->destinations as $destination)
                                            <span style="font-size:13px;"><i class="fas fa-hotel"></i> {{$destination->destination}}</span>
                                            <br>
                                        @endforeach
                                    @endif
                                    @if(in_array('cab', $estimate_type))<span style="font-size:13px;"><i class="fas fa-taxi"></i> {{$estimate->cab->drop}}</span><br>@endif
                                    @if(in_array('safari', $estimate_type))<span style="font-size:13px;"><i class="fab fa-safari"></i> {{$estimate->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($estimate->safari->sanctuary)}}</span><br>@endif
                                    </td>
                                @endif
                                <td>{{ $estimate->user->name ?? 'N/A' }}</td>
                                <td>
                                    <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <ul class="dropdown-menu text-center">
                                        <a href="{{ route('estimates.show', $estimate->id) }}" target="_blank">
                                            <li class="dropdown-item">Show</li>
                                        </a>
                                        <a href="{{ route('estimates.edit', $estimate->id) }}">
                                            <li class="dropdown-item">Edit</li>
                                        </a>
                                        <a href="javascript:void(0)" onclick="confirmDelete({{ $estimate->id }})">
                                            <li class="dropdown-item">
                                                Delete
                                            </li>
                                            <form id='delete-form{{ $estimate->id }}'
                                                action='{{ route('estimates.destroy', $estimate->id) }}' method='POST'>
                                                <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                            </form>
                                        </a>
                                        @if($estimate->estimate_status == 'accepted')
                                        <a href="{{ route('estimate-transactions.index', array_merge(\Request::query(), ['estimate_id' => $estimate->id])) }}">
                                            <li class="dropdown-item">Transactions</li>
                                        </a>
                                        @endif
                                        @if($estimate->estimate_status == 'accepted')
                                        <li class="dropdown-divider"></li>
                                            @if(bookingExists($estimate->id))
                                            <a href="{{ route('bookings.index', array_merge(\Request::query(), ['filter_estimate' => $estimate->id])) }}" disabled><li class="dropdown-item"><i class="fas fa-eye"></i> Booking</li></a>
                                            @else
                                            <a href="{{ route('convert.estimate', $estimate->id) }}" ><li class="dropdown-item">Convert Estimate</li></a>
                                            @endif
                                        @endif
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->

        <!-- Bookings Card -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-check-circle"></i>
                    Latest Bookings
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <table id="dataTable2" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Customer</th>
                            <th>Type</th>
                            <th>Total</th>
                            <th>Date</th>
                            <th>Destination</th>
                            <th>Assigned</th>
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
                                <td style="font-size:14px;">{{ $booking->customer->name }}</td>
                                <td>
                                    <span class="badge bg-danger">{{ ucfirst($booking->type) }}</span><br>
                                    @if ($booking->source == 'custom')
                                    <span class="badge bg-grey">{{ ucfirst($booking->source) }}</span>
                                @elseif($booking->source == 'direct')
                                    <span class="badge bg-indigo">{{ ucfirst($booking->source) }}</span>
                                @else
                                    <span class="badge bg-dark">{{ ucfirst($booking->source) }}</span>
                                @endif
                                </td>
                                <td style="font-size:14px;">₹ {{ $booking->items->sum('amount') }}</td>
                                @if ($booking->type == 'cab')
                                    <td style="font-size:14px;">
                                        <i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Date"></i> {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}</td>
                                @endif
                                @if ($booking->type == 'hotel')
                                    <td style="font-size:14px;">
                                        <i class="fas fa-hotel" data-toggle="tooltip" title="Checkin Date"> </i> {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}</td>
                                @endif
                                @if ($booking->type == 'safari')
                                    <td style="font-size:14px;">
                                        <i class="fab fa-safari" data-toggle="tooltip" title="Safari Date"> </i> @isset($booking->safari)  {{ \Carbon\Carbon::parse($booking->safari->date)->format('d-m-Y') }} @endisset</td>
                                @endif
                                @if ($booking->type == 'tour')
                                    <td style="font-size:14px;">
                                        @if (in_array('cab', $booking_type))
                                            <i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Date"></i> {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}<br>
                                        @endif
                                        @if (in_array('hotel', $booking_type))
                                            <i class="fas fa-hotel" data-toggle="tooltip" title="Checkin Date"></i> {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}<br>
                                        @endif
                                        @if (in_array('safari', $booking_type))
                                        @isset($booking->safari)   <i class="fab fa-safari" data-toggle="tooltip" title="Safari Date"></i> {{ \Carbon\Carbon::parse($booking->safari->date)->format('d-m-Y') }}<br> @endisset
                                        @endif
                                    </td>
                                @endif
                                @if($booking->type == 'package')
                                    <td>
                                        @if(in_array('hotel', $booking_type))
                                        @foreach($booking->destinations as $destination)
                                            <span style="font-size:13px;"><i class="fas fa-hotel"></i> {{ \Carbon\Carbon::parse($destination->check_in)->format('d-m-Y') }}</span>
                                            <br>
                                        @endforeach
                                        @endif
                                        @if(in_array('cab', $booking_type))<span style="font-size:13px;"> <i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Date"></i> {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}</span><br>@endif
                                        @if(in_array('safari', $booking_type))<span style="font-size:13px;"><i class="fab fa-safari" data-toggle="tooltip" title="Safari Date"></i> @isset($booking->safari)  {{ \Carbon\Carbon::parse($booking->safari->date)->format('d-m-Y') }}</span><br>@endisset @endif
                                    </td>
                                @endif
                                @if ($booking->type == 'cab')
                                    <td style="font-size:14px;"><i class="fas fa-taxi" data-toggle="tooltip" title="Pickup Point"></i>
                                        {{ ucfirst($booking->cab->drop) }}</td>
                                @elseif ($booking->type == 'hotel')
                                    <td style="font-size:14px;"><i class="fas fa-hotel" data-toggle="tooltip" title="Hotel Destination"></i>
                                        {{ ucfirst($booking->hotel->destination) }}</td>
                                @elseif($booking->type == 'safari')
                                    <td style="font-size:14px;"><i class="fab fa-safari" data-toggle="tooltip" title="Sanctuary"></i>
                                        @isset($booking->safari)    {{ $booking->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($booking->safari->sanctuary) }} @endisset
                                    </td>
                                @elseif($booking->type == 'tour')
                                    <td style="font-size:14px;">
                                        @if (in_array('cab', $booking_type))
                                            <i class="fas fa-taxi"  data-toggle="tooltip" title="Pickup Point"></i> {{ $booking->cab->drop }}<br>
                                        @endif
                                        @if (in_array('hotel', $booking_type))
                                            <i class="fas fa-hotel"  data-toggle="tooltip" title="Hotel Destination"></i> {{ $booking->hotel->destination }}<br>
                                        @endif
                                        @if (in_array('safari', $booking_type))
                                        @isset($booking->safari)  <i class="fab fa-safari" data-toggle="tooltip" title="Sanctuary"></i> {{ $booking->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($booking->safari->sanctuary) }}<br> @endisset
                                        @endif
                                    </td>
                                @elseif($booking->type == 'package')
                                    <td>
                                        @if(in_array('hotel', $booking_type))
                                        @foreach($booking->destinations as $destination)
                                            <span style="font-size:13px;"><i class="fas fa-hotel"></i> {{$destination->destination}}</span>
                                            <br>
                                        @endforeach
                                        @endif
                                        @if(in_array('cab', $booking_type))<span style="font-size:13px;"><i class="fas fa-taxi"></i> {{$booking->cab->drop}}</span><br>@endif
                                        @if(in_array('safari', $booking_type)) @isset($booking->safari) <span style="font-size:13px;"><i class="fab fa-safari"></i> {{$booking->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($booking->safari->sanctuary)}}</span><br>@endisset @endif
                                    </td>
                                @endif
                                <td style="font-size:14px;">{{ $booking->user->name ?? 'N/A' }}</td>
                                <td>
                                    <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <ul class="dropdown-menu text-center">
                                        <a href="{{ route('bookings.show', $booking->id) }}" target="_blank">
                                            <li class="dropdown-item">Show</li>
                                        </a>
                                        <a href="{{ route('bookings.edit', $booking->id) }}">
                                            <li class="dropdown-item">Edit</li>
                                        </a>
                                        <a href="javascript:void(0)" onclick="confirmDelete({{ $booking->id }})">
                                            <li class="dropdown-item">
                                                Delete
                                            </li>
                                            <form id='delete-form{{ $booking->id }}'
                                                action='{{ route('bookings.destroy', $booking->id) }}' method='POST'>
                                                <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                            </form>
                                        </a>
                                        <a href="{{ route('booking-transactions.index', array_merge(\Request::query(), ['booking_id' => $booking->id])) }}">
                                            <li class="dropdown-item">Transactions</li>
                                        </a>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
    <div class="modal fade" id="modal-follow-up">
        <div class="modal-dialog modal-follow-up">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Do Follow Up</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                         <div class="col-sm-8">
                        </div>
                         <div class="col-sm-4">
                             <a href="#" id="follow_up_btn" class="btn btn-primary margin-r-0">Follow Lead</a>
                        </div>
                    </div>
                   
                    <form method="POST" id="cabForm" action="{{ route('follow-up.save') }}">
                        @csrf
                        <input type="hidden" name="follow_up_id" id="follow_up_id">
                        <div class="form-group">
                            <label for="content">Note</label>
                            <p id="note"></p>
                        </div>
                        <div class="form-group">
                            <label for="comment_type">Comment Type</label>
                            <select name="comment_type" class="form-control">
                                <option value="">Select Comment Type</option>
                                <option value="payment">About Payment</option>
                                <option value="lead">About Lead</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="comment">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="5" placeholder="Enter Comment here" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="cabForm">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('layouts.utilities')
        @if($admin)

    <link rel="stylesheet" href="https://btn.ninja/css/addons.css" >
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script type="text/javascript">
        // Sales graph chart
//   var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
//   // $('#revenue-chart').get(0).getContext('2d');
//     //    console.log(@json($previous_months))                                         
//   var salesGraphChartData = {
//     labels: @json($previous_months),
//     datasets: [
//       {
//         label: 'Direct',
//         fill: false,
//         borderWidth: 2,
//         lineTension: 0,
//         spanGaps: true,
//         borderColor: '#eaf752',
//         pointRadius: 3,
//         pointHoverRadius: 7,
//         pointColor: '#efefef',
//         pointBackgroundColor: '#efefef',
//         data: @json($d_m_bs)
//       },
//       {
//         label: 'Estimate Converted',
//         fill: false,
//         borderWidth: 2,
//         lineTension: 0,
//         spanGaps: true,
//         borderColor: '#5752f7',
//         pointRadius: 3,
//         pointHoverRadius: 7,
//         pointColor: '#efefef',
//         pointBackgroundColor: '#efefef',
//         data: @json($c_m_bs)
//       }
//     ]

//   }

//   var salesGraphChartOptions = {
//     maintainAspectRatio: false,
//     responsive: true,
//     legend: {
//       display: true
//     },
//     scales: {
//       xAxes: [{
//         ticks: {
//           fontColor: '#efefef'
//         },
//         gridLines: {
//           display: false,
//           color: '#efefef',
//           drawBorder: false
//         }
//       }],
//       yAxes: [{
//         ticks: {
//           stepSize: 500,
//           max:2500,
//           fontColor: '#222423',
//         },
//         gridLines: {
//           display: true,
//           color: '#222423',
//           drawBorder: false
//         }
//       }]
//     }
//   }

//   // This will get the first returned node in the jQuery collection.
//   // eslint-disable-next-line no-unused-vars
//   var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
//     type: 'line',
//     data: salesGraphChartData,
//     options: salesGraphChartOptions
//   })
//    $('.knob').knob()
    </script>
  @endif
   @if($admin)
    <script type="text/javascript">
        // Sales graph chart

  
  
  // $('#revenue-chart').get(0).getContext('2d');
  window.onload = (event) => {
  dynamicLead('');
  SalesGraph('sale');
    var dateformat = 'dd/mm/yyyy';
    $('#toDate').datepicker({
    format: dateformat,
    autoclose: true
    });
    $('#fromDate').datepicker({
    format: dateformat,
    autoclose: true
    });
    $('#saleFromDate').datepicker({
    format: dateformat,
    autoclose: true
    });
    $('#saleToDate').datepicker({
    format: dateformat,
    autoclose: true
    });
};
// $('#lead_status').on('change',function(){
//    dynamicLead($(this).val());
// });
var mychart;
var salesGraphChart;
        
  function dynamicLead()
  {
    if (mychart) {
            mychart.destroy()
        }
        
    let lead_status = $("#lead_status").val()
    let fromDate    = $("#fromDate").val()
    let toDate      = $("#toDate").val()
    // console.log(lead_status,fromDate,toDate )
     $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('get-lead-data') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "lead_status":lead_status,"fromDate":fromDate,"toDate":toDate
                },
                success: function(data) {
                //    console.log(data)
                   $("#totalLead").html("Total Lead = " +data.total_leads)
                var xValues = data.m_l;
                var yValues = data.m_c;
                var barColors = data.colors;
                
                let salesGraphChartCanvas = $('#line-lead-chart').get(0).getContext('2d')
                mychart = new Chart(salesGraphChartCanvas, {
                    type: "bar",
                    data: {
                        labels: xValues,
                        datasets: [{
                        backgroundColor: barColors,
                        data: yValues
                        }]
                    },
                    options: {
                        legend: {display: false},
                        responsive: true,
                        title: {
                            display: false,
                            text: ""
                        },
                        scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                            },
                            stacked: true,
                        }]
                    }
                    }
                });


                        
                }
            });
  }
  function SalesGraph(val='')
  {
    if (salesGraphChart) {
            salesGraphChart.destroy()
        }
        // alert(val)
    let fromDate    = $("#saleFromDate").val()
    let toDate      = $("#saleToDate").val()
    let website      = $("#website").val()
    // console.log(lead_status,fromDate,toDate )
     $.ajax({
                type: "POST",
                dataType: "json",
                url: "{{ route('getSaleData') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "fromDate":fromDate,"toDate":toDate,website:website,"type":val
                },
                success: function(data) {
                //    console.log(data)
                  
                var xValues_convert = data.c_date; //converted date
                var yValues_convert = data.c_count; //converted count
                var xValues_direct = data.d_date; //direct date
                var yValues_diret = data.d_count; //converted count
                var barColors = data.colors;
                const xValues = xValues_direct;
                // console.log(Math.max(...yValues_convert));
                var maxDirect = Math.max(...yValues_diret);
                var maxCOnvert = Math.max(...yValues_convert);
                var yVal = Math.max(parseInt(maxDirect), parseInt(maxCOnvert))
                var totalBooking = parseInt(data.convertedCount) + parseInt(data.directCount)
                $("#totalSaleGraphLead").html("Total Booking = " + totalBooking)
                var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
                var salesGraphChartData = {
                    labels: xValues,
                    datasets: [
                    {
                        label: 'Direct',
                        fill: false,
                        borderWidth: 2,
                        lineTension: 0,
                        spanGaps: true,
                        borderColor: '#eaf752',
                        pointRadius: 3,
                        pointHoverRadius: 7,
                        pointColor: '#efefef',
                        pointBackgroundColor: '#efefef',
                        data: yValues_diret
                    },
                    {
                        label: 'Estimate Converted',
                        fill: false,
                        borderWidth: 2,
                        lineTension: 0,
                        spanGaps: true,
                        borderColor: 'blue',
                        pointRadius: 3,
                        pointHoverRadius: 7,
                        pointColor: '#efefef',
                        pointBackgroundColor: '#efefef',
                        data: yValues_convert
                    }
                    ]

                }

                var salesGraphChartOptions = {
                    maintainAspectRatio: false,
                    responsive: true,
                    legend: {
                    display: true
                    },
                    scales: {
                    xAxes: [{
                        ticks: {
                        fontColor: '#222423'
                        },
                        gridLines: {
                        display: false,
                        color: '#222423',
                        drawBorder: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                        stepSize: 15,
                        max:yVal,
                        fontColor: '#222423',
                        },
                        gridLines: {
                        display: true,
                        color: '#222423',
                        drawBorder: false
                        }
                    }]
                    }
                }

                // This will get the first returned node in the jQuery collection.
                // eslint-disable-next-line no-unused-vars
                salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
                    type: 'line',
                    data: salesGraphChartData,
                    options: salesGraphChartOptions
                })
                $('.knob').knob()


                        
                }
            });
  }
    </script>
  @endif
 
    <script>
    $(".edit-followup").click(function () {
            let id = $(this).data('id');
            let note = $(this).data('note');
            let lead_id = $(this).data('lead-id');
            let url = "{{ route('follow-up-history',":id") }}";
            url = url.replace(':id',lead_id);
            $('#note').text(note);
            $('#follow_up_id').val(id);
            $('#follow_up_btn').attr('href',url);
        });
</script>

@endpush
