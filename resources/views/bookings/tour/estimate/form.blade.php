<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-indigo">
            <h3 class="card-title">Tour Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="payment_mode">Booking Type</label>
                    <select class="form-control" name="booking_type[]" id="type" multiple="multiple">
                        <option></option>
                        <option value="cab" {{ (collect(old('booking_type', in_array('cab', $booking_type) ? $booking_type: ''))->contains('cab')) ? 'selected' : '' }}>Cab</option>
                        <option value="hotel" {{ (collect(old('booking_type', in_array('hotel', $booking_type) ? $booking_type : ''))->contains('hotel')) ? 'selected' : '' }}>Hotel</option>
                        <option value="safari" {{ (collect(old('booking_type', in_array('safari', $booking_type) ? $booking_type : ''))->contains('safari')) ? 'selected' : '' }}>Safari</option>
                    </select>
                    @error('booking_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-8">
                    <label for="amount">Total Amount</label>
                    <input type="number" id="amount" class="form-control" placeholder="Total Amount" name="amount"
                        value="{{ tourTotal($id) }}">
                    @error('amount')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto" id="cab">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Cab Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="trip_type">Trip Type</label>
                    <input type="text" id="trip_type" class="form-control cab" placeholder="Trip Type" name="trip_type"
                        value="{{ old('trip_type', in_array('cab', $booking_type) ? $booking->cab->trip_type : '') }}">
                    @error('trip_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>               
                <div class="form-group col-sm-4">
                    <label for="cab_type">Vehicle Type</label>
                    <select type="text" class="form-control cab" id="cab_type" name="cab_type">
                        <option value="">Select Vehicle Type</option>
                        <optgroup label="Hatchback">
                            <option value="Maruti Suzuki Swift"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Maruti Suzuki Swift'? 'selected': '' }}>
                                Maruti Suzuki Swift</option>
                            <option value="Maruti Suzuki Celerio"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Maruti Suzuki Celerio'? 'selected': '' }}>
                                Maruti Suzuki Celerio</option>
                        </optgroup>
                        <optgroup label="MPV">
                            <option value="Maruti Suzuki Eeco"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Maruti Suzuki Eeco'? 'selected': '' }}>
                                Maruti Suzuki Eeco</option>
                            <option value="Maruti Suzuki Ertiga"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Maruti Suzuki Ertiga'? 'selected': '' }}>
                                Maruti Suzuki Ertiga</option>
                            <option value="Maruti Suzuki XL6"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Maruti Suzuki XL6'? 'selected': '' }}>
                                Maruti Suzuki XL6</option>
                            <option value="Toyota Innova Crysta"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Toyota Innova Crysta'? 'selected': '' }}>
                                Toyota Innova Crysta</option>
                                <option value="Innova"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Innova'? 'selected': '' }}>
                                Innova</option>
                        </optgroup>
                        <optgroup label="Sedan">
                            <option value="Swift Dezire"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Swift Dezire'? 'selected': '' }}>
                                Swift Dezire</option>
                            <option value="Toyota Etios"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Toyota Etios'? 'selected': '' }}>
                                Toyota Etios</option>
                        </optgroup>
                        <optgroup label="SUV">
                            <option value="Tata Safari"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Tata Safari' ? 'selected' : '' }}>
                                Tata Safari</option>
                            <option value="Mahindra Scorpio"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Mahindra Scorpio'? 'selected': '' }}>
                                Mahindra Scorpio</option>
                            <option value="Hyundai Creta"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Hyundai Creta'? 'selected': '' }}>
                                Hyundai Creta</option>
                        </optgroup>
                        <optgroup label="Traveller">
                            <option value="Force Traveller"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Force Traveller'? 'selected': '' }}>
                                Force Traveller</option>
                            <option value="Mini Bus"
                                {{ old('cab_type', in_array('cab', $booking_type) ? $booking->cab->vehicle_type : '') == 'Mini Bus' ? 'selected' : '' }}>
                                Mini Bus</option>
                        </optgroup>
                    </select>
                    @error('cab_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="start_date">Journey Start Date</label>
                    <input type="date" id="start_date" class="form-control cab" placeholder="Journey Start Date"
                        name="start_date"
                        value="{{ old('start_date', in_array('cab', $booking_type) ? $booking->cab->start_date : '') }}">
                    @error('start_date')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="end_date">Journey End Date</label>
                    <input type="date" id="end_date" class="form-control cab" placeholder="Journey End Date"
                        name="end_date"
                        value="{{ old('end_date', in_array('cab', $booking_type) ? $booking->cab->end_date : '') }}">
                    @error('end_date')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="days">No of Days</label>
                    <input type="number" id="days" class="form-control cab" placeholder="No of Days" name="days"
                        value="{{ old('days', in_array('cab', $booking_type) ? $booking->cab->days : '') }}">
                    @error('days')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="pick_up">Pickup Point</label>
                    <input type="text" id="pick_up" class="form-control cab" placeholder="Pickup Point" name="pick_up"
                        value="{{ old('pick_up', in_array('cab', $booking_type) ? $booking->cab->pick_up : '') }}">
                    @error('pick_up')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="drop">Drop Point</label>
                    <input type="text" id="drop" class="form-control cab" placeholder="Drop Point" name="drop"
                        value="{{ old('drop', in_array('cab', $booking_type) ? $booking->cab->drop : '') }}">
                    @error('drop')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="pickup_time">Pickup Time</label>
                    <input type="time" id="pickup_time" class="form-control cab" placeholder="Pickup Time"
                        name="pickup_time"
                        value="{{ old('pickup_time', in_array('cab', $booking_type) ? $booking->cab->pickup_time : '') }}">
                    @error('pickup_time')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="total_riders">No of Riders</label>
                    <input type="number" id="total_riders" class="form-control cab" placeholder="No of Riders"
                        name="total_riders"
                        value="{{ old('total_riders', in_array('cab', $booking_type) ? $booking->cab->total_riders : '') }}">
                    @error('total_riders')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="vendor_name">Choose Vendor</label>
                    <select id="vendor_name" class="form-control" name="vendor_name" onchange="$('#vendor_mobile').val($(this).find(':selected').data('phone'))">
                        <option value="">Choose Vendor </option>
                        @foreach ($cab_vendors as $vendor)
                            @if (isset($booking))
                                <option value="{{ $vendor->name }}" data-phone="{{ $vendor->phone }}"
                                    @isset($booking->cab->vendor_name) @if ($vendor->name == $booking->cab->vendor_name) selected @endif  @else @if ($vendor->default == 'yes') selected @endif @endisset>
                                    {{ $vendor->name }} ({{ $vendor->phone }})</option>
                            @else
                                <option value="{{ $vendor->name }}" data-phone="{{ $vendor->phone }}"
                                    @if ($vendor->default == 'yes') selected @endif>{{ $vendor->name }}
                                    ({{ $vendor->phone }})</option>
                            @endif
                        @endforeach
                    </select>
                    @error('vendor_name')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="amount">Vendor Mobile Number</label>
                    <input type="text" id="vendor_mobile" class="form-control" placeholder="Vendor Mobile Number"
                        name="vendor_mobile"
                        value="{{ old('vendor_mobile', in_array('cab', $booking_type) ? $booking->cab->vendor_mobile : '') }}">
                    @error('vendor_mobile')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="amount">Cab Due Amount</label>
                    <input type="number" id="cab_due_amount" class="form-control cab" placeholder="Cab Due Amount" name="cab_due_amount"
                        value="{{ old('cab_due_amount', 0) }}">
                    @error('cab_due_amount')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                 <div class="form-group col-sm-4">
                    <label for="amount">No of Cab</label>
                    <input type="number" id="no_of_cab" class="form-control cab" placeholder="No of Cab" name="no_of_cab"
                        value="{{ old('no_of_cab', 1) }}">
                    @error('no_of_cab')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-12">
                    <label for="note">Cab Note</label>
                    <textarea class="form-control cab summernote" id="cab_note"
                        name="cab_note">{{ old('note', in_array('cab', $booking_type) ? $booking->cab->note : '') }}</textarea>
                </div>
            </div>
        </div>
        @include('bookings.tour.halts')
    </div>
</div>
<div class="col-sm-12 mx-auto" id="hotel">
    <div class="card">
        <div class="card-header bg-orange">
            <h3 class="card-title">Hotel Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="adults">No of Adults</label>
                    <input type="number" id="adults" class="form-control hotel guest" placeholder="No of Adults" name="adults"
                        value="{{ old('adults', in_array('hotel', $booking_type) ? $booking->hotel->adult : '0') }}">
                    @error('adults')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="childs">No of Children</label>
                    <input type="number" id="childs" class="form-control hotel guest" placeholder="No of Children"
                        name="childs" value="{{ old('childs', in_array('hotel', $booking_type) ? $booking->hotel->child : '0') }}">
                    @error('childs')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="room">No of Rooms</label>
                    <input type="number" id="room" class="form-control hotel" placeholder="No of Rooms" name="room"
                        value="{{ old('room', in_array('hotel', $booking_type) ? $booking->hotel->room : '0') }}">
                    @error('room')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="room">No of Beds</label>
                    <input type="number" id="bed" class="form-control hotel" placeholder="No of Beds" name="bed"
                        value="{{ old('bed', in_array('hotel', $booking_type) ? $booking->hotel->bed : '0') }}">
                    @error('bed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-4">
                    <label for="check_in">Check In</label>
                    <input type="date" id="check_in" class="form-control hotel" placeholder="Check In" name="check_in"
                        value="{{ old('check_in', in_array('hotel', $booking_type) ? $booking->hotel->check_in : '') }}">
                    @error('check_in')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="check_out">Check Out</label>
                    <input type="date" id="check_out" class="form-control hotel" placeholder="Check Out"
                        name="check_out"
                        value="{{ old('check_out', in_array('hotel', $booking_type) ? $booking->hotel->check_out : '') }}">
                    @error('check_out')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-4">
                    <label for="destination">Destination</label>
                    <input type="text" id="destination" class="form-control hotel" placeholder="Destination"
                        name="destination"
                        value="{{ old('destination', in_array('hotel', $booking_type) ? $booking->hotel->destination : '') }}">
                    @error('destination')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="hotel">Hotel</label>
                    <select class="form-control hotel" name="hotel" id="hotel"
                        onchange="getRooms(this.value)">
                        <option></option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}"
                                {{ old('zone', isset($booking) ? $booking->option_selected->hotel_id : '') == $hotel->id ? 'selected' : '' }}>
                                {{ $hotel->name }}</option>
                        @endforeach
                    </select>
                    @error('hotel')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="hotel_room">Hotel room</label>
                    <select class="form-control" name="hotel_room" id="hotel_room"
                        onchange="getServices(this.value)">
                        <option>Select Room</option>
                    </select>
                    @error('hotel_room')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="service">Service</label>
                    <select class="form-control service" name="service" id="service" onchange="getTotal(this.value)">
                        <option>Select Service</option>
                    </select>
                    @error('service')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                 <div class="form-group col-sm-4">
                    <label for="amount">Hotel Due Amount</label>
                    <input type="number" id="hotel_due_amount hotel" class="form-control" placeholder="Hotel Due Amount" name="hotel_due_amount"
                        value="{{ old('hotel_due_amount', 0) }}">
                    @error('hotel_due_amount')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-12">
                    <label for="note">Hotel Note</label>
                    <textarea class="form-control hotel summernote" id="hotel_note"
                        name="hotel_note">{{ old('note', in_array('hotel', $booking_type) ? $booking->hotel->note : '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto" id="safari">
    <div class="card">
        <div class="card-header bg-brown">
            <h3 class="card-title">Safari Details</h3>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn bg-dark btn-sm" onclick="addSafari();">
                  Add Safari
                </a>
            </div>
        </div>
        <div class="card-body" id="main-safari-div">
            @include('bookings.tour.safari')
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-brown">
            <h3 class="card-title">Customer Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="image">Upload Image of 1st Member</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="form-control" id="image" name="image">
                        </div>
                        @isset($booking , $booking->image)
                        <div class="input-group-append">
                            <a href={{ asset('storage/uploads/bookings/customers/'.$booking->id.'/'.$booking->image) }} class="input-group-text" download>Download</a>
                        </div>
<div class="input-group-append">
                            <a href={{ route('delete.booking-customer', $booking->id) }} class="input-group-text">Delete</a>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
            <table id="details" class="table table-condensed table-sm">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>State</th>
                        <th>Id Type</th>
                        <th>Id No</th>
                    </tr>
                </thead>
                <tbody>
                        <tr id="customer-option-row0">
                            <td><input type="text" name="customer[0][name]"
                                    placeholder="Name" class="form-control safari" id="name0" required></td>
                            <td><input type="number" name="customer[0][age]"
                                        placeholder="Age" class="form-control safari" id="age0" required></td>
                            <td>
                                <select name="customer[0][gender]" class="form-control safari" id="gender0" required>
                                    <option value="" selected>Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </td>
                            <td>
                                <select name="customer[0][nationality]" class="form-control safari" id="nationality0" onchange="getStates(0, this.value)" required>
                                    <option value="" selected>Select</option>
                                    <option value="Indian">Indian</option>
                                    <option value="Foreigner">Foreigner</option>
                                </select>
                            </td>
                            <td>
                                <select name="customer[0][state]" class="form-control safari" id="state0" required>
                                    <option value="" selected>State</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->state }}">{{ $state->state }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="customer[0][idproof]" class="form-control safari" id="idproof0" required>
                                    <option value="" selected>Type</option>
                                    <option value="Aadhar Card">Aadhar Card</option>
                                    <option value="Voter ID">Voter ID</option>
                                    <option value="Driving License">Driving License</option>
                                    <option value="Passport">Passport</option>
                                </select>
                            </td>
                            <td><input type="text" name="customer[0][idproof_no]"
                                placeholder="Id No" class="form-control safari" id="idproof_no0" required></td>

                            <td class="text-right"><button type="button" onclick="$('#customer-option-row0').remove();"
                                    data-toggle="tooltip" title="" class="btn btn-danger"
                                    data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="9"><button type="button" onclick="addCustomer();"
                                data-toggle="tooltip" title="Add Option" class="btn btn-secondary"
                                data-original-title="Add Option"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-indigo">
            <h3 class="card-title">Payment Details</h3>
        </div>
        <div class="card-body">
            <table id="option" class="table table-striped">
                <thead>
                    <tr>
                        <th>Particular</th>
                        <th>Amount</th>
                        <th>Rate</th>
                    </tr>
                </thead>
                <tbody>
                        <tr id="item-option-row0">
                            <td style="width:350px"><input type="text" name="item[0][particular]"
                                    placeholder="Particular" class="form-control" id="particular0" value="Taxable amount" required></td>
                            <td><input type="text" name="item[0][amount]" placeholder="Amount"
                                    class="form-control amount" id="amount0" value="{{ tourTotal($id) }}" required></td>
                            <td><input type="number" name="item[0][rate]" placeholder="Rate" class="form-control rate"
                                    id="rate0" value="5" required></td>
                            <td class="text-right"><button type="button" onclick="$('#item-option-row0').remove();"
                                    data-toggle="tooltip" title="" class="btn btn-danger"
                                    data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="5"><button type="button" onclick="addItem();"
                                data-toggle="tooltip" title="Add Option" class="btn btn-secondary"
                                data-original-title="Add Option"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
{{-- <div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-indigo">
            <h3 class="card-title">GST & PG Charges</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="gst_filed">GST Filed</label>
                    <select id="gst_filed" class="form-control"  name="gst_filed">
                        <option value="">Please select GST Filed</option>
                        <option value="0" {{ old('gst_filed', isset($booking) ? $booking->gst_filed : '') == '0' ? 'selected' : '' }}>GST included in the package</option>
                        <option value="00" {{ old('gst_filed', isset($booking) ? $booking->gst_filed : '') == '00' ? 'selected' : '' }}>GST not required</option>
                        <option value="5" {{ old('gst_filed', isset($booking) ? $booking->gst_filed : '') == '5' ? 'selected' : '' }}>GST 5%</option>
                        <option value="18" {{ old('gst_filed', isset($booking) ? $booking->gst_filed : '') == '18' ? 'selected' : '' }}>GST 18%</option>
                    </select>
                    @error('gst_filed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
                    <label for="pg_charges_filed">PG charges filed</label>
                    <select id="pg_charges_filed" class="form-control"  name="pg_charges_filed">
                        <option value="">Please select PG charges filed</option>
                        <option value="0" {{ old('pg_charges_filed', isset($booking) ? $booking->pg_charges_filed : '') == '0' ? 'selected' : '' }}>PG charges included in the package</option>
                        <option value="00" {{ old('pg_charges_filed', isset($booking) ? $booking->pg_charges_filed : '') == '00' ? 'selected' : '' }}>PG charges not required</option>
                        <option value="3" {{ old('pg_charges_filed', isset($booking) ? $booking->pg_charges_filed : '') == '3' ? 'selected' : '' }}>PG charges 3%</option>
                        <option value="4" {{ old('pg_charges_filed', isset($booking) ? $booking->pg_charges_filed : '') == '4' ? 'selected' : '' }}>PG charges 4%</option>
                        <option value="5" {{ old('pg_charges_filed', isset($booking) ? $booking->pg_charges_filed : '') == '5' ? 'selected' : '' }}>PG charges 5%</option>
                        <option value="6" {{ old('pg_charges_filed', isset($booking) ? $booking->pg_charges_filed : '') == '6' ? 'selected' : '' }}>PG charges 6%</option>
                        <option value="7" {{ old('pg_charges_filed', isset($booking) ? $booking->pg_charges_filed : '') == '7' ? 'selected' : '' }}>PG charges 7%</option>
                        <option value="8" {{ old('pg_charges_filed', isset($booking) ? $booking->pg_charges_filed : '') == '8' ? 'selected' : '' }}>PG charges 8%</option>
                    </select>
                    @error('pg_charges_filed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div> --}}
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-indigo">
            <h3 class="card-title">Inclusions</h3>
        </div>
        <div class="card-body">
            <table id="inclusion" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $inclusion_row = 0;
                    @endphp
                    @foreach ($inclusions as $inclusion)
                        <tr id="inclusion-row{{ $inclusion_row }}">
                            <td><input type="text" name="inclusion[{{ $inclusion_row }}][content]"
                                    value="{{ $inclusion->content }}" placeholder="Content" class="form-control"
                                    id="content{{ $inclusion_row }}" required></td>
                            <td class="text-right"><button type="button"
                                    onclick="$('#inclusion-row{{ $inclusion_row }}').remove();" data-toggle="tooltip"
                                    title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                        class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                        @php
                            $inclusion_row++;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addTourInclusion();"
                                data-toggle="tooltip" title="Add Inclusion" class="btn btn-secondary"
                                data-original-title="Add Inclusion"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-indigo">
            <h3 class="card-title">Exclusions</h3>
        </div>
        <div class="card-body">
            <table id="exclusion" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $exclusion_row = 0;
                    @endphp
                    @foreach ($exclusions as $exclusion)
                        <tr id="exclusion-row{{ $exclusion_row }}">
                            <td><input type="text" name="exclusion[{{ $exclusion_row }}][content]"
                                    value="{{ $exclusion->content }}" placeholder="Content" class="form-control"
                                    id="content{{ $exclusion_row }}" required></td>
                            <td class="text-right"><button type="button"
                                    onclick="$('#exclusion-row{{ $exclusion_row }}').remove();" data-toggle="tooltip"
                                    title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                        class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                        @php
                            $exclusion_row++;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addTourExclusion();"
                                data-toggle="tooltip" title="Add Exclusion" class="btn btn-secondary"
                                data-original-title="Add Exclusion"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-indigo">
            <h3 class="card-title">Terms and conditions</h3>
        </div>
        <div class="card-body">
            <table id="term" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $term_row = 0;
                    @endphp
                    @foreach ($terms as $term)
                        <tr id="term-row{{ $term_row }}">
                            <td><input type="text" name="term[{{ $term_row }}][content]"
                                    value="{{ $term->content }}" placeholder="Content" class="form-control"
                                    id="content{{ $term_row }}" required></td>
                            <td class="text-right"><button type="button"
                                    onclick="$('#term-row{{ $term_row }}').remove();" data-toggle="tooltip"
                                    title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                        class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                        @php
                            $term_row++;
                        @endphp
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addTourTerm();"
                                data-toggle="tooltip" title="Add Term" class="btn btn-secondary"
                                data-original-title="Add Term"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <button class="btn btn-block btn-success" type="submit" form="tourForm">Submit</button>
</div>
