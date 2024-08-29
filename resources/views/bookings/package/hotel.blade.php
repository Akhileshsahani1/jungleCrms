
@if (in_array('hotel', $booking_type) && count($booking->hotels) > 0)
    @foreach ($booking->hotels as $key => $hotel)
    @php
    $hotel_list = getHotelsbyDestination($hotel->destination);
    $rooms = getRoomsbyHotel($hotel->option->hotel_id);
    $services = getServicesbyRoom($hotel->option->room_id);
@endphp
        <div class="card" id="hotels{{ $key }}">
            <div class="card-header bg-dark">
                <h3 class="card-title">Hotel</h3>
                <div class="card-tools">
                    <a href="javascript:void(0)" class="btn bg-danger btn-sm"
                        onclick="$('#hotels{{ $key }}').remove();">
                        Remove
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="destination0">Destination</label>
                        <select id="destination0" class="form-control hotel" placeholder="Destination"
                            name="hotel[{{ $key }}][destination]"
                            onchange="getHotels({{ $key }}, this.value)" required>
                            <option value="">Select Destination</option>
                            @foreach ($destinations as $destination)
                                <option value="{{ $destination->destination }}" @if($hotel->destination == $destination->destination) selected @endif>{{ $destination->destination }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="adults{{ $key }}">No of Adults</label>
                        <input type="number" id="adults{{ $key }}" class="form-control adult hotel guest"
                            data-hotel_row="{{ $key }}" placeholder="No of Adults"
                            name="hotel[{{ $key }}][adults]" value="{{ $hotel->adult }}" required>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="childs{{ $key }}">No of Children</label>
                        <input type="number" id="childs{{ $key }}" class="form-control child hotel guest"
                            data-hotel_row="{{ $key }}" placeholder="No of Children"
                            name="hotel[{{ $key }}][childs]" value="{{ $hotel->child }}" required>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="room{{ $key }}">No of Rooms</label>
                        <input type="number" id="room{{ $key }}" class="form-control room hotel"
                            placeholder="No of Rooms" name="hotel[{{ $key }}][room]" value="{{ $hotel->bed }}" required>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="bed{{ $key }}">No of Beds</label>
                        <input type="number" id="bed{{ $key }}" class="form-control bed hotel"
                            placeholder="No of Beds" name="hotel[{{ $key }}][bed]" value="{{ $hotel->room }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="check_in{{ $key }}">Check In</label>
                        <input type="date" id="check_in{{ $key }}" class="form-control hotel"
                            placeholder="Check In" name="hotel[{{ $key }}][check_in]" value="{{ $hotel->check_in }}" required>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="check_out{{ $key }}">Check Out</label>
                        <input type="date" id="check_out{{ $key }}" class="form-control hotel"
                            placeholder="Check Out" name="hotel[{{ $key }}][check_out]" value="{{ $hotel->check_out }}" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="hotel{{ $key }}">Hotel</label>
                        <select class="form-control hotel hotelid" name="hotel[{{ $key }}][hotel]"
                            id="hotel{{ $key }}"
                            onchange="getDestinationRooms({{ $key }}, this.value)" required>
                            <option></option>
                            @foreach ($hotel_list as $row)
                                    <option value="{{ $row->id }}" @if($row->id == $hotel->option->hotel_id) selected @endif>{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="hotel_room{{ $key }}">Room</label>
                        <select class="form-control hotel" name="hotel[{{ $key }}][hotel_room]"
                            id="hotel_room{{ $key }}"
                            onchange="getDestinationServices({{ $key }}, this.value)" required>
                            <option>Select Room</option>
                            @foreach ($rooms as $room)
                            <option value="{{ $room->id }}" @if($room->id == $hotel->option->room_id) selected @endif>{{ $room->room }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="service{{ $key }}">Service</label>
                        <select class="form-control hotel" name="hotel[{{ $key }}][service]" id="service{{ $key }}" required>
                            <option>Select Service</option>
                            @foreach ($services as $service)
                                    <option value="{{ $service->id }}" @if($service->id == $hotel->option->service_id) selected @endif>{{ $service->service }}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="hotel_due_amount{{ $key }}">Hotel Due Amount (₹)</label>
                        <input type="number" id="hotel_due_amount{{ $key }}" class="form-control hotel" placeholder="Hotel Due Amount"
                            name="hotel[{{ $key }}][hotel_due_amount]" value="0" required>
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="hotel_note{{ $key }}">Hotel Note</label>
                        <textarea class="form-control hotel summernote" id="hotel_note{{ $key }}" name="hotel[{{ $key }}][hotel_note]">{{ $hotel->note }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@else
    <div class="card" id="hotels0">
        <div class="card-header bg-dark">
            <h3 class="card-title">Hotel</h3>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn bg-danger btn-sm" onclick="$('#hotels0').remove();">
                    Remove
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="destination0">Destination</label>
                    <select id="destination0" class="form-control hotel" placeholder="Destination"
                        name="hotel[0][destination]" onchange="getHotels(0, this.value)" required>
                        <option value="">Select Destination</option>
                        @foreach ($destinations as $destination)
                            <option value="{{ $destination->destination }}">{{ $destination->destination }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-3">
                    <label for="adults0">No of Adults</label>
                    <input type="number" id="adults0" data-hotel_row="0" class="form-control adult hotel guest"
                        placeholder="No of Adults" name="hotel[0][adults]" value="0" required>
                </div>
                <div class="form-group col-sm-3">
                    <label for="childs0">No of Children</label>
                    <input type="number" id="childs0" data-hotel_row="0" class="form-control child hotel guest"
                        placeholder="No of Children" name="hotel[0][childs]" value="0" required>
                </div>
                <div class="form-group col-sm-3">
                    <label for="room0">No of Rooms</label>
                    <input type="number" id="room0" class="form-control room hotel" placeholder="No of Rooms"
                        name="hotel[0][room]" value="0" required>
                </div>
                <div class="form-group col-sm-3">
                    <label for="bed0">No of Beds</label>
                    <input type="number" id="bed0" class="form-control bed hotel" placeholder="No of Beds"
                        name="hotel[0][bed]" value="0">
                </div>
                <div class="form-group col-sm-6">
                    <label for="check_in0">Check In</label>
                    <input type="date" id="check_in0" class="form-control hotel" placeholder="Check In"
                        name="hotel[0][check_in]" value="" required>
                </div>
                <div class="form-group col-sm-6">
                    <label for="check_out0">Check Out</label>
                    <input type="date" id="check_out0" class="form-control hotel" placeholder="Check Out"
                        name="hotel[0][check_out]" value="" required>
                </div>
                <div class="form-group col-sm-4">
                    <label for="hotel0">Hotel</label>
                    <select class="form-control hotel hotelid" name="hotel[0][hotel]" id="hotel0"
                        onchange="getDestinationRooms(0, this.value)" required>
                        <option></option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="hotel_room0">Room</label>
                    <select class="form-control hotel" name="hotel[0][hotel_room]" id="hotel_room0"
                        onchange="getDestinationServices(0, this.value)" required>
                        <option>Select Room</option>
                    </select>
                </div>
                <div class="form-group col-sm-4">
                    <label for="service0">Service</label>
                    <select class="form-control hotel" name="hotel[0][service]" id="service0" required>
                        <option>Select Service</option>
                    </select>
                </div>
                <div class="form-group col-sm-12">
                    <label for="hotel_due_amount0">Hotel Due Amount (₹)</label>
                    <input type="number" id="hotel_due_amount0" class="form-control hotel" placeholder="Hotel Due Amount"
                        name="hotel[0][hotel_due_amount]" value="0" required>
                </div>
                <div class="form-group col-sm-12">
                    <label for="hotel_note0">Hotel Note</label>
                    <textarea class="form-control hotel summernote" id="hotel_note0" name="hotel[0][hotel_note]"></textarea>
                </div>
            </div>
        </div>
    </div>
@endif
