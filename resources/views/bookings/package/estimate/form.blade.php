<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-secondary">
            <h3 class="card-title">Package Details</h3>
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
                        value="{{ packageTotal($id) }}">
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
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn bg-dark btn-sm" onclick="addTrip();">
                  Add Trip
                </a>
            </div>
        </div>
        <div class="card-body" id="main-cab-div">
           @include('bookings.package.cab')
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto" id="hotel">
    <div class="card">
        <div class="card-header bg-orange">
            <h3 class="card-title">Hotel Details</h3>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn bg-dark btn-sm" onclick="addHotel();">
                  Add Hotel
                </a>
            </div>
        </div>
        <div class="card-body" id="main-hotel-div">
            @include('bookings.package.hotel')
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
            @include('bookings.package.safari')
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
        <div class="card-header bg-secondary">
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
                                    class="form-control amount" id="amount0" value="{{ packageTotal($id) }}" required></td>
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
        <div class="card-header bg-secondary">
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
        <div class="card-header bg-secondary">
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
        <div class="card-header bg-secondary">
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
        <div class="card-header bg-secondary">
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
