@extends('layouts.master')
@section('title', 'Create Hotel')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Hotel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}">Hotels</a></li>
                        <li class="breadcrumb-item active">Create Hotel</li>
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
                    <button type="submit" class="btn btn-success" form="HotelSave">Save</button>
                </div>
            </div>
            <div class="card-body">
                <form id="HotelSave" method="POST" action="{{ route('hotels.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="name">Hotel Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Hotel Name"
                                value="{{ old('name') }}">
                            @error('name')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="person">Contact Person</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="person" name="person"
                                    placeholder="Contact person" value="{{ old('person') }}">
                            </div>
                            @error('person')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="phone">Phone Number</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number"
                                    value="{{ old('phone') }}">
                            </div>
                            @error('phone')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="email">Hotel Email</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Hotel email"
                                    value="{{ old('email') }}">
                            </div>
                            @error('email')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="rating">Hotel Rating</label>
                            <select id="rating" name="rating" class="form-control">
                                <option value="" selected="">Select Rating</option>
                                <option value="1">1 Star</option>
                                <option value="2">2 Star</option>
                                <option value="3">3 Star</option>
                                <option value="4">4 Star</option>
                                <option value="5">5 Star</option>
                                <option value="6">6 Star</option>
                                <option value="7">7 Star</option>
                            </select>
                            @error('rating')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control">
                                <option value="" selected="">Select Status</option>
                                <option value="0">Disable</option>
                                <option value="1">Enable</option>
                            </select>
                            @error('status')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                         <div class="form-group col-sm-4">
                            <label for="country">Country</label>
                            <select id="country" name="country" class="form-control">
                                <option value="" selected="">Select Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country }}">{{ $country->country }} </option>
                                @endforeach
                            </select>
                            @error('country')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="state">State</label>
                            <select id="state" name="state" class="form-control">
                              
                            </select>
                            @error('state')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="city">Hotel City</label>
                            <input type="text" class="form-control" id="city" name="city" placeholder="Hotel City"
                                value="{{ old('city') }}">
                            @error('city')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="address">Hotel Address</label>
                            <textarea class="form-control" id="address" name="address"
                                placeholder="Hotel Address">{{ old('address') }}</textarea>
                            @error('address')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="images">Choose Images</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="images" name="images[]" multiple
                                        onchange="preview_image();">
                                    <label class="custom-file-label" for="exampleInputFile">Choose Images</label>
                                </div>
                            </div>
                            <div id="preview"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="HotelSave">Save</button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function preview_image() {
            var total_file = document.getElementById("images").files.length;
            for (var i = 0; i < total_file; i++) {
                $('#preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) +
                    "' width=150px' height='150px' style='margin:10px;'>");
            }
        }
        $('#country').on('change',function(){
           let value = $('#country').val();
           let url = "{{ route('get-states-by-country',':id') }}";
            url =  url.replace(':id',value);
           let states = fetch(url);
           states.then(response => {

              return response.json();
            }).then(states => {
              let html ="<option value=''>Please Select State</option>";
              let get_states = states.states;
              html += get_states.map(s => {
                return "<option value="+s.state+">"+s.state+"</option>";
              })
              $('#state').html(html);
            });
        });
    </script>
@endpush
