<div class="col-sm-7 mx-auto">
    <div class="form-group">
        <label for="customer_id" class="col-sm-12 col-form-label">Billed To (Customer details)</label>
        <div class="col-sm-12">
            {{-- <select class="form-control" name="customer_id" id="customer_id">
                <option></option>
                @foreach ($customers as $row)
                    <option value="{{ $row->id }}"
                        @if ($customer_exists) @if ($customer->id == $row->id) selected readonly @endif
                        @endif>{{ $row->name }} ({{ $row->mobile }})</option>
                @endforeach
            </select> --}}
            @if ($customer_exists)
            <input type="hidden" name="customer_id" id="customer_id" value="{{ $customer->id }}">
            @else
            <input type="hidden" name="customer_id" id="customer_id">
            @endif
            @if ($customer_exists)
            <input type="text" id="autocomplete"  placeholder="Search" class="form-control" value="{{ $customer->name }}"/>
            @else
            <input type="text" id="autocomplete"  placeholder="Search" class="form-control" />
            @endif
           
            @error('customer_id')
                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>
<div class="col-sm-7 mx-auto">
    <div class="col-sm-12" id="customer-detail"
        @if ($customer_exists) style="display: block;" @else style="display: none;" @endif>
        <div class="customer-detail-box">
            <p class="customer-detail-heading">Customer Details</p>
            <table class="table table-sm">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td id="customer_name" class="text-right">
                            @if ($customer_exists){{ $customer->name }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td id="customer_email" class="text-right">
                            @if ($customer_exists){{ $customer->email }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Mobile</td>
                        <td id="customer_mobile" class="text-right">
                            @if ($customer_exists){{ $customer->mobile }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td id="customer_state" class="text-right">
                            @if ($customer_exists){{ $customer->state }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td id="customer_address" class="text-right">
                            @if ($customer_exists){{ $customer->address }}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-12" id="customer-choose"
        @if ($customer_exists) style="display: none;" @else style="display: block;" @endif>
        <div class="customer-box">
            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 84 84.002">
                <g transform="translate(-5678.929 -3706.424)">
                    <path fill="#eff2f8" d="M5762.929,3748.424a41.879,41.879,0,1,1,0-.245Z"
                        transform="translate(0 0.001)"></path>
                    <path fill="#d3dceb" d="M5719.508,3730.817a14.006,14.006,0,1,1,0-.009Z"
                        transform="translate(15.454 12.777)"></path>
                    <path fill="#d3dceb"
                        d="M5740.918,3749.938a41.97,41.97,0,0,1-55.631.043,29.741,29.741,0,0,1,55.631-.043Z"
                        transform="translate(7.827 29.924)"></path>
                </g>
            </svg>
            <div class="mt-2">Select a Customer from list</div>
            <div class="mb-2">or</div>
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">Add Customer</button>
        </div>
    </div>
</div>
