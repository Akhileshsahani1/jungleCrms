<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-12">
                <label for="sanctuary">Choose Sanctuary</label>
                <select id="sanctuary" class="form-control safari" name="sanctuary" onchange="loadForm()">
                    <option value="" selected>Select Sanctuary</option>
                    <option value="gir"
                        {{ old('sanctuary', in_array('safari', $booking_type) ? $booking->safari->sanctuary : '') == 'gir' ? 'selected' : '' }}>
                        Gir</option>
                    <option value="jim"
                        {{ old('sanctuary', in_array('safari', $booking_type) ? $booking->safari->sanctuary : '') == 'jim' ? 'selected' : '' }}>
                        Jim Corbett</option>
                    <option value="ranthambore"
                        {{ old('sanctuary', in_array('safari', $booking_type) ? $booking->safari->sanctuary : '') == 'ranthambore' ? 'selected' : '' }}>
                        Ranthambore</option>
                    <option value="tadoba"
                        {{ old('sanctuary', in_array('safari', $booking_type) ? $booking->safari->sanctuary : '') == 'tadoba' ? 'selected' : '' }}>
                        Tadoba</option>
                </select>
                @error('sanctuary')
                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>
<div id="gir">
    @include('bookings.package.sanctuaries.gir')
</div>
<div id="jim">
    @include('bookings.package.sanctuaries.jim')
</div>
<div id="ranthambore">
    @include('bookings.package.sanctuaries.ranthambore')
</div>
<div id="tadoba">
    @include('bookings.package.sanctuaries.tadoba')
</div>
