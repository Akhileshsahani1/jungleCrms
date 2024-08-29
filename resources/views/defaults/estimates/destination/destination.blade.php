@extends('layouts.master')
@section('title', 'Destination')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Destination</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Defaults</li>
                        <li class="breadcrumb-item active">Destination</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="col-12 col-sm-12">
            <div class="card card-dark card-tabs">
                <div class="card-header p-0 pt-1">
                   Destinattion
                </div>
                <div class="card-body">
                           <div class="row">
                              <div class="col-sm-11 ">
                            
                           </div>
                           <div class="col-sm-1">
                            <a href="javascript:void(0)" class="btn btn-warning modal-destination" data-toggle="modal" data-target="#modal-destination" data-destination="" data-id=""> <i class="fas fa-plus"></i>
                                                        </a>
                           </div>
                           </div>
                            <div class="col-sm-12 mt-2">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Destination</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($destinations as $destination)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $destination->destination }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-destination" data-toggle="modal" data-target="#modal-edit-destination" data-destination="{{ $destination->destination }}" data-id="{{ $destination->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $destination->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $destination->id }}' action='{{route('estimate-destinations.destroy', $destination->id)}}' method='POST'>
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
    </section>
<div class="modal fade" id="modal-destination">
    <div class="modal-dialog modal-destination">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Destination</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="cabForm" action="{{ route('estimate-destinations.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="content">Destination</label>
                        <textarea class="form-control" id="destination" name="destination" placeholder="Enter destination here" rows="1" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="cabForm">Save</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit-destination">
    <div class="modal-dialog modal-edit-destination">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Destination</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="updatecabForm" action="{{ route('estimate-destinations.store') }}">
                    @csrf
                    <input type="hidden" value="" name="id" id="destination_id">
                    <div class="form-group">
                        <label for="edit_cab_destination">Destination</label>
                        <textarea class="form-control" id="edit_destination" name="destination" placeholder="Enter Destination here" rows="1" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="updatecabForm">Update</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(".edit-destination").click(function () {
            var id = $(this).data('id');
            var destination = $(this).data('destination');
            $('#edit_destination').val(destination);
            $('#destination_id').val(id);
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
