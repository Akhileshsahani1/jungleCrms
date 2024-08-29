@if (in_array('safari', $booking_type) && count($booking->safaris) > 0)
    @foreach ($booking->safaris as $key => $safari)
<div class="card" id="safaris{{ $key }}">
    <div class="card-header bg-dark">
        <h3 class="card-title">Jim Corbett National Park Safari</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" class="btn bg-danger btn-sm" onclick="$('#safaris{{ $key }}').remove();">
                Remove
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="mode{{ $key }}">Mode of Vehicle</label>
                <select id="mode{{ $key }}" class="form-control jim" name="safari[{{ $key }}][mode]" onchange="javascript: loadJimCorbettSafariTourTimings({{ $key }}, this.options[this.selectedIndex].value);" required>
                    <option value="" selected>Select Mode of Vehicle</option>
                    <option value="Jeep" @if($safari->mode == 'Jeep') selected @endif>Jeep</option>
                    <option value="Canter" @if($safari->mode == 'Canter') selected @endif>Canter</option>
                    <option value="Elephant" @if($safari->mode == 'Elephant') selected @endif>Elephant</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="area{{ $key }}">Safari Area</label>
                <select name="safari[{{ $key }}][area]" class="form-control jim" id="area{{ $key }}" required>
                    <option value="">Select Safari Area</option>
                    <option value="Buffer Zone" @if($safari->area == 'Buffer Zone') selected @endif>Buffer Zone</option>
                    <option value="Bijrani" @if($safari->area == 'Bijrani') selected @endif>Bijrani</option>
                    <option value="Jhirna" @if($safari->area == 'Jhirna') selected @endif>Jhirna</option>
                    <option value="Dhela" @if($safari->area == 'Dhela') selected @endif>Dhela</option>
                    <option value="Garjia" @if($safari->area == 'Garjia') selected @endif>Garjia</option>
                    <option value="Durga Devi" @if($safari->area == 'Durga') selected @endif>Durga Devi</option>
                    <option value="Dhikala" @if($safari->area == 'Dhikala') selected @endif>Dhikala</option>
                    <option value="Sitabani" @if($safari->area == 'Sitabani') selected @endif>Sitabani</option>
                    <option value="Phato" @if($safari->area == 'Phato') selected @endif>Phato</option>
                    <option value="Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato" @if($safari->area == 'Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato') selected @endif>
                        Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato</option>
                    <option value="Jhirna Range Phato/Sitabani" @if($safari->area == 'Jhirna Range Phato/Sitabani') selected @endif>Jhirna Range Phato/Sitabani</option>
                    <option value="Jhirna/Dhela/Phato" @if($safari->area == 'Jhirna/Dhela/Phato') selected @endif>Jhirna/Dhela/Phato</option>
                    <option value="Sitabani Bhandarpani gate" @if($safari->area =='Sitabani Bhandarpani gate') selected @endif>Sitabani Bhandarpani gate</option>
                    <option value="Jhirna Range Phato/Sitabani Bhandarpani gate" @if($safari->area =='Jhirna Range Phato/Sitabani Bhandarpani gate') selected @endif>Jhirna Range Phato/Sitabani Bhandarpani gate</option>
                    <option value="Jhirna/Dhela/Garjia" @if($safari->area =='Jhirna/Dhela/Garjia') selected @endif>Jhirna/Dhela/Garjia</option>
                    <option value="Jhirna/Dhela/Garjia/Sitabani Bhandarpani" @if($safari->area =='Jhirna/Dhela/Garjia/Sitabani Bhandarpani') selected @endif>Jhirna/Dhela/Garjia/Sitabani Bhandarpani</option>
                    <option value="Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato" @if($safari->area =='Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato') selected @endif>Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="total_person{{ $key }}">No of Person</label>
                <input type="number" id="total_person{{ $key }}" class="form-control jim" placeholder="No of Person"
                    name="safari[{{ $key }}][total_person]" value="{{ $safari->total_person }}" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="nationality{{ $key }}">Nationality</label>
                <select name="safari[{{ $key }}][nationality]" id="nationality{{ $key }}" class="form-control jim" required>
                    <option value="">Select Nationality</option>
                    <option value="Indian" @if($safari->nationality == 'Indian') selected @endif>Indian</option>
                    <option value="Foreigner" @if($safari->nationality == 'Foreigner') selected @endif>Foreigner</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="date{{ $key }}">Safari Date</label>
                <input type="date" id="date{{ $key }}" class="form-control jim" placeholder="Safari Date"
                    name="safari[{{ $key }}][date]" value="{{ $safari->date }}" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="jim_time{{ $key }}">Time</label>
                <select name="safari[{{ $key }}][time]" id="jim_time{{ $key }}" class="form-control jim" required>
                    <option value="">Select Time</option>
                    <option value="Morning" @if($safari->time == 'Morning') selected @endif>Morning</option>
                    <option value="Evening" @if($safari->time == 'Evening') selected @endif>Evening</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="jeeps{{ $key }}">No. of Jeeps/Canter</label>
                <input type="number" id="jeeps{{ $key }}" class="form-control jim" placeholder="No. of Jeeps/Canter"
                    name="safari[{{ $key }}][jeeps]" value="{{ $safari->jeeps }}" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="vendor{{ $key }}">Choose Vendor</label>
                <select id="vendor{{ $key }}" class="form-control jim" name="safari[{{ $key }}][vendor]" required>
                    @foreach ($vendors as $vendor)
                    @if($vendor->sanctuary == 'jim')
                        <option value="{{ $vendor->id }}" @if($safari->vendor == $vendor->id) selected @endif>{{ $vendor->name }} ({{ $vendor->phone }})</option>
                    @else
                        @continue;
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="safari_due_amount{{ $key }}">Safari Due Amount (₹)</label>
                <input type="number" id="safari_due_amount{{ $key }}" class="form-control jim" placeholder="Safari Due Amount"
                    name="safari[{{ $key }}][safari_due_amount]" value="{{ $safari->safari_due_amount ?? 0 }}" required>
            </div>
            <div class="form-group col-sm-12">
                <label for="note{{ $key }}">Safari Note</label>
                <textarea class="form-control jim summernote" id="note{{ $key }}" name="safari[{{ $key }}][note]">{{ $safari->note }}</textarea>
            </div>
        </div>
    </div>
