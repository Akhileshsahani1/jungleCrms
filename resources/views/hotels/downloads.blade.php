@extends('layouts.master')
@section('title', 'Hotel Rooms')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')

    <section class="content-header sheri">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $hotel->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('hotels.index') }}">Hotels</a></li>
                        <li class="breadcrumb-item active">Hotel Rooms</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <p class="card-title text-info">{{ $hotel->address }}</p>
                <div class="card-tools">
                    <a href="{{ route('download.hotel.images', $hotel->id) }}" class="btn btn-info"
                        data-toggle="tooltip" title="Download Images"> <i class="fas fa-download"></i> </a>
                    <div class="btn-group">
                        <a href="{{ route('rooms.show', $hotel->id) }}" class="btn btn-dark" data-toggle="tooltip"
                            title="Show Rooms"> <i class="fas fa-list"></i> </a>
                        <a href="{{ route('hotels.edit', $hotel->id) }}" class="btn btn-warning" data-toggle="tooltip"
                            title="Edit Hotel"> <i class="fas fa-pen"></i> </a>
                        <button type="button" onclick="confirmDelete({{ $hotel->id }})" class="btn btn-danger"
                            data-toggle="tooltip" title="Delete Hotel"><i class="fas fa-trash"></i> </button>
                        <form id='delete-form{{ $hotel->id }}' action='{{ route('hotels.destroy', $hotel->id) }}'
                            method='POST'>
                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                            <input type='hidden' name='_method' value='DELETE'>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="mb-4">Hotel Details</h4>
                        <table class="table table-sm">
                            <tbody>
                                <tr>
                                    <td>Hotel Name</td>
                                    <td>{{ $hotel->name }}</td>
                                </tr>
                                <tr>
                                    <td>Rating</td>
                                    <td>{{ $hotel->rating }} Star</td>
                                </tr>
                                <tr>
                                    <td>State</td>
                                    <td>{{ $hotel->state }}</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>{{ $hotel->city }}</td>
                                </tr>
                                <tr>
                                    <td>Contact Person</td>
                                    <td>{{ $hotel->person }}</td>
                                </tr>
                                <tr>
                                    <td>Contact Number</td>
                                    <td>{{ $hotel->phone }}</td>
                                </tr>
                                <tr>
                                    <td>Contact Email</td>
                                    <td>{{ isset($hotel->email) ? $hotel->email : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td>{{ $hotel->status == 1 ? 'Enabled' : 'Disabled' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                @foreach ($hotel->images as $key => $image)
                                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $key }}"
                                        @if ($loop->first) class="active" @endif></li>
                                @endforeach
                            </ol>
                            <div class="carousel-inner">
                                @foreach ($hotel->images as $image)
                                    <div class="carousel-item  @if ($loop->first) active @endif">
                                        <img class="d-block w-100" src="{{ $image->path }}" alt="{{ $image->image }}"
                                            width="514" height="343">
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 mt-4">
                        <h4 class="mb-4">Room Details</h4>
                        @foreach ($hotel->rooms as $room)
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title" style="color: #6610f2;">{{ $room->room }}</h3>

                                    <div class="card-tools">
                                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning"
                                            data-toggle="tooltip" title="Edit Room"> Edit
                                            Room</a>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Service</th>
                                                <th>Base Price</th>
                                                <th>Adult(Extra Bed)</th>
                                                <th>Child(Extra Bed)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($room->services as $service)
                                                <tr>
                                                    <td>{{ $service->service }}</td>
                                                    <td>₹{{ $service->price }}</td>
                                                    <td>₹{{ $service->extra_adult_price }}</td>
                                                    <td>₹{{ $service->extra_child_price }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
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
