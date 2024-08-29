<!doctype html>
<html lang="en">

<head>
    <title>Cab Booking Voucher</title>
    <!-- Required meta tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('dist/css/voucher.css') }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>        
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
                    <h4 class="estimate-heading">Cab Booking Voucher</h4>
                </div>
                <div class="clearfix"></div>
            </header>
            <div style="width:100%;border-top: 1px solid black; margin:5px;"></div>
            <div style="width:100%">
                <div style="width:50%; float:left;">
                    S.No. : JSI-CV-{{ $booking->id + 1000 }}
                </div>
                <div style="width:50%; float:left; text-align: right;">
                    Booking Date :{{ \Carbon\Carbon::parse($booking->date)->format('d-m-Y') }}
                </div>
                <div style="clear:left;"></div>
            </div>
            <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>
            <div style="width:100%">
                <div style="width:50%; float:left;">
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
                                <td class="text-left">{{ $company->state . ', India-' . $company->pincode }}</td>
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
                <div style="width:50%; float:left; text-align: right;">
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
            <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>
            <div style="width:100%; margin:5px; text-align: center;">
                <h4>Cab Booking Details</h4>
            </div>
            <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>
            <div style="width:100%">
                <div style="width:50%; float:left;">
                    <table class="table table-billing-details table-condensed">
                        <tbody>
                            <tr>
                                <td> Trip Type</td>
                                <td>{{ $booking->cab->trip_type }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"> Pickup Point:</td>
                                <td>{{ $booking->cab->pick_up }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"> Trip Start On:</td>
                                <td>{{ \Carbon\Carbon::parse($booking->cab->start_date)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"> Trip End On:</td>
                                <td>{{ \Carbon\Carbon::parse($booking->cab->end_date)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Pickup Time:</td>
                                <td>{{ \Carbon\Carbon::parse($booking->cab->pickup_time)->format('g:i A') }}</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
                <div style="width:50%; float:left; text-align: right;">
                    <table class="table table-billing-details table-condensed">
                        <tbody>
                            <tr>
                                <td class="text-left"> Vehicle Type</td>
                                <td>{{ $booking->cab->vehicle_type }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"> Drop Point:</td>
                                <td>{{ $booking->cab->drop }}</td>
                            </tr>                            
                            <tr>
                                <td class="text-left"> Total Person:</td>
                                <td>
                                    {{ $booking->cab->total_riders }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"> No. of Vehicle:</td>
                                <td>{{ $booking->cab->no_of_cab }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"> No. of Halts:</td>
                                <td>{{ count($booking->cab->halts) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="clear:left;"></div>
            </div>
            @if(count($booking->cab->halts) > 0)
            <div style="width:100%">
                <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>
                <div style="width:100%; margin:5px; text-align: center;">
                    <h4>Halt Destinations</h4>
                </div>
                <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th style="text-align: center; border-bottom: none; padding: 0.15rem;">Halt Destination</th>
                            <th style="text-align: center; border-bottom: none; padding: 0.15rem;">Halt Starts from</th>
                            <th style="text-align: center; border-bottom: none; padding: 0.15rem;">Halt Ends on</th>                               
                        </tr>
                    </thead>
                    <tbody>                           
                        @foreach ($booking->cab->halts as $halt)
                            <tr>
                                <td style="text-align: center; border-bottom: none; padding:0.15rem">{{ $halt->halt }}</td>   
                                <td style="text-align: center; border-bottom: none; padding:0.15rem">{{ \Carbon\Carbon::parse($halt->start)->format('d-m-Y') }}</td>
                                <td style="text-align: center; border-bottom: none; padding:0.15rem">{{ \Carbon\Carbon::parse($halt->end)->format('d-m-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
            <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>
            <div style="width:100%; text-align: center;">
                Cab Driver : Mr. {{ $booking->cab->vendor_name }} ({{ $booking->cab->vendor_mobile }}).

            </div>
            <div style="width:100%; font-size: 13px; text-align: center;">
                Kindly give him a call once you reach the pickup point.
            </div>

            @if ($booking->cab->cab_due_amount > 0)                
                <div style="width:100%; margin:5px; text-align: center;color:red;">
                    You have to Pay INR {{ $booking->cab->cab_due_amount }} to the Cab Driver before Cab start.
                </div>
            @endif                        
           
            <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>
            @isset($booking->cab->note)
            <div class="col-sm-12 mt-2">
                <span><strong>Notes</strong></span><br>
                <span>{!! $booking->cab->note !!}</span>
            </div>
            @endisset
            <div class="col-sm-12 mt-2">
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
