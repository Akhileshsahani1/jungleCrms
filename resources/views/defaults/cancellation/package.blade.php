@extends('layouts.master')
@section('title', 'Cancellation Charge')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

@endsection

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fab fa-safari"></i> Cancellation Charge</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('chancellation-charges.index') }}">Cancellation</a></li>
                        <li class="breadcrumb-item active">Cancellation Charge</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
             <div class="col-sm-12 mt-5">
                                 <div class="card">
                                        <div class="card-body">
                                            <form method="post" id="package-Form" action="{{ route('chancellation-charges.package.store') }}">
                                                @csrf
                                                 <input type="hidden" name="destination" value="{{ $destination }}">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="content">Content*</label>
                                                            <textarea type="text" id="content" class="form-control summernote" placeholder="Content"
                                                            name="content" rows="10">{{ old('content', $package ?  $package->content : '') }}</textarea>
                                                            @error('content')
                                                                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>                       
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                           <table class="table table-bordered" id="package-table">
                                            <thead>
                                                <tr>
                                                    <th>Min Date</th>
                                                    <th>Max Date</th>
                                                    <th>Charges(in %)</th>
                                                </tr>
                                            </thead>
                                              <tbody>
                                                    @if (isset($package) && count($package->cancellationcharges) > 0)
                                                        @foreach ($package->cancellationcharges as $key => $item)
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
                                                        <td class="text-right" colspan="5"><button type="button" onclick="addPackageItem();"
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
                                            <button type="submit" class="btn btn-success" form="package-Form">Update</button>
                                        </div>
                                    </div>
                            </div>
                    </div>
    </section>
@endsection
@push('scripts')
<script>
     @if (isset($package) && count($package->cancellationcharges) > 0)
      var item_option_package_row='{{ count($package->cancellationcharges) }}';
     @else
      var item_option_package_row=1;
     @endif
   
   function addPackageItem() {
        if (item_option_package_row < 50) {
            html = '<tr id="item-option-row' + item_option_package_row + '">';
            html += '<td style="width:350px"><input type="text" name="item[' + item_option_package_row +
                '][min_day]" placeholder="min_day" class="form-control" id="content' + item_option_package_row +
                '" value="0" required></td>';
            html += '<td><input type="number" name="item[' + item_option_package_row +
                '][max_day]" placeholder="max_day" class="form-control max_day" id="max_date' + item_option_package_row +
                '" value="0" required></td>';
            html += '<td><input type="number" name="item[' + item_option_package_row +
                '][charge]" placeholder="charge" class="form-control charge" id="charge' + item_option_package_row +
                '" value="0" required></td>';
            html += '<td class="text-right"><button type="button" onclick="$(\'#item-option-row' + item_option_package_row +
                '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#package-table tbody').append(html);

            item_option_package_row++;
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
