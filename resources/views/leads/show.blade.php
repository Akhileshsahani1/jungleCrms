@extends('layouts.master')
@section('title', 'Lead Details')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')
<div class="alert alert-info bg-info text-white" id="assign-message" role="alert" style="display: none;">

</div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Lead Details</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
                        <li class="breadcrumb-item active">Lead Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Name</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" value="{{ $lead->name }}" id="name" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="email" value="{{ $lead->email }}" id="email" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label">Mobile</label>
                            <div class="col-sm-9">
                                <input class="form-control" type="text" value="{{ $lead->mobile }}" id="mobile"
                                    disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mobile" class="col-sm-3 col-form-label">Meta</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="meta" name="meta" rows="2" disabled>{{ $lead->meta }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="payment_status" class="col-sm-3 col-form-label">Payment Status</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="payment_status" name="payment_status" disabled>
                                    <option value="waiting" @if ($lead->payment_status == 'waiting') selected @endif>Waiting
                                    </option>
                                    <option value="partially paid" @if ($lead->payment_status == 'partially paid') selected @endif>Partially Paid
                                    </option>
                                    <option value="paid" @if ($lead->payment_status == 'paid') selected @endif>Paid
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="assigned_to" class="col-sm-3 col-form-label">Assigned to</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="assigned_to" name="assigned_to" disabled>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            @if ($user->id == $lead->assigned_to) selected @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="created_at" class="col-sm-3 col-form-label">Generated On</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="created_at" name="created_at"
                                    value="{{ \Carbon\Carbon::parse($lead->created_at)->format('d-m-Y H:i:s') }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                data-target="#myModal"><i class="fas fa-bell"></i> Follow Up</button>
                                <a href="{{ route('follow-up-history', $lead->id) }}" class="btn btn-danger btn-sm"><i class="fas fa-list"></i> Follow Up History</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('convert') }}" id="conversionForm">
                            <input type="hidden" value="{{ $lead->id }}" name="lead_id">
                            <div class="form-group row">
                                <label for="conversion" class="col-sm-3 col-form-label">Convert Lead</label>
                                <div class="col-sm-9">
                                    <select id="conversion" class="form-control" name="conversion">
                                        <option value="">Select Conversion Type</option>
                                        <option value="booking">Booking</option>
                                        <option value="estimate">Estimate</option>`
                                    </select>
                                    @error('conversion')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="type" class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <select id="type" class="form-control" name="type">
                                        <option value="">Select Booking / Estimate Type</option>
                                        <option value="cab">Cab</option>
                                        <option value="hotel">Hotel</option>
                                        <option value="safari">Safari</option>
                                        <option value="tour">Tour</option>
                                        <option value="package">Package</option>
                                    </select>
                                    @error('type')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>

                            </div>
                        </form>
                        <div class="form-group text-right">
                            <button type="submit" form="conversionForm" class="btn btn-success btn-sm">Convert</button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="leadstatus" class="col-sm-3 col-form-label">Lead Status</label>
                            <div class="col-sm-9">
                                <select id="leadstatus" data-id="{{ $lead->id }}" class="form-control"
                                    name="leadstatus">
                                    @foreach ($statuses as $status)
                                        {{-- @if ($status->id == 4)
                                            @continue
                                        @endif --}}
                                        <option @if ($lead->lead_status == $status->id) selected @endif
                                            value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form id="commentForm" method="post" action="{{ route('assign-comment', $lead) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="comment" class="col-sm-3 col-form-label">Comment</label>
                                <div class="col-sm-9">
                                    <select name="comment_type" class="form-control">
                                        <option value="">Select Comment Type</option>
                                        <option value="payment">About Payment</option>
                                        <option value="lead">About Lead</option>
                                    </select>
                                    @if ($errors->has('comment_type'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('comment_type') }}
                                        </em>
                                    @endif
                                    <textarea name="comment" placeholder="Comment" class="form-control mt-2"></textarea>
                                    @if ($errors->has('comment'))
                                        <em class="invalid-feedback">
                                            {{ $errors->first('comment') }}
                                        </em>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-info float-right ml-2" name="submit">Save
                                    Comment</button>
                                @if (!empty($lead->comments))
                                    <button type="button" class="btn btn-sm btn-secondary float-right" data-toggle="modal"
                                        data-target=".bs-example-modal-lg" name="submit">View Comment</button>
                                @endif
                                <a href="{{ route('leads.index') }}" class="btn float-right btn-sm btn-dark mr-2" name="submit">Back to Leads</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h6>More Details</h6>
                    </div>
                    <div class="card-body row">
                        <div class="form-group col-sm-6">
                            <label for="dob">Date of Birth</label>
                            <input type="date" class="form-control" name="dob" id="dob" placeholder="Date of Birth" value="{{ old('dob',$lead->dob) }}" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="anniversary">Anniversary Date</label>
                            <input type="date" class="form-control" name="anniversary" id="anniversary" placeholder="Anniversary Date" value="{{ old('anniversary', $lead->anniversary) }}" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="address">Address</label>
                            <textarea class="form-control" name="address" id="address" placeholder="Address" rows="3" readonly>{{ old('address', $lead->address) }}</textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="more_details">More Details</label>
                            <textarea class="form-control" name="more_details" id="more_details" placeholder="More Details" rows="3" readonly>{{ old('more_details', $lead->more_details) }}</textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="total_traveller">Total Traveler</label>
                            <input type="text" class="form-control" name="total_traveller" id="total_traveller" placeholder="Total Traveler" value="{{ old('total_traveller',$lead->total_traveller) }}" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="travel_date">Travel Date</label>
                            <input type="date" class="form-control" name="travel_date" id="travel_date" placeholder="Travel Date" value="{{ old('travel_date', $lead->travel_date) }}" readonly>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="meal_plan">Meal Plan</label>
                            <textarea class="form-control" name="meal_plan" id="meal_plan" placeholder="Meal Plan" rows="3" readonly>{{ old('meal_plan', $lead->meal_plan) }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    @include('leads.reminder.modal')
    @include('leads.comments.modal')
@endsection
@push('scripts')
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        //Date and time picker
        $('#reminder').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
    </script>
    <script>
               $('#leadstatus').change(function() {
                var status = this.value;

            var lead_id = $(this).data('id');

            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('lead.change-status') }}",
                data: {'status': status, 'lead_id': lead_id},
                success: function(data){
                    $('#assign-message').css('display','block');
                    $("#assign-message").html('<center>'+ data.success +'</center>');
                    $(function(){
                        setTimeout(function() {
                            $('#assign-message').slideUp();
                        }, 4000);
                    });
                }
            });

    })
    </script>
@endpush
