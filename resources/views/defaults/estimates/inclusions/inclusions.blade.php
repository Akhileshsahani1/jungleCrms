@extends('layouts.master')
@section('title', 'Inclusions')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inclusions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Defaults</li>
                        <li class="breadcrumb-item active">Inclusions</li>
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
                                <strong>Cab Inclusions</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-cab">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cab_inclusions as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-cab" data-toggle="modal" data-target="#modal-edit-cab" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('inclusions.destroy', $term->id)}}' method='POST'>
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
                        <div class="tab-pane fade" id="custom-tabs-one-hotel" role="tabpanel"
                            aria-labelledby="custom-tabs-one-hotel-tab">
                            <div class="col-sm-12">
                                <strong>Hotel Inclusions</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-hotel">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Normal Inclusions</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hotel_normal_inclusions as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>{{ ucfirst($term->filter) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-hotel" data-toggle="modal" data-target="#modal-edit-hotel" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('inclusions.destroy', $term->id)}}' method='POST'>
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
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Weekend Inclusions</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hotel_weekend_inclusions as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>{{ ucfirst($term->filter) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-hotel" data-toggle="modal" data-target="#modal-edit-hotel" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('inclusions.destroy', $term->id)}}' method='POST'>
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
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Festival Inclusions</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hotel_festival_inclusions as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>{{ ucfirst($term->filter) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-hotel" data-toggle="modal" data-target="#modal-edit-hotel" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('inclusions.destroy', $term->id)}}' method='POST'>
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
                        <div class="tab-pane fade" id="custom-tabs-one-safari" role="tabpanel"
                            aria-labelledby="custom-tabs-one-safari-tab">
                            <div class="col-sm-12">
                                <strong>Safari Inclusions</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-safari">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Gir Inclusions</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($safari_gir_inclusions as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>{{ ucfirst($term->filter) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-safari" data-toggle="modal" data-target="#modal-edit-safari" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('inclusions.destroy', $term->id)}}' method='POST'>
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
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Jim Corbett Inclusions</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($safari_jim_inclusions as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>Jim Corbett</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-safari" data-toggle="modal" data-target="#modal-edit-safari" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('inclusions.destroy', $term->id)}}' method='POST'>
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
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Ranthambore Inclusions</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($safari_ran_inclusions as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>Ranthambore</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-safari" data-toggle="modal" data-target="#modal-edit-safari" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('inclusions.destroy', $term->id)}}' method='POST'>
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
                             <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Tadoba Inclusions</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($safari_tadoba_inclusions as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>Tadoba</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-safari" data-toggle="modal" data-target="#modal-edit-safari" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('inclusions.destroy', $term->id)}}' method='POST'>
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
                        <div class="tab-pane fade" id="custom-tabs-one-tour" role="tabpanel"
                            aria-labelledby="custom-tabs-one-tour-tab">
                            <div class="col-sm-12">
                                <strong>Tour Inclusions</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-tour">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tour_inclusions as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-tour" data-toggle="modal" data-target="#modal-edit-tour" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i>
                                                        </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('inclusions.destroy', $term->id)}}' method='POST'>
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
                        <div class="tab-pane fade" id="custom-tabs-one-package" role="tabpanel"
                            aria-labelledby="custom-tabs-one-package-tab">
                            <div class="col-sm-12">
                                <strong>Package Inclusions</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-package">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                 @foreach ($package_inclusions as $destination)
                                     <h4 class="text-info text-center">{{ $destination->destination }}</h4>
                                        <table class="table table-bordered">

                                            <thead>
                                                <tr>
                                                    <th style="width: 10px">#</th>
                                                    <th>Content</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                       
                                        
                                        
                                           @if($destination->inclusions)
                                            @foreach($destination->inclusions as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-package" data-toggle="modal" data-target="#modal-edit-package" data-content="{{ $term->content }}" data-destination-id="{{ $term->destination_id }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i>
                                                        </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('inclusions.destroy', $term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            @endforeach
                                             @endif
                                       
                                    </tbody>
                                </table>
                                 @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('defaults.estimates.inclusions.cab')
    @include('defaults.estimates.inclusions.hotel')
    @include('defaults.estimates.inclusions.safari')
    @include('defaults.estimates.inclusions.tour')
    @include('defaults.estimates.inclusions.package')
@endsection
@push('scripts')
<script type="text/javascript">
    $("#custom-tabs-one-{{ $type }}-tab").trigger('click');
</script>
<script>
    $(".edit-cab").click(function () {
            var id = $(this).data('id');
            var content = $(this).data('content');
            $('#edit_cab_content').val(content);
            $('#cab_term_id').val(id);
        });
</script>
<script>
    $(".edit-hotel").click(function () {
            var id = $(this).data('id');
            var content = $(this).data('content');
            var filter = $(this).data('filter');
            $('#edit_hotel_content').val(content);
            $('#hotel_term_id').val(id);
            $("#edit_hotel_filter").val(filter).change();
        });
</script>
<script>
    $(".edit-safari").click(function () {
            var id = $(this).data('id');
            var content = $(this).data('content');
            var filter = $(this).data('filter');
            $('#edit_safari_content').val(content);
            $('#safari_term_id').val(id);
            $("#edit_safari_filter").val(filter).change();
        });
</script>
<script>
    $(".edit-tour").click(function () {
            var id = $(this).data('id');
            var content = $(this).data('content');
            $('#edit_tour_content').val(content);
            $('#tour_term_id').val(id);
        });
</script>
<script>
    $(".edit-package").click(function () {
            var id = $(this).data('id');
            var content = $(this).data('content');
            var destination_id = $(this).data('destination-id');
            $('#edit_destination_id').val(destination_id);
            $('#edit_package_content').val(content);
            $('#package_term_id').val(id);
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
