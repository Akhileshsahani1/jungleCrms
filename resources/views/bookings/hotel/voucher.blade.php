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
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/voucher.css') }}">
</head>

<body>
    @php
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
                    <h4 class="estimate-heading">Hotel Booking Voucher</h4>
                </div>
                <div class="clearfix"></div>
            </header>
            <div style="width:100%;border-top: 1px solid black; margin:5px;"></div>
            <div style="width: 100%;">
                <div style="width: 50%; float: left;">S.NO. JSI-HB-{{ $booking->id + 1000 }}</div>
                <div style="width: 50%;float: left; text-align: right; padding-bottom:10px;">Booking Date
                    :{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}</div>
                <div style="clear:left;"></div>
            </div>
            <div style="width:100%;border-top: 1px solid black; margin:5px;"></div>
            <div style="width: 100%;display:inline-flex;">
                <div style="width: 50%; float: left;">
                    <table class="table table-billing-details table-condensed">
                        <tbody>
                            <tr>
                                <th class="text-left text-info">Billed By :</th>
                            </tr>
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
                </div>
                <div style="width: 50%; float: left;">
                    <table class="table table-billing-details table-condensed">
                        <tbody>
                            <tr>
                                <th class="text-left text-info">Billed To :</th>
                            </tr>
                            <tr>
                                <th class="text-left">{{ $booking->customer->name }}</th>
                            </tr>
                            <tr>
                                <td class="text-left">{{ $booking->customer->address }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">{{ $booking->customer->state }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Phone:</strong> {{ $booking->customer->mobile }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="clear:left;"></div>
            </div>
            <div style="width:100%;border-top: 1px solid black; margin:5px;"></div>
            <div style="width:100%;">
                <div style="width:50%; float:left;">
                    @php
                        $hotel = \App\Models\Hotel::find($booking->hotel->hotel_id);
                    @endphp
                    <h4>
                        {{ $hotel->name }}

                    </h4>
                    <p>{{ $hotel->address }}</p>
                </div>
                <div style="width:25%; float:left;">
                    <p>Check In:</p>
                    <h5>{{ \Carbon\Carbon::parse($booking->hotel->check_in)->format('d-m-Y') }}</h5>
                </div>
                <div style="width:25%; float:left;">
                    <p>Check Out:</p>
                    <h5>{{ \Carbon\Carbon::parse($booking->hotel->check_out)->format('d-m-Y') }}</h5>
                </div>
                <div style="clear:left;"></div>
            </div>

            <div style="width:100%;border-top: 1px solid black; margin:5px;"></div>
            <div style="width:100%;">
                <div style="width:50%;float:left;">
                    <table class="table table-billing-details table-condensed">
                        <tbody>
                            <tr>
                                <td class="text-left"> No. of Adults:</td>
                                <td>{{ $booking->hotel->adult }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"> Room Type:</td>
                                <td>{{ \App\Models\HotelRoom::find($booking->hotel->room_id)->room }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"> No. of Extra Bed:</td>
                                <td>{{ $booking->hotel->bed }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"> Meal Plan:</td>
                                <td>{{ \App\Models\HotelRoomService::find($booking->hotel->service_id)->service }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="width:50%;float:left;">
                    <table class="table table-billing-details table-condensed">
                        <tbody>
                            <tr>
                                <td class="text-left"> No. of Child:</td>
                                <td>{{ $booking->hotel->child }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"> No. Of Rooms:</td>
                                <td>{{ $booking->hotel->room }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"> Total Person:</td>
                                <td>{{ $booking->hotel->adult }} Adults +
                                    {{ $booking->hotel->child }} Child</td>
                            </tr>
                            <tr>
                                <td class="text-left"> Destination:</td>
                                <td>{{ $booking->hotel->destination }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="clear:left;"></div>

            </div>
            <div style="width:100%;border-top: 1px solid black; margin:5px;"></div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    @php
                        $hotel = \App\Models\Hotel::find($booking->hotel->hotel_id);
                    @endphp
                    Hotel Contact Person Details : {{ $hotel->person }} {{ $hotel->phone }}
                </div>
                @if ($booking->hotel->hotel_due_amount > 0)
                    <div style="width:100%;border-top: 1px solid black; margin:5px;"></div>
                    <div class="col-sm-12 text-center text-danger">
                        You have to Pay INR {{ $booking->hotel->hotel_due_amount }} at the time of Check In at
                        Resort.
                    </div>
                @endif
            </div>
            <div style="width:100%;border-top: 1px solid black; margin:5px;"></div>
            <div class="row">
                <div class="col-sm-12 mt-4">
                    <span><strong>Inclusions</strong></span><br>
                    @foreach ($inclusions as $inclusion)
                        <span>{{ $loop->iteration }}. {{ $inclusion->content }}</span><br>
                    @endforeach
                </div>
    
                <div class="col-sm-12 mt-2">
                    <span><strong>Exclusions</strong></span><br>
                    @foreach ($exclusions as $exclusion)
                        <span>{{ $loop->iteration }}. {{ $exclusion->content }}</span><br>
                    @endforeach
                </div>
                <div class="col-sm-12 mt-2">
                    <span><strong>Terms & Conditions and Cancellation Policy</strong></span><br>
                    @foreach ($terms as $term)
                        <span>{{ $loop->iteration }}. {{ $term->content }}</span><br>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</body>

</html>
