@extends('layouts.master')
@section('title', 'Reports Estimates')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-calculator"></i> Reports Estimates</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <div class="btn-group">
                        <button type="submit" class="btn btn-info" form="form-filter"><i class="fa fa-filter"></i></button>
                        <a href="{{ route('reports_unpaidEstimates.index') }}" class="btn btn-secondary ml-2" id="reset-filter"><i class="fa fa-undo"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                @include('reports.totalunpaidestimatefilter')
            </div>
            <div class="card-body">
                @if(count($reports_estimates) > 0)
                <table id="estimateDataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Type</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Destination</th>
                            <th>Assigned</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports_estimates as $estimate)
                            <tr>
                                <td>{{ $estimate->id }}</td>
                                <td>{{ $estimate->customer->name }}</td>
                                <td>{{ $estimate->customer->mobile }}</td>
                                <td>
                                    <span class="badge bg-danger">{{ ucfirst($estimate->type) }}</span><br>
                                    @if ($estimate->source == 'custom')
                                        <span class="badge bg-grey">{{ ucfirst($estimate->source) }}</span><br>
                                    @else
                                        <span class="badge bg-dark">{{ ucfirst($estimate->source) }}</span><br>
                                    @endif
                                </td>

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
                                <td>{{ $estimate->user->name ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>Total Number of Estimates Unpaid</th>
                            <th>{{ count($reports_estimates) }}</th>
                        </tr>
                    </tfoot>
                </table>
                @else
                <p class="text-center">No Estimate found.</p>
                @endif
            </div>
            <div class="mt-2">
                {{$reports_estimates->appends(request()->query())->links("pagination::bootstrap-4")}}
            </div>
        </div>
        @role('administrator')
        <div class="container px-4 mx-auto">
            <div class="p-6 m-20 bg-white rounded shadow">
                {!! $chart->container() !!}
            </div>
        </div>
        @endrole
    </section>
@endsection
@push('scripts')
<script src="{{ $chart->cdn() }}"></script>
{{ $chart->script() }}
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
$(function() {
  $('input[name="filter_daterange"]').daterangepicker({
    opens: 'left',
    autoUpdateInput: false,
    locale: {
      format: 'YYYY-MM-DD',
      cancelLabel: 'Clear'
    },
  }, function(start, end, label) {
  });


  $('input[name="filter_daterange"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
  });

});
</script>
@include('layouts.utilities')
@endpush

