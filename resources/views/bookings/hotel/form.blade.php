<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-orange">
            <h3 class="card-title">Hotel Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="adult">No of Adults</label>
                    <input type="number" id="adult" class="form-control guest" placeholder="No of Adults"
                        name="adult" value="{{ old('adult', isset($booking) ? $booking->hotel->adult : '0') }}">
                    @error('adult')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="child">No of Children</label>
                    <input type="number" id="child" class="form-control guest" placeholder="No of Children"
                        name="child" value="{{ old('child', isset($booking) ? $booking->hotel->child : '0') }}">
                    @error('child')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="room">No of Rooms</label>
                    <input type="number" id="room" class="form-control" placeholder="No of Rooms" name="room"
                        value="{{ old('room', isset($booking) ? $booking->hotel->room : '0') }}">
                    @error('room')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="room">No of Beds</label>
                    <input type="number" id="bed" class="form-control" placeholder="No of Beds" name="bed"
                        value="{{ old('bed', isset($booking) ? $booking->hotel->bed : '0') }}">
                    @error('bed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-4">
                    <label for="check_in">Check In</label>
                    <input type="date" id="check_in" class="form-control" placeholder="Check In" name="check_in"
                        value="{{ old('check_in', isset($booking) ? $booking->hotel->check_in : '') }}">
                    @error('check_in')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="check_out">Check Out</label>
                    <input type="date" id="check_out" class="form-control" placeholder="Check Out" name="check_out"
                        value="{{ old('check_out', isset($booking) ? $booking->hotel->check_out : '') }}">
                    @error('check_out')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-4">
                    <label for="destination">Destination</label>
                    <input type="text" id="destination" class="form-control" placeholder="Destination"
                        name="destination"
                        value="{{ old('destination', isset($booking) ? $booking->hotel->destination : '') }}">
                    @error('destination')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="hotel">Hotel</label>
                    <select class="form-control hotel_id select_hotel" name="hotel" id="hotel_id"
                        onchange="getRooms(this.value)">
                        <option></option>
                        @foreach ($hotels as $hotel)
                            <option value="{{ $hotel->id }}"
                                {{ old('hotel', isset($booking) ? $booking->hotel->hotel_id : '') == $hotel->id ? 'selected' : '' }}>
                                {{ $hotel->name }}</option>
                        @endforeach
                    </select>
                    @error('hotel')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="hotel_room">Hotel room</label>
                    <select class="form-control" name="hotel_room" id="hotel_room" onchange="getServices(this.value)">
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
                    <label for="amount">Total Amount</label>
                    <input type="number" id="amount" class="form-control" placeholder="Total Amount"
                        name="amount" value="{{ old('amount', isset($booking) ? $booking->hotel->amount : '0') }}">
                    @error('amount')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="amount">Hotel Due Amount</label>
                    <input type="number" id="hotel_due_amount" class="form-control" placeholder="hotel Due Amount"
                        name="hotel_due_amount"
                        value="{{ old('hotel_due_amount', isset($booking) ? $booking->hotel->hotel_due_amount : 0) }}">
                    @error('hotel_due_amount')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-12">
                    <label for="payment_mode">Website</label>
                    <select name="website" id="websites" class="form-control">
                        <option value="">Select Website</option>
                        <option value="ranthamboretigerreserve.in"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'ranthamboretigerreserve.in' ? 'selected' : '' }}>
                            ranthamboretigerreserve.in</option>
                        <option value="jimcorbettnationalparkonline.in"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'jimcorbettnationalparkonline.in' ? 'selected' : '' }}>
                            jimcorbettnationalparkonline.in</option>
                        <option value="girsafaribooking.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'girsafaribooking.com' ? 'selected' : '' }}>
                            girsafaribooking.com</option>
                        <option value="jimcorbett.in"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'jimcorbett.in' ? 'selected' : '' }}>
                            jimcorbett.in</option>
                        <option value="girlionsafari.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'girlionsafari.com' ? 'selected' : '' }}>
                            girlionsafari.com</option>
                        <option value="girlion.in"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'girlion.in' ? 'selected' : '' }}>
                            girlion.in</option>
                        <option value="bandhavgarh.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'bandhavgarh.com' ? 'selected' : '' }}>
                            bandhavgarh.com</option>
                        <option value="travelwalacab.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'travelwalacab.com' ? 'selected' : '' }}>
                            travelwalacab.com</option>
                        <option value="dailytourandtravel.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'dailytourandtravel.com' ? 'selected' : '' }}>
                            dailytourandtravel.com</option>
                        <option value="internationaltrips.in"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'internationaltrips.in' ? 'selected' : '' }}>
                            Internationaltrips.in</option>
                        <option value="tadobapark.com"
                            {{ old('website', isset($booking) ? $booking->website : (isset($lead) ? $lead->website : '')) == 'tadobapark.com' ? 'selected' : '' }}>
                            tadobapark.com</option>
                    </select>
                    @error('website')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-12">
                    <label for="note">Note</label>
                    <textarea class="form-control summernote" id="note" name="note">{{ old('note', isset($booking) ? $booking->hotel->note : '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-orange">
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
                    @if (isset($booking) && count($booking->items) > 0)
                        @foreach ($booking->items as $key => $item)
                            <tr id="item-option-row{{ $key }}">
                                <td style="width:350px"><input type="text"
                                        name="item[{{ $key }}][particular]" placeholder="Particular"
                                        class="form-control" id="particular{{ $key }}" required
                                        value="{{ $item->particular }}">
                                </td>
                                <td><input type="number" name="item[{{ $key }}][amount]"
                                        placeholder="Amount" class="form-control amount"
                                        id="amount{{ $key }}" value="{{ $item->amount }}" required></td>
                                <td><input type="number" name="item[{{ $key }}][rate]" placeholder="Rate"
                                        class="form-control rate" id="rate{{ $key }}"
                                        value="{{ $item->rate }}" required></td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#item-option-row{{ $key }}').remove();"
                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                        data-original-title="Remove Button"><i
                                            class="fas fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="item-option-row0">
                            <td style="width:350px"><input type="text" name="item[0][particular]"
                                    placeholder="Particular" class="form-control" id="particular0"
                                    value="Taxable amount" required></td>
                            <td><input type="number" name="item[0][amount]" placeholder="Amount"
                                    class="form-control amount" id="amount0" value="0" required></td>
                            <td><input type="number" name="item[0][rate]" placeholder="Rate"
                                    class="form-control rate" id="rate0" value="0" required></td>
                            <td class="text-right"><button type="button" onclick="$('#item-option-row0').remove();"
                                    data-toggle="tooltip" title="" class="btn btn-danger"
                                    data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                    @endif
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
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-orange">
            <h3 class="card-title">Inclusions</h3>
            <div class="card-tools">
                <select class="form-control" name="inclusion_filter" id="inclusion_filter"
                    onchange="changeInclusion(this.value)">
                    <option value="normal"
                        {{ old('inclusion_filter', isset($estimate) ? $estimate->hotel->inclusion_filter : '') == 'normal' ? 'selected' : '' }}>
                        Normal</option>
                    <option value="weekend"
                        {{ old('inclusion_filter', isset($estimate) ? $estimate->hotel->inclusion_filter : '') == 'weekend' ? 'selected' : '' }}>
                        Weekend</option>
                    <option value="festival"
                        {{ old('inclusion_filter', isset($estimate) ? $estimate->hotel->inclusion_filter : '') == 'festival' ? 'selected' : '' }}>
                        Festival</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <table id="inclusion" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($estimate)
                        @foreach ($inclusions as $key => $inclusion)
                            <tr id="inclusion-row{{ $key }}">
                                <td><input type="text" name="inclusion[{{ $key }}][content]"
                                        value="{{ $inclusion->content }}" placeholder="Content" class="form-control"
                                        id="content{{ $key }}" required></td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#inclusion-row{{ $key }}').remove();" data-toggle="tooltip"
                                        title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                            class="fas fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addHotelInclusion();"
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
        <div class="card-header bg-orange">
            <h3 class="card-title">Exclusions</h3>
            <div class="card-tools">
                <select class="form-control" name="exclusion_filter" id="exclusion_filter"
                    onchange="changeExclusion(this.value)">
                    <option value="normal"
                        {{ old('exclusion_filter', isset($estimate) ? $estimate->hotel->exclusion_filter : '') == 'normal' ? 'selected' : '' }}>
                        Normal</option>
                    <option value="weekend"
                        {{ old('exclusion_filter', isset($estimate) ? $estimate->hotel->exclusion_filter : '') == 'weekend' ? 'selected' : '' }}>
                        Weekend</option>
                    <option value="festival"
                        {{ old('exclusion_filter', isset($estimate) ? $estimate->hotel->exclusion_filter : '') == 'festival' ? 'selected' : '' }}>
                        Festival</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <table id="exclusion" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($estimate)
                        @foreach ($exclusions as $key => $exclusion)
                            <tr id="exclusion-row{{ $key }}">
                                <td><input type="text" name="exclusion[{{ $key }}][content]"
                                        value="{{ $exclusion->content }}" placeholder="Content" class="form-control"
                                        id="content{{ $key }}" required></td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#exclusion-row{{ $key }}').remove();" data-toggle="tooltip"
                                        title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                            class="fas fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addHotelExclusion();"
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
        <div class="card-header bg-orange">
            <h3 class="card-title">Terms and conditions</h3>
            <div class="card-tools">

                <select class="form-control" name="term_filter" id="term_filter" onchange="changeTerm(this.value)">
                    <option value="normal"
                        {{ old('inclusion_filter', isset($estimate) ? $estimate->hotel->term_filter : '') == 'normal' ? 'selected' : '' }}>
                        Normal</option>
                    <option value="weekend"
                        {{ old('inclusion_filter', isset($estimate) ? $estimate->hotel->term_filter : '') == 'weekend' ? 'selected' : '' }}>
                        Weekend</option>
                    <option value="festival"
                        {{ old('inclusion_filter', isset($estimate) ? $estimate->hotel->term_filter : '') == 'festival' ? 'selected' : '' }}>
                        Festival</option>
                </select>

            </div>
        </div>
        <div class="card-body">
            <table id="term" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($estimate)
                        @foreach ($terms as $key => $term)
                            <tr id="term-row{{ $key }}">
                                <td><input type="text" name="term[{{ $key }}][content]"
                                        value="{{ $term->content }}" placeholder="Content" class="form-control"
                                        id="content{{ $key }}" required></td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#term-row{{ $key }}').remove();" data-toggle="tooltip"
                                        title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                            class="fas fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addHotelTerm();"
                                data-toggle="tooltip" title="Add Term" class="btn btn-secondary"
                                data-original-title="Add Term"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <button class="btn btn-block btn-success" type="submit" form="hotelForm">Submit</button>
</div>