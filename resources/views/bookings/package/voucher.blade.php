<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('dist/css/voucher.css') }}">
</head>

<body>
    @php
    $booking_type = bookingType($booking->id);
        $total = 0;
        $rate = 0;

        foreach ($booking->items as $item) {
            $total = $total + $item->amount;
            $rate = $rate + $item->rate;
        }

        $base_fare = $total - ($total * $rate) / 100;
    @endphp
    <div class="main-page">
        <div class="sub-page">
            <header>
                <div class="float-left">
                    <img src="{{ $company->path }}" title="Invoice" alt="Invoice">
                </div>
                <div class="float-right">
                    <h4 class="estimate-heading">Package Booking Voucher</h4>
                </div>
                <div class="clearfix"></div>
            </header>
            <div class="row">
                <hr>
                <div class="col-sm-12">
                    <p>
                        Hi <strong>{{ $booking->customer->name }},</strong><br>
                        Thank you for using Jungle Safari India to book your Package. For your reference, your <strong> Package Booking ID: JSI-TB-{{ $booking->id + 1000 }}</strong>. Kindly
                        note, Contact with us 1 day prior to reconfirm all the details to avoided the
                        inconvenience. We hope you have a pleasant travel and look forward to assisting you again!</p>
                </div>
                @if(in_array('safari', $booking_type))
                <div class="col-sm-12">
                    <h2 class="detail-heading">Safari Booking Details</h2>
                </div>
                <hr>
                <table class="table table-detail table-condensed">
                    <tbody>
                        <tr>
                            <th class="text-left">Destination:</th>
                            @if ($booking->safari->sanctuary == 'ranthambore')
                                <td class="text-right">{{ $booking->safari->area }}</td>
                            @elseif($booking->safari->sanctuary == 'gir')
                                <td class="text-right">Gir National Park</td>
                            @elseif($booking->safari->sanctuary == 'jim')
                                <td class="text-right"> Jim Corbett National Park</td>
                            @endif
                        </tr>
                        <tr>
                            <th class="text-left">No. of Nights:</th>
                            <td class="text-right">
                                {{ date_diff(new \DateTime($booking->hotel->check_in), new \DateTime($booking->hotel->check_out))->format('%d') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left">Pas:</th>
                            <td class="text-right"> {{ $booking->hotel->adult }} Adults +
                                {{ $booking->hotel->child }} Child</td>
                        </tr>
                        <tr>
                            <th class="text-left">Check In:</th>
                            <td class="text-right">
                                {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Check Out:</th>
                            <td class="text-right">
                                {{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}</td>
                        </tr>

                    </tbody>
                </table>
                <hr>
                @endif
                @if(in_array('cab', $booking_type))
                <div class="col-sm-12">
                    <h2 class="detail-heading">Cab  Booking Details</h2>
                </div>
                <hr>
                <table class="table table-detail table-condensed">
                    <tr>
                        <th>Trip Type:</th>
                        <td class="text-right"> {{ $booking->cab->trip_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>Pickup Medium:</th>
                        <td class="text-right"> {{ $booking->cab->pickup_medium }}</td>
                    </tr>
                    <tr>
                        <th>Vehicle Type:</th>
                        <td class="text-right"> {{ $booking->cab->vehicle_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>Pickup Point:</th>
                        <td class="text-right"> {{ $booking->cab->pick_up }}
                        </td>
                    </tr>
                    <tr>
                        <th>Drop Point:</th>
                        <td class="text-right"> {{ $booking->cab->drop }}
                        </td>
                    </tr>
                    <tr>
                        <th>Pickup Time:</th>
                        <td class="text-right">
                            {{ \Carbon\Carbon::parse($booking->cab->pickup_time)->format('g:i A') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Trip Start On:</th>
                        <td class="text-right">
                            {{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Trip End On:</th>
                        <td class="text-right">
                            {{ \Carbon\Carbon::parse($booking->cab->end_date)->format('d-m-Y') }}
                        </td>
                    </tr>
                    <tr>
                        <th>Total Person:</th>
                        <td class="text-right"> {{ $booking->cab->total_riders }}
                        </td>
                    </tr>
                </table>
                <hr>
                @endif
                <div class="col-sm-12">
                    <h2 class="detail-heading">Payment Details</h2>
                </div>
                <div class="table-border">
                    <table class="table table-condensed table-content">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th width="50%">Content</th>
                                <th width="50%">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->destinations as $destination)
                            @foreach ($destination->options as $option)
                            <tr>
                                @php
                                    $hotel = \App\Models\Hotel::find($option->hotel_id);
                                @endphp
                                <td>
                                    {{ $destination->destination }}
                                    <br>
                                    Hotel Name: {{ $hotel->name }}
                                    <br>
                                    @for ($i = 0; $i < $hotel->rating; $i++)
                                        <span class="fas fa-star text-warning"></span>
                                    @endfor
                                </td>
                                <td>
                                    <strong>Package: </strong><span
                                        style="font-family: DejaVu Sans;">&#x20B9;</span>{{ $booking->hotel->amount }}
                                    <br>
                                    <strong>Room: </strong>{{ $booking->hotel->room }} Rooms +
                                    {{ $booking->hotel->bed }} Extra Beds <br>
                                    <strong>Meals:
                                    </strong>{{ \App\Models\HotelRoomService::find($option->service_id)->service }}
                                    <br>
                                </td>
                            @endforeach
                            @endforeach
                            <tr>
                                <td></td>
                                <td>
                                   <span class="float-left" style="font-family: DejaVu Sans;">Base Fare</span> <span class="float-right" style="font-family: DejaVu Sans;"> &#x20B9; {{ $booking->hotel->amount - ($booking->hotel->amount * $rate) / 100 }}</span><br>
                                   <div class="clearfix"></div>
                                   <span class="float-left" style="font-family: DejaVu Sans;">GST (%)</span> <span class="float-right"  style="font-family: DejaVu Sans;"> {{ $rate }}</span><br>
                                   <div class="clearfix"></div>
                                   <span class="float-left" style="font-family: DejaVu Sans;">Total (INR)</span> <span  class="float-right" style="font-family: DejaVu Sans;"> &#x20B9; {{ $total }}</span><br>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12 mt-4">
                    <span><strong>Terms & Conditions and Cancellation Policy</strong></span><br>
                    @foreach ($terms as $term)
                        <span>{{ $loop->iteration }}. {{ $term->content }}</span><br>
                    @endforeach
                </div>
            </div>
            <footer class="mt-5">
                <table class="table table-billing-details table-condensed">
                    <tbody>
                        <tr>
                                <th class="text-left">{{ $company->name }}</th>
                            </tr>
                            <tr>
                                <td class="text-left">{{ $company->address_1 }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">{{ $company->address_2 }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">{{ $company->state.", India-".$company->pincode }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Email:</strong> {{ $company->email }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Phone:</strong> {{ $company->phone }}</td>
                            </tr>
                    </tbody>
                </table>
            </footer>
        </div>
    </div>
</body>

</html>
