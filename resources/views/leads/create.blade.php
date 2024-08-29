@extends('layouts.master')
@section('title', 'Create Lead')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Lead</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
                        <li class="breadcrumb-item active">Create Lead</li>
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
            <form action="{{ route('leads.store') }}" method="POST" enctype="multipart/form-data" id="leadform">
            @csrf
            <div class="card-body row">               
                    <div class="form-group col-sm-6 {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">Name*</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', isset($user) ? $user->name : '') }}">
                        @error('name')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6 {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label for="email">Email*</label>
                        <input type="email" id="email" name="email" class="form-control"
                            value="{{ old('email', isset($user) ? $user->email : '') }}">
                        @error('email')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group col-sm-6 {{ $errors->has('mobile') ? 'has-error' : '' }}">
                        <label for="mobile">Mobile*</label>
                        <input type="text" id="mobile" name="mobile" class="form-control"
                            value="{{ old('mobile', isset($user) ? $user->mobile : '') }}">
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
                                <option value="ranthamboretigerreserve.in">Ranthamboretigerreserve.in</option>
                                <option value="jimcorbettnationalparkonline.in">Jimcorbettnationalparkonline.in</option>
                                <option value="girsafaribooking.com">Girsafaribooking.com</option>
                                <option value="jimcorbett.in">Jimcorbett.in</option>
                                <option value="girlionsafari.com">Girlionsafari.com</option>
                                <option value="girlion.in">Girlion.in</option>
                                <option value="bandhavgarh.com">Bandhavgarh.com</option>
                                <option value="travelwalacab.com">Travelwalacab.com</option>
                                <option value="dailytourandtravel.com">Dailytourandtravel.com</option>
                                 <option value="internationaltrips.in">Internationaltrips.in</option>
                                 <option value="tadobapark.com">tadobapark.com</option>
                                 <option value="SMO">SMO</option>
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
                                <option value="dailytourandtravel.com"
                                    @if ($user->hasRole('internationaltrips.in')) style="display: show" @else style="display: none;" @endif>
                                    internationaltrips.in</option>
                                <option value="tadobapark.com"
                                    @if ($user->hasRole('tadobapark.com')) style="display: show" @else style="display: none;" @endif>
                                    tadobapark.com</option>
                                    <option value="SMO"
                                    @if ($user->hasRole('SMO')) style="display: show" @else style="display: none;" @endif>
                                    SMO</option>
                            </select>
                            @error('website')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    @endrole

                    <div id="destinationRow" class="d-none form-group col-sm-6 {{ $errors->has('destination') ? 'has-error' : '' }}">
                        <label for="destination">Destination</label>
                        <input type="text" id="destination" name="destination" class="form-control"
                            value="{{ old('destination', isset($destination) ? $user->destination : '') }}">
                        @error('destination')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="meta">Meta*</label>
                        <textarea id="meta" name="meta" class="form-control"></textarea>
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
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
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
                                <option value="{{ $status->id }}" @if ($status->id == 1) selected @endif>
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
                    <input type="date" class="form-control" name="dob" id="dob" placeholder="Date of Birth" value="{{ old('dob') }}">
                </div>
                <div class="form-group col-sm-6">
                    <label for="anniversary">Anniversary Date</label>
                    <input type="date" class="form-control" name="anniversary" id="anniversary" placeholder="Anniversary Date" value="{{ old('anniversary') }}">
                </div>
                <div class="form-group col-sm-6">
                    <label for="address">Address</label>
                    <textarea class="form-control" name="address" id="address" placeholder="Address" rows="3">{{ old('address') }}</textarea>
                </div>
                <div class="form-group col-sm-6">
                    <label for="more_details">More Details</label>
                    <textarea class="form-control" name="more_details" id="more_details" placeholder="More Details" rows="3">{{ old('more_details') }}</textarea>
                </div>
                <div class="form-group col-sm-6">
                    <label for="total_traveller">Total Traveler</label>
                    <input type="text" class="form-control" name="total_traveller" id="total_traveller" placeholder="Total Traveler" value="{{ old('total_traveller') }}">
                </div>
                <div class="form-group col-sm-6">
                    <label for="travel_date">Travel Date</label>
                    <input type="date" class="form-control" name="travel_date" id="travel_date" placeholder="Travel Date" value="{{ old('travel_date') }}">
                </div>
                <div class="form-group col-sm-12">
                    <label for="meal_plan">Meal Plan</label>
                    <textarea class="form-control" name="meal_plan" id="meal_plan" placeholder="Meal Plan" rows="3">{{ old('meal_plan') }}</textarea>
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
