@extends('front.layouts.app')
@section('title', 'My Account')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>My Account</h1>
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
            <div class="card-body">
                <form method="post" id="customerForm" action="{{ route('dashboard.my-account.update', $customer->id) }}">
                    @csrf
                    @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name*</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <input type="text" id="name" class="form-control" placeholder="Name" name="name"
                                            value="{{ old('name', isset($customer) ? $customer->name : '') }}">
                                    </div>
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="mobile">Phone Number*</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" id="mobile" class="form-control" placeholder="Phone Number"
                                            name="mobile" value="{{ old('mobile', isset($customer) ? $customer->mobile : '') }}">
                                    </div>
                                    @error('mobile')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Id*</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" id="email" name="email"
                                            placeholder="Email Id"
                                            value="{{ old('email', isset($customer) ? $customer->email : '') }}">
                                    </div>
                                    @error('email')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                @php
                                    $states = App\Models\State::get(['id', 'state']);
                                @endphp
                                <div class="form-group">
                                    <label for="state">State*</label>
                                    <select id="state" name="state" class="form-control">
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->state }}"
                                                {{ old('state', $customer->state) == $state->state ? 'selected' : '' }}>
                                                {{ $state->state }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company">Company</label>
                                    <input type="text" id="company" class="form-control" placeholder="Company"
                                        name="company" value="{{ old('company', $customer->company) }}">

                                </div>
                            </div>
                            <div class="col-md-6">
                                @php
                                    $countries = App\Models\Country::get(['id', 'country']);
                                @endphp
                                <div class="form-group">
                                    <label for="country">Country*</label>
                                    <select id="country" name="country" class="form-control">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->country }}"
                                                {{ old('country', $customer->country) == $country->country ? 'selected' : '' }}>
                                                {{ $country->country }}</option>
                                        @endforeach
                                    </select>
                                    @error('country')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="gstin">GSTIN</label>
                                    <input type="text" id="gstin" class="form-control" placeholder="GSTIN" name="gstin"
                                        value="{{ old('gstin', $customer->gstin) }}">

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address">Address*</label>
                                    <textarea class="form-control" id="address" name="address" placeholder="Address">{{ old('address', $customer->address) }}</textarea>
                                    @error('address')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control" name="dob" id="dob" placeholder="Date of Birth" value="{{ old('dob',$customer->dob) }}">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="anniversary">Anniversary Date</label>
                                <input type="date" class="form-control" name="anniversary" id="anniversary" placeholder="Anniversary Date" value="{{ old('anniversary', $customer->anniversary) }}">
                            </div>                                                    
                        </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="customerForm">Update</button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
@endpush
