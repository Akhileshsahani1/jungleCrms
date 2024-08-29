@extends('layouts.master')
@section('title', 'Estimates')
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
                    <h1><i class="nav-icon fas fa-calculator"></i> Estimates</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-info" form="form-filter"><i class="fa fa-filter"></i></button>
                        <a href="{{ route('trash-estimates') }}" class="btn btn-secondary ml-2" id="reset-filter"><i class="fa fa-undo"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                @include('trash.estimates.estimate-filter')
            </div>
            <div class="card-body">
                @if(count($estimates) > 0)
                <table id="estimateDataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>                           
                            <th>Id</th>
                            <th>Date Time</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Website</th>
                            <th>Type</th>
                             <th>Reason</th>
                             <th>Deleted By</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Destination</th>
                           
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($estimates as $estimate)
                            <tr>                               
                                <td>{{ $estimate->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($estimate->created_at)->format('d-m-Y') }} <br> {{ \Carbon\Carbon::parse($estimate->created_at)->format('h:i A') }}</td>
                                <td>{{ $estimate->customer->name }}</td>
                                <td>{{ $estimate->customer->mobile }}</td>
                                <td>{{ $estimate->website }}</td>
                                <td>
                                    <span class="badge bg-danger">{{ ucfirst($estimate->type) }}</span><br>
                                    @if ($estimate->source == 'custom')
                                        <span class="badge bg-grey">{{ ucfirst($estimate->source) }}</span><br>
                                    @else
                                        <span class="badge bg-dark">{{ ucfirst($estimate->source) }}</span><br>
                                    @endif
                                </td>
                                 <td>{{ $estimate->reason ?? 'N/A' }}</td>
                                  <td>{{ $estimate->userdelete->name ?? 'N/A' }}</td>
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
                                    <td style="font-size:14px;"><i class="fas fa-paw" data-toggle="tooltip" title="" data-original-title="Safari Date"></i>  {{$estimate->safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($estimate->safari->sanctuary)}} {{ \Carbon\Carbon::parse($estimate->safari->date)->format('d-m-Y') }}</td>
                                @elseif($estimate->type == 'tour')
                                @php
                                $estimate_type = estimateType($estimate->id);
                                @endphp
                                    <td>
                                    @if(in_array('hotel', $estimate_type))<span style="font-size:13px;"><i class="fas fa-hotel"></i> {{$estimate->hotel->destination}}</span><br>@endif
                                    @if(in_array('cab', $estimate_type))<span style="font-size:13px;"><i class="fas fa-taxi"></i> {{$estimate->cab->drop}}</span><br>@endif
                                    @if(in_array('safari', $estimate_type))
                                    @foreach($estimate->safaris as $safari)
                                    <span style="font-size:13px;"><i class="fas fa-paw" data-toggle="tooltip" title="" data-original-title="Safari Date"></i> {{$safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($safari->sanctuary)}} ({{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }})</span><br>
                                    @endforeach
                                @endif
                                    </td>
                                @elseif($estimate->type == 'package')
                                @php
                                $estimate_type = estimateType($estimate->id);
                                @endphp
                                    <td>
                                        @if(in_array('hotel', $estimate_type))
                                                @foreach($estimate->hotels as $hotel)
                                                <span style="font-size:13px;"><i class="fas fa-hotel"></i> {{ $hotel->destination}}</span><br>
                                                @endforeach
                                            </ul>
                                        @endif
                                        @if(in_array('cab', $estimate_type))
                                                @foreach($estimate->cabs as $cab)
                                                <span style="font-size:13px;"><i class="fas fa-map-marker-alt"  data-toggle="tooltip" title="" data-original-title="Pick Up"></i> {{$cab->pick_up}} - <i class="fas fa-map-marker-alt"  data-toggle="tooltip" title="" data-original-title="Drop"></i> {{$cab->drop}}</span><br>
                                                @endforeach
                                        @endif
                                        @if(in_array('safari', $estimate_type))
                                            @foreach($estimate->safaris as $safari)
                                            <span style="font-size:13px;"><i class="fas fa-paw" data-toggle="tooltip" title="" data-original-title="Safari Date"></i> {{$safari->sanctuary == 'jim' ? 'Jim Corbett' : ucfirst($safari->sanctuary)}} ({{ \Carbon\Carbon::parse($safari->date)->format('d-m-Y') }})</span><br>
                                            @endforeach
                                        @endif
                                    </td>
                                @endif
                               
                                <td>
                                    <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-list"></i>
                                    </button>
                                    <ul class="dropdown-menu text-center">
                                        <a href="{{ route('trash-estimate.show', $estimate->id) }}" target="_blank">
                                            <li class="dropdown-item">Show</li>
                                        </a>
                                        <a href="{{ route('trash-estimates.restore', $estimate->id) }}" target="_blank">
                                            <li class="dropdown-item">Restore</li>
                                        </a>
                                        <a href="javascript:void(0)" onclick="confirmDelete({{ $estimate->id }})">
                                            <li class="dropdown-item">
                                                Delete
                                            </li>
                                            <form id='delete-form{{ $estimate->id }}'
                                                action='{{ route('trash-estimates.delete', $estimate->id) }}' method='POST'>
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
                <p class="text-center">No Estimate found.</p>
                @endif
            </div>
            <div class="mt-2">
                {{$estimates->appends(request()->query())->links("pagination::bootstrap-4")}}
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('layouts.utilities')
@endpush
