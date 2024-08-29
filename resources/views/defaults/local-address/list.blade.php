@extends('layouts.master')
@section('title', 'Local Address')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Local Address</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Defaults</li>
                        <li class="breadcrumb-item active">Local Address</li>
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
                            <a class="nav-link" id="custom-tabs-one-dailytour-tab" data-toggle="pill"
                                href="#custom-tabs-one-dailytour" role="tab" aria-controls="custom-tabs-one-messages"
                                aria-selected="false">Daily Tour </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-gir" role="tabpanel"
                            aria-labelledby="custom-tabs-one-gir-tab">
                            <div class="col-sm-12">
                                <strong>Local Address</strong>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>Id</th>
                                            <th>Company Name</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($gir_address as $address)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucfirst($address->name) }}</td>
                                                <td>
                                                    Address 1 <span class="float-right"> {{ $address->address_1 }}</span><br>
                                                    Address 2 <span class="float-right"> {{ $address->address_2 }}</span><br>
                                                    State <span class="float-right"> {{ $address->state }}</span><br>
                                                    Pincode <span class="float-right"> {{ $address->pincode }}</span><br>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-address"
                                                            data-toggle="modal" data-target="#modal-edit-address"
                                                            data-name="{{ $address->name }}" data-id="{{ $address->id }}"
                                                            data-sanctuary="{{ $address->sanctuary }}"
                                                            data-address1="{{ $address->address_1 }}"
                                                            data-address2="{{ $address->address_2 }}"
                                                            data-state="{{ $address->state }}"
                                                            data-pincode="{{ $address->pincode }}"> <i
                                                                class="fas fa-pen"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                         @empty
                                          <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-address"
                                                            data-toggle="modal" data-target="#modal-edit-address"
                                                            data-name="" data-id=""
                                                            data-sanctuary="gir"
                                                            data-address1=""
                                                            data-address2=""
                                                            data-state=""
                                                            data-pincode="">Create Address
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-jim" role="tabpanel"
                            aria-labelledby="custom-tabs-one-jim-tab">
                            <div class="col-sm-12">
                                <strong>Local Address</strong>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>Id</th>
                                            <th>Company Name</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($jim_address as $address)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucfirst($address->name) }}</td>
                                                <td>
                                                    Address 1 <span class="float-right"> {{ $address->address_1 }}</span><br>
                                                    Address 2 <span class="float-right"> {{ $address->address_2 }}</span><br>
                                                    State <span class="float-right"> {{ $address->state }}</span><br>
                                                    Pincode <span class="float-right"> {{ $address->pincode }}</span><br>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-address"
                                                            data-toggle="modal" data-target="#modal-edit-address"
                                                            data-name="{{ $address->name }}" data-id="{{ $address->id }}"
                                                            data-sanctuary="{{ $address->sanctuary }}"
                                                            data-address1="{{ $address->address_1 }}"
                                                            data-address2="{{ $address->address_2 }}"
                                                            data-state="{{ $address->state }}"
                                                            data-pincode="{{ $address->pincode }}"> <i
                                                                class="fas fa-pen"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                         @empty
                                          <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-address"
                                                            data-toggle="modal" data-target="#modal-edit-address"
                                                            data-name="" data-id=""
                                                            data-sanctuary="jim"
                                                            data-address1=""
                                                            data-address2=""
                                                            data-state=""
                                                            data-pincode="">Create Address
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-ranthambore" role="tabpanel"
                            aria-labelledby="custom-tabs-one-ranthambore-tab">
                            <div class="col-sm-12">
                                <strong>Local Address</strong>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>Id</th>
                                            <th>Company Name</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($ranthambore_address as $address)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucfirst($address->name) }}</td>
                                                <td>
                                                    Address 1 <span class="float-right"> {{ $address->address_1 }}</span><br>
                                                    Address 2 <span class="float-right"> {{ $address->address_2 }}</span><br>
                                                    State <span class="float-right"> {{ $address->state }}</span><br>
                                                    Pincode <span class="float-right"> {{ $address->pincode }}</span><br>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-address"
                                                            data-toggle="modal" data-target="#modal-edit-address"
                                                            data-name="{{ $address->name }}" data-id="{{ $address->id }}"
                                                            data-sanctuary="{{ $address->sanctuary }}"
                                                            data-address1="{{ $address->address_1 }}"
                                                            data-address2="{{ $address->address_2 }}"
                                                            data-state="{{ $address->state }}"
                                                            data-pincode="{{ $address->pincode }}"> <i
                                                                class="fas fa-pen"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                          <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-address"
                                                            data-toggle="modal" data-target="#modal-edit-address"
                                                            data-name="" data-id=""
                                                            data-sanctuary="ranthambore"
                                                            data-address1=""
                                                            data-address2=""
                                                            data-state=""
                                                            data-pincode="">Create Address
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                         <div class="tab-pane fade" id="custom-tabs-one-tadoba" role="tabpanel"
                            aria-labelledby="custom-tabs-one-tadoba-tab">
                            <div class="col-sm-12">
                                <strong>Local Address</strong>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>Id</th>
                                            <th>Company Name</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tadoba_address as $address)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucfirst($address->name) }}</td>
                                                <td>
                                                    Address 1 <span class="float-right"> {{ $address->address_1 }}</span><br>
                                                    Address 2 <span class="float-right"> {{ $address->address_2 }}</span><br>
                                                    State <span class="float-right"> {{ $address->state }}</span><br>
                                                    Pincode <span class="float-right"> {{ $address->pincode }}</span><br>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-address"
                                                            data-toggle="modal" data-target="#modal-edit-address"
                                                            data-name="{{ $address->name }}" data-id="{{ $address->id }}"
                                                            data-sanctuary="{{ $address->sanctuary }}"
                                                            data-address1="{{ $address->address_1 }}"
                                                            data-address2="{{ $address->address_2 }}"
                                                            data-state="{{ $address->state }}"
                                                            data-pincode="{{ $address->pincode }}"> <i
                                                                class="fas fa-pen"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                          <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-address"
                                                            data-toggle="modal" data-target="#modal-edit-address"
                                                            data-name="" data-id=""
                                                            data-sanctuary="tadoba"
                                                            data-address1=""
                                                            data-address2=""
                                                            data-state=""
                                                            data-pincode="">Create Address
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                         <div class="tab-pane fade" id="custom-tabs-one-dailytour" role="tabpanel"
                            aria-labelledby="custom-tabs-one-dailytour-tab">
                            <div class="col-sm-12">
                                <strong>Local Address</strong>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                        <tr>
                                            <th>Id</th>
                                            <th>Company Name</th>
                                            <th>Address</th>
                                            <th>Action</th>
                                        </tr>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($dailytour_address as $address)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ ucfirst($address->name) }}</td>
                                                <td>
                                                    Address 1 <span class="float-right"> {{ $address->address_1 }}</span><br>
                                                    Address 2 <span class="float-right"> {{ $address->address_2 }}</span><br>
                                                    State <span class="float-right"> {{ $address->state }}</span><br>
                                                    Pincode <span class="float-right"> {{ $address->pincode }}</span><br>
                                                </td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-address"
                                                            data-toggle="modal" data-target="#modal-edit-address"
                                                            data-name="{{ $address->name }}" data-id="{{ $address->id }}"
                                                            data-sanctuary="{{ $address->sanctuary }}"
                                                            data-address1="{{ $address->address_1 }}"
                                                            data-address2="{{ $address->address_2 }}"
                                                            data-state="{{ $address->state }}"
                                                            data-pincode="{{ $address->pincode }}"> <i
                                                                class="fas fa-pen"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                          <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-address"
                                                            data-toggle="modal" data-target="#modal-edit-address"
                                                            data-name="" data-id=""
                                                            data-sanctuary="dailytour"
                                                            data-address1=""
                                                            data-address2=""
                                                            data-state=""
                                                            data-pincode="">Create Address
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('defaults.local-address.modal')
@endsection
@push('scripts')
    <script type="text/javascript">
    $("#custom-tabs-one-{{ $type }}-tab").trigger('click');
   </script>
    <script>
        $(".edit-address").click(function() {
            var id = $(this).data('id');
            var name = $(this).data('name');
            var address1 = $(this).data('address1');
            var address2 = $(this).data('address2');
            var state = $(this).data('state');
            var sanctuary = $(this).data('sanctuary');
            var pincode = $(this).data('pincode');

            $('#edit_name').val(name);
            $("#edit_address1").val(address1).change();
            $('#edit_address2').val(address2);
            $('#edit_state').val(state);
            $('#edit_pincode').val(pincode);
            $('#edit_sanctuary').val(sanctuary);
            (id)?$('#address_id').val(id):$('#address_id').remove();
            
        });
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
