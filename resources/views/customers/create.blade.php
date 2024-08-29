<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="post" action="{{ route('customers.store') }}">
                @csrf              
                <div class="modal-header" style="background:#0093dd;color:white">
                    <h4 class="modal-title" id="myModalLabel">Add Customer</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Name*</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" id="name" class="form-control" placeholder="Name" name="name"
                                        value="{{ old('name', isset($lead) ? $lead->name : '') }}">
                                </div>
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
                                        name="phone" value="{{ old('phone', isset($lead) ? $lead->mobile : '') }}">
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
                                        value="{{ old('email', isset($lead) ? $lead->email : '') }}">
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
                                <label for="company">Company</label>
                                <input type="text" id="company" class="form-control" placeholder="Company"
                                    name="company" value="{{ old('company') }}">

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
                                            {{ old('country', 'India') == $country->country ? 'selected' : '' }}>
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
                                    value="{{ old('gstin') }}">

                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Address*</label>
                                <textarea class="form-control" id="address" name="address" placeholder="Address">{{ old('address', isset($lead) ? $lead->address : '') }}</textarea>
                                @error('address')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
