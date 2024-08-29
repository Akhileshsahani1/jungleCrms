@if (in_array('safari', $booking_type) && count($booking->safaris) > 0)
    @foreach ($booking->safaris as $key => $safari)
<div class="card" id="safaris{{ $key }}">
    <div class="card-header bg-dark">
        <h3 class="card-title">Tadoba Corbett National Park Safari</h3>
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
                <select id="mode{{ $key }}" class="form-control tadoba" name="safari[{{ $key }}][mode]" required>
                    <option value="" selected>Select Mode of Vehicle</option>
                    <option value="Jeep" @if($safari->mode == 'Jeep') selected @endif>Jeep</option>
                    <option value="Canter" @if($safari->mode == 'Canter') selected @endif>Canter</option>
                    <option value="Elephant" @if($safari->mode == 'Elephant') selected @endif>Elephant</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="area{{ $key }}">Safari Area</label>
                <select name="safari[{{ $key }}][area]" class="form-control tadoba" id="area{{ $key }}" required>
                    <option value="">Select Safari Area</option>
                    <option value="Moharli/Junona/Adegaon/Devada/Agarzari" @if($safari->area == 'Moharli/Junona/Adegaon/Devada/Agarzari') selected @endif>Moharli/Junona/Adegaon/Devada/Agarzari</option>
                    <option value="Pangadi/Pangadi Aswal Chuha/Zari/Keslaghat/Zari Peth/Mamla" @if($safari->area == 'Pangadi/Pangadi Aswal Chuha/Zari/Keslaghat/Zari Peth/Mamla') selected @endif>Pangadi/Pangadi Aswal Chuha/Zari/Keslaghat/Zari Peth/Mamla</option>
                    <option value="Kolara Chauradeo/Alizanza/Madnapur/Shirkheda" @if($safari->area == 'Kolara Chauradeo/Alizanza/Madnapur/Shirkheda') selected @endif>Kolara Chauradeo/Alizanza/Madnapur/Shirkheda</option>
                    <option value="Navegaon/Navegaon/Nimdela" @if($safari->area == 'Navegaon/Navegaon/Nimdela') selected @endif>Navegaon/Navegaon/Nimdela</option>
                    <option value="Moharli/Kolara" @if($safari->area == 'Moharli/Kolara') selected @endif>Moharli/Kolara</option>
                    <option value="Mohali tour with Dangerous zone" @if($safari->area == 'Mohali tour with Dangerous zone') selected @endif>Mohali tour with Dangerous zone</option>
                   
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="total_person{{ $key }}">No of Person</label>
                <input type="number" id="total_person{{ $key }}" class="form-control tadoba" placeholder="No of Person"
                    name="safari[{{ $key }}][total_person]" value="{{ $safari->total_person }}" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="nationality{{ $key }}">Nationality</label>
                <select name="safari[{{ $key }}][nationality]" id="nationality{{ $key }}" class="form-control tadoba" required>
                    <option value="">Select Nationality</option>
                    <option value="Indian" @if($safari->nationality == 'Indian') selected @endif>Indian</option>
                    <option value="Foreigner" @if($safari->nationality == 'Foreigner') selected @endif>Foreigner</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="date{{ $key }}">Safari Date</label>
                <input type="date" id="date{{ $key }}" class="form-control tadoba" placeholder="Safari Date"
                    name="safari[{{ $key }}][date]" value="{{ $safari->date }}" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="tadoba_time{{ $key }}">Time</label>
                <select name="safari[{{ $key }}][time]" id="tadoba_time{{ $key }}" class="form-control tadoba" required>
                    <option value="">Select Time</option>
                    <option value="Morning" @if($safari->time == 'Morning') selected @endif>Morning</option>
                    <option value="Evening" @if($safari->time == 'Evening') selected @endif>Evening</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="jeeps{{ $key }}">No. of Jeeps/Canter</label>
                <input type="number" id="jeeps{{ $key }}" class="form-control tadoba" placeholder="No. of Jeeps/Canter"
                    name="safari[{{ $key }}][jeeps]" value="{{ $safari->jeeps }}" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="vendor{{ $key }}">Choose Vendor</label>
                <select id="vendor{{ $key }}" class="form-control tadoba" name="safari[{{ $key }}][vendor]" required>
                    @foreach ($vendors as $vendor)
                    @if($vendor->sanctuary == 'tadoba')
                        <option value="{{ $vendor->id }}" @if($safari->vendor == $vendor->id) selected @endif>{{ $vendor->name }} ({{ $vendor->phone }})</option>
                    @else
                        @continue;
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="safari_due_amount{{ $key }}">Safari Due Amount (₹)</label>
                <input type="number" id="safari_due_amount{{ $key }}" class="form-control tadoba" placeholder="Safari Due Amount"
                    name="safari[{{ $key }}][safari_due_amount]" value="{{ $safari->safari_due_amount ?? 0 }}" required>
            </div>
            <div class="form-group col-sm-12">
                <label for="note{{ $key }}">Safari Note</label>
                <textarea class="form-control summernote tadoba" id="note{{ $key }}" name="safari[{{ $key }}][note]">{{ $safari->note }}</textarea>
            </div>
        </div>
    </div>
