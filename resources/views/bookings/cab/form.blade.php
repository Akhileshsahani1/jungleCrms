<div class="col-sm-12 mx-auto">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Trip Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="trip_type">Trip Type</label>
                    <input type="text" id="trip_type" class="form-control" placeholder="Trip Type" name="trip_type"
                        value="{{ old('trip_type', isset($booking) ? $booking->cab->trip_type : '') }}">
                    @error('trip_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                {{-- <div class="form-group col-sm-4">
                    <label for="pickup_medium">Pickup Medium</label>
                    <select type="text" class="form-control" id="pickup_medium" name="pickup_medium">
                        <option value="">Select Pickup Medium</option>
                        <option value="Hatchback"
                            {{ old('pickup_medium', isset($booking) ? $booking->cab->pickup_medium : '') == 'Hatchback' ? 'selected' : '' }}>
                            Hatchback</option>
                        <option value="MPV"
                            {{ old('pickup_medium', isset($booking) ? $booking->cab->pickup_medium : '') == 'MPV' ? 'selected' : '' }}>
                            MPV</option>
                        <option value="Sedan"
                            {{ old('pickup_medium', isset($booking) ? $booking->cab->pickup_medium : '') == 'Sedan' ? 'selected' : '' }}>
                            Sedan</option>
                        <option value="Suv"
                            {{ old('pickup_medium', isset($booking) ? $booking->cab->pickup_medium : '') == 'Suv' ? 'selected' : '' }}>
                            Suv</option>
                        <option value="Traveller"
                            {{ old('pickup_medium', isset($booking) ? $booking->cab->pickup_medium : '') == 'Traveller' ? 'selected' : '' }}>
                            Traveller</option>
                    </select>
                    @error('pickup_medium')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div> --}}
                <div class="form-group col-sm-4">
                    <label for="vehicle_type">Vehicle Type</label>
                    <select type="text" class="form-control" id="vehicle_type" name="vehicle_type">
                        <option value="">Select Vehicle Type</option>
                        <optgroup label="Main">
                            <option value="Jeep"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Jeep' ? 'selected' : '' }}>
                                Jeep</option>
                            <option value="Canter"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Canter' ? 'selected' : '' }}>
                                Canter</option>
                        </optgroup>
                        <optgroup label="Hatchback">
                            <option value="Maruti Suzuki Swift"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Maruti Suzuki Swift' ? 'selected' : '' }}>
                                Maruti Suzuki Swift</option>
                            <option value="Maruti Suzuki Celerio"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Maruti Suzuki Celerio' ? 'selected' : '' }}>
                                Maruti Suzuki Celerio</option>
                        </optgroup>
                        <optgroup label="MPV">
                            <option value="Maruti Suzuki Eeco"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Maruti Suzuki Eeco' ? 'selected' : '' }}>
                                Maruti Suzuki Eeco</option>
                            <option value="Maruti Suzuki Ertiga"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Maruti Suzuki Ertiga' ? 'selected' : '' }}>
                                Maruti Suzuki Ertiga</option>
                            <option value="Maruti Suzuki XL6"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Maruti Suzuki XL6' ? 'selected' : '' }}>
                                Maruti Suzuki XL6</option>
                            <option value="Toyota Innova Crysta"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Toyota Innova Crysta' ? 'selected' : '' }}>
                                Toyota Innova Crysta</option>
                            <option value="Innova"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Innova' ? 'selected' : '' }}>
                                Innova</option>
                        </optgroup>
                        <optgroup label="Sedan">
                            <option value="Swift Dezire"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Swift Dezire' ? 'selected' : '' }}>
                                Swift Dezire</option>
                            <option value="Toyota Etios"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Toyota Etios' ? 'selected' : '' }}>
                                Toyota Etios</option>
                        </optgroup>
                        <optgroup label="SUV">
                            <option value="Tata Safari"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Tata Safari' ? 'selected' : '' }}>
                                Tata Safari</option>
                            <option value="Mahindra Scorpio"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Mahindra Scorpio' ? 'selected' : '' }}>
                                Mahindra Scorpio</option>
                            <option value="Hyundai Creta"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Hyundai Creta' ? 'selected' : '' }}>
                                Hyundai Creta</option>
                        </optgroup>
                        <optgroup label="Traveller">
                            <option value="Force Traveller"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Force Traveller' ? 'selected' : '' }}>
                                Force Traveller</option>
                            <option value="Mini Bus"
                                {{ old('vehicle_type', isset($booking) ? $booking->cab->vehicle_type : '') == 'Mini Bus' ? 'selected' : '' }}>
                                Mini Bus</option>
                        </optgroup>
                    </select>
                    @error('vehicle_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="start_date">Journey Start Date</label>
                    <input type="date" id="start_date" class="form-control" placeholder="Journey Start Date"
                        name="start_date"
                        value="{{ old('start_date', isset($booking) ? $booking->cab->start_date : '') }}">
                    @error('start_date')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="end_date">Journey End Date</label>
                    <input type="date" id="end_date" class="form-control" placeholder="Journey End Date"
                        name="end_date" value="{{ old('end_date', isset($booking) ? $booking->cab->end_date : '') }}">
                    @error('end_date')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="days">No of Days</label>
                    <input type="number" id="days" class="form-control" placeholder="No of Days" name="days"
                        value="{{ old('days', isset($booking) ? $booking->cab->days : '0') }}">
                    @error('days')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="pick_up">Pickup Point</label>
                    <input type="text" id="pick_up" class="form-control" placeholder="Pickup Point" name="pick_up"
                        value="{{ old('pick_up', isset($booking) ? $booking->cab->pick_up : '') }}">
                    @error('pick_up')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="drop">Drop Point</label>
                    <input type="text" id="drop" class="form-control" placeholder="Drop Point" name="drop"
                        value="{{ old('drop', isset($booking) ? $booking->cab->drop : '') }}">
                    @error('drop')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="pickup_time">Pickup Time</label>
                    <input type="time" id="pickup_time" class="form-control" placeholder="Pickup Time"
                        name="pickup_time"
                        value="{{ old('pickup_time', isset($booking) ? $booking->cab->pickup_time : '') }}">
                    @error('pickup_time')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="total_riders">No of Riders</label>
                    <input type="number" id="total_riders" class="form-control" placeholder="No of Riders"
                        name="total_riders"
                        value="{{ old('total_riders', isset($booking) ? $booking->cab->total_riders : '0') }}">
                    @error('total_riders')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
                    <label for="amount">No. of Cab</label>
                    <input type="number" id="no_of_cab" class="form-control" placeholder="No. of Cab"
                        name="no_of_cab"
                        value="{{ old('no_of_cab', isset($booking) ? $booking->cab->no_of_cab : 1) }}">
                    @error('no_of_cab')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
                    <label for="payment_mode">Website</label>
                    <select name="website" id="websites" class="form-control">
                        <option value="">Select Website</option>
                        <option value="ranthamboretigerreserve.in"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'ranthamboretigerreserve.in' ? 'selected' : '' }}>
                            ranthamboretigerreserve.in</option>
                        <option value="jimcorbettnationalparkonline.in"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'jimcorbettnationalparkonline.in' ? 'selected' : '' }}>
                            jimcorbettnationalparkonline.in</option>
                        <option value="girsafaribooking.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'girsafaribooking.com' ? 'selected' : '' }}>
                            girsafaribooking.com</option>
                        <option value="jimcorbett.in"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'jimcorbett.in' ? 'selected' : '' }}>
                            jimcorbett.in</option>
                        <option value="girlionsafari.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'girlionsafari.com' ? 'selected' : '' }}>
                            girlionsafari.com</option>
                        <option value="girlion.in"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'girlion.in' ? 'selected' : '' }}>
                            girlion.in</option>
                        <option value="bandhavgarh.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'bandhavgarh.com' ? 'selected' : '' }}>
                            bandhavgarh.com</option>
                        <option value="travelwalacab.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'travelwalacab.com' ? 'selected' : '' }}>
                            travelwalacab.com</option>
                        <option value="dailytourandtravel.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'dailytourandtravel.com' ? 'selected' : '' }}>
                            dailytourandtravel.com</option>
                        <option value="internationaltrips.in"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'internationaltrips.in' ? 'selected' : '' }}>
                            Internationaltrips.in</option>
                        <option value="tadobapark.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'tadobapark.com' ? 'selected' : '' }}>
                            tadobapark.com</option>
                    </select>
                    @error('website')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
                    <label for="amount">Total Amount</label>
                    <input type="number" id="amount" class="form-control" placeholder="Total Amount"
                        name="amount" value="{{ old('amount', isset($booking) ? $booking->cab->amount : '0') }}">
                    @error('amount')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-6">
                    <label for="amount">Cab Due Amount</label>
                    <input type="number" id="cab_due_amount" class="form-control" placeholder="Cab Due Amount"
                        name="cab_due_amount"
                        value="{{ old('cab_due_amount', isset($booking) ? $booking->cab->cab_due_amount : 0) }}">
                    @error('cab_due_amount')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-6">
                    <label for="vendor_name">Choose Vendor</label>
                    <select id="vendor_name" class="form-control" name="vendor_name" onchange="$('#vendor_mobile').val($(this).find(':selected').data('phone'))">
                        <option value="">Choose Vendor </option>
                        @foreach ($vendors as $vendor)
                            @if (isset($booking))
                                <option value="{{ $vendor->name }}" data-phone="{{ $vendor->phone }}"
                                    @isset($booking->cab->vendor_name) @if ($vendor->name == $booking->cab->vendor_name) selected @endif  @else @if ($vendor->default == 'yes') selected @endif @endisset>
                                    {{ $vendor->name }} ({{ $vendor->phone }})</option>
                            @else
                                <option value="{{ $vendor->name }}" data-phone="{{ $vendor->phone }}"
                                    @if ($vendor->default == 'yes') selected @endif>{{ $vendor->name }}
                                    ({{ $vendor->phone }})</option>
                            @endif
                        @endforeach
                    </select>
                    @error('vendor_name')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
                    <label for="amount">Vendor Mobile Number</label>
                    <input type="text" id="vendor_mobile" class="form-control" placeholder="Vendor Mobile Number"
                        name="vendor_mobile"
                        value="{{ old('vendor_mobile', isset($booking) ? $booking->cab->vendor_mobile : '') }}">
                    @error('vendor_mobile')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-12">
                    <label for="note">Note</label>
                    <textarea class="form-control summernote" id="note" name="note">{{ old('note', isset($booking) ? $booking->cab->note : '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>

@include('bookings.cab.halts')
<div class="col-sm-12 mx-auto">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Payment Details</h3>
        </div>
        <div class="card-body">
            <table id="option" class="table table-striped">
                <thead>
                    <tr>
                        <th>Particular</th>
                        <th>Amount</th>
                        <th>Rate</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($booking) && count($booking->items) > 0)
                        @foreach ($booking->items as $key => $item)
                            <tr id="item-option-row{{ $key }}">
                                <td style="width:350px"><input type="text"
                                        name="item[{{ $key }}][particular]" placeholder="Particular"
                                        class="form-control" id="particular{{ $key }}" required
                                        value="{{ $item->particular }}">
                                </td>
                                <td><input type="number" name="item[{{ $key }}][amount]"
                                        placeholder="Amount" class="form-control amount"
                                        id="amount{{ $key }}" value="{{ $item->amount }}" required></td>
                                <td><input type="number" name="item[{{ $key }}][rate]" placeholder="Rate"
                                        class="form-control rate" id="rate{{ $key }}"
                                        value="{{ $item->rate }}" required></td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#item-option-row{{ $key }}').remove();"
                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                        data-original-title="Remove Button"><i
                                            class="fas fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="item-option-row0">
                            <td style="width:350px"><input type="text" name="item[0][particular]"
                                    placeholder="Particular" class="form-control" id="particular0"
                                    value="Taxable amount" required></td>
                            <td><input type="number" name="item[0][amount]" placeholder="Amount"
                                    class="form-control amount" id="amount0" value="0" required></td>
                            <td><input type="number" name="item[0][rate]" placeholder="Rate"
                                    class="form-control rate" id="rate0" value="0" required></td>
                            <td class="text-right"><button type="button" onclick="$('#item-option-row0').remove();"
                                    data-toggle="tooltip" title="" class="btn btn-danger"
                                    data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="5"><button type="button" onclick="addItem();"
                                data-toggle="tooltip" title="Add Option" class="btn btn-secondary"
                                data-original-title="Add Option"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Inclusions</h3>
        </div>
        <div class="card-body">
            <table id="inclusion" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $inclusion_row = 0;
                    @endphp
                    @foreach ($inclusions as $inclusion)
                        <tr id="inclusion-row{{ $inclusion_row }}">
                            <td><input type="text" name="inclusion[{{ $inclusion_row }}][content]"
                                    value="{{ $inclusion->content }}" placeholder="Content" class="form-control"
                                    id="content{{ $inclusion_row }}" required></td>
                            <td class="text-right"><button type="button"
                                    onclick="$('#inclusion-row{{ $inclusion_row }}').remove();" data-toggle="tooltip"
                                    title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                        class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                        @php
                            $inclusion_row++;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addCabInclusion();"
                                data-toggle="tooltip" title="Add Inclusion" class="btn btn-secondary"
                                data-original-title="Add Inclusion"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Exclusions</h3>
        </div>
        <div class="card-body">
            <table id="exclusion" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $exclusion_row = 0;
                    @endphp
                    @foreach ($exclusions as $exclusion)
                        <tr id="exclusion-row{{ $exclusion_row }}">
                            <td><input type="text" name="exclusion[{{ $exclusion_row }}][content]"
                                    value="{{ $exclusion->content }}" placeholder="Content" class="form-control"
                                    id="content{{ $exclusion_row }}" required></td>
                            <td class="text-right"><button type="button"
                                    onclick="$('#exclusion-row{{ $exclusion_row }}').remove();" data-toggle="tooltip"
                                    title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                        class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                        @php
                            $exclusion_row++;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addCabExclusion();"
                                data-toggle="tooltip" title="Add Exclusion" class="btn btn-secondary"
                                data-original-title="Add Exclusion"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Terms and conditions</h3>
        </div>
        <div class="card-body">
            <table id="term" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $term_row = 0;
                    @endphp
                    @foreach ($terms as $term)
                        <tr id="term-row{{ $term_row }}">
                            <td><input type="text" name="term[{{ $term_row }}][content]"
                                    value="{{ $term->content }}" placeholder="Content" class="form-control"
                                    id="content{{ $term_row }}" required></td>
                            <td class="text-right"><button type="button"
                                    onclick="$('#term-row{{ $term_row }}').remove();" data-toggle="tooltip"
                                    title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                        class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                        @php
                            $term_row++;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addCabTerm();"
                                data-toggle="tooltip" title="Add Term" class="btn btn-secondary"
                                data-original-title="Add Term"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <button class="btn btn-block btn-success" type="submit" form="cabForm">Submit</button>
</div>
