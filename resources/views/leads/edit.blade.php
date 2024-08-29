@extends('layouts.master')
@section('title', 'Edit Lead')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Lead</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
                        <li class="breadcrumb-item active">Edit Lead</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                </div>
            </div>
            <form action="{{ route('leads.update', $lead->id) }}" method="POST" enctype="multipart/form-data" id="leadform">
                @csrf
                @method('PUT')
                <div class="card-body row">

                    <div class="form-group col-sm-6 {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Name*</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', isset($lead) ? $lead->name : '') }}">
                        @error('name')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">Email*</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="{{ old('email', isset($lead) ? $lead->email : '') }}">
                        @error('email')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-6 {{ $errors->has('mobile') ? 'has-error' : '' }}">
                        <label for="mobile">Mobile*</label>
                        <input type="text" id="mobile" name="mobile" class="form-control"
                            value="{{ old('mobile', isset($lead) ? $lead->mobile : '') }}">
                        @error('mobile')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    @role('administrator')
                        <div class="form-group col-sm-6">
                            <label for="mobile">Website*</label>
                            @php
                                $roles = Auth::user()->roles->pluck('name');
                            @endphp

                            <select class="form-control" name="website" onchange="destInput(value)">
                                <option value="">Please select website</option>
                                <option value="ranthamboretigerreserve.in" @if ($lead->website == 'ranthamboretigerreserve.in') selected @endif>
                                    Ranthamboretigerreserve.in</option>
                                <option value="jimcorbettnationalparkonline.in"
                                    @if ($lead->website == 'jimcorbettnationalparkonline.in') selected @endif>Jimcorbettnationalparkonline.in</option>
                                <option value="girsafaribooking.com" @if ($lead->website == 'girsafaribooking.com') selected @endif>
                                    Girsafaribooking.com</option>
                                <option value="jimcorbett.in" @if ($lead->website == 'jimcorbett.in') selected @endif>Jimcorbett.in
                                </option>
                                <option value="girlionsafari.com" @if ($lead->website == 'girlionsafari.com') selected @endif>
                                    Girlionsafari.com</option>
                                <option value="girlion.in" @if ($lead->website == 'girlion.in') selected @endif>Girlion.in</option>
                                <option value="bandhavgarh.com" @if ($lead->website == 'bandhavgarh.com') selected @endif>
                                    Bandhavgarh.com</option>
                                <option value="travelwalacab.com" @if ($lead->website == 'travelwalacab.com') selected @endif>
                                    Travelwalacab.com</option>
                                <option value="dailytourandtravel.com" @if ($lead->website == 'dailytourandtravel.com') selected @endif>
                                    Dailytourandtravel.com</option>
                                     <option value="internationaltrips.in" @if ($lead->website == 'internationaltrips.in') selected @endif>
                                    Internationaltrips.in</option>
                                    <option value="tadobapark.com" @if ($lead->website == 'tadobapark.com') selected @endif>
                                    tadobapark.com</option>
                                    <option value="SMO" @if ($lead->website == 'SMO') selected @endif>
                                    SMO</option>
                            </select>
                            @error('website')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <div class="form-group col-sm-6">
                            <label for="mobile">Website*</label>
                            @php
                                $user = Auth::user();
                            @endphp

                            <select class="form-control" name="website"  onchange="destInput(value)">
                                <option value="">Please select website</option>
                                <option value="ranthamboretigerreserve.in"
                                    @if ($user->hasRole('ranthamboretigerreserve.in')) style="display: show" @else style="display: none;" @endif>
                                    Ranthamboretigerreserve.in</option>
                                <option value="jimcorbettnationalparkonline.in"
                                    @if ($user->hasRole('jimcorbettnationalparkonline.in')) style="display: show" @else style="display: none;" @endif>
                                    Jimcorbettnationalparkonline.in</option>
                                <option value="girsafaribooking.com"
                                    @if ($user->hasRole('girsafaribooking.com')) style="display: show" @else style="display: none;" @endif>
                                    Girsafaribooking.com</option>
                                <option value="jimcorbett.in"
                                    @if ($user->hasRole('jimcorbett.in')) style="display: show" @else style="display: none;" @endif>
                                    Jimcorbett.in</option>
                                <option value="girlionsafari.com"
                                    @if ($user->hasRole('girlionsafari.com')) style="display: show" @else style="display: none;" @endif>
                                    Girlionsafari.com</option>
                                <option value="girlion.in"
                                    @if ($user->hasRole('girlion.in')) style="display: show" @else style="display: none;" @endif>
                                    Girlion.in</option>
                                <option value="bandhavgarh.com"
                                    @if ($user->hasRole('bandhavgarh.com')) style="display: show" @else style="display: none;" @endif>
                                    Bandhavgarh.com</option>
                                <option value="travelwalacab.com"
                                    @if ($user->hasRole('travelwalacab.com')) style="display: show" @else style="display: none;" @endif>
                                    Travelwalacab.com</option>
                                <option value="dailytourandtravel.com"
                                    @if ($user->hasRole('dailytourandtravel.com')) style="display: show" @else style="display: none;" @endif>
                                    Dailytourandtravel.com</option>
                                    <option value="SMO"
                                    @if ($user->hasRole('SMO')) style="display: show" @else style="display: none;" @endif>
                                    SMO</option>
                            </select>
                            @error('website')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    @endrole
                    <div id="destinationRow" class="<?php if($lead->website == 'SMO') echo "";else echo "d-none";?> form-group col-sm-6 {{ $errors->has('destination') ? 'has-error' : '' }}">
                        <label for="destination">Destination</label>
                        <input type="text" id="destination" name="destination" class="form-control"
                            value="{{ old('destination', isset($lead) ? $lead->destination : '') }}">
                        @error('destination')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="meta">Meta*</label>
                        <textarea id="meta" name="meta" class="form-control">{{ $lead->meta }}</textarea>
                        @error('meta')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="assigned_to">Assign to*</label>
                        <select class="form-control" name="assigned_to">
                            @role('administrator')
                                <option value="">Select Lead Manager</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @if ($lead->assigned_to == $user->id) selected @endif>
                                        {{ $user->name }}</option>
                                @endforeach
                            @else
                                <option value="{{ Auth::User()->id }}" selected>{{ Auth::User()->name }}</option>
                            @endrole
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="lead_status">Lead Status</label>
                        <select class="form-control" name="lead_status">
                            <option value="">Please Select Lead Status</option>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}" @if ($status->id == $lead->lead_status) selected @endif>
                                    {{ $status->name }}</option>
                            @endforeach
                        </select>
                        @error('lead_status')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="payment_status">Payment Status</label>
                        <select class="form-control" name="payment_status">
                            <option value="waiting" selected>Waiting</option>
                        </select>
                    </div>
                </div>
                <div class="card-header bg-dark">
                    <h6>More Details</h6>
                </div>
                <div class="card-body row">
                    <div class="form-group col-sm-6">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" name="dob" id="dob" placeholder="Date of Birth" value="{{ old('dob',$lead->dob) }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="anniversary">Anniversary Date</label>
                        <input type="date" class="form-control" name="anniversary" id="anniversary" placeholder="Anniversary Date" value="{{ old('anniversary', $lead->anniversary) }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="address">Address</label>
                        <textarea class="form-control" name="address" id="address" placeholder="Address" rows="3">{{ old('address', $lead->address) }}</textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="more_details">More Details</label>
                        <textarea class="form-control" name="more_details" id="more_details" placeholder="More Details" rows="3">{{ old('more_details', $lead->more_details) }}</textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="total_traveller">Total Traveler</label>
                        <input type="text" class="form-control" name="total_traveller" id="total_traveller" placeholder="Total Traveler" value="{{ old('total_traveller',$lead->total_traveller) }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="travel_date">Travel Date</label>
                        <input type="date" class="form-control" name="travel_date" id="travel_date" placeholder="Travel Date" value="{{ old('travel_date', $lead->travel_date) }}">
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="meal_plan">Meal Plan</label>
                        <textarea class="form-control" name="meal_plan" id="meal_plan" placeholder="Meal Plan" rows="3">{{ old('meal_plan', $lead->meal_plan) }}</textarea>
                    </div>
                </div>
            </form>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="leadform">Save</button>
            </div>
        </div>
    </section>
@endsection
<script>
    function destInput(val){
        if(val=="SMO"){
            $("#destinationRow").removeClass("d-none");
        }else{
            $("#destinationRow").addClass("d-none");
        }
    }
</script>