<form id="form-filter" class="inline-form" action="{{ route('reports_unpaidEstimates.index') }}">
    <div class="form-row">

        <div class="col">
            <label for="filter_name">Date Range</label>
            <input type="text" name="filter_daterange" class="form-control" value="{{ $filter_daterange }}" data-format="dd-mm-yyyy"/>
        </div>

        <div class="col">
            <label for="filter_hotel">Search By Name</label>
            <input type="text" class="form-control" id="filter_name" placeholder="Name" name="filter_name" value="{{$filter_name}}">
        </div>
        @role('administrator')
        <div class="col">
            <label for="filter_mobile">Search By Mobile</label>
            <input type="text" class="form-control" id="filter_mobile" placeholder="Mobile" name="filter_mobile" value="{{$filter_mobile}}">
        </div>
        <div class="col">
          <label for="inputEmail4">User Assigned</label>
          <select id="input" class="form-control" name="filter_user">
            <option value="">Select User</option>
            @foreach($users as $user)
            <option @if (@$filter_user == $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

    </div>
    @endrole
    <div class="col">
        <label for="">Destination</label>
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
      <label for="">Payment Status</label>
       <select id="input" class="form-control" name="filter_payment_status">
            <option value="">All</option>

            <option @if (@$filter_payment_status == 'paid') selected @endif value="paid">Paid</option>
            <option @if (@$filter_payment_status == 'unpaid') selected @endif value="unpaid">Unpaid</option>
            <option @if (@$filter_payment_status == 'partially_paid') selected @endif value="partially_paid">Partially Paid</option>


        </select>
    </div>
    <div class="col">
      <label for="">Estimate Status</label>
        <select id="input" class="form-control" name="filter_estimate_status">
            <option value="">All</option>

            <option @if (@$filter_estimate_status == 'waiting') selected @endif value="waiting">Waiting</option>
            <option @if (@$filter_estimate_status == 'accepted') selected @endif value="accepted">Accepted</option>

        </select>
    </div>

    <div class="card-tools" style="margin-top: 32px;">

    </div>
</div>
</form>
