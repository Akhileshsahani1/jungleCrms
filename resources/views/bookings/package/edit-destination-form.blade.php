
<div class="card-body hotel_destination">
    @foreach ($booking->destinations as $key => $destination)
    <div class="row" id="destination-row{{ $key }}">
        <div class="form-group col-sm-3">
            <label for="destination{{ $key }}">Destination</label>
            <select id="destination{{ $key }}" class="form-control hotel" placeholder="Destination"
                name="destination[{{ $key }}][destination]" required onchange="getHotels({{ $key }}, 0,this.value)">
                <option value="">Select Destination</option>
                @foreach ($destinations as $row)
                    <option value="{{ $row->destination }}" @if($destination->destination == $row->destination) selected @endif>{{ $row->destination }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-3">
            <label for="check_in{{ $key }}">Check In</label>
            <input type="date" id="check_in{{ $key }}" class="form-control hotel" placeholder="Check In"
                name="destination[{{ $key }}][check_in]" value="{{ $destination->check_in }}" required>
        </div>
        <div class="form-group col-sm-3">
            <label for="check_out{{ $key }}">Check Out</label>
            <input type="date" id="check_out{{ $key }}" class="form-control hotel" placeholder="Check Out"
                name="destination[{{ $key }}][check_out]" value="{{ $destination->check_out }}" required>
        </div>
        <div class="form-group col-sm-3">
            <label for="hotel_due_amount{{ $key }}">Hotel Due Amount</label>
            <input type="number" id="hotel_due_amount{{ $key }}" class="form-control hotel" placeholder="Hotel Due Amount"
                name="destination[{{ $key }}][hotel_due_amount]" value="{{ $destination->hotel_due_amount }}" required>
        </div>
        <table id="hotel_option{{ $key }}" class="table table-condensed">
            <thead class="bg-dark">
                <tr>
                    <th>Hotel</th>
                    <th>Room</th>
                    <th>Service</th>
                </tr>
            </thead>
            <tbody>
                @foreach($destination->options as $newkey => $option)
                @php
                    $hotel_list = getHotelsbyDestination($destination->destination);
                    $rooms = getRoomsbyHotel($option->hotel_id);
                    $services = getServicesbyRoom($option->room_id);
                @endphp
                @if($option->accepted == 'no')
                @continue
                @endif
                <tr id="destination{{ $key }}-option{{  $newkey }}">
                        <td>
                            <select class="form-control hotel destination{{ $key }}hotel_id0" name="destination[{{ $key }}][hotel_option][{{  $newkey }}][hotel_id]" id="destination{{ $key }}_hotel_id{{  $newkey }}"
                                onchange="getDestinationRooms({{ $key }}, {{  $newkey }}, this.value)" required>
                                <option></option>
                                @foreach ($hotel_list as $hotel)
                                    <option value="{{ $hotel->id }}" @if($hotel->id == $option->hotel_id) selected @endif>{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control hotel" name="destination[{{ $key }}][hotel_option][{{  $newkey }}][room_id]" id="destination{{ $key }}_room_id{{  $newkey }}"
                                onchange="getDestinationServices({{ $key }}, {{  $newkey }}, this.value)" required>
                                <option>Select Room</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" @if($room->id == $option->room_id) selected @endif>{{ $room->room }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control hotel" name="destination[{{ $key }}][hotel_option][{{  $newkey }}][service_id]" id="destination{{ $key }}_service_id{{  $newkey }}" required>
                                <option>Select Service</option>
                                @foreach ($services as $service)
                                    <option value="{{ $service->id }}" @if($service->id == $option->service_id) selected @endif>{{ $service->service }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right" colspan="4"><button type="button" onclick="$('#destination-row{{ $key }}').remove();"
                        data-toggle="tooltip" title="Delete Destination" class="btn btn-danger"
                        data-original-title="Delete Destination"><i class="fas fa-minus-circle"> Destination</i></button></td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endforeach
</div>


<div class="card-footer text-right">
    <button type="button" onclick="addDestinationOption();" data-toggle="tooltip" title="Add Destination"
        class="btn btn-primary" data-original-title="Add Destination"><i class="fas fa-plus-circle"></i>
        Destination</button>
</div>
