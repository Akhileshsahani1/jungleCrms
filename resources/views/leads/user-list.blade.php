@extends('layouts.master')
@section('title', 'Leads')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <div class="alert alert-danger bg-danger text-white" id="assign-message" role="alert" style="display: none;">
        <strong>No Leads Selected !</strong> Please select lead(s) to assign.
    </div>
    <div class="alert alert-danger bg-danger text-white" id="delete-message" role="alert" style="display: none;">
        <strong>No Leads Selected !</strong> Please select lead(s) to delete.
    </div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Leads</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <div class="btn-group ml-2" role="group" aria-label="Basic example">
                        <button type="submit" form="filterForm" class="btn btn-info" id="button-filter"><i
                                class="fa fa-filter"></i></button>
                        <button type="submit" form="filterassignedForm" class="btn btn-warning" title="Un Assigned"
                            id="button-filter-unassigned">N/A</button>
                        <a href="{{ route('leads.index') }}" class="btn btn-secondary" id="reset-filter"><i
                                class="fa fa-undo"></i></a>
                        <a href="{{ route('leads.create') }}" class="btn btn-success ml-2">Create</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <form action="{{ route('leads.index') }}" id="filterForm">
                    <div class="form-row mb-2">
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="inputEmail4">Customer</label>
                            <input type="text" class="form-control form-control-sm" id="inputEmail4"
                                placeholder="Customer Name" name="filter_name"
                                @if (null !== @$filter_name) value="{{ $filter_name }}" @endif id="input-name">
                        </div>
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="inputState">Status</label>
                            <select id="toggle-class" class="form-control form-control-sm" name="filter_status">
                                <option value="">Select Status</option>
                                @foreach ($statuses as $status)
                                    <option @if ($filter_status == $status->id) selected @endif value="{{ $status->id }}">
                                        {{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="inputEmail4">Email Id</label>
                            <input type="email" class="form-control form-control-sm" id="inputEmail4"
                                placeholder="Email Id" name="filter_email"
                                @if (null !== @$filter_email) value="{{ $filter_email }}" @endif id="input-email">
                        </div>
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="inputEmail4">Mobile</label>
                            <input type="text" class="form-control form-control-sm" id="inputEmail4" placeholder="Mobile"
                                name="filter_mobile" @if (null !== @$filter_mobile) value="{{ $filter_mobile }}" @endif
                                id="input-mobile">
                        </div>
                        <div class="col-sm-6 col-6">
                            <label class="col-form-label" for="inputEmail4">Website</label>
                            <select class="form-control form-control-sm" name="filter_website">
                                <option value="">Select website</option>
                                <option @if (@$filter_website == 'ranthamboretigerreserve.in') selected @endif
                                    value="ranthamboretigerreserve.in">ranthamboretigerreserve.in</option>
                                <option @if (@$filter_website == 'jimcorbettnationalparkonline.in') selected @endif
                                    value="jimcorbettnationalparkonline.in">jimcorbettnationalparkonline.in</option>
                                <option @if (@$filter_website == 'girsafaribooking.com') selected @endif value="girsafaribooking.com">
                                    girsafaribooking.com</option>
                                <option @if (@$filter_website == 'jimcorbett.in') selected @endif value="jimcorbett.in">
                                    jimcorbett.in</option>
                                <option @if (@$filter_website == 'girlionsafari.com') selected @endif value="girlionsafari.com">
                                    girlionsafari.com</option>
                                <option @if (@$filter_website == 'girlion.in') selected @endif value="girlion.in">
                                    girlion.in</option>
                                <option @if (@$filter_website == 'bandhavgarh.com') selected @endif value="bandhavgarh.com">
                                    bandhavgarh.com</option>
                                <option @if (@$filter_website == 'travelwalacab.com') selected @endif value="travelwalacab.com">
                                    travelwalacab.com</option>
                                <option @if (@$filter_website == 'dailytourandtravel.com') selected @endif value="dailytourandtravel.com">
                                    dailytourandtravel.com</option>
                                 <option @if (@$filter_website == 'internationaltrips.in') selected @endif value="internationaltrips.in">
                                    Internationaltrips.in</option>
                                <option @if (@$filter_website == 'tadobapark.com') selected @endif value="tadobapark.com">
                                    tadobapark.com</option>
                            </select>
                        </div>
                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="filter_date_from">Date from</label>
                            <input type="date" id="filter_date_from" name="filter_date_from"
                                @if (null !== @$filter_date_from) value="{{ $filter_date_from }}" @endif
                                class="form-control form-control-sm floating-label" placeholder="Select Date">
                        </div>

                        <div class="col-sm-3 col-3">
                            <label class="col-form-label" for="filter_date_to">Date to</label>
                            <input type="date" id="filter_date_to" name="filter_date_to"
                                @if (null !== @$filter_date_to) value="{{ $filter_date_to }}" @endif width="276"
                                class="datepickers form-control form-control-sm" placeholder="Select Date">
                        </div>
                    </div>
                </form>

                <form action="{{ route('leads.index') }}" id="filterassignedForm">
                    <div class="col" style="display:none;">
                        <label for="filter_date_assigned">Un Assigned</label>
                        <input type="text" id="filter_user_assigned" value="2" name="filter_user_assigned"
                            @if (null !== @$filter_user_assigned) value="{{ $filter_user_assigned }}" @endif
                            class="form-control floating-label" placeholder="Select Date">
                    </div>
                </form>

            </div>
            <div class="card-body">
                <table id="leadDataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Assigned By</th>
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
                                @if($lead->assigned_by && $lead->view == 0)
                                <td style="background-color:#ff000047; {{ $lead->counter ? 'background-color:#cfeb34 !important' : '' }}">
                                    {{ $lead->name }}<br>
                                    @if ($lead->source == 'crm')
                                        <span class="badge bg-dark">Created</span>
                                    @endif
                                </td>
                                @else
                                <td style="{{ $lead->assigned_to === 2 ? 'background-color:#9EF395;' : '' }} {{ $lead->counter ? 'background-color:#cfeb34 !important' : '' }}">
                                    {{ $lead->name }}<br>
                                    @if ($lead->source == 'crm')
                                        <span class="badge bg-dark">Created</span>
                                    @endif
                                </td>
                                @endif
                                @isset($lead->assigned_by)
                                <td>{{ $lead->assigned_by == Auth::user()->id ? "Self" : \App\Models\User::find($lead->assigned_by)->name}}</td>
                                @else
                                <td>N/A</td>
                                @endisset
                                <td><span class="badge bg-danger">{{ $lead->website }}</span></td>
                                <td>{{ $lead->lead_status == 0 ? 'Generated' : \App\Models\LeadStatus::find($lead->lead_status)->name }}
                                    @isset($lead->estimate)
                                        <br>
                                        <span class="badge bg-purple">Estimate</span>
                                        <span class="badge bg-grey">{{ ucfirst($lead->estimate->payment_status) }}</span>
                                    @endisset
                                    @isset($lead->booking)
                                        <br>
                                        <span class="badge bg-success">Booking</span>
                                        @if ($lead->booking->transactions->sum('amount') > 0)
                                            @if ($lead->booking->transactions->sum('amount') >= $lead->booking->items->sum('amount'))
                                                <span class="badge bg-grey">Paid</span><br>
                                            @else
                                                <span class="badge bg-grey">Partial</span><br>
                                            @endif
                                        @else
                                            <span class="badge bg-grey">Unpaid</span><br>
                                        @endif
                                    @endisset
                                </td>
                                <td>{{ $lead->assigned_to == 2 ? 'N/A' : $lead->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($lead->created_at)->diffForHumans() }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if ($lead->source == 'website')
                                            @php
                                                
                                                $current = strtotime(date('Y-m-d'));
                                                $date = strtotime($lead->date);
                                                
                                                $datediff = $date - $current;
                                                $difference = floor($datediff / (60 * 60 * 24));
                                                
                                                $dbtimestamp = strtotime($lead->created_at);
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
                                            <a href="{{ route('leads.edit-more-details', $lead->id) }}" class="btn btn-dark"> <i
                                                class="fas fa-pen"></i></a>
                                            <a href="{{ route('leads.show', $lead->id) }}"
                                                class="btn btn-info  @if ($disabled) disabled @endif">
                                                <i class="fas fa-eye"></i> </a>
                                            <a href="{{ route('lead-history', $lead->mobile) }}"
                                                class="btn btn-warning  @if ($disabled) disabled @endif">
                                                History </a>
                                        @else
                                            <a href="{{ route('leads.edit-more-details', $lead->id) }}" class="btn btn-dark"> <i
                                            class="fas fa-pen"></i></a>
                                            <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-info"> <i
                                                    class="fas fa-eye"></i> </a>
                                            <a href="{{ route('lead-history', $lead->mobile) }}" class="btn btn-warning">
                                                History </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $leads->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('layouts.utilities')
@endpush
