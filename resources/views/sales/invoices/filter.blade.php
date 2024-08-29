<form id="form-filter" class="inline-form" action="{{ route('invoices.index') }}">
    <div class="form-row mb-2">
        <div class="col">
            <label for="filter_name">Search By Name</label>
            <input type="text" class="form-control" id="filter_name" placeholder="Name" name="filter_name"
                value="{{ $filter_name }}">
        </div>
        <div class="col">
            <label for="">Booking Type</label>
            <select name="filter_type" class="form-control">
                <option value="">All</option>
                <option value="safari" {{ $filter_type == 'safari' ? 'selected' : '' }}>Safari</option>
                <option value="hotel" {{ $filter_type == 'hotel' ? 'selected' : '' }}>Hotel</option>
                <option value="cab" {{ $filter_type == 'cab' ? 'selected' : '' }}>Cab</option>
                <option value="tour" {{ $filter_type == 'tour' ? 'selected' : '' }}>Tour</option>
                <option value="package" {{ $filter_type == 'package' ? 'selected' : '' }}>Package</option>

            </select>
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
        @role('administrator')
        <div class="col">
            <label for="inputEmail4">User Assigned</label>
            <select id="input" class="form-control" name="filter_user">
                <option value="">Select User</option>
                @foreach ($users as $user)
                    <option @if (@$filter_user == $user->id) selected @endif value="{{ $user->id }}">
                        {{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        @endrole
        <div class="col">
            <label for=""> Invoice Date</label>
            <input type="text" id="filter_date" name="filter_date" value="{{ $filter_date }}"
                class="form-control floating-label" placeholder="Select Date">
        </div>

        <div class="col">
            <label for="">Booking</label>
            <select name="filter_booking_status" class="form-control">
                <option value="all" {{ $filter_booking_status == 'all' ? 'selected' : '' }}>All</option>
                <option value="cancel" {{ $filter_booking_status == 'cancel' ? 'selected' : '' }}>Cancel</option>
            </select>
        </div>

        <div class="card-tools" style="margin-top: 32px;">
            <div class="btn-group">
                <button type="submit" class="btn btn-info" form="form-filter"><i class="fa fa-filter"></i></button>
                <a href="{{ route('invoices.index') }}" class="btn btn-secondary ml-2" id="reset-filter"><i
                        class="fa fa-undo"></i></a>
            </div>

            {{-- <div class="btn-group">
                <a href="{{ route('invoices.create') }}" class="btn btn-success"> Create Invoice</a>
            </div> --}}
        </div>
    </div>
</form>
