<div class="form-group col-sm-4">
    <label for="tadoba_mode">Mode of Vehicle</label>
    <select id="tadoba_mode" class="form-control tadoba" name="mode">
        <option value="" selected>Select Mode of Vehicle</option>
        <option value="Jeep"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Jeep' ? 'selected' : '' }}>Jeep
        </option>
        <option value="Canter"
            {{ old('mode', isset($estimate) ? $estimate->safari->mode : '') == 'Canter' ? 'selected' : '' }}>Canter
        </option>
    </select>
    @error('mode')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="area">Safari Area</label>
    <select name="area" class="form-control tadoba" id="area">
        <option value="">Select Safari Area</option>
        <option value="Moharli/Junona/Adegaon/Devada/Agarzari"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Moharli/Junona/Adegaon/Devada/Agarzari' ? 'selected' : '' }}>Moharli/Junona/Adegaon/Devada/Agarzari
        </option>
        <option value="Pangadi/Pangadi Aswal Chuha/Zari/Keslaghat/Zari Peth/Mamla"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Pangadi/Pangadi Aswal Chuha/Zari/Keslaghat/Zari Peth/Mamla' ? 'selected' : '' }}>Pangadi/Pangadi Aswal Chuha/Zari/Keslaghat/Zari Peth/Mamla
        </option>
        <option value="Kolara Chauradeo/Alizanza/Madnapur/Shirkheda"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Kolara Chauradeo/Alizanza/Madnapur/Shirkheda' ? 'selected' : '' }}>Kolara Chauradeo/Alizanza/Madnapur/Shirkheda</option>
        <option value="Navegaon/Navegaon/Nimdela"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Navegaon/Navegaon/Nimdela' ? 'selected' : '' }}>Navegaon/Navegaon/Nimdela
        </option>
        <option value="Moharli/Kolara"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Moharli/Kolara' ? 'selected' : '' }}>Moharli/Kolara
        </option>
        <option value="Mohali tour with Dangerous zone"
            {{ old('area', isset($estimate) ? $estimate->safari->area : '') == 'Mohali tour with Dangerous zone' ? 'selected' : '' }}>Mohali tour with Dangerous zone</option>
    </select>
    @error('area')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="total_person">No of Person</label>
    <input type="number" id="total_person" class="form-control tadoba" placeholder="No of Person" name="total_person"
        value="{{ old('total_person', isset($estimate) ? $estimate->safari->total_person : '') }}">
    @error('total_person')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="nationality">Nationality</label>
    <select name="nationality" id="nationality" class="form-control tadoba">
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
    <input type="date" id="date" class="form-control tadoba" placeholder="Safari Date" name="date"
        value="{{ old('date', isset($estimate) ? $estimate->safari->date : '') }}">
    @error('date')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="tadoba_time">Time</label>
    <select name="time" id="tadoba_time" class="form-control tadoba tadoba_time">
        <option value="">Select Time</option>
        <option value="Morning"
            {{ old('time', isset($estimate) ? $estimate->safari->time : '') == 'Morning' ? 'selected' : '' }}>Morning
        </option>
         <option value="Evening"
            {{ old('time', isset($estimate) ? $estimate->safari->time : '') == 'Evening' ? 'selected' : '' }}>Evening
        </option>
    </select>
    @error('time')
    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-12">
    <label for="jeeps">No. of Jeeps/Canter</label>
    <input type="number" id="jeeps" class="form-control tadoba" placeholder="No. of Jeeps/Canter" name="jeeps"
        value="{{ old('jeeps', isset($estimate) ? $estimate->safari->jeeps : '1') }}">
    @error('jeeps')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>

