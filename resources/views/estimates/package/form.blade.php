<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-secondary">
            <h3 class="card-title">Package Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
            <div class="form-group col-sm-6">
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
                <div class="form-group col-sm-6">
                    <label for="payment_mode">Estimate Type</label>
                    <select class="form-control" name="estimate_type[]" id="type" multiple="multiple">
                        <option></option>
                        <option value="cab" {{ (collect(old('estimate_type', in_array('cab', $estimate_type) ? $estimate_type: ''))->contains('cab')) ? 'selected' : '' }}>Cab</option>
                        <option value="hotel" {{ (collect(old('estimate_type', in_array('hotel', $estimate_type) ? $estimate_type : ''))->contains('hotel')) ? 'selected' : '' }}>Hotel</option>
                        <option value="safari" {{ (collect(old('estimate_type', in_array('safari', $estimate_type) ? $estimate_type : ''))->contains('safari')) ? 'selected' : '' }}>Safari</option>
                        <option value="flight" {{ (collect(old('estimate_type', in_array('flight', $estimate_type) ? $estimate_type: ''))->contains('flight')) ? 'selected' : '' }}>Flight</option>
                    </select>
                    @error('estimate_type')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
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
                {{-- @if(!isset($lead->id)) --}}
                <div class="form-group col-sm-6">
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
                {{-- @endif --}}
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
            @include('estimates.package.cab')
        </div>
    </div>
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Cab Content</h3>
        </div>
        <div class="card-body">
            <table id="cab_option" class="table table-striped">
                <thead>
                    <tr>
                        <th>Cab Content</th>
                        <th>Amount</th>
                        <th>Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @if (in_array('cab', $estimate_type) && count($estimate->cab_options) > 0)
                        @foreach ($estimate->cab_options as $key => $option)
                            <tr id="cab-option-row{{ $key }}">
                                <td style="width:350px"><input type="text"
                                        name="cab_option[{{ $key }}][content]" placeholder="Content"
                                        class="form-control cab" id="cab_content{{ $key }}" required
                                        value="{{ $option->content }}"></td>
                                <td><input type="number" name="cab_option[{{ $key }}][amount]"
                                        placeholder="Amount" class="form-control cab"
                                        id="cab_amount{{ $key }}" value="{{ $option->amount }}" required>
                                </td>
                                <td><input type="number" name="cab_option[{{ $key }}][discount]"
                                        placeholder="Discount" class="form-control cab"
                                        id="cab_discount{{ $key }}" value="{{ $option->discount }}"
                                        required></td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#cab-option-row{{ $key }}').remove();"
                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                        data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="cab-option-row0">
                            <td style="width:350px"><input type="text" name="cab_option[0][content]"
                                    placeholder="Content" class="form-control cab" id="cab_content0" required></td>
                            <td><input type="number" name="cab_option[0][amount]" placeholder="Amount"
                                    class="form-control cab" id="cab_amount0" value="0" required></td>
                            <td><input type="number" name="cab_option[0][discount]" placeholder="Discount"
                                    class="form-control cab" id="cab_discount0" value="0" required></td>
                            <td class="text-right"><button type="button" onclick="$('#cab-option-row0').remove();"
                                    data-toggle="tooltip" title="" class="btn btn-danger"
                                    data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                            </td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="5"><button type="button" onclick="addCabOption();"
                                data-toggle="tooltip" title="Add Option" class="btn btn-secondary"
                                data-original-title="Add Option"><i class="fas fa-plus-circle"></i></button></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto" id="flight">
    <div class="card card-warning">
        <div class="card-header">
            <h3 class="card-title">Flight Details</h3>
            <div class="card-tools">
                <a href="javascript:void(0)" class="btn bg-dark btn-sm" onclick="addFlightTrip();">
                  Add Trip
                </a>
            </div>
        </div>
        <div class="card-body" id="main-flight-div">
            @include('estimates.package.flight')
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
           @include('estimates.package.hotel')
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
            @include('estimates.package.safari')
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-brown">
            <h3 class="card-title">Safari Content</h3>
        </div>
        <div class="card-body">
            <table id="safari_option" class="table table-striped">
                <thead>
                    <tr>
                        <th>Safari Content</th>
                        <th>Amount</th>
                        <th>Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @if (in_array('safari', $estimate_type) && count($estimate->safari_options) > 0)
                        @foreach ($estimate->safari_options as $key => $option)
                            <tr id="safari-option-row{{ $key }}">
                                <td style="width:350px"><input type="text"
                                        name="safari_option[{{ $key }}][content]" placeholder="Content"
                                        class="form-control safari" id="safari_content{{ $key }}" required
                                        value="{{ $option->content }}"></td>
                                <td><input type="number" name="safari_option[{{ $key }}][amount]"
                                        placeholder="Amount" class="form-control safari"
                                        id="safari_amount{{ $key }}" value="{{ $option->amount }}"
                                        required></td>
                                <td><input type="number" name="safari_option[{{ $key }}][discount]"
                                        placeholder="Discount" class="form-control safari"
                                        id="safari_discount{{ $key }}" value="{{ $option->discount }}"
                                        required></td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#safari-option-row{{ $key }}').remove();"
                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                        data-original-title="Remove Button"><i
                                            class="fas fa-minus-circle"></i></button></td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="safari-option-row0">
                            <td style="width:350px"><input type="text" name="safari_option[0][content]"
                                    placeholder="Content" class="form-control safari" id="safari_content0" required></td>
                            <td><input type="number" name="safari_option[0][amount]" placeholder="Amount"
                                    class="form-control safari" id="safari_amount0" value="0" required></td>
                            <td><input type="number" name="safari_option[0][discount]" placeholder="Discount"
                                    class="form-control safari" id="safari_discount0" value="0" required></td>
                            <td class="text-right"><button type="button"
                                    onclick="$('#safari-option-row0').remove();" data-toggle="tooltip" title=""
                                    class="btn btn-danger" data-original-title="Remove Button"><i
                                        class="fas fa-minus-circle"></i></button></td>
                        </tr>
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td class="text-right" colspan="5"><button type="button" onclick="addSafariOption();"
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
 @include('estimates.package.iternaries')

 <div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-secondary">
            <h3 class="card-title">Select Destination Type</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="destination_id">Destination Type</label>
                    <select id="destination_id" class="form-control"  name="destination_id" onchange="getPackageData(this.value)">
                         <option value="0" >Please Select Destination</option>
                        @foreach($estimate_destinations as $dest)
                           <option value="{{ $dest->id }}" {{ old('destination_id', isset($estimate) ? $estimate->destination_id : '') == $dest->id ? 'selected' : '' }}>{{ $dest->destination }}</option>
                        @endforeach                     
                       
                    </select>
                    @error('destination_id')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

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
                    @if(isset($estimate))
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
                    @endif
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
                    @if(isset($estimate))
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
                    @endif
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
                    @if(isset($estimate))
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
                    @endif
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
<div class="modal fade" id="modal-package-amount" style="display: none;" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Amount</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="number" class="form-control" name="model_package_amount" id="model_package_amount" placeholder="Amount">
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" id="modal-package-amount-save" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
