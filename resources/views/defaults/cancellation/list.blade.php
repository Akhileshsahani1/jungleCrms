@extends('layouts.master')
@section('title', 'Cancellation')
@section('head')
<link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Cancellation</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Defaults</li>
                        <li class="breadcrumb-item active">Cancellation</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="col-12 col-sm-12">
            <div class="card card-dark card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-cab-tab" data-toggle="pill"
                                href="#custom-tabs-one-cab" role="tab" aria-controls="custom-tabs-one-home"
                                aria-selected="true">Cab</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-hotel-tab" data-toggle="pill"
                                href="#custom-tabs-one-hotel" role="tab" aria-controls="custom-tabs-one-profile"
                                aria-selected="false">Hotel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-safari-tab" data-toggle="pill"
                                href="#custom-tabs-one-safari" role="tab" aria-controls="custom-tabs-one-messages"
                                aria-selected="false">Safari</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-tour-tab" data-toggle="pill"
                                href="#custom-tabs-one-tour" role="tab" aria-controls="custom-tabs-one-settings"
                                aria-selected="false">Tour</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-package-tab" data-toggle="pill"
                                href="#custom-tabs-one-package" role="tab" aria-controls="custom-tabs-one-package"
                                aria-selected="false">Package</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-cab" role="tabpanel"
                            aria-labelledby="custom-tabs-one-cab-tab">
                            <div class="col-sm-12">
                                <strong>Cab </strong>
                            </div>
                            <div class="col-sm-12 mt-5">
                                 <div class="card">
                                        <div class="card-body">
                                            <form method="post" id="cab-Form" action="{{ route('chancellation-charges.cab.store') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="content">Content*</label>
                                                            <textarea type="text" id="content" class="form-control summernote" placeholder="Content"
                                                            name="content" rows="10">{{ old('content', $cab ?  $cab->content : '') }}</textarea>
                                                            @error('content')
                                                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>                       
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                           <table class="table table-bordered" id="cab-table">
                                            <thead>
                                                <tr>
                                                    <th>Min Date</th>
                                                    <th>Max Date</th>
                                                    <th>Charges(in %)</th>
                                                </tr>
                                            </thead>
                                              <tbody>
                                                    @if (isset($cab) && count($cab->cancellationcharges) > 0)
                                                        @foreach ($cab->cancellationcharges as $key => $item)
                                                            <tr id="item-option-row{{ $key }}">
                                                                <td style="width:350px"><input type="text"
                                                                        name="item[{{ $key }}][min_day]" placeholder="min_day"
                                                                        class="form-control" id="min_day{{ $key }}" required
                                                                        value="{{ $item->min_day }}">
                                                                </td>
                                                                <td><input type="text" name="item[{{ $key }}][max_day]"
                                                                        placeholder="max_day" class="form-control max_day"
                                                                        id="max_day{{ $key }}" value="{{ $item->max_day }}" required></td>
                                                                <td><input type="number" name="item[{{ $key }}][charge]" placeholder="charge"
                                                                        class="form-control charge" id="charge{{ $key }}"
                                                                        value="{{ $item->charge }}" required></td>
                                                                <td class="text-right"><button type="button"
                                                                        onclick="$('#item-option-row{{ $key }}').remove();"
                                                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                                                        data-original-title="Remove Button"><i
                                                                            class="fas fa-minus-circle"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr id="item-option-row0">
                                                            <td style="width:350px"><input type="text" name="item[0][min_day]"
                                                                    placeholder="Min Date" class="form-control" id="pmin_day0"
                                                                    value="0" required></td>
                                                            <td><input type="text" name="item[0][max_day]" placeholder="max_day"
                                                                    class="form-control max_day" id="max_day0" value="0" required></td>
                                                            <td><input type="number" name="item[0][charge]" placeholder="charge"
                                                                    class="form-control charge" id="charge0" value="0" required></td>
                                                            <td class="text-right"><button type="button" onclick="$('#item-option-row0').remove();"
                                                                    data-toggle="tooltip" title="" class="btn btn-danger"
                                                                    data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="text-right" colspan="5"><button type="button" onclick="addItem();"
                                                                data-toggle="tooltip" title="Add Option" class="btn btn-secondary"
                                                                data-original-title="Add Option"><i class="fas fa-plus-circle"></i></button></td>
                                                    </tr>
                                                </tfoot>
                                        </table>
                                                        </div>
                                                    </div>                       
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-success" form="cab-Form">Update</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-hotel" role="tabpanel"
                            aria-labelledby="custom-tabs-one-hotel-tab">
                            <div class="col-sm-12">
                                <strong>Hotel</strong>
                            </div>
                             <div class="col-sm-12 mt-5">
                                 <div class="card">
                                        <div class="card-body">
                                            <form method="post" id="hotel-Form" action="{{ route('chancellation-charges.hotel.store') }}">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="content">Content*</label>
                                                            <textarea type="text" id="content" class="form-control summernote" placeholder="Content"
                                                            name="content" rows="10">{{ old('content', $hotel ?  $hotel->content : '') }}</textarea>
                                                            @error('content')
                                                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>                       
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                           <table class="table table-bordered" id="hotel-table">
                                            <thead>
                                                <tr>
                                                    <th>Min Date</th>
                                                    <th>Max Date</th>
                                                    <th>Charges(in %)</th>
                                                </tr>
                                            </thead>
                                              <tbody>
                                                    @if (isset($hotel) && count($hotel->cancellationcharges) > 0)
                                                        @foreach ($hotel->cancellationcharges as $key => $item)
                                                            <tr id="item-option-row{{ $key }}">
                                                                <td style="width:350px"><input type="text"
                                                                        name="item[{{ $key }}][min_day]" placeholder="min_day"
                                                                        class="form-control" id="min_day{{ $key }}" required
                                                                        value="{{ $item->min_day }}">
                                                                </td>
                                                                <td><input type="text" name="item[{{ $key }}][max_day]"
                                                                        placeholder="max_day" class="form-control max_day"
                                                                        id="max_day{{ $key }}" value="{{ $item->max_day }}" required></td>
                                                                <td><input type="number" name="item[{{ $key }}][charge]" placeholder="charge"
                                                                        class="form-control charge" id="charge{{ $key }}"
                                                                        value="{{ $item->charge }}" required></td>
                                                                <td class="text-right"><button type="button"
                                                                        onclick="$('#item-option-row{{ $key }}').remove();"
                                                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                                                        data-original-title="Remove Button"><i
                                                                            class="fas fa-minus-circle"></i></button>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr id="item-option-row0">
                                                            <td style="width:350px"><input type="text" name="item[0][min_day]"
                                                                    placeholder="Min Date" class="form-control" id="pmin_day0"
                                                                    value="0" required></td>
                                                            <td><input type="text" name="item[0][max_day]" placeholder="max_day"
                                                                    class="form-control max_day" id="max_day0" value="0" required></td>
                                                            <td><input type="number" name="item[0][charge]" placeholder="charge"
                                                                    class="form-control charge" id="charge0" value="0" required></td>
                                                            <td class="text-right"><button type="button" onclick="$('#item-option-row0').remove();"
                                                                    data-toggle="tooltip" title="" class="btn btn-danger"
                                                                    data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="text-right" colspan="5"><button type="button" onclick="addHotelItem();"
                                                                data-toggle="tooltip" title="Add Option" class="btn btn-secondary"
                                                                data-original-title="Add Option"><i class="fas fa-plus-circle"></i></button></td>
                                                    </tr>
                                                </tfoot>
                                        </table>
                                                        </div>
                                                    </div>                       
                                                </div>
                                            </form>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-success" form="hotel-Form">Update</button>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-safari" role="tabpanel"
                            aria-labelledby="custom-tabs-one-safari-tab">
                            <div class="col-sm-12">
                                <strong>Safari</strong>
                            </div>
                            <div class="col-sm-12 mt-5">
                                 <div class="card">
                                        <div class="card-body">
                                          <table class="table">
                                            <thead>
                                               <th>ID</th>
                                               <th> Destinataion </th>
                                               <th> Action </th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                      1 
                                                    </td>
                                                    <td>
                                                      Gir   
                                                    </td>
                                                     <td>
                                                      <a href="{{ route('chancellation-charges.safari.create','gir' ) }}" class="btn btn-success">
                                                        Edit
                                                    </a>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td>
                                                      2
                                                    </td>
                                                    <td>
                                                      Jim   
                                                    </td>
                                                     <td>
                                                      <a href="{{ route('chancellation-charges.safari.create','jim' ) }}" class="btn btn-success">
                                                        Edit
                                                    </a>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td>
                                                      3
                                                    </td>
                                                    <td>
                                                      Ranthambore   
                                                    </td>
                                                     <td>
                                                      <a href="{{ route('chancellation-charges.safari.create','ranthambore' ) }}" class="btn btn-success">
                                                        Edit
                                                    </a>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td>
                                                      4
                                                    </td>
                                                    <td>
                                                      Tadoba   
                                                    </td>
                                                     <td>
                                                      <a href="{{ route('chancellation-charges.safari.create','tadoba' ) }}" class="btn btn-success">
                                                        Edit
                                                    </a>
                                                    </td>
                                                </tr>
                                                
                                                
                                            </tbody>
                                          </table>
                                        </div>
                                        
                                    </div>
                            </div>
                            
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-tour" role="tabpanel"
                            aria-labelledby="custom-tabs-one-tour-tab">
                            <div class="col-sm-12">
                                <strong>Tour </strong>
                            </div>
                             <div class="col-sm-12 mt-5">
                                 <div class="card">
                                        <div class="card-body">
                                          <table class="table">
                                            <thead>
                                               <th>ID</th>
                                               <th> Destinataion </th>
                                               <th> Action </th>
                                            </thead>
                                            <tbody>
                                                @foreach($destinations as $destination)
                                                 <tr>
                                                <td>
                                                  {{ $loop->index + 1 }}   
                                                </td>
                                                <td>
                                                  {{ $destination->destination }}   
                                                </td>
                                                 <td>
                                                  <a href="{{ route('chancellation-charges.tour.create',$destination->destination ) }}" class="btn btn-success">
                                                    Edit
                                                </a>
                                                </td>
                                                 </tr>
                                                @endforeach
                                            </tbody>
                                          </table>
                                        </div>
                                        
                                    </div>
                            </div>
                             
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-package" role="tabpanel"
                        aria-labelledby="custom-tabs-one-package-tab">
                        <div class="col-sm-12">
                            <strong>Package </strong>
                        </div>
                        <div class="col-sm-12 mt-5">
                                 <div class="card">
                                        <div class="card-body">
                                          <table class="table">
                                            <thead>
                                               <th>ID</th>
                                               <th> Destinataion </th>
                                               <th> Action </th>
                                            </thead>
                                            <tbody>
                                                @foreach($destinations as $destination)
                                                 <tr>
                                                <td>
                                                  {{ $loop->index + 1 }}   
                                                </td>
                                                <td>
                                                  {{ $destination->destination }}   
                                                </td>
                                                 <td>
                                                  <a href="{{ route('chancellation-charges.package.create',$destination->destination ) }}" class="btn btn-success">
                                                    Edit
                                                </a>
                                                </td>
                                                 </tr>
                                                @endforeach
                                            </tbody>
                                          </table>
                                        </div>
                                        
                                    </div>
                            </div>
                    
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
   {{--  @include('defaults.cancellation.cab')
    @include('defaults.cancellation.hotel')
    @include('defaults.cancellation.safari') --}}
    {{-- @include('defaults.cancellation.tour') --}}
    {{-- @include('defaults.cancellation.package') --}}
