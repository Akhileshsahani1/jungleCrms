<form id="form-filter" class="inline-form" action="{{ route('customers.index') }}">
    <div class="form-row">

        <div class="col">
            <label for="filter_name">Search By Name</label>
            <input type="text" class="form-control" id="filter_name" placeholder="Name" name="filter_name" value="{{$filter_name}}">
        </div>

        <div class="col">
            <label for="filter_phone">Search By Phone</label>
            <input type="text" class="form-control" id="filter_phone" placeholder="Phone" name="filter_phone" value="{{$filter_phone}}">
        </div>

        <div class="col">
            <label for="filter_email">Search By Email</label>
            <input type="email" class="form-control" id="filter_email" placeholder="Email" name="filter_email" value="{{$filter_email}}">
        </div>

        <div class="col">
            <label for="filter_state">Search By State</label>
            <select class="form-control" id="filter_state"  name="filter_state">
                <option value="">All</option>
                @foreach ($states as $state)
                    <option value="{{ $state->state }}" @if($state->state == $filter_state) selected @endif>{{ $state->state }}</option>
                @endforeach
            </select>
        </div>


    <div class="col">
        <label for="">Date</label>
        <input type="date" id="filter_date"  name="filter_date" value="{{$filter_date}}" class="form-control floating-label" placeholder="Select Date">
    </div>

    <div class="card-tools" style="margin-top: 32px;">
        <div class="btn-group">
            <button type="submit" class="btn btn-info" form="form-filter"><i class="fa fa-filter"></i></button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary ml-2 mr-2" id="reset-filter"><i class="fa fa-undo"></i></a>
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">Add</button>
        </div>
    </div>
</div>
</form>
