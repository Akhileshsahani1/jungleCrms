@extends('layouts.master')
@section('title', 'Refund Approval History')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Refund Approval History</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Refund Approval History</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
        
                </div>
                @if (count($history) > 0)
                    <table id="customers" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Note</th>
                                <th>NoteBy</th>
                            
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($history as $h)
                                <tr>
                                    <td>
                                       {{ \Carbon\Carbon::parse($h->created_at)->format('d-m-Y h:i A') }}
                                    </td>
                                    <td>
                                       {{$h->amount }}
                                    </td>

                                    <td>
                                        @if($h->status == 'Generated')
                                            <button class="btn btn-sm btn-info">{{$h->status}}</button>
                                        @elseif($h->status == 'Accepted')
                                            <button class="btn btn-sm btn-info">{{$h->status}}</button>
                                       @else
                                            <button class="btn btn-sm btn-danger">{{ $h->status}}</button>
                                       @endif
                                    </td>
                                    <td>
                                       {{$h->note }}
                                    </td>
                                    <td>
                                       {{get_note_by($h->admin_id)}}
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-center">No History found.</p>
                @endif
            </div>
            {{ $history->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
    </section>

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
