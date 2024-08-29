<div class="card-body hotel_destination">
    <div class="row" id="destination-row0">
        <div class="form-group col-sm-3">
            <label for="destination0">Destination</label>
            <select id="destination0" class="form-control hotel" placeholder="Destination"
                name="destination[0][destination]" required onchange="getHotels(0, 0,this.value)">
                <option value="">Select Destination</option>
                @foreach ($destinations as $destination)
                    <option value="{{ $destination->destination }}">{{ $destination->destination }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-3">
            <label for="check_in0">Check In</label>
            <input type="date" id="check_in0" class="form-control hotel" placeholder="Check In"
                name="destination[0][check_in]" value="" required>
        </div>
        <div class="form-group col-sm-3">
            <label for="check_out0">Check Out</label>
            <input type="date" id="check_out0" class="form-control hotel" placeholder="Check Out"
                name="destination[0][check_out]" value="" required>
        </div>
        <div class="form-group col-sm-3">
            <label for="hotel_due_amount0">Hotel Due Amount</label>
            <input type="number" id="hotel_due_amount0" class="form-control hotel" placeholder="Hotel Due Amount"
                name="destination[0][hotel_due_amount]" value="0" required>
        </div>
        <table id="hotel_option0" class="table table-condensed">
            <thead class="bg-dark">
                <tr>
                    <th>Hotel</th>
                    <th>Room</th>
                    <th>Service</th>
                </tr>
            </thead>
            <tbody>
                    <tr id="destination0-option0">
                        <td>
                            <select class="form-control hotel destination0hotel_id0" name="destination[0][hotel_option][0][hotel_id]" id="destination0_hotel_id0"
                                onchange="getDestinationRooms(0, 0, this.value)" required>
                                <option></option>
                                @foreach ($hotels as $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="form-control hotel" name="destination[0][hotel_option][0][room_id]" id="destination0_room_id0"
                                onchange="getDestinationServices(0, 0, this.value)" required>
                                <option>Select Room</option>
                            </select>
                        </td>
                        <td>
                            <select class="form-control hotel" name="destination[0][hotel_option][0][service_id]" id="destination0_service_id0" required>
                                <option>Select Service</option>
                            </select>
                        </td>
                    </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-right" colspan="4"><button type="button" onclick="$('#destination-row0').remove();"
                        data-toggle="tooltip" title="Delete Destination" class="btn btn-danger"
                        data-original-title="Delete Destination"><i class="fas fa-minus-circle"> Destination</i></button></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div class="card-footer text-right">
    <button type="button" onclick="addDestinationOption();" data-toggle="tooltip" title="Add Destination"
        class="btn btn-primary" data-original-title="Add Destination"><i class="fas fa-plus-circle"></i>
        Destination</button>
</div>
