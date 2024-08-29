@extends('layouts.master')
@section('title', 'Create Company')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Company</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Sales</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
            <div class="card-body">
                <form method="post" action="{{ route('companies.store') }}" id="companyForm" enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name*</label>
                                        <input type="text" id="name" class="form-control" placeholder="Name" name="name"
                                            value="{{ old('name', isset($company) ? $company->name : '') }}">
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone Number*</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        </div>
                                        <input type="text" id="phone" class="form-control" placeholder="Phone Number"
                                            name="phone" value="{{ old('phone', isset($company) ? $company->phone : '') }}">
                                    </div>
                                    @error('phone')
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
                                            value="{{ old('email', isset($company) ? $company->email : '') }}">
                                    </div>
                                    @error('email')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="state">State*</label>
                                    <select id="state" name="state" class="form-control">
                                        <option value="">Select State</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->state }}"
                                                {{ old('state') == $state->state ? 'selected' : '' }}>
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
                                    <label for="pincode">Pincode</label>
                                    <input type="text" id="pincode" class="form-control" placeholder="Pincode" name="pincode"
                                        value="">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gstin">GSTIN</label>
                                    <input type="text" id="gstin" class="form-control" placeholder="GSTIN" name="gstin"
                                        value="{{ old('gstin') }}">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dark_color">Dark Color</label>
                                    <input type="color" id="dark_color" class="form-control" placeholder="Dark Color" name="dark_color"
                                        value="{{ old('dark_color') }}">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="light_color">Light Color</label>
                                    <input type="color" id="light_color" class="form-control" placeholder="Light Color" name="light_color"
                                        value="{{ old('light_color') }}">

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="websites">Websites</label>
                                    {{-- <button type="button" class="btn btn-info btn-sm select-all">Select All</button type="button">
                                    <button type="button" class="btn btn-dark btn-sm deselect-all">Deselect All</button type="button"></label> --}}
                                    <select name="websites[]" id="websites" class="form-control select2" multiple="multiple">
                                        <option value="ranthamboretigerreserve.in">ranthamboretigerreserve.in</option>
                                        <option value="jimcorbettnationalparkonline.in">jimcorbettnationalparkonline.in</option>
                                        <option value="girsafaribooking.com">girsafaribooking.com</option>
                                        <option value="jimcorbett.in">jimcorbett.in</option>
                                        <option value="girlionsafari.com">girlionsafari.com</option>
                                        <option value="girlion.in">girlion.in</option>
                                        <option value="bandhavgarh.com">bandhavgarh.com</option>
                                        <option value="travelwalacab.com">travelwalacab.com</option>
                                        <option value="dailytourandtravel.com">dailytourandtravel.com</option>
                                        <option value="internationaltrips.in">Internationaltrips.in</option>
                                        <option value="tadobapark.com">Tadobapark.com</option>
                                    </select>
                                    @error('websites')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address_1">Address 1*</label>
                                    <textarea class="form-control" id="address_1" name="address_1" placeholder="Address 1">{{ old('address_1') }}</textarea>
                                    @error('address_1')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                             <div class="col-md-12">
                                <div class="form-group">
                                    <label for="address_2">Address 2*</label>
                                    <textarea class="form-control" id="address_2" name="address_2" placeholder="Address 2">{{ old('address_2') }}</textarea>
                                    @error('address_2')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                         <div class=" col-sm-12">
                                <div class="form-group mb-3">
                                <label for="avatar">Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="image" name="image"
                                            onchange="loadPreview(this);">
                                        <label class="custom-file-label" for="image">Choose Image</label>
                                    </div>
                                </div>
                                @if ($errors->has('image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                @endif
                                <img id="preview_img" src="https://via.placeholder.com/150" class="mt-2" width="100"
                                    height="100" />
                            </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="companyForm">Save</button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('#websites').select2({
                theme: 'bootstrap4'
            })
            $('.select-all').click(function() {
                let $select2 = $(this).parent().siblings('#websites')
                $select2.find('option').prop('selected', 'selected')
                $select2.trigger('change')
            })
            $('.deselect-all').click(function() {
                let $select2 = $(this).parent().siblings('#websites')
                $select2.find('option').prop('selected', '')
                $select2.trigger('change')
            })
        });
        function loadPreview(input, id) {
            id = id || '#preview_img';
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $(id)
                        .attr('src', e.target.result)
                        .width(100)
                        .height(100);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
