@extends('layouts.master')
@section('title', 'Long Weekends')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Long Weekends</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Defaults</li>
                        <li class="breadcrumb-item active">Long Weekends</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="text-right mb-2"><a href="{{ route('long-weekends.create') }}" class="btn btn-primary">Add Long
                        Weekend</a></div>
                @if (count($weekends) > 0)
                    <table id="customers" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($weekends as $weekend)
                                <tr>
                                    <td>{{ $weekend->start }}</td>
                                    <td>{{ $weekend->end }}</td>
                                    <td>
                                        <button type="button" class="btn btn-dark dropdown-toggle" data-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fas fa-list"></i>
                                        </button>
                                        <ul class="dropdown-menu text-center">
                                            <a href="{{ route('long-weekends.edit', $weekend->id) }}">
                                                <li class="dropdown-item">Edit</li>
                                            </a>
                                            <a href="javascript:void(0)" onclick="confirmDelete({{ $weekend->id }})">
                                                <li class="dropdown-item">
                                                    Delete
                                                </li>
                                                <form id='delete-form{{ $weekend->id }}'
                                                    action='{{ route('long-weekends.destroy', $weekend->id) }}'
                                                    method='POST'>
                                                    <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                    <input type='hidden' name='_method' value='DELETE'>
                                                </form>
                                            </a>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center">No Long Weekend found.</p>
                @endif
            </div>
        </div>
    </section>


@endsection
@push('scripts')
    @include('layouts.utilities')
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
