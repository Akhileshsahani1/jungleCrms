<form id="form-filter" class="inline-form" action="{{ route('hotels.index') }}">
    <div class="form-row">

        <div class="col">
            <label for="filter_hotel">Search By Name</label>
            <input type="text" class="form-control" id="filter_name" placeholder="Name" name="filter_name" value="{{$filter_name}}">
        </div>
   
    <div class="col">
      <label for="rating">Rating</label>
       <select id="rating" class="form-control" name="filter_rating">
        <option value="" selected="">Select Rating</option>
                                <option value="1" {{ $filter_rating == '1' ? 'selected' : '' }}>1 Star</option>
                                <option value="2" {{ $filter_rating == '2' ? 'selected' : '' }}>2 Star</option>
                                <option value="3" {{ $filter_rating == '3' ? 'selected' : '' }}>3 Star</option>
                                <option value="4" {{ $filter_rating == '4' ? 'selected' : '' }}>4 Star</option>
                                <option value="5" {{ $filter_rating == '5' ? 'selected' : '' }}>5 Star</option>
                                <option value="6" {{ $filter_rating == '6' ? 'selected' : '' }}>6 Star</option>
                                <option value="7" {{ $filter_rating == '7' ? 'selected' : '' }}>7 Star</option>
        </select>
    </div>
    <div class="col">
        <label for="state">State</label>
        <select id="state" name="filter_state" class="form-control">
            <option value="" selected="">Select State</option>
            @foreach ($states as $state)
                <option value="{{ $state->state }}" @if($filter_state == $state->state) selected @endif>{{ $state->state }}</option>
            @endforeach
        </select>
    </div>

    <div class="col">
        <label for="city">City</label>
        <select id="city" name="filter_city" class="form-control">
            <option value="" selected="">Select City</option>
            @foreach ($cities as $city)
                <option value="{{ $city->city }}" @if($filter_city == $city->city) selected @endif>{{ $city->city }}</option>
            @endforeach
        </select>
    </div>

    <div class="card-tools" style="margin-top: 32px;">
        <div class="btn-group">
            <button type="submit" class="btn btn-info" form="form-filter"><i class="fa fa-filter"></i></button>
            <a href="{{ route('hotels.index') }}" class="btn btn-secondary ml-2" id="reset-filter"><i class="fa fa-undo"></i></a>
        </div>

        <div class="btn-group">
            <a class="btn btn-success" href="{{ route('hotels.create') }}">
              Create
            </a>
          </div>
    </div>
</div>
</form>
