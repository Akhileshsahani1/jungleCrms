@extends('layouts.master')
@section('title', 'Create Hotel Room')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Hotel Room</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}">Hotels</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('rooms.show', $hotel->id) }}">Rooms</a></li>
                        <li class="breadcrumb-item active">Create Hotel Room</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $hotel->name }}</h3>
                <div class="card-tools">
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                    <button type="submit" class="btn btn-success" form="RoomSave">Save</button>
                </div>
            </div>
            <div class="card-body">
                <form id="RoomSave" method="POST" action="{{ route('rooms.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="room">Room room*</label>
                                <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                                <input type="text" class="form-control" id="room" name="room" placeholder="Room name"
                                    value="{{ old('room') }}">
                                @error('name')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Room Services</h3>
                                    </div>
                                    <div class="card-body p-0">
                                        <table id="service" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Service</th>
                                                    <th>Base Price</th>
                                                    <th>Adult(Extra Bed)</th>
                                                    <th>Child(Extra Bed)</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr id="service-row0">
                                                    <td style="width:350px"><input type="text" name="service[0][service]" value="Room with Breakfast" placeholder="Service" class="form-control" id="service0" required></td>
                                                    <td>
                                                        <input type="text" name="service[0][price]" placeholder="Normal Price" class="form-control" id="price0" required>
                                                        <input type="text" name="service[0][weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="weekend_price0" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="service[0][extra_adult_price]" placeholder="Normal Price" class="form-control" id="extra_adult_price0" required>
                                                        <input type="text" name="service[0][extra_adult_weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="extra_adult_weekend_price0" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="service[0][extra_child_price]" placeholder="Normal Price" class="form-control" id="extra_child_price0" required>
                                                        <input type="text" name="service[0][extra_child_weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="extra_child_weekend_price0" required>
                                                    </td>
                                                    <td class="text-right"><button type="button" onclick="$('#service-row0').remove();" data-toggle="tooltip" title="" class="btn btn-danger ms-btn-icon btn-danger" data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button></td>
                                                </tr>
                                                <tr id="service-row1">
                                                    <td style="width:350px"><input type="text" name="service[1][service]" value="Room with Breakfast and Dinner" placeholder="Service" class="form-control" id="service1" required></td>
                                                    <td>
                                                        <input type="text" name="service[1][price]" placeholder="Normal Price" class="form-control" id="price1" required>
                                                        <input type="text" name="service[1][weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="weekend_price1" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="service[1][extra_adult_price]" placeholder="Normal Price" class="form-control" id="extra_adult_price1" required>
                                                        <input type="text" name="service[1][extra_adult_weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="extra_adult_weekend_price1" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="service[1][extra_child_price]" placeholder="Normal Price" class="form-control" id="extra_child_price" required>
                                                        <input type="text" name="service[1][extra_child_weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="extra_child_weekend_price1" required>
                                                    </td>
                                                    <td class="text-right"><button type="button" onclick="$('#service-row1').remove();" data-toggle="tooltip" title="" class="btn btn-danger ms-btn-icon btn-danger" data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button></td>
                                                </tr>
                                                <tr id="service-row2">
                                                    <td style="width:350px"><input type="text" name="service[2][service]" value="Room with Breakfast, Lunch and Dinner" placeholder="Service" class="form-control" id="service2" required></td>
                                                    <td>
                                                        <input type="text" name="service[2][price]" placeholder="Normal Price" class="form-control" id="price2" required>
                                                        <input type="text" name="service[2][weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="weekend_price2" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="service[2][extra_adult_price]" placeholder="Normal Price" class="form-control" id="extra_adult_price2" required>
                                                        <input type="text" name="service[2][extra_adult_weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="extra_adult_weekend_price2" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="service[2][extra_child_price]" placeholder="Normal Price" class="form-control" id="extra_child_price2" required>
                                                        <input type="text" name="service[2][extra_child_weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="extra_child_weekend_price2" required>
                                                    </td>
                                                    <td class="text-right"><button type="button" onclick="$('#service-row2').remove();" data-toggle="tooltip" title="" class="btn btn-danger ms-btn-icon btn-danger" data-original-title="Remove Button"><i class="fas fa-minus-circle"></i></button></td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-right" colspan="5"><button type="button" onclick="addService();" data-toggle="tooltip" title="" class="btn btn-primary ms-btn-icon btn-secondary addItems" data-original-title="Add Image"><i class="fas fa-plus-circle"></i></button></td>
                                                  </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="RoomSave">Save</button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script>
        function preview_image() {
            var total_file = document.getElementById("images").files.length;
            for (var i = 0; i < total_file; i++) {
                $('#preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) +
                    "' width=150px' height='150px' style='margin:10px;'>");
            }
        }
    </script>
    <script>
        var row = 3;

            function addService() {
                if(row < 50){
                    html = '<tr id="service-row' + row + '">';
                    html += ' <td style="width:350px"><input type="text" name="service['+ row +'][service]" placeholder="Service" class="form-control" id="service'+ row +'" required/></td>';
                    html += ' <td><input type="text" name="service['+ row +'][price]" placeholder="Normal Price" class="form-control" id="price'+ row +'" required/><input type="text" name="service['+ row +'][weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="weekend_price'+ row +'" required/></td>';
                    html += ' <td><input type="text" name="service['+ row +'][extra_adult_price]" placeholder="Normal Price" class="form-control" id="extra_adult_price'+ row +'" required/><input type="text" name="service['+ row +'][extra_adult_weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="extra_adult_weekend_price'+ row +'" required/></td>';
                    html += ' <td><input type="text" name="service['+ row +'][extra_child_price]" placeholder="Normal Price" class="form-control" id="extra_child_price'+ row +'" required/><input type="text" name="service['+ row +'][extra_child_weekend_price]" placeholder="Weekend Price" class="form-control mt-2" id="extra_child_weekend_price'+ row +'" required/></td>';

                    html += ' <td class="text-left"><button type="button" onclick="$(\'#service-row' + row + '\').remove();" data-toggle="tooltip" title="Remove Button" class="btn btn-danger ms-btn-icon btn-danger"><i class="fas fa-minus-circle"></i></button></td>';
                    html += '</tr>';

                    $('#service tbody').append(html);

                    row++;
                }
            }
    </script>
@endpush
