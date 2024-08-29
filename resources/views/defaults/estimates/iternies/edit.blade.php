@extends('layouts.master')
@section('title', 'Edit Iternaries')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Iternaries</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Sales</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Companies</a></li>
                        <li class="breadcrumb-item active">Edit Iternaries</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                </div>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('iternaries.update',$id) }}" id="companyForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name*</label>
                                        <input type="text" id="name" class="form-control" placeholder="Name" name="name"
                                            value="{{ old('name', isset($destination) ? $destination->name : '') }}">
                                    @error('name')
                                        <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                     <label for="filter">Duration</label>
                                        <select name="duration" id="websites" class="form-control">
                                        <option value="">Select Duration</option>
                                        <option value="1" {{ old('duration', isset($destination) ? $destination->duration : '') == '1' ? 'selected' : '' }}>1 Night</option>
                                        <option value="2" {{ old('duration', isset($destination) ? $destination->duration : '') == '2' ? 'selected' : '' }}>2 Nights</option>
                                        <option value="3" {{ old('duration', isset($destination) ? $destination->duration : '') == '3' ? 'selected' : '' }}>3 Nights</option>
                                        <option value="4" {{ old('duration', isset($destination) ? $destination->duration : '') == '4' ? 'selected' : '' }}>4 Nights</option>
                                        <option value="5" {{ old('duration', isset($destination) ? $destination->duration : '') == '5' ? 'selected' : '' }}>5 Nights</option>
                                        <option value="6" {{ old('duration', isset($destination) ? $destination->duration : '') == '6' ? 'selected' : '' }}>6 Nights</option>
                                        <option value="7" {{ old('duration', isset($destination) ? $destination->duration : '') == '7' ? 'selected' : '' }}>7 Nights</option>
                                        <option value="8" {{ old('duration', isset($destination) ? $destination->duration : '') == '8' ? 'selected' : '' }}>8 Nights</option>
                                        <option value="9" {{ old('duration', isset($destination) ? $destination->duration : '') == '9' ? 'selected' : '' }}>9 Nights</option>
                                        <option value="10" {{ old('duration', isset($destination) ? $destination->duration : '') == '10' ? 'selected' : '' }}>10 Nights</option>
                                        <option value="11" {{ old('duration', isset($destination) ? $destination->duration : '') == '11' ? 'selected' : '' }}>11 Nights</option>
                                        <option value="12" {{ old('duration', isset($destination) ? $destination->duration : '') == '12' ? 'selected' : '' }}>12 Nights</option>
                                        <option value="13" {{ old('duration', isset($destination) ? $destination->duration : '') == '13' ? 'selected' : '' }}>13 Nights</option>
                                        <option value="14" {{ old('duration', isset($destination) ? $destination->duration : '') == '14' ? 'selected' : '' }}>14 Nights</option>
                                        <option value="15" {{ old('duration', isset($destination) ? $destination->duration : '') == '15' ? 'selected' : '' }}>15 Nights</option>
                                        <option value="16" {{ old('duration', isset($destination) ? $destination->duration : '') == '16' ? 'selected' : '' }}>16 Nights</option>
                                        <option value="17" {{ old('duration', isset($destination) ? $destination->duration : '') == '17' ? 'selected' : '' }}>17 Nights</option>
                                        <option value="18" {{ old('duration', isset($destination) ? $destination->duration : '') == '18' ? 'selected' : '' }}>18 Nights</option>
                                        <option value="19" {{ old('duration', isset($destination) ? $destination->duration : '') == '19' ? 'selected' : '' }}>19 Nights</option>
                                        <option value="20" {{ old('duration', isset($destination) ? $destination->duration : '') == '20' ? 'selected' : '' }}>20 Nights</option>
                                        </select>
                                    @error('duration')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>
                            <div class="col-sm-12 mx-auto">
                        <table id="option" class="table table-striped">
                            <tbody>
                           @foreach ($d_iternaries as $key => $item)
                            <tr id="item-option-row{{ $key }}">
                                <td style="width:350px"><input type="text" name="item[{{ $key }}][title]"
                                        placeholder="Title" class="form-control"
                                        id="particular{{ $key }}" required value="{{ $item->title }}">
                                </td>
                                <td><textarea name="item[{{ $key }}][text]" placeholder="Text" class="form-control rate" required="">{{ $item->text }}</textarea></td>
                                <td class="text-right"><button type="button"
                                        onclick="$('#item-option-row{{ $key }}').remove();"
                                        data-toggle="tooltip" title="" class="btn btn-danger"
                                        data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
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
                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="companyForm">Save</button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
   
    var item_option_row = {{ count($d_iternaries) }};
    function addItem() {
        if (item_option_row < 50) {
            html = '<tr id="item-option-row' + item_option_row + '">';
            html += '<td style="width:350px"><input type="text" name="item[' + item_option_row +
                '][title]" placeholder="Iternary title" class="form-control" id="content' + item_option_row +
                '" required></td>';
            html += '<td><textarea name="item[' + item_option_row +
                '][text]" placeholder="Iternary text" class="form-control rate" id="rate' + item_option_row +
                '" value="0" required></textarea></td>';
            html += '<td class="text-right"><button type="button" onclick="$(\'#item-option-row' + item_option_row +
                '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
            html += '</tr>';

            $('#option tbody').append(html);

            item_option_row++;
        }
    }
</script>
@endpush