@push('scripts')
<script type="text/javascript">
    $("#custom-tabs-one-{{ $type }}-tab").trigger('click');
</script>
<script>
     @if (isset($cab) && count($cab->cancellationcharges) > 0)
      var item_option_row='{{ count($cab->cancellationcharges) }}';
     @else
      var item_option_row=1;
     @endif
   
   function addItem() {
        if (item_option_row < 50) {
            html = '<tr id="item-option-row' + item_option_row + '">';
            html += '<td style="width:350px"><input type="text" name="item[' + item_option_row +
                '][min_day]" placeholder="min_day" class="form-control" id="content' + item_option_row +
                '" value="0" required></td>';
            html += '<td><input type="number" name="item[' + item_option_row +
                '][max_day]" placeholder="max_day" class="form-control max_day" id="max_date' + item_option_row +
                '" value="0" required></td>';
            html += '<td><input type="number" name="item[' + item_option_row +
                '][charge]" placeholder="charge" class="form-control charge" id="charge' + item_option_row +
                '" value="0" required></td>';
            html += '<td class="text-right"><button type="button" onclick="$(\'#item-option-row' + item_option_row +
                '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#cab-table tbody').append(html);

            item_option_row++;
        }
    }
</script>
<script>
     @if (isset($hotel) && count($hotel->cancellationcharges) > 0)
      var item_option_hotel_row='{{ count($hotel->cancellationcharges) }}';
     @else
      var item_option_hotel_row=1;
     @endif
   
   function addHotelItem() {
        if (item_option_hotel_row < 50) {
            html = '<tr id="item-option-row' + item_option_hotel_row + '">';
            html += '<td style="width:350px"><input type="text" name="item[' + item_option_hotel_row +
                '][min_day]" placeholder="min_day" class="form-control" id="content' + item_option_hotel_row +
                '" value="0" required></td>';
            html += '<td><input type="number" name="item[' + item_option_hotel_row +
                '][max_day]" placeholder="max_day" class="form-control max_day" id="max_date' + item_option_hotel_row +
                '" value="0" required></td>';
            html += '<td><input type="number" name="item[' + item_option_hotel_row +
                '][charge]" placeholder="charge" class="form-control charge" id="charge' + item_option_hotel_row +
                '" value="0" required></td>';
            html += '<td class="text-right"><button type="button" onclick="$(\'#item-option-row' + item_option_hotel_row +
                '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#hotel-table tbody').append(html);

            item_option_hotel_row++;
        }
    }
</script>


<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<script>
    $(function() {
    $('.summernote').summernote({
        height: 300,                 // set editor height
        minHeight: null,             // set minimum height of editor
        maxHeight: null,             // set maximum height of editor
        focus: true                  // set focus to editable area after initializing summernote
    })
});
</script>

@endpush
