<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-brown">
            <h3 class="card-title">Safari Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="sanctuary">Choose Sanctuary</label>
                    <select id="sanctuary" class="form-control"  name="sanctuary" onchange="loadForm()">
                        <option value="" selected>Select Sanctuary</option>
                        <option value="gir" {{ old('sanctuary', isset($booking) ? $booking->safari->sanctuary : '') == 'gir' ? 'selected' : '' }}>Gir</option>
                        <option value="jim" {{ old('sanctuary', isset($booking) ? $booking->safari->sanctuary : '') == 'jim' ? 'selected' : '' }}>Jim Corbett</option>
                        <option value="ranthambore" {{ old('sanctuary', isset($booking) ? $booking->safari->sanctuary : '') == 'ranthambore' ? 'selected' : '' }}>Ranthambore</option>
                        <option value="tadoba" {{ old('sanctuary', isset($booking) ? $booking->safari->sanctuary : '') == 'tadoba' ? 'selected' : '' }}>Tadoba</option>
                    </select>
                    @error('sanctuary')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row" id="gir">
                @include('bookings.safari.sanctuaries.gir')
            </div>
            <div class="row" id="jim">
                @include('bookings.safari.sanctuaries.jim')
            </div>
            <div class="row" id="ranthambore">
                @include('bookings.safari.sanctuaries.ranthambore')
            </div>
            <div class="row" id="tadoba">
                @include('bookings.safari.sanctuaries.tadoba')
            </div>
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="amount">Total Amount</label>
                    <input type="number" id="amount" class="form-control" placeholder="Total Amount" name="amount"
                        value="{{ old('amount', isset($booking) ? $booking->safari->amount : '0') }}">
                    @error('amount')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                 <div class="form-group col-sm-6">
                    <label for="amount">Safari Due Amount</label>
                    <input type="number" id="safari_due_amount" class="form-control" placeholder="Safari Due Amount" name="safari_due_amount"
                        value="{{ old('safari_due_amount', isset($booking) ? $booking->safari->safari_due_amount : 0) }}">
                    @error('safari_due_amount')
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
                    <textarea class="form-control summernote" id="note"
                        name="note">{{ old('note', isset($booking) ? $booking->safari->note : '') }}</textarea>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-brown">
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
                                <td style="width:350px"><input type="text" name="item[{{ $key }}][particular]"
                                        placeholder="Particular" class="form-control"
                                        id="particular{{ $key }}" required value="{{ $item->particular }}">
                                </td>
                                <td><input type="text" name="item[{{ $key }}][amount]" placeholder="Amount"
                                        class="form-control amount" id="amount{{ $key }}"
                                        value="{{ $item->amount }}" required></td>
                                <td><input type="number" name="item[{{ $key }}][rate]" placeholder="Rate"
                                        class="form-control rate" id="rate{{ $key }}"
                                        value="{{ $item->rate }}" required></td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#item-option-row{{ $key }}').remove();"
                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                        data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="item-option-row0">
                            <td style="width:350px"><input type="text" name="item[0][particular]"
                                    placeholder="Particular" class="form-control" id="particular0" value="Taxable amount" required></td>
                            <td><input type="text" name="item[0][amount]" placeholder="Amount"
                                    class="form-control amount" id="amount0" value="0" required></td>
                            <td><input type="number" name="item[0][rate]" placeholder="Rate" class="form-control rate"
                                    id="rate0" value="5" required></td>
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
                    @if (isset($booking) && count($booking->customer_details) > 0)
                    @foreach ($booking->customer_details as $key => $detail)
                    <tr id="customer-option-row{{ $key }}">
                        <td><input type="text" name="customer[{{ $key }}][name]"
                                placeholder="Name" class="form-control" id="name{{ $key }}" value="{{ $detail->name }}" required></td>
                        <td><input type="number" name="customer[{{ $key }}][age]"
                                    placeholder="Age" class="form-control" id="age{{ $key }}" value="{{ $detail->age }}" required></td>
                        <td>
                            <select name="customer[{{ $key }}][gender]" class="form-control" id="gender{{ $key }}" required>
                                <option value="" selected>Gender</option>
                                <option value="Male" @if($detail->gender == "Male") selected @endif>Male</option>
                                <option value="Female" @if($detail->gender == "Female") selected @endif>Female</option>
                            </select>
                        </td>
                        <td>
                            <select name="customer[{{ $key }}][nationality]" class="form-control" id="nationality{{ $key }}" onchange="getStates({{ $key }}, this.value)" required>
                                <option value="" selected>Select</option>
                                <option value="Indian"  @if($detail->nationality == "Indian") selected @endif>Indian</option>
                                <option value="Foreigner"  @if($detail->nationality == "Foreigner") selected @endif>Foreigner</option>
                            </select>
                        </td>
                        <td>
                            <select name="customer[{{ $key }}][state]" class="form-control" kk="{{ $detail->state }}" id="state{{ $key }}" required>
                                <option value="" selected>State</option>
                                @if($detail->nationality == "Indian")
                                    @foreach($states as $state)
                                    <option value="{{ $state->state }}"  @if($detail->state == $state->state) selected @endif>{{ $state->state }}</option>
                                    @endforeach
                                @elseif($detail->nationality == "Foreigner")
                                    @foreach($countries as $country)
                                    <option value="{{ $country->country }}"  @if($detail->state == $country->country) selected @endif>{{ $country->country }}</option>
                                    @endforeach
                                @else
                                    @foreach($states as $state)
                                    <option value="{{ $state->state }}"  @if($detail->state == $state->state) selected @endif>{{ $state->state }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                        <td>
                            <select name="customer[{{ $key }}][idproof]" class="form-control" id="idproof{{ $key }}" required>
                                <option value="" selected>Type</option>
                                <option value="Aadhar Card" @if($detail->idproof == "Aadhar Card") selected @endif>Aadhar Card</option>
                                <option value="Voter ID" @if($detail->idproof == "Voter ID") selected @endif>Voter ID</option>
                                <option value="Driving License" @if($detail->idproof == "Driving License") selected @endif>Driving License</option>
                                <option value="Passport" @if($detail->idproof == "Passport") selected @endif>Passport</option>
                            </select>
                        </td>
                        <td><input type="text" name="customer[{{ $key }}][idproof_no]"
                            placeholder="Id No" class="form-control" id="idproof_no{{ $key }}" required value="{{ $detail->idproof_no }}"></td>

                        <td class="text-right"><button type="button" onclick="$('#customer-option-row{{ $key }}').remove();"
                                data-toggle="tooltip" title="" class="btn btn-danger"
                                data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                        </td>
                    </tr>
                    @endforeach
                    @else
                        <tr id="customer-option-row0">
                            <td><input type="text" name="customer[0][name]"
                                    placeholder="Name" class="form-control" id="name0" required></td>
                            <td><input type="number" name="customer[0][age]"
                                        placeholder="Age" class="form-control" id="age0" required></td>
                            <td>
                                <select name="customer[0][gender]" class="form-control" id="gender0" required>
                                    <option value="" selected>Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </td>
                            <td>
                                <select name="customer[0][nationality]" class="form-control" id="nationality0"  onchange="getStates(0, this.value)" required>
                                    <option value="" selected>Select</option>
                                    <option value="Indian">Indian</option>
                                    <option value="Foreigner">Foreigner</option>
                                </select>
                            </td>
                            <td>
                                <select name="customer[0][state]" class="form-control" id="state0" required>
                                    <option value="" selected>State</option>
                                    @foreach($states as $state)
                                    <option value="{{ $state->state }}">{{ $state->state }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="customer[0][idproof]" class="form-control" id="idproof0" required>
                                    <option value="" selected>Type</option>
                                    <option value="Aadhar Card">Aadhar Card</option>
                                    <option value="Voter ID">Voter ID</option>
                                    <option value="Driving License">Driving License</option>
                                    <option value="Passport">Passport</option>
                                </select>
                            </td>
                            <td><input type="text" name="customer[0][idproof_no]"
                                placeholder="Id No" class="form-control" id="idproof_no0" required></td>

                            <td class="text-right"><button type="button" onclick="$('#customer-option-row0').remove();"
                                    data-toggle="tooltip" title="" class="btn btn-danger"
                                    data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                        @endif
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
        <div class="card-header bg-brown">
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
                    @isset($estimate)
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
                    @else
                    <tr><td style="width:100%" class="text-center">Please Select Sanctuary for loading Inclusions.</tr>
                    @endisset
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addSafariInclusion();"
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
        <div class="card-header bg-brown">
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
                    @isset($estimate)
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
                    @else
                    <tr><td style="width:100%" class="text-center">Please Select Sanctuary for loading exclusions.</tr>
                    @endisset
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addSafariExclusion();"
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
        <div class="card-header bg-brown">
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
                    @isset($estimate)
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
                    @else
                    <tr><td style="width:100%" class="text-center">Please Select Sanctuary for loading Terms.</tr>
                    @endisset
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="2"><button type="button" onclick="addSafariTerm();"
                                data-toggle="tooltip" title="Add Term" class="btn btn-secondary"
                                data-original-title="Add Term"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <button class="btn btn-block btn-success" type="submit" form="safariForm">Submit</button>
</div>
