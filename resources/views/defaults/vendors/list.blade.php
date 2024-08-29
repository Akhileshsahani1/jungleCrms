@extends('layouts.master')
@section('title', 'Vendors')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Vendors</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Defaults</li>
                        <li class="breadcrumb-item active">Vendors</li>
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
                            <a class="nav-link active" id="custom-tabs-one-gir-tab" data-toggle="pill"
                                href="#custom-tabs-one-gir" role="tab" aria-controls="custom-tabs-one-home"
                                aria-selected="true">Gir National Park</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-jim-tab" data-toggle="pill"
                                href="#custom-tabs-one-jim" role="tab" aria-controls="custom-tabs-one-profile"
                                aria-selected="false">Jim Corbett National Park</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-ranthambore-tab" data-toggle="pill"
                                href="#custom-tabs-one-ranthambore" role="tab" aria-controls="custom-tabs-one-messages"
                                aria-selected="false">Ranthambore National Park</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-tadoba-tab" data-toggle="pill"
                                href="#custom-tabs-one-tadoba" role="tab" aria-controls="custom-tabs-one-messages"
                                aria-selected="false">Tadoba National Park</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-cab-tab" data-toggle="pill"
                                href="#custom-tabs-one-cab" role="tab" aria-controls="custom-tabs-one-messages"
                                aria-selected="false">Cab</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-gir" role="tabpanel"
                            aria-labelledby="custom-tabs-one-gir-tab">
                            <div class="col-sm-12">
                                <strong>Vendors</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-vendor">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Sanctuary</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Alternate Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gir_vendors as $vendor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $vendor->name }}</td>
                                                @if($vendor->sanctuary == 'gir')
                                                <td>Gir National Park</td>
                                                @elseif($vendor->sanctuary == 'jim')
                                                <td>Jim Corbett National Park</td>
                                                @elseif($vendor->sanctuary == 'ranthambore')
                                                <td>Ranthambore National Park</td>
                                                @endif
                                                <td>{{ $vendor->email }}</td>
                                                <td>{{ $vendor->phone }}</td>
                                                <td>{{ $vendor->alternate }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-vendor" data-toggle="modal" data-target="#modal-edit-vendor" data-name="{{ $vendor->name }}" data-id="{{ $vendor->id }}" data-sanctuary="{{ $vendor->sanctuary }}" data-email="{{ $vendor->email }}" data-phone="{{ $vendor->phone }}" data-alternate="{{ $vendor->alternate }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $vendor->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $vendor->id }}' action='{{route('vendor.destroy', $vendor->id)}}' method='POST'>
                                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-jim" role="tabpanel"
                            aria-labelledby="custom-tabs-one-jim-tab">
                            <div class="col-sm-12">
                                <strong>Vendors</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-vendor">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Sanctuary</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Alternate Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jim_vendors as $vendor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $vendor->name }}</td>
                                                @if($vendor->sanctuary == 'gir')
                                                <td>Gir National Park</td>
                                                @elseif($vendor->sanctuary == 'jim')
                                                <td>Jim Corbett National Park</td>
                                                @elseif($vendor->sanctuary == 'ranthambore')
                                                <td>Ranthambore National Park</td>
                                                @endif
                                                <td>{{ $vendor->email }}</td>
                                                <td>{{ $vendor->phone }}</td>
                                                <td>{{ $vendor->alternate }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-vendor" data-toggle="modal" data-target="#modal-edit-vendor" data-name="{{ $vendor->name }}" data-id="{{ $vendor->id }}" data-sanctuary="{{ $vendor->sanctuary }}" data-email="{{ $vendor->email }}" data-phone="{{ $vendor->phone }}" data-alternate="{{ $vendor->alternate }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $vendor->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $vendor->id }}' action='{{route('vendor.destroy', $vendor->id)}}' method='POST'>
                                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-ranthambore" role="tabpanel"
                            aria-labelledby="custom-tabs-one-ranthambore-tab">
                            <div class="col-sm-12">
                                <strong>Vendors</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-vendor">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Sanctuary</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Alternate Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ranthambore_vendors as $vendor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $vendor->name }}</td>
                                                @if($vendor->sanctuary == 'gir')
                                                <td>Gir National Park</td>
                                                @elseif($vendor->sanctuary == 'jim')
                                                <td>Jim Corbett National Park</td>
                                                @elseif($vendor->sanctuary == 'ranthambore')
                                                <td>Ranthambore National Park</td>
                                                @endif
                                                <td>{{ $vendor->email }}</td>
                                                <td>{{ $vendor->phone }}</td>
                                                <td>{{ $vendor->alternate }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-vendor" data-toggle="modal" data-target="#modal-edit-vendor" data-name="{{ $vendor->name }}" data-id="{{ $vendor->id }}" data-sanctuary="{{ $vendor->sanctuary }}" data-email="{{ $vendor->email }}" data-phone="{{ $vendor->phone }}" data-alternate="{{ $vendor->alternate }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $vendor->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $vendor->id }}' action='{{route('vendor.destroy', $vendor->id)}}' method='POST'>
                                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                          <div class="tab-pane fade" id="custom-tabs-one-tadoba" role="tabpanel"
                            aria-labelledby="custom-tabs-one-tadoba-tab">
                            <div class="col-sm-12">
                                <strong>Cabs</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-vendor">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>           
                                            <th>Sanctuary</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Alternate Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tadoba_vendors as $vendor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $vendor->name }}</td>                                               <td>Tadoba National Park</td>
                                                <td>{{ $vendor->email }}</td>
                                                <td>{{ $vendor->phone }}</td>
                                                <td>{{ $vendor->alternate }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-vendor" data-toggle="modal" data-target="#modal-edit-vendor" data-name="{{ $vendor->name }}" data-id="{{ $vendor->id }}" data-sanctuary="{{ $vendor->sanctuary }}" data-email="{{ $vendor->email }}" data-phone="{{ $vendor->phone }}" data-alternate="{{ $vendor->alternate }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $vendor->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $vendor->id }}' action='{{route('vendor.destroy', $vendor->id)}}' method='POST'>
                                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-cab" role="tabpanel"
                            aria-labelledby="custom-tabs-one-cab-tab">
                            <div class="col-sm-12">
                                <strong>Cabs</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-vendor">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>                                           
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Alternate Phone</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cab_vendors as $vendor)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $vendor->name }}</td>                                               
                                                <td>{{ $vendor->email }}</td>
                                                <td>{{ $vendor->phone }}</td>
                                                <td>{{ $vendor->alternate }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-vendor" data-toggle="modal" data-target="#modal-edit-vendor" data-name="{{ $vendor->name }}" data-id="{{ $vendor->id }}" data-sanctuary="{{ $vendor->sanctuary }}" data-email="{{ $vendor->email }}" data-phone="{{ $vendor->phone }}" data-alternate="{{ $vendor->alternate }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $vendor->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $vendor->id }}' action='{{route('vendor.destroy', $vendor->id)}}' method='POST'>
                                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
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
    </section>
    @include('defaults.vendors.modal')
@endsection
@push('scripts')
<script type="text/javascript">
    $("#custom-tabs-one-{{ $type }}-tab").trigger('click');
</script>
<script>
    $(".edit-vendor").click(function () {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var sanctuary = $(this).data('sanctuary');
            var email = $(this).data('email');
            var phone = $(this).data('phone');
            var alternate = $(this).data('alternate');

            $('#edit_name').val(name);
            $("#edit_sanctuary").val(sanctuary).change();
            $('#edit_email').val(email);
            $('#edit_phone').val(phone);
            $('#edit_alternate').val(alternate);
            $('#vendor_id').val(id);
        });
</script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function confirmDelete(no){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form'+no).submit();
            }
        })
    };
</script>

@endpush
