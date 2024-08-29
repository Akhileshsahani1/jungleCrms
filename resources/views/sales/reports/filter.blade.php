<form id="form-filter" action="{{ route('reports.index') }}">
    <div class="form-row mb-2">
      <div class="col">
        <label for="filter_month">Month</label>
        <select class="form-control" name="filter_month">
          <option value="">Select Month</option>
          <option @if (@$filter_month == '01') selected @endif value="01">January</option>
          <option @if (@$filter_month == '02') selected @endif value="02">February</option>
          <option @if (@$filter_month == '03') selected @endif value="03">March</option>
          <option @if (@$filter_month == '04') selected @endif value="4">April</option>
          <option @if (@$filter_month == '05') selected @endif value="05">May</option>
          <option @if (@$filter_month == '06') selected @endif value="06">June</option>
          <option @if (@$filter_month == '07') selected @endif value="07">July</option>
          <option @if (@$filter_month == '08') selected @endif value="08">August</option>
          <option @if (@$filter_month == '09') selected @endif value="09">September</option>
          <option @if (@$filter_month == '10') selected @endif value="10">October</option>
          <option @if (@$filter_month == '11') selected @endif value="11">November</option>
          <option @if (@$filter_month == '12') selected @endif value="12">December</option>
        </select>
      </div>
      <div class="col">
        <label for="filter_name">Search By Name</label>
        <input type="text" class="form-control" id="filter_name" placeholder="Name" name="filter_name" value="{{$filter_name}}">
      </div>
      <div class="col">
        <label for="filter_mobile">Search By Mobile</label>
        <input type="text" class="form-control" id="filter_mobile" placeholder="Mobile" name="filter_mobile" value="{{$filter_mobile}}">
      </div>
      <div class="col">
        <label for="filter_date_from">Date from</label>
        <input type="date" id="filter_date_from"  name="filter_date_from" value="{{ $filter_date_from}}" class="form-control" placeholder="Select Date">
      </div>

      <div class="col">
        <label for="filter_date_to">Date to</label>
        <input type="date" id="filter_date_to" name="filter_date_to" value="{{ $filter_date_to}}" class="form-control" placeholder="Select Date">
      </div>

      <div class="card-tools" style="margin-top: 32px;">
        <div class="btn-group" role="group" aria-label="Basic example">
          <button type="button" class="btn btn-info" id="filter"><i class="fa fa-filter"></i></button>
          <a href="{{ route('reports.index') }}" class="btn btn-secondary ml-1 mr-1" id="reset-filter"><i class="fa fa-undo"></i></a>
          <button type="button" class="btn btn-success" id="download"><i class="fa fa-download"></i></button>
          <button type="button" class="btn btn-warning ml-1 mr-1" id="export"><i class="fa fa-file-export"></i></button>
        </div>
      </div>

    </div>
  </form>
