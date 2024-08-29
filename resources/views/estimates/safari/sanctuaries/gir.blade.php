<div class="form-group col-sm-4">
    <label for="mode">Mode of Vehicle</label>
    <select id="mode" class="form-control gir" name="mode">
        <option value="" selected>Select Mode of Vehicle</option>
        <option value="Jeep"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Jeep' ? 'selected' : '' }}>Jeep
        </option>
        <option value="Car"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Car' ? 'selected' : '' }}>Car</option>
        <option value="Bus"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Bus' ? 'selected' : '' }}>Bus</option>
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
            {{ old('zone', isset($estimate) ? $estimate->safari->zone : '') == 'Gir Jungle Trail' ? 'selected' : '' }}>
            Gir Jungle Trail</option>
        <option value="Devalia Safari Park"
            {{ old('zone', isset($estimate) ? $estimate->safari->zone : '') == 'Devalia Safari Park' ? 'selected' : '' }}>
            Devalia Safari Park</option>
        <option value="Kankai Nature Safari"
            {{ old('zone', isset($estimate) ? $estimate->safari->zone : '') == 'Kankai Nature Safari' ? 'selected' : '' }}>
            Kankai Nature Safari </option>
            <option value="Devalia Bus Safari"
            {{ old('zone', isset($estimate) ? $estimate->safari->zone : '') == 'Devalia Bus Safari' ? 'selected' : '' }}>
            Devalia Bus Safari</option>
    </select>
    @error('zone')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="adult">No of Adults</label>
    <input type="number" id="adult" class="form-control gir" placeholder="No of Adults" name="adult"
        value="{{ old('adult', isset($estimate) ? $estimate->safari->adult : '') }}">
    @error('adult')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="child">No of Children</label>
    <input type="number" id="child" class="form-control gir" placeholder="No of Children" name="child"
        value="{{ old('child', isset($estimate) ? $estimate->safari->child : '') }}">
    @error('child')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="nationality">Nationality</label>
    <select name="nationality" id="nationality" class="form-control gir">
        <option value="">Select Nationality</option>
        <option value="Indian"
            {{ old('nationality', isset($estimate) ? $estimate->safari->nationality : '') == 'Indian' ? 'selected' : '' }}>
            Indian</option>
        <option value="Foreigner"
            {{ old('nationality', isset($estimate) ? $estimate->safari->nationality : '') == 'Foreigner' ? 'selected' : '' }}>
            Foreigner</option>
    </select>
    @error('nationality')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="date">Safari Date</label>
    <input type="date" id="date" class="form-control gir" placeholder="Safari Date" name="date"
        value="{{ old('date', isset($estimate) ? $estimate->safari->date : '') }}">
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
<div class="form-group col-sm-8">
    <label for="jeeps">No. of Jeeps/Canter</label>
    <input type="number" id="jeeps" class="form-control gir" placeholder="No. of Jeeps/Canter" name="jeeps"
        value="{{ old('jeeps', isset($estimate) ? $estimate->safari->jeeps : '1') }}">
    @error('jeeps')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
