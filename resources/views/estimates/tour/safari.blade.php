<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <label for="sanctuary">Choose Sanctuary</label>
                <select id="sanctuary" class="form-control safari" name="sanctuary" onchange="loadForm()">
                    <option value="" selected>Select Sanctuary</option>
                    <option value="gir"
                        {{ old('sanctuary', in_array('safari', $estimate_type) ? $estimate->safari->sanctuary : '') == 'gir' ? 'selected' : '' }}>
                        Gir</option>
                    <option value="jim"
                        {{ old('sanctuary', in_array('safari', $estimate_type) ? $estimate->safari->sanctuary : '') == 'jim' ? 'selected' : '' }}>
                        Jim Corbett</option>
                    <option value="ranthambore"
                        {{ old('sanctuary', in_array('safari', $estimate_type) ? $estimate->safari->sanctuary : '') == 'ranthambore' ? 'selected' : '' }}>
                        Ranthambore</option>
                </select>
                @error('sanctuary')
                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>
<div id="gir">
    @include('estimates.tour.sanctuaries.gir')
</div>
<div id="jim">
    @include('estimates.tour.sanctuaries.jim')
</div>
<div id="ranthambore">
    @include('estimates.tour.sanctuaries.ranthambore')
</div>
