@if (in_array('cab', $booking_type) && count($booking->cabs) > 0)
    @foreach ($booking->cabs as $key => $cab)
        <div class="card" id="trip{{ $key }}">
            <div class="card-header bg-dark">
                <h3 class="card-title">Trip</h3>
                <div class="card-tools">
                    <a href="javascript:void(0)" class="btn bg-danger btn-sm"
                        onclick="$('#trip{{ $key }}').remove();">
                        Remove
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-4">
                        <label for="trip_type0">Trip Type</label>
                        <input type="text" id="trip_type0" class="form-control cab" placeholder="Trip Type"
                            name="trip[{{ $key }}][trip_type]"
                            value="{{ in_array('cab', $booking_type) ? $cab->trip_type : '' }}" required>
                    </div>
                   
                    <div class="form-group col-sm-4">
                        <label for="cab_type0">Vehicle Type</label>
                        <select type="text" class="form-control cab" id="cab_type0"
                            name="trip[{{ $key }}][cab_type]" required>
                            <option value="">Select Vehicle Type</option>
                            <optgroup label="Main">
                                <option value="Jeep" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Jeep') selected @endif>
                                    Jeep</option>
                                <option value="Canter" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Canter') selected @endif>
                                    Canter</option>
                            </optgroup>
                            <optgroup label="Hatchback">
                                <option value="Maruti Suzuki WagonR" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Maruti Suzuki WagonR') selected @endif>
                                    Maruti Suzuki WagonR</option>
                                <option value="Maruti Suzuki Swift" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Maruti Suzuki Swift') selected @endif>
                                    Maruti Suzuki Swift</option>
                                <option value="Maruti Suzuki Celerio" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Maruti Suzuki Celerio') selected @endif>
                                    Maruti Suzuki Celerio</option>
                            </optgroup>
                            <optgroup label="MPV">
                                <option value="Maruti Suzuki Eeco" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Maruti Suzuki Eeco') selected @endif>
                                    Maruti Suzuki Eeco</option>
                                <option value="Maruti Suzuki Ertiga" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Maruti Suzuki Ertiga') selected @endif>
                                    Maruti Suzuki Ertiga</option>
                                <option value="Maruti Suzuki XL6" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Maruti Suzuki XL6') selected @endif>
                                    Maruti Suzuki XL6</option>
                                <option value="Toyota Innova Crysta"
                                    @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Toyota Innova Crysta') selected @endif>
                                    Toyota Innova Crysta</option>
                                <option value="Innova" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Innova') selected @endif>
                                    Innova</option>
                            </optgroup>
                            <optgroup label="Sedan">
                                <option value="Swift Dezire" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Swift Dezire') selected @endif>
                                    Swift Dezire</option>
                                <option value="Toyota Etios" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Toyota Etios') selected @endif>
                                    Toyota Etios</option>
                            </optgroup>
                            <optgroup label="SUV">
                                <option value="Tata Safari" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Tata Safari') selected @endif>
                                    Tata Safari</option>
                                <option value="Mahindra Scorpio" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Mahindra Scorpio') selected @endif>
                                    Mahindra Scorpio</option>
                                <option value="Hyundai Creta" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Hyundai Creta') selected @endif>
                                    Hyundai Creta</option>
                                <option value="Jeep" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Jeep') selected @endif>
                                    Jeep</option>
                            </optgroup>
                            <optgroup label="Traveller">
                                <option value="Force Traveller" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Force Traveller') selected @endif>
                                    Force Traveller</option>
                                <option value="Mini Bus" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Mini Bus') selected @endif>
                                    Mini Bus</option>
                                <option value="Canter" @if (in_array('cab', $booking_type) && $cab->vehicle_type == 'Canter') selected @endif>
                                    Canter</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="start_date0">Journey Start Date</label>
                        <input type="date" id="start_date0" class="form-control cab" placeholder="Journey Start Date"
                            name="trip[{{ $key }}][start_date]"
                            value="{{ in_array('cab', $booking_type) && isset($cab->start_date) ? $cab->start_date : '' }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="end_date0">Journey End Date</label>
                        <input type="date" id="end_date0" class="form-control cab" placeholder="Journey End Date"
                            name="trip[{{ $key }}][end_date]"
                            value="{{ in_array('cab', $booking_type) && isset($cab->end_date) ? $cab->end_date : '' }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="days0">No of Days</label>
                        <input type="number" id="days0" class="form-control cab" placeholder="No of Days"
                            name="trip[{{ $key }}][days]"
                            value="{{ in_array('cab', $booking_type) && isset($cab->days) ? $cab->days : '' }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pick_up0">Pickup Point</label>
                        <input type="text" id="pick_up0" class="form-control cab" placeholder="Pickup Point"
                            name="trip[{{ $key }}][pick_up]"
                            value="{{ in_array('cab', $booking_type) && isset($cab->pick_up) ? $cab->pick_up : '' }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="drop0">Drop Point</label>
                        <input type="text" id="drop0" class="form-control cab" placeholder="Drop Point"
                            name="trip[{{ $key }}][drop]"
                            value="{{ in_array('cab', $booking_type) && isset($cab->drop) ? $cab->drop : '' }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="pickup_time0">Pickup Time</label>
                        <input type="time" id="pickup_time0" class="form-control cab" placeholder="Pickup Time"
                            name="trip[{{ $key }}][pickup_time]"
                            value="{{ in_array('cab', $booking_type) && isset($cab->pickup_time) ? $cab->pickup_time : '' }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="total_riders0">No of Riders</label>
                        <input type="number" id="total_riders0" class="form-control cab" placeholder="No of Riders"
                            name="trip[{{ $key }}][total_riders]"
                            value="{{ in_array('cab', $booking_type) && isset($cab->total_riders) ? $cab->total_riders : '' }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="vendor_name0">Vendor Name</label>
                        {{-- <input type="text" id="vendor_name0" class="form-control cab" placeholder="Vendor Name" name="trip[{{ $key }}][vendor_name]"
                            value="{{ in_array('cab', $booking_type) && isset($cab->vendor_name) ? $cab->vendor_name : '' }}" required> --}}
                            <select id="vendor_name0" class="form-control cab" name="trip[{{ $key }}][vendor_name]" onchange="$('#vendor_mobile{{ $key }}').val($(this).find(':selected').data('phone'))">
                                <option value="">Choose Vendor </option>
                                @foreach ($cab_vendors as $vendor)
                                    @if (isset($booking))
                                        <option value="{{ $vendor->name }}" data-phone="{{ $vendor->phone }}"
                                            @isset($cab->vendor_name) @if ($vendor->name == $cab->vendor_name) selected @endif  @else @if ($vendor->default == 'yes') selected @endif @endisset>
                                            {{ $vendor->name }} ({{ $vendor->phone }})</option>
                                    @else
                                        <option value="{{ $vendor->name }}" data-phone="{{ $vendor->phone }}"
                                            @if ($vendor->default == 'yes') selected @endif>{{ $vendor->name }}
                                            ({{ $vendor->phone }})</option>
                                    @endif
                                @endforeach
                            </select>
                    </div>
                     <div class="form-group col-sm-4">
                        <label for="vendor_mobile0">Vendor Mobile Number</label>
                        <input type="text" id="vendor_mobile{{ $key }}" class="form-control cab" placeholder="Vendor Mobile Number" name="trip[{{ $key }}][vendor_mobile]"
                            value="{{ in_array('cab', $booking_type) && isset($cab->vendor_mobile) ? $cab->vendor_mobile : '' }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="no_of_cab0">No. of Cab</label>
                        <input type="number" id="no_of_cab0" class="form-control cab" placeholder="No. of Cab"
                            name="trip[{{ $key }}][no_of_cab]"
                            value="{{ in_array('cab', $booking_type) && isset($cab->no_of_cab) ? $cab->no_of_cab : 1 }}" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="cab_due_amount0">Cab Due Amount (₹)</label>
                        <input type="number" id="cab_due_amount0" class="form-control cab" placeholder="Cab Due Amount" name="trip[{{ $key }}][cab_due_amount]"
                            value="{{ in_array('cab', $booking_type)  && isset($cab->cab_due_amount) ?  $cab->cab_due_amount : '0' }}" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="cab_note0">Cab Note</label>
                        <textarea class="form-control cab summernote" id="cab_note0" name="trip[{{ $key }}][cab_note]">{{ in_array('cab', $booking_type) && isset($cab->note) ? $cab->note : '' }}</textarea>
                    </div>
                </div>
            </div>
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Cab Halts</h3>
                </div>
                <div class="card-body">
                    <table id="halt{{ $key }}" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Halt</th>
                                <th>Starts from</th>
                                <th>Ends on</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($cab->halts) && count($cab->halts) > 0)
                                @foreach ($cab->halts as $lowkey => $halt)
                                    <tr id="cab-halt-{{ $key }}-row{{ $lowkey }}">
                                        <td style="width:550px"><input type="text" name="trip[{{ $key }}][halts][{{ $lowkey }}][halt]"
                                                placeholder="Halt Destination" class="form-control"
                                                id="halt-destination-{{ $key }}-row{{ $lowkey }}" value="{{ $halt->halt }}">
                                        </td>
                                        <td><input type="date" name="trip[{{ $key }}][halts][{{ $lowkey }}][start]"
                                                placeholder="Start Date" class="form-control" id="halt-start-{{ $key }}-row{{ $lowkey }}"
                                                value="{{ $halt->start }}">
                                        </td>
                                        <td><input type="date" name="trip[{{ $key }}][halts][{{ $lowkey }}][end]" placeholder="End Date"
                                                class="form-control" id="halt-end-{{ $key }}-row{{ $lowkey }}"
                                                value="{{ $halt->end }}">
                                        </td>
                                        <td class="text-right"><button type="button"
                                                onclick="$('#cab-halt-{{ $key }}-row{{ $lowkey }}').remove();" data-toggle="tooltip"
                                                title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                                    class="fas fa-minus-circle"></i></button></td>
                                    </tr>
                                @endforeach 
                            @endif                   
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="text-right" colspan="5"><button type="button" onclick="addCabHalt({{ $key }});"
                                        data-toggle="tooltip" title="Add Halt" class="btn btn-secondary"
                                        data-original-title="Add Halt"><i class="fas fa-plus-circle"></i></button></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="card" id="trip0">
        <div class="card-header bg-dark">
            <h3 class="card-title">Trip</h3>
            <div class="card-tools"><a href="javascript:void(0)" class="btn bg-danger btn-sm"
                    onclick="$('#trip0').remove();">Remove</a></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="trip_type0">Trip Type</label>
                    <input type="text" id="trip_type0" class="form-control cab" placeholder="Trip Type"
                        name="trip[0][trip_type]" required>
                </div>
                {{-- <div class="form-group col-sm-4">
                    <label for="pickup_medium0">Pickup Medium</label>
                    <select type="text" class="form-control cab" id="pickup_medium0" name="trip[0][pickup_medium]"
                        required>
                        <option value="">Select Pickup Medium</option>
                        <option value="Hatchback">Hatchback</option>
                        <option value="MPV">MPV</option>
                        <option value="Sedan">Sedan</option>
                        <option value="Suv">Suv</option>
                        <option value="Traveller">Traveller</option>
                    </select>
                </div> --}}
                <div class="form-group col-sm-4">
                    <label for="cab_type0">Vehicle Type</label>
                    <select type="text" class="form-control cab" id="cab_type0" name="trip[0][cab_type]" required>
                        <option value="">Select Vehicle Type</option>
                        <optgroup label="Hatchback">
                            <option value="Maruti Suzuki WagonR">Maruti Suzuki WagonR</option>
                            <option value="Maruti Suzuki Swift">Maruti Suzuki Swift</option>
                            <option value="Maruti Suzuki Celerio">Maruti Suzuki Celerio</option>
                        </optgroup>
                        <optgroup label="MPV">
                            <option value="Maruti Suzuki Eeco">Maruti Suzuki Eeco</option>
                            <option value="Maruti Suzuki Ertiga">Maruti Suzuki Ertiga</option>
                            <option value="Maruti Suzuki XL6">Maruti Suzuki XL6</option>
                            <option value="Toyota Innova Crysta">Toyota Innova Crysta</option>
                            <option value="Innova">Innova</option>
                        </optgroup>
                        <optgroup label="Sedan">
                            <option value="Swift Dezire">Swift Dezire</option>
                            <option value="Toyota Etios">Toyota Etios</option>
                        </optgroup>
                        <optgroup label="SUV">
                            <option value="Tata Safari">Tata Safari</option>
                            <option value="Mahindra Scorpio">Mahindra Scorpio</option>
                            <option value="Hyundai Creta">Hyundai Creta</option>
                            <option value="Jeep">Jeep</option>
                        </optgroup>
                        <optgroup label="Traveller">
                            <option value="Force Traveller">Force Traveller</option>
                            <option value="Mini Bus">Mini Bus</option>
                            <option value="Canter">Canter</option>
                        </optgroup>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="start_date0">Journey Start Date</label>
                    <input type="date" id="start_date0" class="form-control cab" placeholder="Journey Start Date"
                        name="trip[0][start_date]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="end_date0">Journey End Date</label>
                    <input type="date" id="end_date0" class="form-control cab" placeholder="Journey End Date"
                        name="trip[0][end_date]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="days0">No of Days</label>
                    <input type="number" id="days0" class="form-control cab" placeholder="No of Days"
                        name="trip[0][days]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="pick_up0">Pickup Point</label>
                    <input type="text" id="pick_up0" class="form-control cab" placeholder="Pickup Point"
                        name="trip[0][pick_up]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="drop0">Drop Point</label>
                    <input type="text" id="drop0" class="form-control cab" placeholder="Drop Point" name="trip[0][drop]"
                        required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="pickup_time0">Pickup Time</label>
                    <input type="time" id="pickup_time0" class="form-control cab" placeholder="Pickup Time"
                        name="trip[0][pickup_time]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="total_riders0">No of Riders</label>
                    <input type="number" id="total_riders0" class="form-control cab" placeholder="No of Riders"
                        name="trip[0][total_riders]" value="2" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="vendor_name0">Vendor Name</label>
                    <select id="vendor_name0" class="form-control cab" name="trip[0][vendor_name]" onchange="$('#vendor_mobile0').val($(this).find(':selected').data('phone'))">
                        <option value="">Choose Vendor </option>
                        @foreach ($cab_vendors as $vendor)
                            @if (isset($booking))
                                <option value="{{ $vendor->name }}" data-phone="{{ $vendor->phone }}"
                                    @isset($cab->vendor_name) @if ($vendor->name == $cab->vendor_name) selected @endif  @else @if ($vendor->default == 'yes') selected @endif @endisset>
                                    {{ $vendor->name }} ({{ $vendor->phone }})</option>
                            @else
                                <option value="{{ $vendor->name }}" data-phone="{{ $vendor->phone }}"
                                    @if ($vendor->default == 'yes') selected @endif>{{ $vendor->name }}
                                    ({{ $vendor->phone }})</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                 <div class="form-group col-sm-4">
                    <label for="vendor_mobile0">Vendor Mobile Number</label>
                    <input type="text" id="vendor_mobile0" class="form-control cab" placeholder="Vendor Mobile Number" name="trip[0][vendor_mobile]" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="no_of_cab0">No. of Cab</label>
                    <input type="number" id="no_of_cab0" class="form-control cab" placeholder="No. of Cab"
                        name="trip[0][no_of_cab]" value="1" required>
                </div>
                <div class="form-group col-sm-12">
                    <label for="cab_due_amount0">Cab Due Amount (₹)</label>
                    <input type="number" id="cab_due_amount0" class="form-control cab" placeholder="Cab Due Amount" name="trip[0][cab_due_amount]" value="0" required>
                </div>
                <div class="form-group col-sm-12">
                    <label for="cab_note0">Cab Note</label>
                    <textarea class="form-control cab summernote" id="cab_note0" name="trip[0][cab_note]"></textarea>
                </div>
            </div>
        </div>
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Cab Halts</h3>
            </div>
            <div class="card-body">
                <table id="halt0" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Halt</th>
                            <th>Starts from</th>
                            <th>Ends on</th>
                        </tr>
                    </thead>
                    <tbody>
                                      
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right" colspan="5"><button type="button" onclick="addCabHalt(0);"
                                    data-toggle="tooltip" title="Add Halt" class="btn btn-secondary"
                                    data-original-title="Add Halt"><i class="fas fa-plus-circle"></i></button></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endif
