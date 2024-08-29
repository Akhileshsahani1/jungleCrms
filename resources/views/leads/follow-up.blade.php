@extends('layouts.master')
@section('title', 'Follow Up History')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Follow Up History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Leads</li>
                        <li class="breadcrumb-item active">Follow Up History</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="text-right mb-2"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" class="btn btn-primary">Add Follow Up</a>
                </div>
                @if (count($follow_ups) > 0)
                    <table id="customers" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Follow Up</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($follow_ups as $follow_up)
                                <tr>
                                    <td>
                                        <span class="right badge badge-danger">{{ \Carbon\Carbon::parse($follow_up->datetime)->format('d-m-Y h:i A') }}</span>
                                        
                                        <br>
                                        {!! $follow_up->comment !!}
                                    </td>
                                    <td>
                                        @if($follow_up->done == 1)
                                            <button class="btn btn-sm btn-success">Done</button>
                                       @elseif(\Carbon\Carbon::parse($follow_up->datetime)->isToday())
                                            <button class="btn btn-sm btn-success">Today</button>                                       
                                       @elseif(\Carbon\Carbon::parse($follow_up->datetime)->isPast())
                                            <button class="btn btn-sm btn-primary">Missed</button>
                                       @else
                                            <button class="btn btn-sm btn-warning">Upcoming</button>
                                       @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center">No Follow Up found.</p>
                @endif
            </div>
        </div>
    </section>

    @include('leads.reminder.modal')
@endsection
@push('scripts')
    @include('layouts.utilities')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        //Date and time picker
        $('#reminder').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
    </script>
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
