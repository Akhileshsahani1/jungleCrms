<form id="form-filter" action="{{ route('support.index') }}">
    <div class="form-row mb-2">
      
      
      
      <div class="col">
        <label for="filter_date_from">Date from</label>
        <input type="date" id="filter_date_from"  name="filter_date_from" value="{{ $filter_date_from}}" class="form-control" placeholder="Select Date">
      </div>

      <div class="col">
        <label for="filter_date_to">Date to</label>
        <input type="date" id="filter_date_to" name="filter_date_to" value="{{ $filter_date_to}}" class="form-control" placeholder="Select Date">
      </div>
      <div class="col">
        <label for="filter_status">Status</label>
        <select class="form-control" name="filter_status">
          <option value="">Select Status</option>
          <option @if (@$filter_status == '0') selected @endif value="0">Open</option>
          <option @if (@$filter_status == '1') selected @endif value="1">Closed</option>
        </select>
      </div>

      <div class="card-tools" style="margin-top: 32px;">
        <div class="btn-group" role="group" aria-label="Basic example">
          <button type="submit" class="btn btn-info" id="filter"><i class="fa fa-filter"></i></button>
          <a href="{{ route('support.index') }}" class="btn btn-secondary ml-1 mr-1" id="reset-filter"><i class="fa fa-undo"></i></a>
        </div>
      </div>

    </div>
  </form>
