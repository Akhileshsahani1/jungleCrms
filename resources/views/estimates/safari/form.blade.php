<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-brown">
            <h3 class="card-title">Safari Details</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="sanctuary">Choose Sanctuary</label>
                    <select id="sanctuary" class="form-control" name="sanctuary" onchange="loadForm()">
                        <option value="" selected>Select Sanctuary</option>
                        <option value="gir"
                            {{ old('sanctuary', isset($estimate) ? $estimate->safari->sanctuary : '') == 'gir' ? 'selected' : '' }}>
                            Gir</option>
                        <option value="jim"
                            {{ old('sanctuary', isset($estimate) ? $estimate->safari->sanctuary : '') == 'jim' ? 'selected' : '' }}>
                            Jim Corbett</option>
                        <option value="ranthambore"
                            {{ old('sanctuary', isset($estimate) ? $estimate->safari->sanctuary : '') == 'ranthambore' ? 'selected' : '' }}>
                            Ranthambore</option>
                        <option value="tadoba"
                            {{ old('sanctuary', isset($estimate) ? $estimate->safari->sanctuary : '') == 'tadoba' ? 'selected' : '' }}>
                            Tadoba</option>
                    </select>
                    @error('sanctuary')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="row" id="gir">
                @include('estimates.safari.sanctuaries.gir')
            </div>
            <div class="row" id="jim">
                @include('estimates.safari.sanctuaries.jim')
            </div>
            <div class="row" id="ranthambore">
                @include('estimates.safari.sanctuaries.ranthambore')
            </div>
             <div class="row" id="tadoba">
                @include('estimates.safari.sanctuaries.tadoba')
            </div>
            <div class="row">

                <div class="form-group col-sm-12">
                    <label for="payment_mode">Website</label>
                    <select name="website" id="websites" class="form-control">
                        <option value="">Select Website</option>
                        <option value="ranthamboretigerreserve.in"
                            {{ old('website', isset($estimate) ? $estimate->website : '') == 'ranthamboretigerreserve.in' ? 'selected' : '' }}>
                            ranthamboretigerreserve.in</option>
                        <option value="jimcorbettnationalparkonline.in"
                            {{ old('website', isset($estimate) ? $estimate->website : '') == 'jimcorbettnationalparkonline.in' ? 'selected' : '' }}>
                            jimcorbettnationalparkonline.in</option>
                        <option value="girsafaribooking.com"
                            {{ old('website', isset($estimate) ? $estimate->website : '') == 'girsafaribooking.com' ? 'selected' : '' }}>
                            girsafaribooking.com</option>
                        <option value="jimcorbett.in"
                            {{ old('website', isset($estimate) ? $estimate->website : '') == 'jimcorbett.in' ? 'selected' : '' }}>
                            jimcorbett.in</option>
                        <option value="girlionsafari.com"
                            {{ old('website', isset($estimate) ? $estimate->website : '') == 'girlionsafari.com' ? 'selected' : '' }}>
                            girlionsafari.com</option>
                        <option value="girlion.in"
                            {{ old('website', isset($estimate) ? $estimate->website : '') == 'girlion.in' ? 'selected' : '' }}>
                            girlion.in</option>
                        <option value="bandhavgarh.com"
                            {{ old('website', isset($estimate) ? $estimate->website : '') == 'bandhavgarh.com' ? 'selected' : '' }}>
                            bandhavgarh.com</option>
                        <option value="travelwalacab.com"
                            {{ old('website', isset($estimate) ? $estimate->website : '') == 'travelwalacab.com' ? 'selected' : '' }}>
                            travelwalacab.com</option>
                        <option value="dailytourandtravel.com"
                            {{ old('website', isset($estimate) ? $estimate->website : '') == 'dailytourandtravel.com' ? 'selected' : '' }}>
                            dailytourandtravel.com</option>
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
                <div class="form-group col-sm-4">
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
                <div class="form-group col-sm-8">
                    <label for="payment_mode">Payment Mode</label>
                    <select type="text" class="form-control" id="payment_mode" name="payment_modes[]" multiple>
                        <option></option>
                        @foreach ($payment_modes as $payment_mode)
                            <option value="{{ $payment_mode->id }}"
                                {{ collect(old('payment_modes', isset($estimate) ? $estimate->payment_modes : ''))->contains($payment_mode->id) ? 'selected' : '' }}>
                                {{ $payment_mode->name }}</option>
                        @endforeach
                    </select>
                    @error('payment_modes')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-12">
                    <label for="note">Note</label>
                    <textarea class="form-control summernote" id="note" name="note">{{ old('note', isset($estimate) ? $estimate->safari->note : '') }}</textarea>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="col-sm-12 mx-auto">
    <div class="card">
        <div class="card-header bg-brown">
            <h3 class="card-title">Safari Options</h3>
        </div>
        <div class="card-body">
            <table id="option" class="table table-striped">
                <thead>
                    <tr>
                        <th>Content</th>
                        <th>Amount</th>
                        <th>Discount</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($estimate) && count($estimate->safari_options) > 0)
                        @foreach ($estimate->safari_options as $key => $option)
                            <tr id="safari-option-row{{ $key }}">
                                <td style="width:350px"><input type="text"
                                        name="option[{{ $key }}][content]" placeholder="Content"
                                        class="form-control" id="content{{ $key }}" required
                                        value="{{ $option->content }}"></td>
                                <td><input type="number" name="option[{{ $key }}][amount]"
                                        placeholder="Amount" class="form-control amount" id="amount{{ $key }}"
                                        value="{{ $option->amount }}" required></td>
                                <td><input type="number" name="option[{{ $key }}][discount]"
                                        placeholder="Discount" class="form-control discount"
                                        id="discount{{ $key }}" value="{{ $option->discount }}" required>
                                </td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#safari-option-row{{ $key }}').remove();"
                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                        data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr id="safari-option-row0">
                            <td style="width:350px"><input type="text" name="option[0][content]"
                                    placeholder="Content" class="form-control" id="content0" required></td>
                            <td><input type="number" name="option[0][amount]" placeholder="Amount"
                                    class="form-control amount" id="amount0" value="0" required></td>
                            <td><input type="number" name="option[0][discount]" placeholder="Discount"
                                    class="form-control discount" id="discount0" value="0" required></td>
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
        <div class="card-header bg-brown">
            <h3 class="card-title">GST & PG Charges</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="gst_filed">GST Filed</label>
                    <select id="gst_filed" class="form-control" name="gst_filed">
                        <option value=""
                            {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '' ? 'selected' : '' }}>
                            GST not required</option>
                        <option value="0"
                            {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '0' ? 'selected' : '' }}>
                            GST included in the package</option>
                        <option value="5"
                            {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '5' ? 'selected' : '' }}>
                            GST 5%</option>
                        <option value="18"
                            {{ old('gst_filed', isset($estimate) ? $estimate->gst_filed : '') == '18' ? 'selected' : '' }}>
                            GST 18%</option>
                    </select>
                    @error('gst_filed')
                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group col-sm-6">
                    <label for="pg_charges_filed">PG charges filed</label>
                    <select id="pg_charges_filed" class="form-control" name="pg_charges_filed">
                        <option value=""
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '' ? 'selected' : '' }}>
                            PG charges not required</option>
                        <option value="0"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '0' ? 'selected' : '' }}>
                            PG charges included in the package</option>
                        <option value="3"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '3' ? 'selected' : '' }}>
                            PG charges 3%</option>
                        <option value="4"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '4' ? 'selected' : '' }}>
                            PG charges 4%</option>
                        <option value="5"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '5' ? 'selected' : '' }}>
                            PG charges 5%</option>
                        <option value="6"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '6' ? 'selected' : '' }}>
                            PG charges 6%</option>
                        <option value="7"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '7' ? 'selected' : '' }}>
                            PG charges 7%</option>
                        <option value="8"
                            {{ old('pg_charges_filed', isset($estimate) ? $estimate->pg_charges_filed : '') == '8' ? 'selected' : '' }}>
                            PG charges 8%</option>
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
                        <tr>
                            <td style="width:100%" class="text-center">Please Select Sanctuary for loading Inclusions.
                        </tr>
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
                        <tr>
                            <td style="width:100%" class="text-center">Please Select Sanctuary for loading exclusions.
                        </tr>
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
                        <tr>
                            <td style="width:100%" class="text-center">Please Select Sanctuary for loading Terms.
                        </tr>
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
