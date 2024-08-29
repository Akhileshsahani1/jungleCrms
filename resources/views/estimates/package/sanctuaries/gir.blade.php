@if (in_array('safari', $estimate_type) && count($estimate->safaris) > 0)
    @foreach ($estimate->safaris as $key => $safari)
<div class="card" id="safaris{{ $key }}">
    <div class="card-header bg-dark">
        <h3 class="card-title">Gir National Park Safari</h3>
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
            <select id="mode{{ $key }}" class="form-control gir" name="safari[{{ $key }}][mode]" required>
                <option value="" selected>Select Mode of Vehicle</option>
                <option value="Jeep" @if($safari->mode == 'Jeep') selected @endif>Jeep</option>
                <option value="Car" @if($safari->mode == 'Car') selected @endif>Car</option>
                <option value="Bus" @if($safari->mode == 'Bus') selected @endif>Bus</option>
            </select>
        </div>
        <div class="form-group col-sm-4">
            <label for="zone{{ $key }}">Safari Zone</label>
            <select name="safari[{{ $key }}][zone]" class="form-control gir" id="zone{{ $key }}"
                onchange="javascript: loadSafariTimings({{ $key }}, this.options[this.selectedIndex].value);" required>
                <option value="">Select Safari Zone</option>
                <option value="Gir Jungle Trail" @if($safari->zone == 'Gir Jungle Trail') selected @endif>Gir Jungle Trail</option>
                <option value="Devalia Safari Park" @if($safari->zone == 'Devalia Safari Park') selected @endif>Devalia Safari Park</option>
                <option value="Kankai Nature Safari" @if($safari->zone == 'Kankai Nature Safari') selected @endif>Kankai Nature Safari </option>
                <option value="Devalia Bus Safari" @if($safari->zone == 'Devalia Bus Safari') selected @endif>Devalia Bus Safari</option>
            </select>
        </div>
        <div class="form-group col-sm-4">
            <label for="adult{{ $key }}">No of Adults</label>
            <input type="number" id="adult{{ $key }}" class="form-control gir" placeholder="No of Adults"
                name="safari[{{ $key }}][adult]" value="{{ $safari->adult }}" required>
        </div>
        <div class="form-group col-sm-4">
            <label for="child{{ $key }}">No of Children</label>
            <input type="number" id="child{{ $key }}" class="form-control gir" placeholder="No of Children"
                name="safari[{{ $key }}][child]" value="{{ $safari->child }}" required>
        </div>
        <div class="form-group col-sm-4">
            <label for="nationality{{ $key }}">Nationality</label>
            <select name="safari[{{ $key }}][nationality]" id="nationality{{ $key }}" class="form-control gir" required>
                <option value="">Select Nationality</option>
                <option value="Indian" @if($safari->nationality == 'Indian') selected @endif>Indian</option>
                <option value="Foreigner" @if($safari->nationality == 'Foreigner') selected @endif>Foreigner</option>
            </select>
        </div>
        <div class="form-group col-sm-4">
            <label for="date{{ $key }}">Safari Date</label>
            <input type="date" id="date{{ $key }}" class="form-control gir" placeholder="Safari Date" name="safari[{{ $key }}][date]"
            value="{{ $safari->date }}" required>
        </div>
        <div class="form-group col-sm-4">
            <label for="time{{ $key }}">Safari Time</label>
            <select name="safari[{{ $key }}][time]" id="time{{ $key }}" class="form-control gir" required>
                <option value="">Select Time</option>
            </select>
        </div>
        <div class="form-group col-sm-8">
            <label for="jeeps{{ $key }}">No. of Jeeps/Canter</label>
            <input type="number" id="jeeps{{ $key }}" class="form-control gir" placeholder="No. of Jeeps/Canter"
                name="safari[{{ $key }}][jeeps]" value="{{ $safari->jeeps }}" required>
        </div>

        <div class="form-group col-sm-12">
            <label for="note{{ $key }}">Safari Note</label>
            <textarea class="form-control gir summernote" id="note{{ $key }}" name="safari[{{ $key }}][note]">{{ $safari->note }}</textarea>
        </div>
        </div>
    </div>
</div>
@endforeach
@else
<div class="card" id="safaris0">
    <div class="card-header bg-dark">
        <h3 class="card-title">Gir National Park Safari</h3>
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
            <select id="mode0" class="form-control gir" name="safari[0][mode]" required>
                <option value="" selected>Select Mode of Vehicle</option>
                <option value="Jeep">Jeep</option>
                <option value="Car">Car</option>
                <option value="Bus">Bus</option>

            </select>
        </div>
        <div class="form-group col-sm-4">
            <label for="zone0">Safari Zone</label>
            <select name="safari[0][zone]" class="form-control gir" id="zone0"
                onchange="javascript: loadSafariTimings(0, this.options[this.selectedIndex].value);" required>
                <option value="">Select Safari Zone</option>
                <option value="Gir Jungle Trail">Gir Jungle Trail</option>
                <option value="Devalia Safari Park">Devalia Safari Park</option>
                <option value="Kankai Nature Safari">Kankai Nature Safari </option>
                <option value="Devalia Bus Safari">Devalia Bus Safari</option>
            </select>
        </div>
        <div class="form-group col-sm-4">
            <label for="adult0">No of Adults</label>
            <input type="number" id="adult0" class="form-control gir" placeholder="No of Adults"
                name="safari[0][adult]" value="1" required>
        </div>
        <div class="form-group col-sm-4">
            <label for="child0">No of Children</label>
            <input type="number" id="child0" class="form-control gir" placeholder="No of Children"
                name="safari[0][child]" value="0" required>
        </div>
        <div class="form-group col-sm-4">
            <label for="nationality0">Nationality</label>
            <select name="safari[0][nationality]" id="nationality0" class="form-control gir" required>
                <option value="">Select Nationality</option>
                <option value="Indian">Indian</option>
                <option value="Foreigner">Foreigner</option>
            </select>
        </div>
        <div class="form-group col-sm-4">
            <label for="date0">Safari Date</label>
            <input type="date" id="date0" class="form-control gir" placeholder="Safari Date" name="safari[0][date]"
                required>
        </div>
        <div class="form-group col-sm-4">
            <label for="time0">Safari Time</label>
            <select name="safari[0][time]" id="time0" class="form-control gir" required>
                <option value="">Select Time</option>
            </select>
        </div>
        <div class="form-group col-sm-8">
            <label for="jeeps0">No. of Jeeps/Canter</label>
            <input type="number" id="jeeps0" class="form-control gir" placeholder="No. of Jeeps/Canter"
                name="safari[0][jeeps]" value="1" required>
        </div>

        <div class="form-group col-sm-12">
            <label for="note0">Safari Note</label>
            <textarea class="form-control gir summernote" id="note0" name="safari[0][note]"></textarea>
        </div>
        </div>
    </div>
</div>
@endif
