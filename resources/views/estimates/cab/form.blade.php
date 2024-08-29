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
                        value="{{ old('trip_type', isset($estimate) ? $estimate->cab->trip_type : '') }}">
                    @error('trip_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                {{-- <div class="form-group col-sm-4">
                    <label for="pickup_medium">Pickup Medium</label>
                    <select type="text" class="form-control" id="pickup_medium" name="pickup_medium">
                        <option value="">Select Pickup Medium</option>
                        <option value="Hatchback" {{ old('pickup_medium', isset($estimate) ? $estimate->cab->pickup_medium : '') == 'Hatchback' ? 'selected' : '' }}>Hatchback</option>
                        <option value="MPV" {{ old('pickup_medium', isset($estimate) ? $estimate->cab->pickup_medium : '') == 'MPV' ? 'selected' : '' }}>MPV</option>
                        <option value="Sedan" {{ old('pickup_medium', isset($estimate) ? $estimate->cab->pickup_medium : '') == 'Sedan' ? 'selected' : ''}}>Sedan</option>
                        <option value="Suv" {{ old('pickup_medium', isset($estimate) ? $estimate->cab->pickup_medium : '') == 'Suv' ? 'selected' : ''}}>Suv</option>
                        <option value="Traveller" {{ old('pickup_medium', isset($estimate) ? $estimate->cab->pickup_medium : '') == 'Traveller' ? 'selected' : ''}}>Traveller</option>
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
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Jeep' ? 'selected' : '' }}>
                                Jeep</option>
                            <option value="Canter"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Canter' ? 'selected' : '' }}>
                                Canter</option>
                        </optgroup>
                        <optgroup label="Hatchback">
                            <option value="Maruti Suzuki Swift"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Maruti Suzuki Swift' ? 'selected' : '' }}>
                                Maruti Suzuki Swift</option>
                            <option value="Maruti Suzuki Celerio"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Maruti Suzuki Celerio' ? 'selected' : '' }}>
                                Maruti Suzuki Celerio</option>
                        </optgroup>
                        <optgroup label="MPV">
                            <option value="Maruti Suzuki Eeco"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Maruti Suzuki Eeco' ? 'selected' : '' }}>
                                Maruti Suzuki Eeco</option>
                            <option value="Maruti Suzuki Ertiga"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Maruti Suzuki Ertiga' ? 'selected' : '' }}>
                                Maruti Suzuki Ertiga</option>
                            <option value="Maruti Suzuki XL6"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Maruti Suzuki XL6' ? 'selected' : '' }}>
                                Maruti Suzuki XL6</option>
                            <option value="Toyota Innova Crysta"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Toyota Innova Crysta' ? 'selected' : '' }}>
                                Toyota Innova Crysta</option>
                            <option value="Innova"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Innova' ? 'selected' : '' }}>
                                Innova</option>
                        </optgroup>
                        <optgroup label="Sedan">
                            <option value="Swift Dezire"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Swift Dezire' ? 'selected' : '' }}>
                                Swift Dezire</option>
                            <option value="Toyota Etios"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Toyota Etios' ? 'selected' : '' }}>
                                Toyota Etios</option>
                        </optgroup>
                        <optgroup label="SUV">
                            <option value="Tata Safari"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Tata Safari' ? 'selected' : '' }}>
                                Tata Safari</option>
                            <option value="Mahindra Scorpio"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Mahindra Scorpio' ? 'selected' : '' }}>
                                Mahindra Scorpio</option>
                            <option value="Hyundai Creta"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Hyundai Creta' ? 'selected' : '' }}>
                                Hyundai Creta</option>
                        </optgroup>
                        <optgroup label="Traveller">
                            <option value="Force Traveller"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Force Traveller' ? 'selected' : '' }}>
                                Force Traveller</option>
                            <option value="Mini Bus"
                                {{ old('vehicle_type', isset($estimate) ? $estimate->cab->vehicle_type : '') == 'Mini Bus' ? 'selected' : '' }}>
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
                        value="{{ old('start_date', isset($estimate) ? $estimate->cab->start_date : '') }}">
                    @error('start_date')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="end_date">Journey End Date</label>
                    <input type="date" id="end_date" class="form-control" placeholder="Journey End Date"
                        name="end_date"
                        value="{{ old('end_date', isset($estimate) ? $estimate->cab->end_date : '') }}">
                    @error('end_date')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="days">No of Days</label>
                    <input type="number" id="days" class="form-control" placeholder="No of Days" name="days"
                        value="{{ old('days', isset($estimate) ? $estimate->cab->days : '0') }}">
                    @error('days')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="pick_up">Pickup Point</label>
                    <input type="text" id="pick_up" class="form-control" placeholder="Pickup Point" name="pick_up"
                        value="{{ old('pick_up', isset($estimate) ? $estimate->cab->pick_up : '') }}">
                    @error('pick_up')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="drop">Drop Point</label>
                    <input type="text" id="drop" class="form-control" placeholder="Drop Point" name="drop"
                        value="{{ old('drop', isset($estimate) ? $estimate->cab->drop : '') }}">
                    @error('drop')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="pickup_time">Pickup Time</label>
                    <input type="time" id="pickup_time" class="form-control" placeholder="Pickup Time"
                        name="pickup_time"
                        value="{{ old('pickup_time', isset($estimate) ? $estimate->cab->pickup_time : '') }}">
                    @error('pickup_time')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="total_riders">No of Riders</label>
                    <input type="number" id="total_riders" class="form-control" placeholder="No of Riders"
                        name="total_riders"
                        value="{{ old('total_riders', isset($estimate) ? $estimate->cab->total_riders : '0') }}">
                    @error('total_riders')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class='{{ isset($lead->id) ? "form-group col-sm-12" : "form-group col-sm-6" }}'>
                    <label for="amount">No. of Cab</label>
                    <input type="number" id="no_of_cab" class="form-control" placeholder="No. of Cab"
                        name="no_of_cab"
                        value="{{ old('no_of_cab', isset($estimate) ? $estimate->cab->no_of_cab : 1) }}">
                    @error('no_of_cab')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                @if (!isset($lead->id))
                    <div class="form-group col-sm-6">
                        <label for="payment_mode">Website</label>
                        <select name="website" id="websites" class="form-control">
                            <option value="">Select Website</option>
                            <option value="ranthamboretigerreserve.in"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'ranthamboretigerreserve.in' ? 'selected' : '' }}>
                                ranthamboretigerreserve.in</option>
                            <option value="jimcorbettnationalparkonline.in"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'jimcorbettnationalparkonline.in' ? 'selected' : '' }}>
                                jimcorbettnationalparkonline.in</option>
                            <option value="girsafaribooking.com"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'girsafaribooking.com' ? 'selected' : '' }}>
                                girsafaribooking.com</option>
                            <option value="jimcorbett.in"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'jimcorbett.in' ? 'selected' : '' }}>
                                jimcorbett.in</option>
                            <option value="girlionsafari.com"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'girlionsafari.com' ? 'selected' : '' }}>
                                girlionsafari.com</option>
                            <option value="girlion.in"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'girlion.in' ? 'selected' : '' }}>
                                girlion.in</option>
                            <option value="bandhavgarh.com"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'bandhavgarh.com' ? 'selected' : '' }}>
                                bandhavgarh.com</option>
                            <option value="travelwalacab.com"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'travelwalacab.com' ? 'selected' : '' }}>
                                travelwalacab.com</option>
                            <option value="dailytourandtravel.com"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'dailytourandtravel.com' ? 'selected' : '' }}>
                                dailytourandtravel.com</option>
                             <option value="internationaltrips.in"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'internationaltrips.in' ? 'selected' : '' }}>
                                Internationaltrips.in</option>
                             <option value="tadobapark.com"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'tadobapark.com' ? 'selected' : '' }}>
                                tadobapark.com</option>
                                <option value="SMO"
                                {{ old('website', isset($estimate) ? $estimate->website : '') == 'SMO' ? 'selected' : '' }}>
                                SMO</option>
                        </select>
                        @error('website')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
                <div class="form-group col-sm-6">
                    <label for="payment_type">Payment Type</label>
                    <select class="form-control" name="payment_type[]" id="payment_type" multiple="multiple">
                        <option></option>
                        <option value="1" <?php if(isset($estimate->payment_type) && in_array(1,explode(",",$estimate->payment_type))) echo "selected"; else echo "";  ?>>50%</option>
                        <option value="2" <?php if(isset($estimate->payment_type) && in_array(2,explode(",",$estimate->payment_type))) echo "selected"; else echo "";  ?>>100%</option>
                    </select>
                    @error('estimate_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
                    <label for="payment_mode">Payment Mode</label>
                    <select type="text" class="form-control" id="payment_mode" name="payment_modes[]" multiple>
                        <option></option>
                        @foreach ($payment_modes as $payment_mode)
                            <option value="{{ $payment_mode->id }}"
                                {{ collect(old('payment_modes', isset($estimate) ? $estimate->payment_modes : ''))->contains($payment_mode->id) ? 'selected' : '' }}>
                                {{ $payment_mode->name }}</option>
                        @endforeach
                    </select>
                    @error('payment_modes')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-12">
                    <label for="note">Note</label>
                    <textarea class="form-control summernote" id="note" name="note">{{ old('note', isset($estimate) ? $estimate->cab->note : '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
@include('estimates.cab.halts')
<div class="col-sm-12 mx-auto">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Cab Options</h3>
        </div>
        <div class="card-body">
            <table id="option" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content</th>
                        <th>Amount</th>
                        <th>Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($estimate) && count($estimate->cab_options) > 0)
                        @foreach ($estimate->cab_options as $key => $option)
                            <tr id="cab-option-row{{ $key }}">
                                <td style="width:350px"><input type="text"
                                        name="option[{{ $key }}][content]" placeholder="Content"
                                        class="form-control" id="content{{ $key }}" required
                                        value="{{ $option->content }}"></td>
                                <td><input type="number" name="option[{{ $key }}][amount]"
                                        placeholder="Amount" class="form-control amount"
                                        id="amount{{ $key }}" value="{{ $option->amount }}" required></td>
                                <td><input type="number" name="option[{{ $key }}][discount]"
                                        placeholder="Discount" class="form-control discount"
                                        id="discount{{ $key }}" value="{{ $option->discount }}" required>
                                </td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#cab-option-row{{ $key }}').remove();"
                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                        data-original-title="Remove Button"><i
                                            class="fas fa-minus-circle"></i></button></td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="cab-option-row0">
                            <td style="width:350px"><input type="text" name="option[0][content]"
                                    placeholder="Content" class="form-control" id="content0" required></td>
                            <td><input type="number" name="option[0][amount]" placeholder="Amount"
                                    class="form-control amount" id="amount0" value="0" required></td>
                            <td><input type="number" name="option[0][discount]" placeholder="Discount"
                                    class="form-control discount" id="discount0" value="0" required></td>
                            <td class="text-right"><button type="button" onclick="$('#cab-option-row0').remove();"
                                    data-toggle="tooltip" title="" class="btn btn-danger"
                                    data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="5"><button type="button" onclick="addCabOption();"
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
            <h3 class="card-title">GST & PG Charges</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="gst_filed">GST Filed</label>
                    <select id="gst_filed" class="form-control" name="gst_filed">
                        <option value=""
                            {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '' ? 'selected' : '' }}>
                            GST not required</option>
                        <option value="0"
                            {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '0' ? 'selected' : '' }}>
                            GST included in the package</option>
                        <option value="5"
                            {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '5' ? 'selected' : '' }}>
                            GST 5%</option>
                        <option value="18"
                            {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '18' ? 'selected' : '' }}>
                            GST 18%</option>
                    </select>
                    @error('gst_filed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
                    <label for="pg_charges_filed">PG charges filed</label>
                    <select id="pg_charges_filed" class="form-control" name="pg_charges_filed">
                        <option value=""
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '' ? 'selected' : '' }}>
                            PG charges not required</option>
                        <option value="0"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '0' ? 'selected' : '' }}>
                            PG charges included in the package</option>
                        <option value="3"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '3' ? 'selected' : '' }}>
                            PG charges 3%</option>
                        <option value="4"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '4' ? 'selected' : '' }}>
                            PG charges 4%</option>
                        <option value="5"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '5' ? 'selected' : '' }}>
                            PG charges 5%</option>
                        <option value="6"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '6' ? 'selected' : '' }}>
                            PG charges 6%</option>
                        <option value="7"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '7' ? 'selected' : '' }}>
                            PG charges 7%</option>
                        <option value="8"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '8' ? 'selected' : '' }}>
                            PG charges 8%</option>
                    </select>
                    @error('pg_charges_filed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
@include('estimates.cab.iternaries')
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
