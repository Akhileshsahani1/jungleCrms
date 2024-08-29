 <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="flight_trip_type">Choose Trip Type</label>
                    <select id="flight_trip_type" class="form-control flight" name="flight_trip_type" required>
                        <option value="" selected>Select Trip Type</option>
                        <option value="one_way"
                            {{ old('flight_trip_type', in_array('flight', $estimate_type) ? $estimate->flight->trip_type : '') == 'one_way' ? 'selected' : '' }}>
                            One Way</option>
                        <option value="round_trip"
                            {{ old('flight_trip_type', in_array('flight', $estimate_type) ? $estimate->flight->trip_type : '') == 'round_trip' ? 'selected' : '' }}>
                            Round Trip</option>
                        <option value="multi_city"
                            {{ old('flight_trip_type', in_array('flight', $estimate_type) ? $estimate->flight->trip_type : '') == 'multi_city' ? 'selected' : '' }}>
                            Multi City</option>
                    </select>
                    @error('flight_trip_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-3">
                    <label for="flight_adults">Adults</label>
                     <input type="number" min="0" id="flight_adults" class="form-control flight" placeholder="Adults"
                        name="flight_adults"  value="{{ in_array('flight', $estimate_type) ? $estimate->flight->adults : '' }}"  required>
                    @error('flight_adults')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-3">
                    <label for="flight_childs">Childs</label>
                     <input type="number" min="0" id="flight_childs" class="form-control flight" placeholder="Childs"
                        name="flight_childs"  value="{{ in_array('flight', $estimate_type) ? $estimate->flight->childs : '' }}"  required>
                    @error('flight_childs')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-3">
                    <label for="flight_infants">Infants</label>
                     <input type="number" min="0" id="flight_infants" class="form-control flight" placeholder="Infants"
                        name="flight_infants"  value="{{ in_array('flight', $estimate_type) ? $estimate->flight->infants : '' }}"  required>
                    @error('flight_infants')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
 </div>
@if (in_array('flight', $estimate_type) && count($estimate->flight_options) > 0)
    @foreach ($estimate->flight_options as $key => $flight)
        <div class="card" id="flighttrip{{ $key }}">
            <div class="card-header bg-dark">
                <h3 class="card-title">Flight Trip</h3>
                <div class="card-tools">
                    <a href="javascript:void(0)" class="btn bg-danger btn-sm"
                        onclick="$('#flighttrip{{ $key }}').remove();">
                        Remove
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-4">
                     <label for="journey_type">Journey Type</label>
                       <select type="text" class="form-control flight" id="journey_type{{ $key }}" name="flighttrip[{{ $key }}][journey_type]" required>
                            <option value="">Select Journey Type</option>
                            <option value="depart" @if (in_array('flight', $estimate_type) && $flight->type == 'depart') selected @endif>Depart</option>
                            <option value="return" @if (in_array('flight', $estimate_type) && $flight->type == 'return') selected @endif>Return</option>
                        </select>
                    </div>                
                    <div class="form-group col-sm-4">
                        <label for="start_date{{ $key }}">Journey Start Date</label>
                        <input type="date" id="start_date{{ $key }}" class="form-control flight" placeholder="Journey Start Date"
                            name="flighttrip[{{ $key }}][start_date]" value="{{ in_array('flight', $estimate_type) && isset($flight->travel_date) ? $flight->travel_date : '' }}" required>
                    </div>                 
                    <div class="form-group col-sm-4">
                    <label for="from{{ $key }}">From</label>
                    <input type="text" id="from{{ $key }}" class="form-control flight" placeholder="From"
                        name="flighttrip[{{ $key }}][from]" value="{{ in_array('flight', $estimate_type) && isset($flight->from) ? $flight->from : '' }}"required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="to{{ $key }}">To</label>
                    <input type="text" id="to{{ $key }}" class="form-control flight" placeholder="To"
                        name="flighttrip[{{ $key }}][to]" value="{{ in_array('flight', $estimate_type) && isset($flight->to) ? $flight->to : '' }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="travel_class">Travel Class</label>
                   <select type="text" class="form-control flight" id="travel_class{{ $key }}" name="flighttrip[{{ $key }}][travel_class]" required>
                        <option value="">Select Travel Class</option>
                        <option value="Economy/Premium Economy" @if (in_array('flight', $estimate_type) && $flight->travel_class == 'Economy/Premium Economy') selected @endif>Economy/Premium Economy</option>
                        <option value="Premium Economy" @if (in_array('flight', $estimate_type) && $flight->travel_class == 'Premium Economy') selected @endif>Premium Economy</option>
                        <option value="Bussiness" @if (in_array('flight', $estimate_type) && $flight->travel_class == 'Bussiness') selected @endif>Bussiness</option>
                    </select>
                </div>     
                <div class="form-group col-sm-4">
                    <label for="airport_name_from{{ $key }}">Airport(From)</label>
                    <input type="text" id="airport_name_from{{ $key }}" class="form-control flight" placeholder="Airport(From)"
                        name="flighttrip[{{ $key }}][airport_name_from]" value="{{ in_array('flight', $estimate_type) && isset($flight->airport_name_from) ? $flight->airport_name_from : '' }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="airport_name_to{{ $key }}">Airport(To)</label>
                    <input type="text" id="airport_name_to{{ $key }}" class="form-control flight" placeholder="Airport(To)" name="flighttrip[{{ $key }}][airport_name_to]"  value="{{ in_array('flight', $estimate_type) && isset($flight->airport_name_to) ? $flight->airport_name_to : '' }}"
                        required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="cancellation_charges{{ $key }}">Cancellation Penalty</label>
                    <input type="number" min="0" id="cancellation_charges{{ $key }}" class="form-control flight" placeholder="Cancellation Penalty"
                        name="flighttrip[{{ $key }}][cancellation_charges]"  value="{{ in_array('flight', $estimate_type) && isset($flight->cancellation_charges) ? $flight->cancellation_charges : '' }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="airline_name{{ $key }}">Airline Name</label>
                    <input type="text" id="airline_name{{ $key }}" class="form-control flight" placeholder="Airline Name"
                        name="flighttrip[{{ $key }}][airline_name]" value="{{ in_array('flight', $estimate_type) && isset($flight->airline_name) ? $flight->airline_name : '' }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="departure_time{{ $key }}">Departure Time</label>
                    <input type="time" id="departure_time{{ $key }}" class="form-control flight" placeholder="Departure Time"
                        name="flighttrip[{{ $key }}][departure_time]" value="{{ in_array('flight', $estimate_type) && isset($flight->departure_time) ? $flight->departure_time : '' }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="reach_time{{ $key }}">Reach Time</label>
                    <input type="time" id="reach_time{{ $key }}" class="form-control flight" placeholder="Reach Time"
                        name="flighttrip[{{ $key }}][reach_time]" value="{{ in_array('flight', $estimate_type) && isset($flight->reach_time) ? $flight->reach_time : '' }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="stops{{ $key }}">Stops</label>
                    <input type="text" id="stops{{ $key }}" class="form-control flight" placeholder="Stops"
                        name="flighttrip[{{ $key }}][stops]" value="{{ in_array('flight', $estimate_type) && isset($flight->stops) ? $flight->stops : '' }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="flight_no{{ $key }}">Flight No</label>
                    <input type="text" id="flight_no{{ $key }}" class="form-control flight" placeholder="Flight No"
                        name="flighttrip[{{ $key }}][flight_no]" value="{{ in_array('flight', $estimate_type) && isset($flight->flight_no) ? $flight->flight_no : '' }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="cabin_bag{{ $key }}">Cabin Bag</label>
                    <input type="text" id="cabin_bag{{ $key }}" class="form-control flight" placeholder="Cabin Bag"
                        name="flighttrip[{{ $key }}][cabin_bag]" value="{{ in_array('flight', $estimate_type) && isset($flight->cabin_bag) ? $flight->cabin_bag : '' }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="bag_weight{{ $key }}">Bag Weight</label>
                    <input type="text" id="bag_weight{{ $key }}" class="form-control flight" placeholder="Bag Weight"
                        name="flighttrip[{{ $key }}][bag_weight]" value="{{ in_array('flight', $estimate_type) && isset($flight->bag_weight) ? $flight->bag_weight : '' }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="cancellation{{ $key }}">Cancellation</label>
                    <input type="text" id="cancellation{{ $key }}" class="form-control flight" placeholder="Cancellation"
                        name="flighttrip[{{ $key }}][cancellation]" value="{{ in_array('flight', $estimate_type) && isset($flight->cancellation) ? $flight->cancellation : '' }}" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="meal{{ $key }}">Meal</label>
                    <input type="text" id="meal{{ $key }}" class="form-control flight" placeholder="Meal"
                        name="flighttrip[{{ $key }}][meal]" value="{{ in_array('flight', $estimate_type) && isset($flight->meal) ? $flight->meal : '' }}" required>
                </div>
                 <div class="form-group col-sm-4">
                    <label for="price{{ $key }}">Price</label>
                    <input type="number"  min ="0" id="price{{ $key }}" class="form-control flight" placeholder="Price"
                        name="flighttrip[{{ $key }}][price]" value="{{ in_array('flight', $estimate_type) && isset($flight->price) ? $flight->price : '' }}" required>
                </div>
                 <div class="form-group col-sm-4">
                    <label for="discount{{ $key }}">Discount</label>
                    <input type="number" min ="0" id="discount{{ $key }}" class="form-control flight" placeholder="Discount"
                        name="flighttrip[{{ $key }}][discount]" value="{{ in_array('flight', $estimate_type) && isset($flight->discount) ? $flight->discount : '' }}" required>
                </div>
                   
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="card" id="flighttrip0">
        <div class="card-header bg-dark">
            <h3 class="card-title">Flight Trip</h3>
            <div class="card-tools"><a href="javascript:void(0)" class="btn bg-danger btn-sm"
                    onclick="$('#flighttrip0').remove();">Remove</a></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="journey_type">Journey Type</label>
                   <select type="text" class="form-control flight" id="journey_type0" name="flighttrip[0][journey_type]" required>
                        <option value="">Select Journey Type</option>
                        <option value="depart">Depart</option>
                        <option value="return">Return</option>
                    </select>
                </div>                
                <div class="form-group col-sm-4">
                    <label for="start_date0">Journey Start Date</label>
                    <input type="date" id="start_date0" class="form-control flight" placeholder="Journey Start Date"
                        name="flighttrip[0][start_date]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="from0">From</label>
                    <input type="text" id="from0" class="form-control flight" placeholder="From"
                        name="flighttrip[0][from]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="to0">To</label>
                    <input type="text" id="to0" class="form-control flight" placeholder="To"
                        name="flighttrip[0][to]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="travel_class">Travel Class</label>
                   <select type="text" class="form-control flight" id="travel_class0" name="flighttrip[0][travel_class]" required>
                        <option value="">Select Travel Class</option>
                        <option value="Economy/Premium Economy">Economy/Premium Economy</option>
                        <option value="Premium Economy">Premium Economy</option>
                        <option value="Bussiness">Bussiness</option>
                    </select>
                </div>     
                <div class="form-group col-sm-4">
                    <label for="airport_name_from0">Airport(From)</label>
                    <input type="text" id="airport_name_from0" class="form-control flight" placeholder="Airport(From)"
                        name="flighttrip[0][airport_name_from]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="airport_name_to0">Airport(To)</label>
                    <input type="text" id="airport_name_to0" class="form-control flight" placeholder="Airport(To)" name="flighttrip[0][airport_name_to]"
                        required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="cancellation_charges0">Cancellation Penalty</label>
                    <input type="number" min="0" id="cancellation_charges0" class="form-control flight" placeholder="Cancellation Penalty"
                        name="flighttrip[0][cancellation_charges]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="airline_name0">Airline Name</label>
                    <input type="text" id="airline_name0" class="form-control flight" placeholder="Airline Name"
                        name="flighttrip[0][airline_name]" value="" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="departure_time0">Departure Time</label>
                    <input type="time" id="departure_time0" class="form-control flight" placeholder="Departure Time"
                        name="flighttrip[0][departure_time]" value="" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="reach_time0">Reach Time</label>
                    <input type="time" id="reach_time0" class="form-control flight" placeholder="Reach Time"
                        name="flighttrip[0][reach_time]" value="" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="stops0">Stops</label>
                    <input type="text" id="stops0" class="form-control flight" placeholder="Stops"
                        name="flighttrip[0][stops]" value="" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="flight_no0">Flight No</label>
                    <input type="text" id="flight_no0" class="form-control flight" placeholder="Flight No"
                        name="flighttrip[0][flight_no]" value="" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="cabin_bag0">Cabin Bag</label>
                    <input type="text" id="cabin_bag0" class="form-control flight" placeholder="Cabin Bag"
                        name="flighttrip[0][cabin_bag]" value="" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="bag_weight0">Bag Weight</label>
                    <input type="text" id="bag_weight0" class="form-control flight" placeholder="Bag Weight"
                        name="flighttrip[0][bag_weight]" value="" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="cancellation0">Cancellation</label>
                    <input type="text" id="cancellation0" class="form-control flight" placeholder="Cancellation"
                        name="flighttrip[0][cancellation]" value="" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="meal0">Meal</label>
                    <input type="text" id="meal0" class="form-control flight" placeholder="Meal"
                        name="flighttrip[0][meal]" value="" required>
                </div>
                 <div class="form-group col-sm-4">
                    <label for="price0">Price</label>
                    <input type="text" id="price0" class="form-control flight" placeholder="Price"
                        name="flighttrip[0][price]" value="" required>
                </div>
                 <div class="form-group col-sm-4">
                    <label for="discount0">Discount</label>
                    <input type="text" id="discount0" class="form-control flight" placeholder="Discount"
                        name="flighttrip[0][discount]" value="" required>
                </div>

                
            </div>
        </div>
    </div>
@endif
