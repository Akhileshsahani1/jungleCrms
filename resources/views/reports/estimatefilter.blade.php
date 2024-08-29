<form id="form-filter" class="inline-form" action="{{ route('reports_estimates.index') }}">
    <div class="form-row">

        <div class="col">
            <label for="filter_name">Date Range</label>
            <input type="text" name="filter_daterange" class="form-control" value="{{ $filter_daterange }}" data-format="dd-mm-yyyy"/>
        </div>

        <div class="col">
            <label for="filter_hotel">Search Name</label>
            <input type="text" class="form-control" id="filter_name" placeholder="Name" name="filter_name" value="{{$filter_name}}">
        </div>
        @role('administrator')
        <div class="col">
            <label for="filter_mobile">Search Mobile</label>
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
   
    

    <div class="card-tools" style="margin-top: 32px;">

    </div>

</div>
<div class="form-row">
     <div class="col">
      <label for="">Estimate Status</label>
        <select id="input" class="form-control" name="filter_estimate_status">
            <option value="">All</option>

            <option @if (@$filter_estimate_status == 'waiting') selected @endif value="waiting">Waiting</option>
            <option @if (@$filter_estimate_status == 'accepted') selected @endif value="accepted">Accepted</option>

        </select>
    </div>
    <div class="col">
            <label for="">Estimate Type</label>
             <select id="input" class="form-control" name="filter_estimate_type">
                  <option value="">All</option>
      
                  <option @if (@$filter_estimate_type == 'cab') selected @endif value="cab">Cab</option>
                  <option @if (@$filter_estimate_type == 'hotel') selected @endif value="hotel">Hotel</option>
                  <option @if (@$filter_estimate_type == 'safari') selected @endif value="safari">Safari</option>
                  <option @if (@$filter_estimate_type == 'tour') selected @endif value="tour">Tour</option>
                  <option @if (@$filter_estimate_type == 'package') selected @endif value="package">Package</option>
      
      
              </select>
          </div>
     <div class="col">
        <label for="">Check In</label>
        <input type="date" class="form-control" id="filter_check_in" placeholder="Name" name="filter_check_in" value="{{$filter_check_in}}">
     </div>
      <div class="col">
        <label for="">Check Out</label>
        <input type="date" class="form-control" id="filter_check_out" placeholder="Name" name="filter_check_out" value="{{$filter_check_out}}">
     </div>
      <div class="col">
        <label for="">Safari Date</label>
        <input type="date" class="form-control" id="filter_safari_date" placeholder="Name" name="filter_safari_date" value="{{$filter_safari_date}}">
     </div>
      <div class="col">
            <label for="">Slot</label>
             <select id="input" class="form-control" name="filter_safari_slot">
                  <option value="">All</option>
      
                  <option @if (@$filter_safari_slot == 'Morning') selected @endif value="Morning">Morning</option>
                  <option @if (@$filter_safari_slot == 'Evening') selected @endif value="Evening">Evening</option>
                 
      
      
              </select>
          </div>


    <div class="card-tools" style="margin-top: 32px;">

    </div>
</div>
</form>
