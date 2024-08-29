<div class="form-group col-sm-4">
    <label for="jim_mode">Mode of Vehicle</label>
    <select id="jim_mode" class="form-control jim" name="mode" onchange="javascript: loadJimCorbettTimings(this.options[this.selectedIndex].value);">
        <option value="" selected>Select Mode of Vehicle</option>
        <option value="Jeep"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Jeep' ? 'selected' : '' }}>Jeep
        </option>
        <option value="Canter"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Canter' ? 'selected' : '' }}>Canter
        </option>
        <option value="Elephant"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Elephant' ? 'selected' : '' }}>Elephant
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
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Buffer Zone' ? 'selected' : '' }}>Buffer Zone
        </option>
        <option value="Bijrani"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Bijrani' ? 'selected' : '' }}>Bijrani
        </option>
        <option value="Jhirna"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Jhirna' ? 'selected' : '' }}>Jhirna</option>
        <option value="Dhela"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Dhela' ? 'selected' : '' }}>Dhela
        </option>
        <option value="Garjia"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Garjia' ? 'selected' : '' }}>Garjia
        </option>
        <option value="Durga Devi"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Durga Devi' ? 'selected' : '' }}>Durga
            Devi</option>
        <option value="Dhikala"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Dhikala' ? 'selected' : '' }}>Dhikala
        </option>
        <option value="Sitabani"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Sitabani' ? 'selected' : '' }}>Sitabani</option>
        <option value="Phato"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Phato' ? 'selected' : '' }}>Phato
        </option>
        <option value="Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') =='Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato'? 'selected': '' }}>
            Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato</option>
        <option value="Jhirna Range Phato/Sitabani"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') =='Jhirna Range Phato/Sitabani'? 'selected': '' }}>
            Jhirna Range Phato/Sitabani</option>
        <option value="Jhirna/Dhela/Phato"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') =='Jhirna/Dhela/Phato'? 'selected': '' }}>
            Jhirna/Dhela/Phato</option>
        <option value="Sitabani Bhandarpani gate"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') =='Sitabani Bhandarpani gate'? 'selected': '' }}>
            Sitabani Bhandarpani gate</option>
        <option value="Jhirna Range Phato/Sitabani Bhandarpani gate"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') =='Jhirna Range Phato/Sitabani Bhandarpani gate'? 'selected': '' }}>
            Jhirna Range Phato/Sitabani Bhandarpani gate</option>
        <option value="Jhirna/Dhela/Garjia"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') =='Jhirna/Dhela/Garjia'? 'selected': '' }}>
            Jhirna/Dhela/Garjia</option>
        <option value="Jhirna/Dhela/Garjia/Sitabani Bhandarpani"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') =='Jhirna/Dhela/Garjia/Sitabani Bhandarpani'? 'selected': '' }}>
            Jhirna/Dhela/Garjia/Sitabani Bhandarpani</option>
        <option value="Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') =='Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato'? 'selected': '' }}>
            Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato</option>
    </select>
    @error('area')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="total_person">No of Person</label>
    <input type="number" id="total_person" class="form-control jim" placeholder="No of Person" name="total_person"
        value="{{ old('total_person', isset($estimate) ? $estimate->safari->total_person : '') }}">
    @error('total_person')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="nationality">Nationality</label>
    <select name="nationality" id="nationality" class="form-control jim">
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
    <input type="date" id="date" class="form-control jim" placeholder="Safari Date" name="date"
        value="{{ old('date', isset($estimate) ? $estimate->safari->date : '') }}">
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

<div class="form-group col-sm-12">
    <label for="jeeps">No. of Jeeps/Canter/Elephant</label>
    <input type="number" id="jeeps" class="form-control jim" placeholder="No. of Jeeps/Canter" name="jeeps"
        value="{{ old('jeeps', isset($estimate) ? $estimate->safari->jeeps : '1') }}">
    @error('jeeps')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>

