<form id="form-filter" class="inline-form" action="{{ route('trash-estimates') }}">
    <div class="form-row">
        <div class="col-3">
            <label class="col-form-label" for="filter_hotel">Search By Name</label>
            <input type="text" class="form-control form-control-sm" id="filter_name" placeholder="Name" name="filter_name" value="{{$filter_name}}">
        </div>

        <div class="col-3">
            <label class="col-form-label" for="filter_mobile">Search By Mobile</label>
            <input type="text" class="form-control form-control-sm" id="filter_mobile" placeholder="Mobile" name="filter_mobile" value="{{$filter_mobile}}">
        </div>
        <div class="col-3">
            <label class="col-form-label" for="filter_email">Search By Email</label>
            <input type="text" class="form-control form-control-sm" id="filter_email" placeholder="Email" name="filter_email" value="{{$filter_email}}">
        </div>
        <div class="col-3">
            <label class="col-form-label" for="">Payment Status</label>
             <select id="input" class="form-control form-control-sm" name="filter_payment_status">
                  <option value="">All</option>
      
                  <option @if (@$filter_payment_status == 'paid') selected @endif value="paid">Paid</option>
                  <option @if (@$filter_payment_status == 'unpaid') selected @endif value="unpaid">Unpaid</option>
                  <option @if (@$filter_payment_status == 'partially_paid') selected @endif value="partially_paid">Partially Paid</option>
      
      
              </select>
          </div>
    </div>
    <div class="form-row">
        @role('administrator')
        <div class="col-3">
          <label class="col-form-label" for="inputEmail4">User Assigned</label>
          <select id="input" class="form-control form-control-sm" name="filter_user">
            <option value="">Select User</option>
            @foreach($users as $user)
            <option @if (@$filter_user == $user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>

    </div>
    <div class="col-2">
        <label for="website" class="col-form-label">Website</label>
           <select class="form-control form-control-sm" name="filter_website">
             <option value="">Select website</option>
             <option @if (@$filter_website == 'ranthamboretigerreserve.in') selected @endif
                        value="ranthamboretigerreserve.in">ranthamboretigerreserve.in</option>
             <option @if (@$filter_website == 'jimcorbettnationalparkonline.in') selected @endif
                        value="jimcorbettnationalparkonline.in">jimcorbettnationalparkonline.in</option>
             <option @if (@$filter_website == 'girsafaribooking.com') selected @endif value="girsafaribooking.com">
                                girsafaribooking.com</option>
             <option @if (@$filter_website == 'jimcorbett.in') selected @endif value="jimcorbett.in">
                                jimcorbett.in</option>
             <option @if (@$filter_website == 'girlionsafari.com') selected @endif value="girlionsafari.com">
                                girlionsafari.com</option>
             <option @if (@$filter_website == 'girlion.in') selected @endif value="girlion.in">
                                girlion.in</option>
             <option @if (@$filter_website == 'bandhavgarh.com') selected @endif value="bandhavgarh.com">
                                bandhavgarh.com</option>
             <option @if (@$filter_website == 'travelwalacab.com') selected @endif value="travelwalacab.com">
                                travelwalacab.com</option>
             <option @if (@$filter_website == 'dailytourandtravel.com') selected @endif
                                value="dailytourandtravel.com">dailytourandtravel.com</option>
            <option @if (@$filter_website == 'rajasthan.dailytourandtravel.com') selected @endif
                                value="rajasthan.dailytourandtravel.com">rajasthan.dailytourandtravel.com</option>
            <option @if (@$filter_website == 'himachal.dailytourandtravel.com') selected @endif
                                value="himachal.dailytourandtravel.com">himachal.dailytourandtravel.com</option>
            <option @if (@$filter_website == 'internationaltrips.in') selected @endif
                                            value="internationaltrips.in">internationaltrips.in</option>
            <option @if (@$filter_website == 'tadobapark.com') selected @endif
                                            value="tadobapark.com">tadobapark.com</option>

           </select>
    </div>
    <div class="col-2">
        <label class="col-form-label" for="">Destination</label>
        <select name="filter_sanctuary" class="form-control form-control-sm">
            <option value="">All</option>
            <option value="ranthambore" {{ $filter_sanctuary == 'Ranthambore' ? 'selected' : '' }}>Ranthambore
            </option>
            <option value="gir" {{ $filter_sanctuary == 'Gir' ? 'selected' : '' }}>Gir</option>
            <option value="jim" {{ $filter_sanctuary == 'Jim Corbett' ? 'selected' : '' }}>Jim Corbett
            </option>

        </select>
    </div>
    <div class="col-2">
        <label class="col-form-label" for="">Estimate Creation Date</label>
        <input type="date" data-format="dd-mm-yyyy" id="filter_date"  name="filter_date" value="{{$filter_date}}" class="form-control form-control-sm" placeholder="Select Date">
    </div>
    @else
    <div class="col-3">
        <label for="website" class="col-form-label">Website</label>
           <select class="form-control form-control-sm" name="filter_website">
             <option value="">Select website</option>
             <option @if (@$filter_website == 'ranthamboretigerreserve.in') selected @endif
                        value="ranthamboretigerreserve.in">ranthamboretigerreserve.in</option>
             <option @if (@$filter_website == 'jimcorbettnationalparkonline.in') selected @endif
                        value="jimcorbettnationalparkonline.in">jimcorbettnationalparkonline.in</option>
             <option @if (@$filter_website == 'girsafaribooking.com') selected @endif value="girsafaribooking.com">
                                girsafaribooking.com</option>
             <option @if (@$filter_website == 'jimcorbett.in') selected @endif value="jimcorbett.in">
                                jimcorbett.in</option>
             <option @if (@$filter_website == 'girlionsafari.com') selected @endif value="girlionsafari.com">
                                girlionsafari.com</option>
             <option @if (@$filter_website == 'girlion.in') selected @endif value="girlion.in">
                                girlion.in</option>
             <option @if (@$filter_website == 'bandhavgarh.com') selected @endif value="bandhavgarh.com">
                                bandhavgarh.com</option>
             <option @if (@$filter_website == 'travelwalacab.com') selected @endif value="travelwalacab.com">
                                travelwalacab.com</option>
             <option @if (@$filter_website == 'dailytourandtravel.com') selected @endif
                                value="dailytourandtravel.com">dailytourandtravel.com</option>
           </select>
    </div>
    <div class="col-3">
        <label class="col-form-label" for="">Destination</label>
        <select name="filter_sanctuary" class="form-control form-control-sm">
            <option value="">All</option>
            <option value="ranthambore" {{ $filter_sanctuary == 'Ranthambore' ? 'selected' : '' }}>Ranthambore
            </option>
            <option value="gir" {{ $filter_sanctuary == 'Gir' ? 'selected' : '' }}>Gir</option>
            <option value="jim" {{ $filter_sanctuary == 'Jim Corbett' ? 'selected' : '' }}>Jim Corbett
            </option>

        </select>
    </div>
    <div class="col-3">
        <label class="col-form-label" for="">Estimate Creation Date</label>
        <input type="date" data-format="dd-mm-yyyy" id="filter_date"  name="filter_date" value="{{$filter_date}}" class="form-control form-control-sm" placeholder="Select Date">
    </div>
    @endrole
    
    <div class="col-3">
        <label class="col-form-label" for="">Estimate Status</label>
          <select id="input" class="form-control form-control-sm" name="filter_estimate_status">
              <option value="">All</option>
  
              <option @if (@$filter_estimate_status == 'waiting') selected @endif value="waiting">Waiting</option>
              <option @if (@$filter_estimate_status == 'accepted') selected @endif value="accepted">Accepted</option>
  
          </select>
      </div>
    </div>
</form>