</div>
@endforeach
@else
<div class="card" id="safaris0">
    <div class="card-header bg-dark">
        <h3 class="card-title">Tadoba Corbett National Park Safari</h3>
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
                <select id="mode0" class="form-control tadoba" name="safari[0][mode]" onchange="javascript: loadtadobaCorbettSafariPackageTimings(0, this.options[this.selectedIndex].value);" required>
                    <option value="" selected>Select Mode of Vehicle</option>
                    <option value="Jeep">Jeep</option>
                    <option value="Canter">Canter</option>
                    <option value="Elephant">Elephant</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="area0">Safari Area</label>
                <select name="safari[0][area]" class="form-control tadoba" id="area0" required>
                    <option value="">Select Safari Area</option>
                     <option value="Moharli/Junona/Adegaon/Devada/Agarzari">Moharli/Junona/Adegaon/Devada/Agarzari</option>
                    <option value="Pangadi/Pangadi Aswal Chuha/Zari/Keslaghat/Zari Peth/Mamla" >Pangadi/Pangadi Aswal Chuha/Zari/Keslaghat/Zari Peth/Mamla</option>
                    <option value="Kolara Chauradeo/Alizanza/Madnapur/Shirkheda">Kolara Chauradeo/Alizanza/Madnapur/Shirkheda</option>
                    <option value="Navegaon/Navegaon/Nimdela">Navegaon/Navegaon/Nimdela</option>
                    <option value="Moharli/Kolara">Moharli/Kolara</option>
                    <option value="Mohali tour with Dangerous zone">Mohali tour with Dangerous zone</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="total_person0">No of Person</label>
                <input type="number" id="total_person0" class="form-control tadoba" placeholder="No of Person"
                    name="safari[0][total_person]" value="1" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="nationality0">Nationality</label>
                <select name="safari[0][nationality]" id="nationality0" class="form-control tadoba" required>
                    <option value="">Select Nationality</option>
                    <option value="Indian">Indian</option>
                    <option value="Foreigner">Foreigner</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="date0">Safari Date</label>
                <input type="date" id="date0" class="form-control tadoba" placeholder="Safari Date"
                    name="safari[0][date]" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="tadoba_time0">Time</label>
                <select name="safari[0][time]" id="tadoba_time0" class="form-control tadoba" required>
                    <option value="">Select Time</option>
                    <option value="Morning">Morning</option>
                    <option value="Evening">Evening</option>
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="jeeps0">No. of Jeeps/Canter</label>
                <input type="number" id="jeeps0" class="form-control tadoba" placeholder="No. of Jeeps/Canter"
                    name="safari[0][jeeps]" value="1" required>
            </div>
            <div class="form-group col-sm-4">
                <label for="vendor0">Choose Vendor</label>
                <select id="vendor0" class="form-control tadoba" name="safari[0][vendor]" required>
                    @foreach ($vendors as $vendor)
                    @if($vendor->sanctuary == 'tadoba')
                        <option value="{{ $vendor->id }}" @if($vendor->default == 'yes') selected @endif>{{ $vendor->name }} ({{ $vendor->phone }})</option>
                    @else
                        @continue;
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-4">
                <label for="safari_due_amount0">Safari Due Amount (₹)</label>
                <input type="number" id="safari_due_amount0" class="form-control tadoba" placeholder="Safari Due Amount"
                    name="safari[0][safari_due_amount]" value="0" required>
            </div>
            <div class="form-group col-sm-12">
                <label for="note0">Safari Note</label>
                <textarea class="form-control summernote tadoba" id="note0" name="safari[0][note]"></textarea>
            </div>
        </div>
    </div>
</div>
@endif
