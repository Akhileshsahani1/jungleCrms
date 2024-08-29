@extends('layouts.master')
@section('title', 'Destination Iternaries')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Destination Iternaries</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Defaults</li>
                        <li class="breadcrumb-item active">Destination Iternaries</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="col-12 col-sm-12">
                            <div class="col-sm-12">
                            	<div class="row">
                            		<div class="col-sm-10">
                                <h4 class="text-danger">{{ $destination->state }}</h4>
                                </div>
                                <div class="col-sm-2">
                                <a href="{{ route('iternary.index') }}" class="btn btn-dark">Back</a>
                                </div>
                                </div>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach ($d_iternaries as $iternary)
                                         <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $iternary->name }}</td>
                                            <td>
                                            <div class="btn-group">
					                        <a href="{{ route('iternary.edit', $iternary->id) }}" class="btn btn-warning"> <i class="fas fa-pen"></i> </a>
					                        <button type="button" onclick="confirmDelete({{$iternary->id}})" class="btn btn-danger"><i class="fas fa-trash"></i> </button>
					                        <form id='delete-form{{$iternary->id}}' action='{{route('iternary.delete', $iternary->id)}}' method='POST'>
					                            <input type='hidden' name='_token' value='{{ csrf_token()}}'>
					                            <input type='hidden' name='_method' value='DELETE'>
					                        </form>
					                        </div>
					                        </div>
                                        </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
         </div>
        
    </section>
   

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
