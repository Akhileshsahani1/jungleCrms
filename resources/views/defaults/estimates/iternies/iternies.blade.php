@extends('layouts.master')
@section('title', 'Iternaries')
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
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-11">
                                </div>
                                <div class="col-sm-1">
                                    <a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-safari">Add</a>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-5">
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
                                            <td>{{ $destination->state }}</td>
                                            <td><button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fas fa-list"></i>
                                    </button> <ul class="dropdown-menu text-center">
                                   
                                     <a href="{{ route('iternary.show',$destination->id) }}" target="_blank">
                                            <li class="dropdown-item">Show</li>
                                        </a>
                                      <a href="{{ route('iternary.add',$destination->id) }}" target="_blank">
                                            <li class="dropdown-item">Add</li>
                                      </a>
                                    <a href="javascript:void(0)" onclick="confirmDelete({{ $destination->id }})">
                                            <li class="dropdown-item">
                                                Delete
                                            </li>
                                            <form id='delete-form{{ $destination->id }}'
                                                action='{{ route('iternary.destroy', $destination->id) }}' method='POST'>
                                                <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                <input type='hidden' name='_method' value='DELETE'>
                                            </form>
                                        </a>
                                     </ul></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
         </div>
        
    </section>
    <div class="modal fade" id="modal-safari">
    <div class="modal-dialog modal-safari">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Destination</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="safariForm" action="{{ route('iternary.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="content">Destination</label>
                        <input type="text" class="form-control" id="content" name="state" placeholder="Destination" rows="3" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="safariForm">Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
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
