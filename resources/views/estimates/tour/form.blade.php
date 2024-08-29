<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-indigo">
            <h3 class="card-title">Tour Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="payment_mode">Estimate Type</label>
                    <select class="form-control" name="estimate_type[]" id="type" multiple="multiple">
                        <option></option>
                        <option value="cab" {{ (collect(old('estimate_type', in_array('cab', $estimate_type) ? $estimate_type: ''))->contains('cab')) ? 'selected' : '' }}>Cab</option>
                        <option value="hotel" {{ (collect(old('estimate_type', in_array('hotel', $estimate_type) ? $estimate_type : ''))->contains('hotel')) ? 'selected' : '' }}>Hotel</option>
                        <option value="safari" {{ (collect(old('estimate_type', in_array('safari', $estimate_type) ? $estimate_type : ''))->contains('safari')) ? 'selected' : '' }}>Safari</option>
                    </select>
                    @error('estimate_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-8">
                    <label for="payment_mode">Payment Mode</label>
                    <select type="text" class="form-control" id="payment_mode" name="payment_modes[]" multiple>
                        <option></option>
                        @foreach ($payment_modes as $payment_mode)
                            <option value="{{ $payment_mode->id }}"
                                {{ collect(old('payment_modes', isset($estimate) ? $estimate->payment_modes : ''))->contains($payment_mode->id)? 'selected': '' }}>
                                {{ $payment_mode->name }}</option>
                        @endforeach
                    </select>
                    @error('payment_modes')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
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

                <div class="form-group col-sm-8">
                    <label for="payment_mode">Website</label>
                    <select name="website" id="websites" class="form-control">
                                        <option value="">Select Website</option>
                                        <option value="ranthamboretigerreserve.in" {{ old('website', isset($estimate) ? $estimate->website : '') == 'ranthamboretigerreserve.in' ? 'selected' : '' }}>ranthamboretigerreserve.in</option>
                                        <option value="jimcorbettnationalparkonline.in" {{ old('website', isset($estimate) ? $estimate->website : '') == 'jimcorbettnationalparkonline.in' ? 'selected' : '' }}>jimcorbettnationalparkonline.in</option>
                                        <option value="girsafaribooking.com" {{ old('website', isset($estimate) ? $estimate->website : '') == 'girsafaribooking.com' ? 'selected' : '' }}>girsafaribooking.com</option>
                                        <option value="jimcorbett.in" {{ old('website', isset($estimate) ? $estimate->website : '') == 'jimcorbett.in' ? 'selected' : '' }}>jimcorbett.in</option>
                                        <option value="girlionsafari.com" {{ old('website', isset($estimate) ? $estimate->website : '') == 'girlionsafari.com' ? 'selected' : '' }}>girlionsafari.com</option>
                                        <option value="girlion.in" {{ old('website', isset($estimate) ? $estimate->website : '') == 'girlion.in' ? 'selected' : '' }}>girlion.in</option>
                                        <option value="bandhavgarh.com" {{ old('website', isset($estimate) ? $estimate->website : '') == 'bandhavgarh.com' ? 'selected' : '' }}>bandhavgarh.com</option>
                                        <option value="travelwalacab.com" {{ old('website', isset($estimate) ? $estimate->website : '') == 'travelwalacab.com' ? 'selected' : '' }}>travelwalacab.com</option>
                                        <option value="dailytourandtravel.com" {{ old('website', isset($estimate) ? $estimate->website : '') == 'dailytourandtravel.com' ? 'selected' : '' }}>dailytourandtravel.com</option>
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

            </div>
        </div>
    </div>
</div>

<div class="col-sm-12 mx-auto" id="cab">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Cab Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="trip_type">Trip Type</label>
                    <input type="text" id="trip_type" class="form-control cab" placeholder="Trip Type" name="trip_type"
                        value="{{ old('trip_type', in_array('cab', $estimate_type) ? $estimate->cab->trip_type : '') }}">
                    @error('trip_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
               
                <div class="form-group col-sm-4">
                    <label for="cab_type">Vehicle Type</label>
                    <select type="text" class="form-control cab" id="cab_type" name="cab_type">
                        <option value="">Select Vehicle Type</option>
                        <optgroup label="Main">
                            <option value="Jeep"  {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Jeep'? 'selected': '' }}>Jeep</option>
                            <option value="Canter"  {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Canter'? 'selected': '' }}>Canter</option>
                        </optgroup>
                        <optgroup label="Hatchback">
                            <option value="Maruti Suzuki Swift"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Maruti Suzuki Swift'? 'selected': '' }}>
                                Maruti Suzuki Swift</option>
                            <option value="Maruti Suzuki Celerio"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Maruti Suzuki Celerio'? 'selected': '' }}>
                                Maruti Suzuki Celerio</option>
                        </optgroup>
                        <optgroup label="MPV">
                            <option value="Maruti Suzuki Eeco"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Maruti Suzuki Eeco'? 'selected': '' }}>
                                Maruti Suzuki Eeco</option>
                            <option value="Maruti Suzuki Ertiga"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Maruti Suzuki Ertiga'? 'selected': '' }}>
                                Maruti Suzuki Ertiga</option>
                            <option value="Maruti Suzuki XL6"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Maruti Suzuki XL6'? 'selected': '' }}>
                                Maruti Suzuki XL6</option>
                            <option value="Toyota Innova Crysta"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Toyota Innova Crysta'? 'selected': '' }}>
                                Toyota Innova Crysta</option>
                                <option value="Innova"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Innova'? 'selected': '' }}>
                                Innova</option>
                        </optgroup>
                        <optgroup label="Sedan">
                            <option value="Swift Dezire"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Swift Dezire'? 'selected': '' }}>
                                Swift Dezire</option>
                            <option value="Toyota Etios"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Toyota Etios'? 'selected': '' }}>
                                Toyota Etios</option>
                        </optgroup>
                        <optgroup label="SUV">
                            <option value="Tata Safari"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Tata Safari' ? 'selected' : '' }}>
                                Tata Safari</option>
                            <option value="Mahindra Scorpio"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Mahindra Scorpio'? 'selected': '' }}>
                                Mahindra Scorpio</option>
                            <option value="Hyundai Creta"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Hyundai Creta'? 'selected': '' }}>
                                Hyundai Creta</option>
                        </optgroup>
                        <optgroup label="Traveller">
                            <option value="Force Traveller"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Force Traveller'? 'selected': '' }}>
                                Force Traveller</option>
                            <option value="Mini Bus"
                                {{ old('cab_type', in_array('cab', $estimate_type) ? $estimate->cab->vehicle_type : '') == 'Mini Bus' ? 'selected' : '' }}>
                                Mini Bus</option>
                        </optgroup>
                    </select>
                    @error('cab_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="start_date">Journey Start Date</label>
                    <input type="date" id="start_date" class="form-control cab" placeholder="Journey Start Date"
                        name="start_date"
                        value="{{ old('start_date', in_array('cab', $estimate_type) ? $estimate->cab->start_date : '') }}">
                    @error('start_date')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="end_date">Journey End Date</label>
                    <input type="date" id="end_date" class="form-control cab" placeholder="Journey End Date"
                        name="end_date"
                        value="{{ old('end_date', in_array('cab', $estimate_type) ? $estimate->cab->end_date : '') }}">
                    @error('end_date')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="days">No of Days</label>
                    <input type="number" id="days" class="form-control cab" placeholder="No of Days" name="days"
                        value="{{ old('days', in_array('cab', $estimate_type) ? $estimate->cab->days : '') }}">
                    @error('days')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="pick_up">Pickup Point</label>
                    <input type="text" id="pick_up" class="form-control cab" placeholder="Pickup Point" name="pick_up"
                        value="{{ old('pick_up', in_array('cab', $estimate_type) ? $estimate->cab->pick_up : '') }}">
                    @error('pick_up')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="drop">Drop Point</label>
                    <input type="text" id="drop" class="form-control cab" placeholder="Drop Point" name="drop"
                        value="{{ old('drop', in_array('cab', $estimate_type) ? $estimate->cab->drop : '') }}">
                    @error('drop')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="pickup_time">Pickup Time</label>
                    <input type="time" id="pickup_time" class="form-control cab" placeholder="Pickup Time"
                        name="pickup_time"
                        value="{{ old('pickup_time', in_array('cab', $estimate_type) ? $estimate->cab->pickup_time : '') }}">
                    @error('pickup_time')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="total_riders">No of Riders</label>
                    <input type="number" id="total_riders" class="form-control cab" placeholder="No of Riders"
                        name="total_riders"
                        value="{{ old('total_riders', in_array('cab', $estimate_type) ? $estimate->cab->total_riders : '') }}">
                    @error('total_riders')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-12">
                    <label for="amount">No. of Cab</label>
                    <input type="number" id="no_of_cab" class="form-control cab" placeholder="No. of Cab" name="no_of_cab"
                        value="{{ old('no_of_cab', in_array('cab', $estimate_type) ? $estimate->cab->no_of_cab : 1) }}">
                    @error('no_of_cab')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-12">
                    <label for="note">Cab Note</label>
                    <textarea class="form-control cab summernote" id="cab_note"
                        name="cab_note">{{ old('note', in_array('cab', $estimate_type) ? $estimate->cab->note : '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
    @include('estimates.tour.halts')
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Cab Content</h3>
        </div>
        <div class="card-body">
            <table id="cab_option" class="table table-striped">
                <thead>
                    <tr>
                        <th>Cab Content</th>
                        <th>Amount</th>
                        <th>Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @if (in_array('cab', $estimate_type) && count($estimate->cab_options) > 0)
                        @foreach ($estimate->cab_options as $key => $option)
                            <tr id="cab-option-row{{ $key }}">
                                <td style="width:350px"><input type="text"
                                        name="cab_option[{{ $key }}][content]" placeholder="Content"
                                        class="form-control cab" id="cab_content{{ $key }}" required
                                        value="{{ $option->content }}"></td>
                                <td><input type="number" name="cab_option[{{ $key }}][amount]"
                                        placeholder="Amount" class="form-control cab"
                                        id="cab_amount{{ $key }}" value="{{ $option->amount }}" required>
                                </td>
                                <td><input type="number" name="cab_option[{{ $key }}][discount]"
                                        placeholder="Discount" class="form-control cab"
                                        id="cab_discount{{ $key }}" value="{{ $option->discount }}"
                                        required></td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#cab-option-row{{ $key }}').remove();"
                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                        data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="cab-option-row0">
                            <td style="width:350px"><input type="text" name="cab_option[0][content]"
                                    placeholder="Content" class="form-control cab" id="cab_content0" required></td>
                            <td><input type="number" name="cab_option[0][amount]" placeholder="Amount"
                                    class="form-control cab" id="cab_amount0" value="0" required></td>
                            <td><input type="number" name="cab_option[0][discount]" placeholder="Discount"
                                    class="form-control cab" id="cab_discount0" value="0" required></td>
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

<div class="col-sm-12 mx-auto" id="hotel">
    <div class="card">
        <div class="card-header bg-orange">
            <h3 class="card-title">Hotel Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="adults">No of Adults</label>
                    <input type="number" id="adults" class="form-control hotel guest" placeholder="No of Adults" name="adults"
                        value="{{ old('adults', in_array('hotel', $estimate_type) ? $estimate->hotel->adult : '0') }}">
                    @error('adults')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="childs">No of Children</label>
                    <input type="number" id="childs" class="form-control hotel guest" placeholder="No of Children"
                        name="childs" value="{{ old('childs', in_array('hotel', $estimate_type) ? $estimate->hotel->child : '0') }}">
                    @error('childs')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="room">No of Rooms</label>
                    <input type="number" id="room" class="form-control hotel" placeholder="No of Rooms" name="room"
                        value="{{ old('room', in_array('hotel', $estimate_type) ? $estimate->hotel->room : '0') }}">
                    @error('room')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="room">No of Beds</label>
                    <input type="number" id="bed" class="form-control hotel" placeholder="No of Beds" name="bed"
                        value="{{ old('bed', in_array('hotel', $estimate_type) ? $estimate->hotel->bed : '0') }}">
                    @error('bed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-4">
                    <label for="check_in">Check In</label>
                    <input type="date" id="check_in" class="form-control hotel" placeholder="Check In" name="check_in"
                        value="{{ old('check_in', in_array('hotel', $estimate_type) ? $estimate->hotel->check_in : '') }}">
                    @error('check_in')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="check_out">Check Out</label>
                    <input type="date" id="check_out" class="form-control hotel" placeholder="Check Out"
                        name="check_out"
                        value="{{ old('check_out', in_array('hotel', $estimate_type) ? $estimate->hotel->check_out : '') }}">
                    @error('check_out')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-4">
                    <label for="destination">Destination</label>
                    <input type="text" id="destination" class="form-control hotel" placeholder="Destination"
                        name="destination"
                        value="{{ old('destination', in_array('hotel', $estimate_type) ? $estimate->hotel->destination : '') }}">
                    @error('destination')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-12">
                    <label for="note">Hotel Note</label>
                    <textarea class="form-control hotel summernote" id="hotel_note"
                        name="hotel_note">{{ old('note', in_array('hotel', $estimate_type) ? $estimate->hotel->note : '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-orange">
            <h3 class="card-title">Hotel Options</h3>
        </div>
        <div class="card-body">
            <table id="hotel_option" class="table table-condensed">
                <thead>
                    <tr>
                        <th>Hotel</th>
                        <th>Room</th>
                        <th>Service</th>
                        <th style="width: 15%;">Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @if (in_array('hotel', $estimate_type) && count($estimate->hotel_options) > 0)
                        @foreach ($estimate->hotel_options as $key => $option)
                            <tr id="hotel-option{{ $key }}">
                                <td>
                                    <select class="form-control hotelid" name="option[{{ $key }}][hotel_id]"
                                        id="hotel_id{{ $key }}"
                                        onchange="getRooms({{ $key }}, this.value)" required>
                                        <option></option>
                                        @foreach ($hotels as $hotel)
                                            <option value="{{ $hotel->id }}"
                                                @if ($option->hotel_id == $hotel->id) selected @endif>
                                                {{ $hotel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control hotel" name="option[{{ $key }}][room_id]"
                                        id="room_id{{ $key }}"
                                        onchange="getServices({{ $key }}, this.value)" required>
                                        <option value="{{ $option->room_id }}">
                                            {{ \App\Models\HotelRoom::find($option->room_id)->room }}</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control hotel"
                                        name="option[{{ $key }}][service_id]"
                                        id="service_id{{ $key }}"
                                        onchange="getTotal({{ $key }}, this.value)" required>
                                        <option value="{{ $option->service_id }}">
                                            {{ \App\Models\HotelRoomService::find($option->service_id)->service }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="option[{{ $key }}][discount]"
                                        placeholder="Discount" class="form-control hotel"
                                        id="discount{{ $key }}" value="{{ $option->discount }}" required>
                                </td>
                                <td class="text-right">
                                    <button type="button" class="btn bg-success"
                                        id="amount-button{{ $key }}" onclick="openHotelModal({{ $key }})">{{ $option->amount }}</button>
                                    <input type="hidden" class="btn bg-grey" id="amount{{ $key }}"
                                        name="option[{{ $key }}][amount]" value="{{ $option->amount }}">
                                </td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#hotel-option{{ $key }}').remove();" data-toggle="tooltip"
                                        title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                            class="fas fa-minus-circle"></i></button></td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="hotel-option0">
                            <td>
                                <select class="form-control hotel hotelid" name="option[0][hotel_id]" id="hotel_id0"
                                    onchange="getRooms(0, this.value)" required>
                                    <option></option>
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control hotel" name="option[0][room_id]" id="room_id0"
                                    onchange="getServices(0, this.value)" required>
                                    <option>Select Room</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control hotel" name="option[0][service_id]" id="service_id0"
                                    onchange="getTotal(0, this.value)" required>
                                    <option>Select Service</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="option[0][discount]" placeholder="Discount"
                                    class="form-control discount" id="discount0" value="0" required>
                            </td>
                            <td class="text-right">
                                <button type="button" class="btn bg-success" id="amount-button0"
                                    style="display: none;" onclick="openHotelModal(0)">Total</button>
                                <input type="hidden" class="btn bg-grey" id="amount0" name="option[0][amount]">
                            </td>
                            <td class="text-right"><button type="button" onclick="$('#hotel-option0').remove();"
                                    data-toggle="tooltip" title="" class="btn btn-danger"
                                    data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="6"><button type="button" onclick="addHotelOption();"
                                data-toggle="tooltip" title="Add Option" class="btn btn-secondary"
                                data-original-title="Add Option"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<div class="col-sm-12 mx-auto" id="safari">
    <div class="card">
        <div class="card-header bg-brown">
            <h3 class="card-title">Safari Details</h3>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn bg-dark btn-sm" onclick="addSafari();">
                  Add Safari
                </a>
            </div>
        </div>
        <div class="card-body" id="main-safari-div">
            @include('estimates.tour.safari')
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-brown">
            <h3 class="card-title">Safari Content</h3>
        </div>
        <div class="card-body">
            <table id="safari_option" class="table table-striped">
                <thead>
                    <tr>
                        <th>Safari Content</th>
                        <th>Amount</th>
                        <th>Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @if (in_array('safari', $estimate_type) && count($estimate->safari_options) > 0)
                        @foreach ($estimate->safari_options as $key => $option)
                            <tr id="safari-option-row{{ $key }}">
                                <td style="width:350px"><input type="text"
                                        name="safari_option[{{ $key }}][content]" placeholder="Content"
                                        class="form-control safari" id="safari_content{{ $key }}" required
                                        value="{{ $option->content }}"></td>
                                <td><input type="number" name="safari_option[{{ $key }}][amount]"
                                        placeholder="Amount" class="form-control safari"
                                        id="safari_amount{{ $key }}" value="{{ $option->amount }}"
                                        required></td>
                                <td><input type="number" name="safari_option[{{ $key }}][discount]"
                                        placeholder="Discount" class="form-control safari"
                                        id="safari_discount{{ $key }}" value="{{ $option->discount }}"
                                        required></td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#safari-option-row{{ $key }}').remove();"
                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                        data-original-title="Remove Button"><i
                                            class="fas fa-minus-circle"></i></button></td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="safari-option-row0">
                            <td style="width:350px"><input type="text" name="safari_option[0][content]"
                                    placeholder="Content" class="form-control safari" id="safari_content0" required></td>
                            <td><input type="number" name="safari_option[0][amount]" placeholder="Amount"
                                    class="form-control safari" id="safari_amount0" value="0" required></td>
                            <td><input type="number" name="safari_option[0][discount]" placeholder="Discount"
                                    class="form-control safari" id="safari_discount0" value="0" required></td>
                            <td class="text-right"><button type="button"
                                    onclick="$('#safari-option-row0').remove();" data-toggle="tooltip" title=""
                                    class="btn btn-danger" data-original-title="Remove Button"><i
                                        class="fas fa-minus-circle"></i></button></td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="5"><button type="button" onclick="addSafariOption();"
                                data-toggle="tooltip" title="Add Option" class="btn btn-secondary"
                                data-original-title="Add Option"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-indigo">
            <h3 class="card-title">GST & PG Charges</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="gst_filed">GST Filed</label>
                    <select id="gst_filed" class="form-control"  name="gst_filed">                        
                        <option value="" {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '' ? 'selected' : '' }}>GST not required</option>
                        <option value="0" {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '0' ? 'selected' : '' }}>GST included in the package</option>
                        <option value="5" {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '5' ? 'selected' : '' }}>GST 5%</option>
                        <option value="18" {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '18' ? 'selected' : '' }}>GST 18%</option>
                    </select>
                    @error('gst_filed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
                    <label for="pg_charges_filed">PG charges filed</label>
                    <select id="pg_charges_filed" class="form-control"  name="pg_charges_filed">
                        <option value="" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '' ? 'selected' : '' }}>PG charges not required</option>
                        <option value="0" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '0' ? 'selected' : '' }}>PG charges included in the package</option>                       
                        <option value="3" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '3' ? 'selected' : '' }}>PG charges 3%</option>
                        <option value="4" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '4' ? 'selected' : '' }}>PG charges 4%</option>
                        <option value="5" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '5' ? 'selected' : '' }}>PG charges 5%</option>
                        <option value="6" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '6' ? 'selected' : '' }}>PG charges 6%</option>
                        <option value="7" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '7' ? 'selected' : '' }}>PG charges 7%</option>
                        <option value="8" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '8' ? 'selected' : '' }}>PG charges 8%</option>
                    </select>
                    @error('pg_charges_filed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
 @include('estimates.tour.iternaries')
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-indigo">
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
                        <td class="text-right" colspan="2"><button type="button" onclick="addTourInclusion();"
                                data-toggle="tooltip" title="Add Inclusion" class="btn btn-secondary"
                                data-original-title="Add Inclusion"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-indigo">
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
                        <td class="text-right" colspan="2"><button type="button" onclick="addTourExclusion();"
                                data-toggle="tooltip" title="Add Exclusion" class="btn btn-secondary"
                                data-original-title="Add Exclusion"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-indigo">
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
                        <td class="text-right" colspan="2"><button type="button" onclick="addTourTerm();"
                                data-toggle="tooltip" title="Add Term" class="btn btn-secondary"
                                data-original-title="Add Term"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <button class="btn btn-block btn-success" type="submit" form="tourForm">Submit</button>
</div>
<div class="modal fade" id="modal-amount" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Amount</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="number" class="form-control" name="model_amount" id="model_amount" placeholder="Amount">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="modal-amount-save" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
