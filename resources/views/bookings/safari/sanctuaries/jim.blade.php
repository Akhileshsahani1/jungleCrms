<div class="form-group col-sm-4">
    <label for="jim_mode">Mode of Vehicle</label>
    <select id="jim_mode" class="form-control jim" name="mode" onchange="javascript: loadJimCorbettTimings(this.options[this.selectedIndex].value);">
        <option value="" selected>Select Mode of Vehicle</option>
        <option value="Jeep"
            {{ old('mode', isset($booking) ? $booking->safari->mode : '') == 'Jeep' ? 'selected' : '' }}>Jeep
        </option>
        <option value="Canter"
            {{ old('mode', isset($booking) ? $booking->safari->mode : '') == 'Canter' ? 'selected' : '' }}>Canter
        </option>
        <option value="Elephant"
            {{ old('mode', isset($booking) ? $booking->safari->mode : '') == 'Elephant' ? 'selected' : '' }}>Elephant
        </option>
    </select>
    @error('mode')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="area">Safari Area</label>
    <select name="area" class="form-control jim" id="area">
        <option value="">Select Safari Area</option>
        <option value="Buffer Zone"
            {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Buffer Zone' ? 'selected' : '' }}>Buffer Zone
        </option>
        <option value="Bijrani"
            {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Bijrani' ? 'selected' : '' }}>Bijrani
        </option>
        <option value="Jhirna"
            {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Jhirna' ? 'selected' : '' }}>Jhirna
        </option>
        <option value="Dhela"
            {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Dhela' ? 'selected' : '' }}>Dhela
        </option>
        <option value="Garjia"
            {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Garjia' ? 'selected' : '' }}>Garjia
        </option>
        <option value="Durga Devi"
            {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Durga Devi' ? 'selected' : '' }}>Durga
            Devi</option>
        <option value="Dhikala"
            {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Dhikala' ? 'selected' : '' }}>Dhikala
        </option>
        <option value="Sitabani"
            {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Sitabani' ? 'selected' : '' }}>Sitabani
        </option>
        <option value="Phato"
            {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Phato' ? 'selected' : '' }}>Phato
        </option>
        <option value="Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato"
            {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato' ? 'selected' : '' }}>
            Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato</option>
        <option value="Jhirna Range Phato/Sitabani"
            {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Jhirna Range Phato/Sitabani' ? 'selected' : '' }}>
            Jhirna Range Phato/Sitabani</option>
        <option value="Jhirna/Dhela/Phato" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Jhirna/Dhela/Phato' ? 'selected' : '' }}>Jhirna/Dhela/Phato</option>
        <option value="Sitabani Bhandarpani gate"
        {{ old('area', isset($booking) ? $booking->safari->area : '') =='Sitabani Bhandarpani gate'? 'selected': '' }}>
        Sitabani Bhandarpani gate</option>
        <option value="Jhirna Range Phato/Sitabani Bhandarpani gate"
            {{ old('area', isset($booking) ? $booking->safari->area : '') =='Jhirna Range Phato/Sitabani Bhandarpani gate'? 'selected': '' }}>
            Jhirna Range Phato/Sitabani Bhandarpani gate</option>
        <option value="Jhirna/Dhela/Garjia"
            {{ old('area', isset($booking) ? $booking->safari->area : '') =='Jhirna/Dhela/Garjia'? 'selected': '' }}>
            Jhirna/Dhela/Garjia</option>
        <option value="Jhirna/Dhela/Garjia/Sitabani Bhandarpani"
            {{ old('area', isset($booking) ? $booking->safari->area : '') =='Jhirna/Dhela/Garjia/Sitabani Bhandarpani'? 'selected': '' }}>
            Jhirna/Dhela/Garjia/Sitabani Bhandarpani</option>
        <option value="Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato"
            {{ old('area', isset($booking) ? $booking->safari->area : '') =='Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato'? 'selected': '' }}>
            Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato</option>
    </select>
    @error('area')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="total_person">No of Person</label>
    <input type="number" id="total_person" class="form-control jim" placeholder="No of Person" name="total_person"
        value="{{ old('total_person', isset($booking) ? $booking->safari->total_person : '') }}">
    @error('total_person')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="nationality">Nationality</label>
    <select name="nationality" id="nationality" class="form-control jim">
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
    <input type="date" id="date" class="form-control jim" placeholder="Safari Date" name="date"
        value="{{ old('date', isset($booking) ? $booking->safari->date : '') }}">
    @error('date')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-4">
    <label for="jim_time">Time</label>
    <select name="time" id="jim_time" class="form-control jim jim_time">
        <option value="">Select Time</option>
    </select>
    @error('time')
    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-4">
    <label for="vendor">Choose Vendor</label>
    <select id="vendor" class="form-control jim" name="vendor">
        <option value="">Choose Vendor </option>
        @foreach ($vendors as $vendor)
            @if ($vendor->sanctuary == 'jim')
                @if (isset($booking))
                    <option value="{{ $vendor->id }}"
                        @isset($booking->safari->vendor_id) @if ($vendor->id == $booking->safari->vendor_id) selected @endif  @else @if ($vendor->default == 'yes') selected @endif @endisset>
                        {{ $vendor->name }} ({{ $vendor->phone }})</option>
                @else
                    <option value="{{ $vendor->id }}" @if ($vendor->default == 'yes') selected @endif>
                        {{ $vendor->name }} ({{ $vendor->phone }})</option>
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
<div class="form-group col-sm-8">
    <label for="jeeps">No. of Jeeps/Canter</label>
    <input type="number" id="jeeps" class="form-control jim" placeholder="No. of Jeeps/Canter" name="jeeps"
        value="{{ old('jeeps', isset($booking) ? $booking->safari->jeeps : '1') }}">
    @error('jeeps')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>

