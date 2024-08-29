<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-orange">
            <h3 class="card-title">Hotel Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="adult">No of Adults</label>
                    <input type="number" id="adult" class="form-control guest" placeholder="No of Adults" name="adult"
                        value="{{ old('adult', isset($estimate) ? $estimate->hotel->adult : '0') }}">
                    @error('adult')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="child">No of Children</label>
                    <input type="number" id="child" class="form-control guest" placeholder="No of Children" name="child"
                        value="{{ old('child', isset($estimate) ? $estimate->hotel->child : '0') }}">
                    @error('child')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="room">No of Rooms</label>
                    <input type="number" id="room" class="form-control" placeholder="No of Rooms" name="room"
                        value="{{ old('room', isset($estimate) ? $estimate->hotel->room : '0') }}">
                    @error('room')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="room">No of Beds</label>
                    <input type="number" id="bed" class="form-control" placeholder="No of Beds" name="bed"
                        value="{{ old('bed', isset($estimate) ? $estimate->hotel->bed : '0') }}">
                    @error('bed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-4">
                    <label for="check_in">Check In</label>
                    <input type="date" id="check_in" class="form-control" placeholder="Check In" name="check_in"
                        value="{{ old('check_in', isset($estimate) ? $estimate->hotel->check_in : '') }}">
                    @error('check_in')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-4">
                    <label for="check_out">Check Out</label>
                    <input type="date" id="check_out" class="form-control" placeholder="Check Out" name="check_out"
                        value="{{ old('check_out', isset($estimate) ? $estimate->hotel->check_out : '') }}">
                    @error('check_out')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group col-sm-4">
                    <label for="destination">Destination</label>
                    <input type="text" id="destination" class="form-control" placeholder="Destination"
                        name="destination"
                        value="{{ old('destination', isset($estimate) ? $estimate->hotel->destination : '') }}">
                    @error('destination')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-3">
                    <label for="payment_type">Payment Type</label>
                    <select class="form-control" name="payment_type[]" id="payment_type" multiple="multiple">
                        <option></option>
                        <option value="1" <?php if(isset($estimate->payment_type) && in_array(1,explode(",",$estimate->payment_type))) echo "selected"; else echo "";  ?>>50%</option>
                        <option value="2" <?php if(isset($estimate->payment_type) && in_array(2,explode(",",$estimate->payment_type))) echo "selected"; else echo "";  ?>>100%</option>
                    </select>
                    @error('estimate_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-5">
                    <label for="payment_mode">Payment Mode</label>
                    <select type="text" class="form-control" id="payment_mode" name="payment_modes[]" multiple>
                        <option></option>
                        @foreach ($payment_modes as $payment_mode)
                            <option value="{{ $payment_mode->id }}"
                                {{ collect(old('payment_modes', isset($estimate) ? $estimate->payment_modes : ''))->contains($payment_mode->id)? 'selected': '' }}>
                                {{ $payment_mode->name }}</option>
                        @endforeach
                    </select>
                    @error('payment_modes')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                 @if(!isset($lead->id))
                 <div class="form-group col-sm-4">
                    <label for="payment_mode">Website</label>
                    <select name="website" id="websites" class="form-control">
                                        <option value="">Select Website</option>
                                        <option value="ranthamboretigerreserve.in" {{ old('website', isset($estimate) ? $estimate->website : '') == 'ranthamboretigerreserve.in' ? 'selected' : '' }}>ranthamboretigerreserve.in</option>
                                        <option value="jimcorbettnationalparkonline.in" {{ old('website', isset($estimate) ? $estimate->website : '') == 'jimcorbettnationalparkonline.in' ? 'selected' : '' }}>jimcorbettnationalparkonline.in</option>
                                        <option value="girsafaribooking.com" {{ old('website', isset($estimate) ? $estimate->website : '') == 'girsafaribooking.com' ? 'selected' : '' }}>girsafaribooking.com</option>
                                        <option value="jimcorbett.in" {{ old('website', isset($estimate) ? $estimate->website : '') == 'jimcorbett.in' ? 'selected' : '' }}>jimcorbett.in</option>
                                        <option value="girlionsafari.com" {{ old('website', isset($estimate) ? $estimate->website : '') == 'girlionsafari.com' ? 'selected' : '' }}>girlionsafari.com</option>
                                        <option value="girlion.in" {{ old('website', isset($estimate) ? $estimate->website : '') == 'girlion.in' ? 'selected' : '' }}>girlion.in</option>
                                        <option value="bandhavgarh.com" {{ old('website', isset($estimate) ? $estimate->website : '') == 'bandhavgarh.com' ? 'selected' : '' }}>bandhavgarh.com</option>
                                        <option value="travelwalacab.com" {{ old('website', isset($estimate) ? $estimate->website : '') == 'travelwalacab.com' ? 'selected' : '' }}>travelwalacab.com</option>
                                        <option value="dailytourandtravel.com" {{ old('website', isset($estimate) ? $estimate->website : '') == 'dailytourandtravel.com' ? 'selected' : '' }}>dailytourandtravel.com</option>
                                        <option value="internationaltrips.in"
                                        {{ old('website', isset($estimate) ? $estimate->website : '') == 'internationaltrips.in' ? 'selected' : '' }}>
                                        Internationaltrips.in</option>
                                        <option value="tadobapark.com"
                                        {{ old('website', isset($estimate) ? $estimate->website : '') == 'tadobapark.com' ? 'selected' : '' }}>
                                        tadobapark.com</option>
                                        <option value="SMO"
                                        {{ old('website', isset($estimate) ? $estimate->website : '') == 'SMO' ? 'selected' : '' }}>
                                        SMO</option>
                                    </select>
                                    @error('website')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                </div>
                @endif
                <div class="form-group col-sm-12">
                    <label for="note">Note</label>
                    <textarea class="form-control summernote" id="note"
                        name="note">{{ old('note', isset($estimate) ? $estimate->hotel->note : '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-orange">
            <h3 class="card-title">Hotel Options</h3>
        </div>
        <div class="card-body">
            <table id="option" class="table table-condensed">
                <thead>
                    <tr>
                        <th>Hotel</th>
                        <th>Room</th>
                        <th>Service</th>
                        <th style="width: 15%;">Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($estimate) && count($estimate->hotel_options) > 0)
                        @foreach ($estimate->hotel_options as $key => $option)
                            <tr id="hotel-option{{ $key }}">
                                <td>
                                    <select class="form-control hotel_id" name="option[{{ $key }}][hotel_id]"
                                        id="hotel_id{{ $key }}"
                                        onchange="getRooms({{ $key }}, this.value)" required>
                                        <option></option>
                                        @foreach ($hotels as $hotel)
                                            <option value="{{ $hotel->id }}"
                                                @if ($option->hotel_id == $hotel->id) selected @endif>{{ $hotel->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control room" name="option[{{ $key }}][room_id]"
                                        id="room_id{{ $key }}"
                                        onchange="getServices({{ $key }}, this.value)" required>
                                        <option value="{{ $option->room_id }}">
                                            {{ \App\Models\HotelRoom::find($option->room_id)->room }}</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control service" name="option[{{ $key }}][service_id]"
                                        id="service_id{{ $key }}"
                                        onchange="getTotal({{ $key }}, this.value)" required>
                                        <option value="{{ $option->service_id }}">
                                            {{ \App\Models\HotelRoomService::find($option->service_id)->service }}
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="option[{{ $key }}][discount]"
                                        placeholder="Discount" class="form-control discount"
                                        id="discount{{ $key }}" value="{{ $option->discount }}" required>
                                </td>
                                <td class="text-right">
                                    <button type="button" class="btn bg-success"
                                        id="amount-button{{ $key }}" onclick="openHotelModal({{ $key }})">{{ $option->amount }}</button>
                                    <input type="hidden" class="btn bg-grey" id="amount{{ $key }}"
                                        name="option[{{ $key }}][amount]" value="{{ $option->amount }}">
                                </td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#hotel-option{{ $key }}').remove();" data-toggle="tooltip"
                                        title="" class="btn btn-danger" data-original-title="Remove Button"><i
                                            class="fas fa-minus-circle"></i></button></td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="hotel-option0">
                            <td>
                                <select class="form-control hotel_id" name="option[0][hotel_id]" id="hotel_id0"
                                    onchange="getRooms(0, this.value)" required>
                                    <option></option>
                                    @foreach ($hotels as $hotel)
                                        <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control room" name="option[0][room_id]" id="room_id0"
                                    onchange="getServices(0, this.value)" required>
                                    <option>Select Room</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control service" name="option[0][service_id]" id="service_id0"
                                    onchange="getTotal(0, this.value)" required>
                                    <option>Select Service</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="option[0][discount]" placeholder="Discount"
                                    class="form-control discount" id="discount0" value="0" required>
                            </td>
                            <td class="text-right">
                                <button type="button" class="btn bg-success" id="amount-button0"
                                    style="display: none;" onclick="openHotelModal(0)">Total</button>
                                <input type="hidden" class="btn bg-grey" id="amount0" name="option[0][amount]">
                            </td>
                            <td class="text-right"><button type="button" onclick="$('#hotel-option0').remove();"
                                    data-toggle="tooltip" title="" class="btn btn-danger"
                                    data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="6"><button type="button" onclick="addHotelOption();"
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
            <h3 class="card-title">GST & PG Charges</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="gst_filed">GST Filed</label>
                    <select id="gst_filed" class="form-control"  name="gst_filed">                        
                        <option value="" {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '' ? 'selected' : '' }}>GST not required</option>
                        <option value="0" {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '0' ? 'selected' : '' }}>GST included in the package</option>
                        <option value="5" {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '5' ? 'selected' : '' }}>GST 5%</option>
                        <option value="18" {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '18' ? 'selected' : '' }}>GST 18%</option>
                    </select>
                    @error('gst_filed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
                    <label for="pg_charges_filed">PG charges filed</label>
                    <select id="pg_charges_filed" class="form-control"  name="pg_charges_filed">
                        <option value="" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '' ? 'selected' : '' }}>PG charges not required</option>
                        <option value="0" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '0' ? 'selected' : '' }}>PG charges included in the package</option>                       
                        <option value="3" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '3' ? 'selected' : '' }}>PG charges 3%</option>
                        <option value="4" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '4' ? 'selected' : '' }}>PG charges 4%</option>
                        <option value="5" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '5' ? 'selected' : '' }}>PG charges 5%</option>
                        <option value="6" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '6' ? 'selected' : '' }}>PG charges 6%</option>
                        <option value="7" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '7' ? 'selected' : '' }}>PG charges 7%</option>
                        <option value="8" {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '8' ? 'selected' : '' }}>PG charges 8%</option>
                    </select>
                    @error('pg_charges_filed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
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
                        {{ old('inclusion_filter', isset($estimate) ? $estimate->hotel->inclusion_filter : '') == 'normal'? 'selected': '' }}>
                        Normal</option>
                    <option value="weekend"
                        {{ old('inclusion_filter', isset($estimate) ? $estimate->hotel->inclusion_filter : '') == 'weekend'? 'selected': '' }}>
                        Weekend</option>
                    <option value="festival"
                        {{ old('inclusion_filter', isset($estimate) ? $estimate->hotel->inclusion_filter : '') == 'festival'? 'selected': '' }}>
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
                        {{ old('exclusion_filter', isset($estimate) ? $estimate->hotel->exclusion_filter : '') == 'normal'? 'selected': '' }}>
                        Normal</option>
                    <option value="weekend"
                        {{ old('exclusion_filter', isset($estimate) ? $estimate->hotel->exclusion_filter : '') == 'weekend'? 'selected': '' }}>
                        Weekend</option>
                    <option value="festival"
                        {{ old('exclusion_filter', isset($estimate) ? $estimate->hotel->exclusion_filter : '') == 'festival'? 'selected': '' }}>
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
                        {{ old('inclusion_filter', isset($estimate) ? $estimate->hotel->term_filter : '') == 'weekend'? 'selected': '' }}>
                        Weekend</option>
                    <option value="festival"
                        {{ old('inclusion_filter', isset($estimate) ? $estimate->hotel->term_filter : '') == 'festival'? 'selected': '' }}>
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
    <div class="modal fade" id="modal-amount" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Amount</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
            <div class="modal-body">
              <input type="number" class="form-control" name="model_amount" id="model_amount" placeholder="Amount">
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" id="modal-amount-save" class="btn btn-primary">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
