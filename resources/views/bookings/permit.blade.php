<!doctype html>
<html lang="en">
  <head>
    <title>All Permits | {{ \Carbon\Carbon::parse($link->created_at)->format('d-m-Y') }}</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
</head>
  <body>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-check-circle"></i> Permits</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-warning">Link Generated : {{ \Carbon\Carbon::parse($link->created_at)->format('d-m-Y g:i:A') }}</button>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card card-widget">
            <!-- /.card-header -->
            <div class="card-body" style="display: block;">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="10%">#</th>
                            <th>Customer</th>
                            <th>Mobile</th>
                            <th>Note</th>
                            <th>Due Amount</th>
                            <th>Safari Date</th>
                            <th>Safari Time</th>
                            <th>Total Person</th>
                            <th>Canter/Jeep</th>
                            <th>Vehicle Booking Type</th>
                            <th>Zone</th>
                            <th>Permit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                        <tr>
                            <td scope="row">{{ $loop->iteration }}</td>
                            <td>{{ $booking->customer->name }}</td>
                            <td>{{ $booking->customer->mobile }}</td>
                            <td>{!! $booking->safari->note !!}</td>
                            <td>₹ {{ $booking->safari->safari_due_amount }} </td>
                            <td style="font-size:13px;">
                                @if($booking->type == 'package')
                                   @php
                                   $safaris = \App\Models\BookingSafari::where('date', $link->safari_date)->where('booking_id', $booking->id)->get();
                                   @endphp
                                    @foreach($safaris as $safari)
                                    {{ \Carbon\Carbon::parse($safari->date)->format('d/m/Y') }}<br>
                                    @endforeach
                                @elseif($booking->type == 'tour')
                                    @php
                                    $safaris = \App\Models\BookingSafari::where('date', $link->safari_date)->where('booking_id', $booking->id)->get();
                                    @endphp
                                    @foreach($safaris as $safari)
                                    {{ \Carbon\Carbon::parse($safari->date)->format('d/m/Y') }}<br>
                                    @endforeach
                                @else
                                        {{ \Carbon\Carbon::parse($booking->safari->date)->format('d/m/Y') }}
                                @endif
                            </td>
                            <td>{{ $booking->safari->time }}</td>
                            <td>{{ $booking->safari->total_person }}</td>
                             <td>{{ $booking->safari->mode }} </td>
                             @if($booking->safari->sanctuary == 'ranthambore')
                                <td>{{ $booking->safari->vehicle_type }}</td>
                             @else
                                <td>Unknown</td>
                             @endif
                            @if($booking->safari->sanctuary == 'jim')
                            <td>
                                {{ $booking->safari->area }}
                            </td>
                            @else
                            <td>
                               Zone {{ $booking->safari->zone }}
                            </td>
                            @endif
                            <td>
                                @if($booking->type == 'package')
                                   @php
                                   $safaris = \App\Models\BookingSafari::where('date', $link->safari_date)->where('booking_id', $booking->id)->get();
                                   @endphp
                                    @foreach($safaris as $safari)
                                    <a href="{{ route('download.package.permit', $safari->id) }}" class="btn btn-dark"><i class="fas fa-download"></i> Download</a><br>
                                    @endforeach
                                @elseif($booking->type == 'tour')
                                @php
                                   $safaris = \App\Models\BookingSafari::where('date', $link->safari_date)->where('booking_id', $booking->id)->get();
                                   @endphp
                                    @foreach($safaris as $safari)
                                    <a href="{{ route('download.tour.permit', $safari->id) }}" class="btn btn-dark"><i class="fas fa-download"></i> Download</a><br>
                                    @endforeach
                                @else
                                    <a href="{{ route('download.permit', $booking->id) }}" class="btn btn-dark"><i class="fas fa-download"></i> Download</a>
                                @endif

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
          </div>
    </section>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    @include('layouts.utilities')
</body>
</html>
