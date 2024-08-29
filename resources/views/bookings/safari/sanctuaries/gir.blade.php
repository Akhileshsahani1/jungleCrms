<div class="form-group col-sm-4">
    <label for="mode">Mode of Vehicle</label>
    <select id="mode" class="form-control gir" name="mode">
        <option value="" selected>Select Mode of Vehicle</option>
        <option value="Jeep"
            {{ old('mode', isset($booking) ? $booking->safari->mode : '') == 'Jeep' ? 'selected' : '' }}>Jeep
        </option>
        <option value="Car"
            {{ old('mode', isset($booking) ? $booking->safari->mode : '') == 'Car' ? 'selected' : '' }}>Car</option>
        <option value="Bus"
            {{ old('mode', isset($booking) ? $booking->safari->mode : '') == 'Bus' ? 'selected' : '' }}>Bus</option>
    </select>
    @error('mode')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="zone">Safari Zone</label>
    <select name="zone" class="form-control gir" id="zone"
        onchange="javascript: loadTimings(this.options[this.selectedIndex].value);">
        <option value="">Select Safari Zone</option>
        <option value="Gir Jungle Trail"
            {{ old('zone', isset($booking) ? $booking->safari->zone : '') == 'Gir Jungle Trail' ? 'selected' : '' }}>
            Gir Jungle Trail</option>
        <option value="Devalia Safari Park"
            {{ old('zone', isset($booking) ? $booking->safari->zone : '') == 'Devalia Safari Park' ? 'selected' : '' }}>
            Devalia Safari Park</option>
        <option value="Kankai Nature Safari"
            {{ old('zone', isset($booking) ? $booking->safari->zone : '') == 'Kankai Nature Safari' ? 'selected' : '' }}>
            Kankai Nature Safari </option>
        <option value="Devalia Bus Safari"
            {{ old('zone', isset($booking) ? $booking->safari->zone : '') == 'Devalia Bus Safari' ? 'selected' : '' }}>
            Devalia Bus Safari</option>
    </select>
    @error('zone')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="adult">No of Adults</label>
    <input type="number" id="adult" class="form-control gir" placeholder="No of Adults" name="adult"
        value="{{ old('adult', isset($booking) ? $booking->safari->adult : '') }}">
    @error('adult')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="child">No of Children</label>
    <input type="number" id="child" class="form-control gir" placeholder="No of Children" name="child"
        value="{{ old('child', isset($booking) ? $booking->safari->child : '') }}">
    @error('child')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="nationality">Nationality</label>
    <select name="nationality" id="nationality" class="form-control gir">
        <option value="">Select Nationality</option>
        <option value="Indian"
            {{ old('nationality', isset($booking) ? $booking->safari->nationality : '') == 'Indian' ? 'selected' : '' }}>
            Indian</option>
        <option value="Foreigner"
            {{ old('nationality', isset($booking) ? $booking->safari->nationality : '') == 'Foreigner' ? 'selected' : '' }}>
            Foreigner</option>
    </select>
    @error('nationality')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="date">Safari Date</label>
    <input type="date" id="date" class="form-control gir" placeholder="Safari Date" name="date"
        value="{{ old('date', isset($booking) ? $booking->safari->date : '') }}">
    @error('date')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="time">Safari Time</label>
    <select name="time" id="time" class="form-control gir">
        <option value="">Select Time</option>
    </select>
    @error('time')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="vendor">Choose Vendor</label>
    <select id="vendor" class="form-control gir" name="vendor">
        <option value="">Choose Vendor </option>
        @foreach ($vendors as $vendor)
            @if($vendor->sanctuary == 'gir')
                @if(isset($booking))
                    <option value="{{ $vendor->id }}" @isset($booking->safari->vendor_id) @if($vendor->id == $booking->safari->vendor_id) selected @endif  @else @if($vendor->default == 'yes') selected @endif @endisset>{{ $vendor->name }} ({{ $vendor->phone }})</option>
                @else
                    <option value="{{ $vendor->id }}" @if($vendor->default == 'yes') selected @endif>{{ $vendor->name }} ({{ $vendor->phone }})</option>
                @endif
            @else
                @continue;
            @endif
        @endforeach
    </select>
    @error('vendor')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="jeeps">No. of Jeeps/Canter</label>
    <input type="number" id="jeeps" class="form-control gir" placeholder="No. of Jeeps/Canter" name="jeeps"
        value="{{ old('jeeps', isset($booking) ? $booking->safari->jeeps : '1') }}">
    @error('jeeps')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
