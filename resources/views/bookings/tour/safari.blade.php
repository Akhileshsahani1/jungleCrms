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
                </select>
                @error('sanctuary')
                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
</div>
<div id="gir">
    @include('bookings.tour.sanctuaries.gir')
</div>
<div id="jim">
    @include('bookings.tour.sanctuaries.jim')
</div>
<div id="ranthambore">
    @include('bookings.tour.sanctuaries.ranthambore')
</div>
