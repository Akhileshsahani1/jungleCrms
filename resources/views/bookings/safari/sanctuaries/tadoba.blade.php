<div class="form-group col-sm-4">
    <label for="tadoba_mode">Mode of Vehicle</label>
    <select id="tadoba_mode" class="form-control tadoba" name="mode" >
        <option value="" selected>Select Mode of Vehicle</option>
        <option value="Jeep"
            {{ old('mode', isset($booking) ? $booking->safari->mode : '') == 'Jeep' ? 'selected' : '' }}>Jeep
        </option>
        <option value="Canter"
            {{ old('mode', isset($booking) ? $booking->safari->mode : '') == 'Canter' ? 'selected' : '' }}>Canter
        </option>
    </select>
    @error('mode')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="area">Safari Area</label>
    <!-- <select name="area" class="form-control tadoba" id="area">
        <option value="">Select Safari Area</option>
         <option value="Moharli/Junona/Adegaon/Devada/Agarzari" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Moharli/Junona/Adegaon/Devada/Agarzari' ? 'selected' : '' }}>Moharli/Junona/Adegaon/Devada/Agarzari</option>
         <option value="Pangadi/Pangadi Aswal Chuha/Zari/Keslaghat/Zari Peth/Mamla" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Pangadi/Pangadi Aswal Chuha/Zari/Keslaghat/Zari Peth/Mamla' ? 'selected' : '' }}>Pangadi/Pangadi Aswal Chuha/Zari/Keslaghat/Zari Peth/Mamla</option>

         <option value="Kolara Chauradeo/Alizanza/Madnapur/Shirkheda" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Kolara Chauradeo/Alizanza/Madnapur/Shirkheda' ? 'selected' : '' }}>Kolara Chauradeo/Alizanza/Madnapur/Shirkheda</option>

         <option value="Navegaon/Navegaon/Nimdela" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Navegaon/Navegaon/Nimdela' ? 'selected' : '' }}>Navegaon/Navegaon/Nimdela</option>

         <option value="Moharli/Kolara" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Moharli/Kolara' ? 'selected' : '' }}>Moharli/Kolara</option>

         <option value="Mohali tour with Dangerous zone" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Mohali tour with Dangerous zone' ? 'selected' : '' }}>Mohali tour with Dangerous zone</option>
    </select> -->

    <select name="area" class="form-control tadoba" id="area">
        <option value="">Select Safari Area</option>
         <option value="Moharli" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Moharli' ? 'selected' : '' }}>Moharli</option>
         <option value="Junona" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Junona' ? 'selected' : '' }}>Junona</option>
         <option value="Adegaon" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Adegaon' ? 'selected' : '' }}>Adegaon</option>
         <option value="Devada" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Devada' ? 'selected' : '' }}>Devada</option>
         <option value="Agarzari" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Agarzari' ? 'selected' : '' }}>Agarzari</option>

         <option value="Pangadi" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Pangadi' ? 'selected' : '' }}>Pangadi</option>
         <option value="Pangadi Aswal Chuha" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Pangadi Aswal Chuha' ? 'selected' : '' }}>Pangadi Aswal Chuha</option>
         <option value="Zari" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Zari' ? 'selected' : '' }}>Zari</option>
         <option value="Keslaghat" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Keslaghat' ? 'selected' : '' }}>Keslaghat</option>
         <option value="Zari Peth" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Zari Peth' ? 'selected' : '' }}>Zari Peth</option>

         <option value="Kolara Chauradeo" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Kolara Chauradeo' ? 'selected' : '' }}>Kolara Chauradeo</option>
         <option value="Alizanza" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Alizanza' ? 'selected' : '' }}>Alizanza</option>
         <option value="Madnapur" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Madnapur' ? 'selected' : '' }}>Madnapur</option>
         <option value="Shirkheda" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Shirkheda' ? 'selected' : '' }}>Shirkheda</option>
         <option value="Navegaon" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Navegaon' ? 'selected' : '' }}>Navegaon</option>
         <option value="Nimdela" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Nimdela' ? 'selected' : '' }}>Nimdela</option>
         
         <option value="Moharli" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Moharli' ? 'selected' : '' }}>Moharli</option>
         <option value="Kolara" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Kolara' ? 'selected' : '' }}>Kolara</option>

         <option value="Mohali tour with Dangerous zone" {{ old('area', isset($booking) ? $booking->safari->area : '') == 'Mohali tour with Dangerous zone' ? 'selected' : '' }}>Mohali tour with Dangerous zone</option>
    </select>
    @error('area')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="total_person">No of Person</label>
    <input type="number" id="total_person" class="form-control tadoba" placeholder="No of Person" name="total_person"
        value="{{ old('total_person', isset($booking) ? $booking->safari->total_person : '') }}">
    @error('total_person')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>
<div class="form-group col-sm-4">
    <label for="nationality">Nationality</label>
    <select name="nationality" id="nationality" class="form-control tadoba">
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
    <input type="date" id="date" class="form-control tadoba" placeholder="Safari Date" name="date"
        value="{{ old('date', isset($booking) ? $booking->safari->date : '') }}">
    @error('date')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-4">
    <label for="tadoba_time">Time</label>
    <select name="time" id="tadoba_time" class="form-control tadoba tadoba_time">
        <option value="">Select Time</option>
        <option value="Morning" {{ old('time', isset($booking) ? $booking->safari->time : '') == 'Morning' ? 'selected' : '' }}>Morning</option>
        <option value="Evening" {{ old('time', isset($booking) ? $booking->safari->time : '') == 'Evening' ? 'selected' : '' }}>Evening</option>
    </select>
    @error('time')
    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>

<div class="form-group col-sm-4">
    <label for="vendor">Choose Vendor</label>
    <select id="vendor" class="form-control tadoba" name="vendor">
        <option value="">Choose Vendor </option>
        @foreach ($vendors as $vendor)
            @if ($vendor->sanctuary == 'tadoba')
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
    <input type="number" id="jeeps" class="form-control tadoba" placeholder="No. of Jeeps/Canter" name="jeeps"
        value="{{ old('jeeps', isset($booking) ? $booking->safari->jeeps : '1') }}">
    @error('jeeps')
        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
    @enderror
</div>