</div>
@endforeach
@else
<div class="card" id="safaris0">
    <div class="card-header bg-dark">
        <h3 class="card-title">Jim Corbett National Park Safari</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" class="btn bg-danger btn-sm" onclick="$('#safaris0').remove();">
                Remove
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="form-group col-sm-4">
                <label for="mode0">Mode of Vehicle</label>
                <select id="mode0" class="form-control jim" name="safari[0][mode]" onchange="javascript: loadJimCorbettSafariTourTimings(0, this.options[this.selectedIndex].value);" required>
                    <option value="" selected>Select Mode of Vehicle</option>
                    <option value="Jeep">Jeep</option>
                    <option value="Canter">Canter</option>
                    <option value="Elephant">Elephant</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="area0">Safari Area</label>
                <select name="safari[0][area]" class="form-control jim" id="area0" required>
                    <option value="">Select Safari Area</option>
                    <option value="Buffer Zone">Buffer Zone</option>
                    <option value="Bijrani">Bijrani</option>
                    <option value="Jhirna">Jhirna</option>
                    <option value="Dhela">Dhela</option>
                    <option value="Garjia">Garjia</option>
                    <option value="Durga Devi">Durga Devi</option>
                    <option value="Dhikala">Dhikala</option>
                    <option value="Sitabani">Sitabani</option>
                    <option value="Phato">Phato</option>
                    <option value="Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato">
                        Bijrani/Jhirna/Dhela/Garjia/Durga Devi/Dhikala/Sitabani/Phato</option>
                    <option value="Jhirna Range Phato/Sitabani">Jhirna Range Phato/Sitabani</option>
                    <option value="Jhirna/Dhela/Phato">Jhirna/Dhela/Phato</option>
                    <option value="Sitabani Bhandarpani gate">Sitabani Bhandarpani gate</option>
                    <option value="Jhirna Range Phato/Sitabani Bhandarpani gate">Jhirna Range Phato/Sitabani Bhandarpani gate</option>
                    <option value="Jhirna/Dhela/Garjia">Jhirna/Dhela/Garjia</option>
                    <option value="Jhirna/Dhela/Garjia/Sitabani Bhandarpani">Jhirna/Dhela/Garjia/Sitabani Bhandarpani</option>
                    <option value="Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato">Jhirna/Dhela/Garjia/Sitabani Bhandarpani/Phato</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="total_person0">No of Person</label>
                <input type="number" id="total_person0" class="form-control jim" placeholder="No of Person"
                    name="safari[0][total_person]" value="1" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="nationality0">Nationality</label>
                <select name="safari[0][nationality]" id="nationality0" class="form-control jim" required>
                    <option value="">Select Nationality</option>
                    <option value="Indian">Indian</option>
                    <option value="Foreigner">Foreigner</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="date0">Safari Date</label>
                <input type="date" id="date0" class="form-control jim" placeholder="Safari Date"
                    name="safari[0][date]" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="jim_time0">Time</label>
                <select name="safari[0][time]" id="jim_time0" class="form-control jim" required>
                    <option value="">Select Time</option>
                    <option value="Morning">Morning</option>
                    <option value="Evening">Evening</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="jeeps0">No. of Jeeps/Canter</label>
                <input type="number" id="jeeps0" class="form-control jim" placeholder="No. of Jeeps/Canter"
                    name="safari[0][jeeps]" value="1" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="vendor0">Choose Vendor</label>
                <select id="vendor0" class="form-control jim" name="safari[0][vendor]" required>
                    @foreach ($vendors as $vendor)
                    @if($vendor->sanctuary == 'jim')
                        <option value="{{ $vendor->id }}" @if($vendor->default == 'yes') selected @endif>{{ $vendor->name }} ({{ $vendor->phone }})</option>
                    @else
                        @continue;
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="safari_due_amount0">Safari Due Amount (₹)</label>
                <input type="number" id="safari_due_amount0" class="form-control jim" placeholder="Safari Due Amount"
                    name="safari[0][safari_due_amount]" value="0" required>
            </div>
            <div class="form-group col-sm-12">
                <label for="note0">Safari Note</label>
                <textarea class="form-control jim summernote" id="note0" name="safari[0][note]"></textarea>
            </div>
        </div>
    </div>
</div>
@endif
