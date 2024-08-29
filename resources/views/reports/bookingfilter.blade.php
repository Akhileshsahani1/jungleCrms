<form id="form-filter" class="inline-form" action="{{ route('reports_bookings.index') }}">
    <div class="form-row mb-2">

        <div class="col">
            <label for="filter_name">Date Range</label>
            <input type="text" name="filter_daterange" class="form-control" value="{{ $filter_daterange }}" data-format="dd-mm-yyyy"/>
        </div>


        <div class="col">
            <label for="filter_name">Name</label>
            <input type="text" class="form-control" id="filter_name" placeholder="Name" name="filter_name"
                value="{{ $filter_name }}">
        </div>
        <div class="col">
            <label for="">Sanctuary</label>
            <select name="filter_sanctuary" class="form-control">
                <option value="">All</option>
                <option value="ranthambore" {{ $filter_sanctuary == 'Ranthambore' ? 'selected' : '' }}>Ranthambore
                </option>
                <option value="gir" {{ $filter_sanctuary == 'Gir' ? 'selected' : '' }}>Gir</option>
                <option value="jim" {{ $filter_sanctuary == 'Jim Corbett' ? 'selected' : '' }}>Jim Corbett
                </option>

            </select>
        </div>
        <div class="col">
            <label for="filter_vendor">Vendor</label>
            <select name="filter_vendor" id="filter_vendor" class="form-control">
                <option value="">All</option>
                @foreach ($vendors as $vendor)
                <option value="{{ $vendor->id }}" @if($vendor->id == $filter_vendor) selected @endif>{{ $vendor->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <label for="">Type</label>
            <select name="filter_type" class="form-control">
                <option value="">All</option>
                <option value="safari" {{ $filter_type == 'safari' ? 'selected' : '' }}>Safari</option>
                <option value="hotel" {{ $filter_type == 'hotel' ? 'selected' : '' }}>Hotel</option>
                <option value="cab" {{ $filter_type == 'cab' ? 'selected' : '' }}>Cab</option>
                <option value="tour" {{ $filter_type == 'tour' ? 'selected' : '' }}>Tour</option>
                <option value="package" {{ $filter_type == 'package' ? 'selected' : '' }}>Package</option>
            </select>
        </div>
        @role('administrator')
        <div class="col">
            <label for="inputEmail4">Assigned</label>
            <select id="input" class="form-control" name="filter_user">
                <option value="">User</option>
                @foreach ($users as $user)
                    <option @if (@$filter_user == $user->id) selected @endif value="{{ $user->id }}">
                        {{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        @endrole
        <div class="col">
            <label for="">Order Date</label>
            <input type="date" id="filter_order_date" name="filter_order_date" value="{{ $filter_order_date }}"
                class="form-control floating-label" placeholder="Order Date">
        </div>
    </div>
    <div class="form-row mb-2">
        <div class="col">
            <label for="filter_mobile">Mobile</label>
            <input type="text" class="form-control" id="filter_mobile" placeholder="Mobile" name="filter_mobile"
                value="{{ $filter_mobile }}">
        </div>
        <div class="col">
            <label for="">Booking Date</label>
            <input type="date" id="filter_date" name="filter_date" value="{{ $filter_date }}"
                class="form-control floating-label" placeholder="Select Date">
        </div>
        <div class="col">
            <label for="">Time Slot</label>
            <select name="filter_time" class="form-control">
                <option value="">All</option>
                <optgroup label="Ranthambore / Jim Corbett">
                <option value="morning" {{ $filter_time == 'morning' ? 'selected' : '' }}>Morning</option>
                <option value="evening" {{ $filter_time == 'evening' ? 'selected' : '' }}>Evening</option>
                </optgroup>
                <optgroup label="Gir - Jungle Trail">
                    <option value="6:00 AM - 9:00 AM" {{ $filter_time == '6:00 AM - 9:00 AM' ? 'selected' : '' }}>6:00 AM - 9:00 AM</option>
                    <option value="6:45 AM - 9:45 AM" {{ $filter_time == '6:45 AM - 9:45 AM' ? 'selected' : '' }}>6:45 AM - 9:45 AM</option>
                    <option value="8:30 AM - 11:30 AM" {{ $filter_time == '8:30 AM - 11:30 AM' ? 'selected' : '' }}>8:30 AM - 11:30 AM</option>
                    <option value="3:00 PM - 6:00 PM" {{ $filter_time == '3:00 PM - 6:00 PM' ? 'selected' : '' }}>3:00 PM - 6:00 PM</option>
                    <option value="4:00 PM - 7:00 PM" {{ $filter_time == '4:00 PM - 7:00 PM' ? 'selected' : '' }}>4:00 PM - 7:00 PM</option>
                    </optgroup>
                    <optgroup label="Gir - Devalia Safari Park">
                        <option value="7:00 AM - 7:55 AM" {{ $filter_time == '7:00 AM - 7:55 AM' ? 'selected' : '' }}>7:00 AM - 7:55 AM</option>
                        <option value="8:00 AM - 8:55 AM" {{ $filter_time == '8:00 AM - 8:55 AM' ? 'selected' : '' }}>8:00 AM - 8:55 AM</option>
                        <option value="9:00 AM - 9:55 AM" {{ $filter_time == '9:00 AM - 9:55 AM' ? 'selected' : '' }}>9:00 AM - 9:55 AM</option>
                        <option value="10:00 AM - 10:55 AM" {{ $filter_time == '10:00 AM - 10:55 AM' ? 'selected' : '' }}>10:00 AM - 10:55 AM</option>
                        <option value="3:00 PM - 3:55 PM" {{ $filter_time == '3:00 PM - 3:55 PM' ? 'selected' : '' }}>3:00 PM - 3:55 PM</option>
                        <option value="4:00 PM - 4:55 PM" {{ $filter_time == '4:00 PM - 4:55 PM' ? 'selected' : '' }}>4:00 PM - 4:55 PM</option>
                        <option value="5:00 PM - 5:55 PM" {{ $filter_time == '5:00 PM - 5:55 PM' ? 'selected' : '' }}>5:00 PM - 5:55 PM</option>
                        </optgroup>
                        <optgroup label="Gir - Kankai Nature Safari">
                            <option value="6:00 AM - 12:00 PM" {{ $filter_time == '6:00 AM - 12:00 PM' ? 'selected' : '' }}>6:00 AM - 12:00 PM</option>
                            <option value="1:00 PM - 5:00 PM" {{ $filter_time == '1:00 PM - 5:00 PM' ? 'selected' : '' }}>1:00 PM - 5:00 PM</option>
                            </optgroup>
            </select>
        </div>
        <div class="col">
          <label for="">Payment</label>
           <select id="input" class="form-control" name="filter_payment_status">
                <option value="">All</option>

                <option @if (@$filter_payment_status == 'paid') selected @endif value="paid">Paid</option>
                <option @if (@$filter_payment_status == 'unpaid') selected @endif value="unpaid">Unpaid</option>
                <option @if (@$filter_payment_status == 'partially_paid') selected @endif value="partially_paid">Partially Paid</option>


            </select>
        </div>
         <div class="col">
            <label for="">Booking</label>
            <select name="filter_booking_status" class="form-control">
                <option value="all" {{ $filter_booking_status == 'all' ? 'selected' : '' }}>All</option>
                <option value="cancel" {{ $filter_booking_status == 'cancel' ? 'selected' : '' }}>Cancel</option>
            </select>
        </div>
        <div class="col">
            <label for="">Permit Uploaded</label>
            <select name="filter_permit_uploaded" class="form-control">
                <option value="">Choose One</option>
                <option value="yes" {{ $filter_permit_uploaded == 'yes' ? 'selected' : '' }}>Yes</option>
                <option value="no" {{ $filter_permit_uploaded == 'no' ? 'selected' : '' }}>No</option>
            </select>
        </div>

    </div>
</form>
