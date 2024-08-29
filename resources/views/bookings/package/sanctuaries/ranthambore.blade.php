@if (in_array('safari', $booking_type) && count($booking->safaris) > 0)
    @foreach ($booking->safaris as $key => $safari)
        <div class="card" id="safaris{{ $key }}">
            <div class="card-header bg-dark">
                <h3 class="card-title">Ranthambore National Park Safari</h3>
                <div class="card-tools">
                    <a href="javascript:void(0)" class="btn bg-danger btn-sm"
                        onclick="$('#safaris{{ $key }}').remove();">
                        Remove
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="mode{{ $key }}">Mode of Vehicle</label>
                        <select id="mode{{ $key }}" class="form-control ranthambore"
                            name="safari[{{ $key }}][mode]" required>
                            <option value="" selected>Select Mode of Vehicle</option>
                            <option value="Jeep" @if ($safari->mode == 'Jeep') selected @endif>Jeep</option>
                            <option value="Jeep Half Day Safari" @if ($safari->mode == 'Jeep Half Day Safari') selected @endif>Jeep
                                Half Day Safari</option>
                            <option value="Jeep Full Day Safari" @if ($safari->mode == 'Jeep Full Day Safari') selected @endif>Jeep
                                Full Day Safari</option>
                            <option value="Canter" @if ($safari->mode == 'Canter') selected @endif>Canter</option>
                            <option value="Boat" @if ($safari->mode == 'Boat') selected @endif>Boat</option>
                            <option value="Tatkal Gypsy" @if ($safari->mode == 'Tatkal Gypsy') selected @endif>Tatkal Gypsy</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="area{{ $key }}">Safari Area</label>
                        <select name="safari[{{ $key }}][area]" id="area{{ $key }}"
                            class="form-control ranthambore" required>
                            <option value="">Select Safari Area</option>
                            <option value="Ranthambore National Park" @if ($safari->area == 'Ranthambore National Park') selected @endif>
                                Ranthambore National Park</option>
                            <option value="Chambal Motor Boat Safari" @if ($safari->area == 'Chambal Motor Boat Safari') selected @endif>
                                Chambal Motor Boat Safari</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="zone{{ $key }}">Safari Zone</label>
                        <select name="safari[{{ $key }}][zone]" id="zone{{ $key }}"
                            class="form-control ranthambore" required>
                            <option value="">Select Safari Zone</option>
                            <option value="All Zone" @if ($safari->zone == 'All Zone') selected @endif>All Zone</option>
                            <option value="1" @if ($safari->zone == 1) selected @endif>Zone 1</option>
                            <option value="2" @if ($safari->zone == 2) selected @endif>Zone 2</option>
                            <option value="3" @if ($safari->zone == 3) selected @endif>Zone 3</option>
                            <option value="4" @if ($safari->zone == 4) selected @endif>Zone 4</option>
                            <option value="5" @if ($safari->zone == 5) selected @endif>Zone 5</option>
                            <option value="6" @if ($safari->zone == 6) selected @endif>Zone 6</option>
                            <option value="7" @if ($safari->zone == 7) selected @endif>Zone 7</option>
                            <option value="8" @if ($safari->zone == 8) selected @endif>Zone 8</option>
                            <option value="9" @if ($safari->zone == 9) selected @endif>Zone 9</option>
                            <option value="10" @if ($safari->zone == 10) selected @endif>Zone 10</option>
                            <option value="Zone Not Confirmed" @if ($safari->zone == 'Zone Not Confirmed') selected @endif>Zone
                                Not Confirmed</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="vehicle_type{{ $key }}">Vehicle Booking Type</label>
                        <select name="safari[{{ $key }}][vehicle_type]" id="vehicle_type{{ $key }}"
                            class="form-control ranthambore" required>
                            <option value="">Select Vehicle Booking Type</option>
                            <option value="Private" @if ($safari->vehicle_type == 'Private') selected @endif>Private</option>
                            <option value="Sharing" @if ($safari->vehicle_type == 'Sharing') selected @endif>Sharing</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="total_person{{ $key }}">No of Person</label>
                        <input type="number" id="total_person{{ $key }}" class="form-control ranthambore"
                            placeholder="No of Person" name="safari[{{ $key }}][total_person]"
                            value="{{ $safari->total_person }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="nationality{{ $key }}">Nationality</label>
                        <select name="safari[{{ $key }}][nationality]" id="nationality{{ $key }}"
                            class="form-control ranthambore" required>
                            <option value="">Select Nationality</option>
                            <option value="Indian" @if ($safari->nationality == 'Indian') selected @endif>Indian</option>
                            <option value="Foreigner" @if ($safari->nationality == 'Foreigner') selected @endif>Foreigner
                            </option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="date{{ $key }}">Safari Date</label>
                        <input type="date" id="date{{ $key }}" class="form-control ranthambore"
                            placeholder="Safari Date" name="safari[{{ $key }}][date]"
                            value="{{ $safari->date }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="time{{ $key }}">Time</label>
                        <select name="safari[{{ $key }}][time]" id="time{{ $key }}"
                            class="form-control ranthambore" required>
                            <option value="">Select Time</option>
                            <option value="Morning" @if ($safari->time == 'Morning') selected @endif>Morning</option>
                            <option value="Evening" @if ($safari->time == 'Evening') selected @endif>Evening</option>
                            <option value="Half Day: Morning (06:00 AM - 12:30 PM)"
                                @if ($safari->time == 'Half Day: Morning (06:00 AM - 12:30 PM)') selected @endif>Half Day: Morning (06:00 AM - 12:30
                                PM)</option>
                            <option value="Half Day: Evening (12:30 PM - 05:00 PM)"
                                @if ($safari->time == 'Half Day: Evening (12:30 PM - 05:00 PM)') selected @endif>Half Day: Evening (12:30 PM - 05:00
                                PM)</option>
                            <option value="Full Day: (06:00 AM - 05:00 PM)"
                                @if ($safari->time == 'Full Day: (06:00 AM - 05:00 PM)') selected @endif>Full Day: (06:00 AM - 05:00 PM)
                            </option>
                            <optgroup label="Chambal Timings"></optgroup>
                            <option value="8:00 am to 9:00 am" @if($safari->time  == '8:00 am to 9:00 am') selected @endif>8:00 AM to 9:00 AM</option>
                            <option value="9:00 am to 10:00 am" @if($safari->time  == '9:00 am to 10:00 am') selected @endif>9:00 AM to 10:00 AM</option>
                            <option value="10:00 am to 11:00 am" @if($safari->time  == '10:00 am to 11:00 am') selected @endif>10:00 AM to 11:00 AM</option>
                            <option value="11:00 am to 12:00 pm" @if($safari->time  == '11:00 am to 12:00 pm') selected @endif>11:00 AM to 12:00 PM</option>
                            <option value="12:00 pm to 01:00 pm" @if($safari->time  == '12:00 pm to 01:00 pm') selected @endif>12:00 PM to 01:00 PM</option>
                            <option value="01:00 pm to 02:00 pm" @if($safari->time  == '01:00 pm to 02:00 pm') selected @endif>01:00 PM to 02:00 PM</option>
                            <option value="02:00 pm to 03:00 pm" @if($safari->time  == '02:00 pm to 03:00 pm') selected @endif>02:00 PM to 03:00 PM</option>
                            <option value="03:00 pm to 04:00 pm" @if($safari->time  == '03:00 pm to 04:00 pm') selected @endif>03:00 PM to 04:00 PM</option>
                            <option value="04:00 pm to 05:00 pm" @if($safari->time  == '04:00 pm to 05:00 pm') selected @endif>04:00 PM to 05:00 PM</option>
                            <option value="05:00 pm to 06:00 pm" @if($safari->time  == '05:00 pm to 06:00 pm') selected @endif>05:00 PM to 06:00 PM</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="type{{ $key }}">Booking Type</label>
                        <select name="safari[{{ $key }}][type]" id="type{{ $key }}"
                            class="form-control ranthambore" required>
                            <option value="">Select Booking Type</option>
                            <option value="Advance Booking" @if ($safari->type == 'Advance Booking') selected @endif>Advanced
                                Booking</option>
                            <option value="Current Booking" @if ($safari->type == 'Current Booking') selected @endif>Current
                                Booking</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="jeeps{{ $key }}">No. of Jeeps/Canter</label>
                        <input type="number" id="jeeps{{ $key }}" class="form-control ranthambore"
                            placeholder="No. of Jeeps/Canter" name="safari[{{ $key }}][jeeps]"
                            value="{{ $safari->jeeps }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="vendor{{ $key }}">Choose Vendor</label>
                        <select id="vendor{{ $key }}" class="form-control ranthambore"
                            name="safari[{{ $key }}][vendor]" required>
                            @foreach ($vendors as $vendor)
                                @if ($vendor->sanctuary == 'ranthambore')
                                    <option value="{{ $vendor->id }}"
                                        @if ($safari->vendor == $vendor->id) selected @endif>{{ $vendor->name }}
                                        ({{ $vendor->phone }})</option>
                                @else
                                    @continue;
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="safari_due_amount{{ $key }}">Safari Due Amount (₹)</label>
                        <input type="number" id="safari_due_amount{{ $key }}"
                            class="form-control ranthambore" placeholder="Safari Due Amount"
                            name="safari[{{ $key }}][safari_due_amount]"
                            value="{{ $safari->safari_due_amount ?? 0 }}" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="note{{ $key }}">Safari Note</label>
                        <textarea class="form-control summernote ranthambore" id="note{{ $key }}" name="safari[{{ $key }}][note]">{{ $safari->note }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="card" id="safaris0">
        <div class="card-header bg-dark">
            <h3 class="card-title">Ranthambore National Park Safari</h3>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn bg-danger btn-sm" onclick="$('#safaris0').remove();">
                    Remove
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="mode0">Mode of Vehicle</label>
                    <select id="mode0" class="form-control ranthambore" name="safari[0][mode]" required>
                        <option value="" selected>Select Mode of Vehicle</option>
                        <option value="Jeep">Jeep</option>
                        <option value="Jeep Half Day Safari">Jeep Half Day Safari</option>
                        <option value="Jeep Full Day Safari">Jeep Full Day Safari</option>
                        <option value="Canter">Canter</option>
                        <option value="Boat">Boat</option>
                        <option value="Tatkal Gypsy">Tatkal Gypsy</option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="area0">Safari Area</label>
                    <select name="safari[0][area]" id="area0" class="form-control ranthambore" required>
                        <option value="">Select Safari Area</option>
                        <option value="Ranthambore National Park">Ranthambore National Park</option>
                        <option value="Chambal Motor Boat Safari">Chambal Motor Boat Safari</option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="zone0">Safari Zone</label>
                    <select name="safari[0][zone]" id="zone0" class="form-control ranthambore" required>
                        <option value="">Select Safari Zone</option>
                        <option value="All Zone">All Zone</option>
                        <option value="1">Zone 1</option>
                        <option value="2">Zone 2</option>
                        <option value="3">Zone 3</option>
                        <option value="4">Zone 4</option>
                        <option value="5">Zone 5</option>
                        <option value="6">Zone 6</option>
                        <option value="7">Zone 7</option>
                        <option value="8">Zone 8</option>
                        <option value="9">Zone 9</option>
                        <option value="10">Zone 10</option>
                        <option value="Zone Not Confirmed">Zone Not Confirmed</option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="vehicle_type0">Vehicle Booking Type</label>
                    <select name="safari[0][vehicle_type]" id="vehicle_type0" class="form-control ranthambore"
                        required>
                        <option value="">Select Vehicle Booking Type</option>
                        <option value="Private">Private</option>
                        <option value="Sharing">Sharing</option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="total_person0">No of Person</label>
                    <input type="number" id="total_person0" class="form-control ranthambore"
                        placeholder="No of Person" name="safari[0][total_person]" value="1">
                </div>
                <div class="form-group col-sm-4">
                    <label for="nationality0">Nationality</label>
                    <select name="safari[0][nationality]" id="nationality0" class="form-control ranthambore"
                        required>
                        <option value="">Select Nationality</option>
                        <option value="Indian">Indian</option>
                        <option value="Foreigner">Foreigner</option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="date0">Safari Date</label>
                    <input type="date" id="date0" class="form-control ranthambore" placeholder="Safari Date"
                        name="safari[0][date]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="time0">Time</label>
                    <select name="safari[0][time]" id="time0" class="form-control ranthambore" required>
                        <option value="">Select Time</option>
                        <option value="Morning">Morning</option>
                        <option value="Evening">Evening</option>
                        <option value="Half Day: Morning (06:00 AM - 12:30 PM)">Half Day: Morning (06:00 AM - 12:30PM)
                        </option>
                        <option value="Half Day: Evening (12:30 PM - 05:00 PM)">Half Day: Evening (12:30 PM - 05:00 PM)
                        </option>
                        <option value="Full Day: (06:00 AM - 05:00 PM)">Full Day: (06:00 AM - 05:00 PM)</option>
                        <optgroup label="Chambal Timings"></optgroup>
                        <option value="8:00 am to 9:00 am">8:00 AM to 9:00 AM</option>
                        <option value="9:00 am to 10:00 am">9:00 AM to 10:00 AM</option>
                        <option value="10:00 am to 11:00 am">10:00 AM to 11:00 AM</option>
                        <option value="11:00 am to 12:00 pm">11:00 AM to 12:00 PM</option>
                        <option value="12:00 pm to 01:00 pm">12:00 PM to 01:00 PM</option>
                        <option value="01:00 pm to 02:00 pm">01:00 PM to 02:00 PM</option>
                        <option value="02:00 pm to 03:00 pm">02:00 PM to 03:00 PM</option>
                        <option value="03:00 pm to 04:00 pm">03:00 PM to 04:00 PM</option>
                        <option value="04:00 pm to 05:00 pm">04:00 PM to 05:00 PM</option>
                        <option value="05:00 pm to 06:00 pm">05:00 PM to 06:00 PM</option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="type0">Booking Type</label>
                    <select name="safari[0][type]" id="type0" class="form-control ranthambore">
                        <option value="">Select Booking Type</option>
                        <option value="Advance Booking">Advanced Booking</option>
                        <option value="Current Booking">Current Booking</option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="jeeps0">No. of Jeeps/Canter</label>
                    <input type="number" id="jeeps0" class="form-control ranthambore"
                        placeholder="No. of Jeeps/Canter" name="safari[0][jeeps]" value="1" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="vendor0">Choose Vendor</label>
                    <select id="vendor0" class="form-control ranthambore" name="safari[0][vendor]" required>
                        @foreach ($vendors as $vendor)
                            @if ($vendor->sanctuary == 'ranthambore')
                                <option value="{{ $vendor->id }}"
                                    @if ($vendor->default == 'yes') selected @endif>{{ $vendor->name }}
                                    ({{ $vendor->phone }})</option>
                            @else
                                @continue;
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="safari_due_amount0">Safari Due Amount (₹)</label>
                    <input type="number" id="safari_due_amount0" class="form-control ranthambore"
                        placeholder="Safari Due Amount" name="safari[0][safari_due_amount]" value="0" required>
                </div>
                <div class="form-group col-sm-12">
                    <label for="note0">Safari Note</label>
                    <textarea class="form-control summernote ranthambore" id="note0" name="safari[0][note]"></textarea>
                </div>
            </div>
        </div>
    </div>
@endif
