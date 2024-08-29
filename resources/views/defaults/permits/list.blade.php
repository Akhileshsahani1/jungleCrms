@extends('layouts.master')
@section('title', 'Permit Rate')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Permit Rate</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Defaults</li>
                        <li class="breadcrumb-item active">Permit Rate</li>
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
                                href="#custom-tabs-one-tadoba" role="tab" aria-controls="custom-tabs-one-profile"
                                aria-selected="false">Tadoba  National Park</a>
                        </li>

                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-gir" role="tabpanel"
                            aria-labelledby="custom-tabs-one-gir-tab">
                            <div class="col-sm-12">
                                <strong>Permit Rate</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary"
                                        data-toggle="modal" data-target="#modal-rate">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Sanctuary</th>
                                            <th>Type</th>
                                            <th>Nationality</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gir_rates as $rate)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                @if ($rate->sanctuary == 'gir')
                                                    <td>Gir National Park</td>
                                                @elseif($rate->sanctuary == 'jim')
                                                    <td>Jim Corbett National Park</td>
                                                @elseif($rate->sanctuary == 'ranthambore')
                                                    <td>Ranthambore National Park</td>
                                                @endif
                                                <td>{{ ucfirst($rate->type) }}</td>
                                                <td>{{ ucfirst($rate->nationality) }}</td>
                                                <td>{{ $rate->price }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-rate"
                                                            data-toggle="modal" data-target="#modal-edit-rate"
                                                            data-type="{{ $rate->type }}" data-id="{{ $rate->id }}"
                                                            data-sanctuary="{{ $rate->sanctuary }}"
                                                            data-nationality="{{ $rate->nationality }}"
                                                            data-price="{{ $rate->price }}"> <i
                                                                class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $rate->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $rate->id }}'
                                                            action='{{ route('permit.destroy', $rate->id) }}'
                                                            method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
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
                                <strong>Permit Rate</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary"
                                        data-toggle="modal" data-target="#modal-rate">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Sanctuary</th>
                                            <th>Type</th>
                                            <th>Nationality</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($jim_rates as $rate)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                @if ($rate->sanctuary == 'gir')
                                                    <td>Gir National Park</td>
                                                @elseif($rate->sanctuary == 'jim')
                                                    <td>Jim Corbett National Park</td>
                                                @elseif($rate->sanctuary == 'ranthambore')
                                                    <td>Ranthambore National Park</td>
                                                @endif
                                                <td>{{ ucfirst($rate->type) }}</td>
                                                <td>{{ ucfirst($rate->nationality) }}</td>
                                                <td>{{ $rate->price }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-rate"
                                                            data-toggle="modal" data-target="#modal-edit-rate"
                                                            data-type="{{ $rate->type }}" data-id="{{ $rate->id }}"
                                                            data-sanctuary="{{ $rate->sanctuary }}"
                                                            data-nationality="{{ $rate->nationality }}"
                                                            data-price="{{ $rate->price }}"> <i
                                                                class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $rate->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $rate->id }}'
                                                            action='{{ route('permit.destroy', $rate->id) }}'
                                                            method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
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
                                <strong>Permit Rate</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary"
                                        data-toggle="modal" data-target="#modal-rate">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Sanctuary</th>
                                            <th>Type</th>
                                            <th>Nationality</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($ranthambore_rates as $rate)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                @if ($rate->sanctuary == 'gir')
                                                    <td>Gir National Park</td>
                                                @elseif($rate->sanctuary == 'jim')
                                                    <td>Jim Corbett National Park</td>
                                                @elseif($rate->sanctuary == 'ranthambore')
                                                    <td>Ranthambore National Park</td>
                                                @endif
                                                <td>{{ ucfirst($rate->type) }}</td>
                                                <td>{{ ucfirst($rate->nationality) }}</td>
                                                <td>{{ $rate->price }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-rate"
                                                            data-toggle="modal" data-target="#modal-edit-rate"
                                                            data-type="{{ $rate->type }}" data-id="{{ $rate->id }}"
                                                            data-sanctuary="{{ $rate->sanctuary }}"
                                                            data-nationality="{{ $rate->nationality }}"
                                                            data-price="{{ $rate->price }}"> <i
                                                                class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $rate->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $rate->id }}'
                                                            action='{{ route('permit.destroy', $rate->id) }}'
                                                            method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
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
                                <strong>Permit Rate</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary"
                                        data-toggle="modal" data-target="#modal-rate">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Sanctuary</th>
                                            <th>Type</th>
                                            <th>Nationality</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tadoba_rates as $rate)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>Tadoba National Park</td>
                                                <td>{{ ucfirst($rate->type) }}</td>
                                                <td>{{ ucfirst($rate->nationality) }}</td>
                                                <td>{{ $rate->price }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-rate"
                                                            data-toggle="modal" data-target="#modal-edit-rate"
                                                            data-type="{{ $rate->type }}" data-id="{{ $rate->id }}"
                                                            data-sanctuary="{{ $rate->sanctuary }}"
                                                            data-nationality="{{ $rate->nationality }}"
                                                            data-price="{{ $rate->price }}"> <i
                                                                class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $rate->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $rate->id }}'
                                                            action='{{ route('permit.destroy', $rate->id) }}'
                                                            method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
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
    @include('defaults.permits.modal')
@endsection
@push('scripts')
   <script type="text/javascript">
    $("#custom-tabs-one-{{ $type }}-tab").trigger('click');
   </script>
    <script>
        $(".edit-rate").click(function() {
            var id = $(this).data('id');
            var sanctuary = $(this).data('sanctuary');
            var type = $(this).data('type');
            var nationality = $(this).data('nationality');
            var price = $(this).data('price');

            $("#edit_sanctuary").val(sanctuary).change();
            $('#edit_type').val(type);
            $('#edit_nationality').val(nationality);
            $('#edit_price').val(price);
            $('#rate_id').val(id);
        });
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function confirmDelete(no) {
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
                    document.getElementById('delete-form' + no).submit();
                }
            })
        };
    </script>
@endpush
