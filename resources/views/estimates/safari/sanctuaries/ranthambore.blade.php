<div class="form-group col-sm-4">
    <label for="mode">Mode of Vehicle</label>
    <select id="mode" class="form-control ranthambore" name="mode">
        <option value="" selected>Select Mode of Vehicle</option>
        <option value="Jeep"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Jeep' ? 'selected' : '' }}>Jeep
        </option>
        <option value="Jeep Half Day Safari"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Jeep Half Day Safari' ? 'selected' : '' }}>Jeep Half Day Safari
        </option>
        <option value="Jeep Full Day Safari"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Jeep Full Day Safari' ? 'selected' : '' }}>Jeep Full Day Safari
        </option>
        <option value="Canter"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Canter' ? 'selected' : '' }}>Canter</option>
        <option value="Boat"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Boat' ? 'selected' : '' }}>Boat</option>
            <option value="Tatkal Gypsy"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Tatkal Gypsy' ? 'selected' : '' }}>Tatkal Gypsy</option>
    </select>
    @error('mode')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="area">Safari Area</label>
    <select name="area" id="area" class="form-control ranthambore">
        <option value="">Select Safari Area</option>
        <option value="Ranthambore National Park" {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Ranthambore National Park' ? 'selected' : '' }}>Ranthambore National Park</option>
        <option value="Chambal Motor Boat Safari" {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Chambal Motor Boat Safari' ? 'selected' : '' }}>Chambal Motor Boat Safari</option>
    </select>
    @error('area')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="zone">Safari Zone</label>
    <select name="zone" id="zone" class="form-control ranthambore">
        <option value="">Select Safari Zone</option>
        <option value="All Zone" {{ old('zone', isset($estimate) ? $estimate->safari->zone : '') == 'All Zone' ? 'selected' : '' }}>All Zone</option>
        <option value="1/2/3/4/5/6/7" {{ old('zone', isset($estimate) ? $estimate->safari->zone : '') == '1/2/3/4/5/6/7' ? 'selected' : '' }}>Zone 1/2/3/4/5/6/7</option>
        <option value="8/9/10" {{ old('zone', isset($estimate) ? $estimate->safari->zone : '') == '8/9/10' ? 'selected' : '' }}>Zone 8/9/10</option>
        <option value="1/2/3/4/5/6/7/8/9/10" {{ old('zone', isset($estimate) ? $estimate->safari->zone : '') == '1/2/3/4/5/6/7/8/9/10' ? 'selected' : '' }}>Zone 1/2/3/4/5/6/7/8/9/10</option>
    </select>
    @error('zone')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="vehicle_type">Vehicle Booking Type</label>
    <select name="vehicle_type" id="vehicle_type" class="form-control ranthambore">
        <option value="">Select Vehicle Booking Type</option>
        <option value="Private" {{ old('vehicle_type', isset($estimate) ? $estimate->safari->vehicle_type : '') == 'Private' ? 'selected' : '' }}>Private</option>
        <option value="Sharing" {{ old('vehicle_type', isset($estimate) ? $estimate->safari->vehicle_type : '') == 'Sharing' ? 'selected' : '' }}>Sharing</option>
    </select>
    @error('vehicle_type')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="total_person">No of Person</label>
    <input type="number" id="total_person" class="form-control ranthambore" placeholder="No of Person" name="total_person"
        value="{{ old('total_person', isset($estimate) ? $estimate->safari->total_person : '') }}">
    @error('total_person')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="nationality">Nationality</label>
    <select name="nationality" id="nationality" class="form-control ranthambore">
        <option value="">Select Nationality</option>
        <option value="Indian" {{ old('nationality', isset($estimate) ? $estimate->safari->nationality : '') == 'Indian' ? 'selected' : '' }}>Indian</option>
        <option value="Foreigner" {{ old('nationality', isset($estimate) ? $estimate->safari->nationality : '') == 'Foreigner' ? 'selected' : '' }}>Foreigner</option>
    </select>
    @error('nationality')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="date">Safari Date</label>
    <input type="date" id="date" class="form-control ranthambore" placeholder="Safari Date" name="date"
        value="{{ old('date', isset($estimate) ? $estimate->safari->date : '') }}">
    @error('date')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="time">Time</label>
    <select name="time" id="time" class="form-control ranthambore">
        <option value="">Select Time</option>
        <option value="Morning" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == 'Morning' ? 'selected' : '' }}>Morning</option>
        <option value="Evening" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == 'Evening' ? 'selected' : '' }}>Evening</option>
        <option value="Half Day: Morning (06:00 AM - 12:30 PM)" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == 'Half Day: Morning (06:00 AM - 12:30 PM)' ? 'selected' : '' }}>Half Day: Morning (06:00 AM - 12:30 PM)</option>
        <option value="Half Day: Evening (12:30 PM - 05:00 PM)" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == 'Half Day: Evening (12:30 PM - 05:00 PM)' ? 'selected' : '' }}>Half Day: Evening (12:30 PM - 05:00 PM)</option>
        <option value="Full Day: (06:00 AM - 05:00 PM)" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == 'Full Day: (06:00 AM - 05:00 PM)' ? 'selected' : '' }}>Full Day: (06:00 AM - 05:00 PM)</option>
        <optgroup label="Chambal Timings"></optgroup>
        <option value="8:00 am to 9:00 am" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == '8:00 am to 9:00 am' ? 'selected' : '' }}>8:00 AM to 9:00 AM</option>
        <option value="9:00 am to 10:00 am" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == '9:00 am to 10:00 am' ? 'selected' : '' }}>9:00 AM to 10:00 AM</option>
        <option value="10:00 am to 11:00 am" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == '10:00 am to 11:00 am' ? 'selected' : '' }}>10:00 AM to 11:00 AM</option>
        <option value="11:00 am to 12:00 pm" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == '11:00 am to 12:00 pm' ? 'selected' : '' }}>11:00 AM to 12:00 PM</option>
        <option value="12:00 pm to 01:00 pm" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == '12:00 pm to 01:00 pm' ? 'selected' : '' }}>12:00 PM to 01:00 PM</option>
        <option value="01:00 pm to 02:00 pm" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == '01:00 pm to 02:00 pm' ? 'selected' : '' }}>01:00 PM to 02:00 PM</option>
        <option value="02:00 pm to 03:00 pm" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == '02:00 pm to 03:00 pm' ? 'selected' : '' }}>02:00 PM to 03:00 PM</option>
        <option value="03:00 pm to 04:00 pm" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == '03:00 pm to 04:00 pm' ? 'selected' : '' }}>03:00 PM to 04:00 PM</option>
        <option value="04:00 pm to 05:00 pm" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == '04:00 pm to 05:00 pm' ? 'selected' : '' }}>04:00 PM to 05:00 PM</option>
        <option value="05:00 pm to 06:00 pm" {{ old('time', isset($estimate) ? $estimate->safari->time : '') == '05:00 pm to 06:00 pm' ? 'selected' : '' }}>05:00 PM to 06:00 PM</option>
    </select>
    @error('time')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="type">Booking Type</label>
    <select name="type" id="type" class="form-control ranthambore">
        <option value="">Select Booking Type</option>
        <option value="Advance Booking" {{ old('type', isset($estimate) ? $estimate->safari->type : '') == 'Advance Booking' ? 'selected' : '' }}>Advanced Booking</option>
        <option value="Current Booking" {{ old('type', isset($estimate) ? $estimate->safari->type : '') == 'Current Booking' ? 'selected' : '' }}>Currennt Booking</option>
    </select>
    @error('type')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-12">
    <label for="jeeps">No. of Jeeps/Canter</label>
    <input type="number" id="jeeps" class="form-control ranthambore" placeholder="No. of Jeeps/Canter" name="jeeps"
        value="{{ old('jeeps', isset($estimate) ? $estimate->safari->jeeps : '1') }}">
    @error('jeeps')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
