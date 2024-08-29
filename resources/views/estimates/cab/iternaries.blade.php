<div class="col-sm-12 mx-auto" id="iternaries">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Iternaries</h3>
        </div>
        <div class="card-body">
            <table id="iternaries_option" class="table table-striped">
                <tbody>

                    <tr>
                        <td style="width:35%;">
                            <select type="text" class="form-control" id="iternary_state" name="iternary_state"
                                onchange="getIternaries()">
                                <option>Please Select Iternary State</option>
                                @foreach ($iternaries as $iternary)
                                    <option value="{{ $iternary->id }}"
                                        @if (isset($estimate)) @if ($estimate->iternary_state == $iternary->id) selected @endif
                                        @endif>
                                        {{ $iternary->state }}</option>
                                @endforeach
                            </select>
                            @error('iternary_state')
                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </td>
                        <td style="width:25%;">
                            <select name="duration" id="iternary_duration" class="form-control"
                                onchange="getIternaries()">
                                <option value="1"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '1' ? 'selected' : '' }}>
                                    1 Night</option>
                                <option value="2"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '2' ? 'selected' : '' }}>
                                    2 Nights</option>
                                <option value="3"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '3' ? 'selected' : '' }}>
                                    3 Nights</option>
                                <option value="4"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '4' ? 'selected' : '' }}>
                                    4 Nights</option>
                                <option value="5"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '5' ? 'selected' : '' }}>
                                    5 Nights</option>
                                <option value="6"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '6' ? 'selected' : '' }}>
                                    6 Nights</option>
                                <option value="7"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '7' ? 'selected' : '' }}>
                                    7 Nights</option>
                                <option value="8"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '8' ? 'selected' : '' }}>
                                    8 Nights</option>
                                <option value="9"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '9' ? 'selected' : '' }}>
                                    9 Nights</option>
                                <option value="10"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '10' ? 'selected' : '' }}>
                                    10 Nights</option>
                                <option value="11"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '11' ? 'selected' : '' }}>
                                    11 Nights</option>
                                <option value="12"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '12' ? 'selected' : '' }}>
                                    12 Nights</option>
                                <option value="13"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '13' ? 'selected' : '' }}>
                                    13 Nights</option>
                                <option value="14"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '14' ? 'selected' : '' }}>
                                    14 Nights</option>
                                <option value="15"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '15' ? 'selected' : '' }}>
                                    15 Nights</option>
                                <option value="16"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '16' ? 'selected' : '' }}>
                                    16 Nights</option>
                                <option value="17"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '17' ? 'selected' : '' }}>
                                    17 Nights</option>
                                <option value="18"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '18' ? 'selected' : '' }}>
                                    18 Nights</option>
                                <option value="19"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '19' ? 'selected' : '' }}>
                                    19 Nights</option>
                                <option value="20"
                                    {{ old('duration', isset($estimate) ? $estimate->duration : '') == '20' ? 'selected' : '' }}>
                                    20 Nights</option>
                            </select>
                        </td>
                        <td><select class="form-control" id="iternary" name="iternary"
                                onchange="showIternaries(this.value)">
                                @if (isset($estimate))
                                    @foreach ($iternarie_options as $option)
                                        <option value="{{ $option->id }}"
                                            @if ($estimate->iternary == $option->id) selected @endif>
                                            {{ $option->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>

    </div>
    <table class="table table-striped" id="iternaries_show">
        @if (isset($estimate))
            <tbody>
                @foreach ($estimate->iternaries as $key => $iternaries)
                    <tr id="iternaries-option-row{{ $key }}">
                        <td><input type="text" name="iternaries[{{ $key }}][title]" placeholder="Title"
                                class="form-control" id="particular{{ $key }}" required
                                value="{{ $iternaries->title }}">
                        </td>
                        <td>
                            <textarea name="iternaries[{{ $key }}][text]" placeholder="Text" class="form-control rate" required="">{{ $iternaries->text }}</textarea>
                        </td>
                        <td class="text-right"><button type="button"
                                onclick="$('#iternaries-option-row{{ $key }}').remove();"
                                data-toggle="tooltip" title="" class="btn btn-danger"
                                data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right" colspan="6"><button type="button" onclick="addIternary();"
                            data-toggle="tooltip" title="Add Option" class="btn btn-secondary"
                            data-original-title="Add Option"><i class="fas fa-plus-circle"></i></button></td>
                </tr>
            </tfoot>
        @endif
    </table>
</div>
