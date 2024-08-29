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
                    <h4 class="estimate-heading">Safari Booking Voucher</h4>
                </div>
                <div class="clearfix"></div>
            </header>
            <div style="width:100%;border-top: 1px solid black; margin:5px;"></div>
            <div style="width:100%">
                <div style="width:50%; float:left;">
                    S.No. : JSI-SV-{{ $safari->id  }}-{{ $booking->id + 1000 }}
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
                            <td class="text-left"><strong>Phone:</strong> {{ $booking->customer->mobile }}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
                <div style="clear:left;"></div>
            </div>
            <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>
            <div style="width:100%; margin:5px;">
                  <h2 style="text-align: center;">Safari Booking Details</h2>
            </div>
            <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>

             <div style="width:100%">
                <div style="width:50%; float:left;">
                    <table class="table table-billing-details table-condensed">
                    <tbody>
                        <tr>
                            <td > Safari Area</td>
                            @if($safari->sanctuary == 'ranthambore')
                                <td >{{ $safari->area }}</td>
                            @elseif($safari->sanctuary == 'gir')
                                <td >Gir National Park</td>
                            @elseif($safari->sanctuary == 'jim')
                                <td  > Jim Corbett National Park</td>
                            @endif
                        </tr>
                        <tr>
                            <td class="text-left"> Safari Zone</td>
                            @if($safari->sanctuary == 'jim')
                            <td >
                                {{ $safari->area }}
                            </td>
                            @else
                            <td>
                               Zone {{ $safari->zone }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="text-left">Nationality:</td>
                            <td>{{ $safari->nationality }}</td>
                        </tr>
                        <tr>
                            <td class="text-left"> Mode of Vehicle</td>
                            <td>{{ $safari->mode }}</td>
                        </tr>
                        @if($safari->sanctuary == 'ranthambore')
                        <tr>
                            <td class="text-left"> Vehicle Booking Type</td>
                            <td>{{ $safari->vehicle_type }}</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                </div>
                <div style="width:50%; float:left; text-align: right;">
                    <table class="table table-billing-details table-condensed">
                    <tbody>
                        <tr>
                            <td class="text-left"> Safari Date</td>
                            <td>{{ $safari->date }}</td>
                        </tr>
                        <tr>
                            <td class="text-left"> Safari Time:</td>
                            <td> {{ $safari->time }}</td>
                        </tr>
                        <tr>
                            <td class="text-left"> Total Person:</td>
                           @if($safari->sanctuary == 'gir')
                            <td >
                                {{ $safari->adult }} Adults + {{ $safari->child }} Child
                            </td>
                            @else
                            <td>
                                {{ $safari->total_person }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            <td class="text-left"> No. of Jeep/Canter:</td>
                            <td>{{ $safari->jeeps }}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
                <div style="clear:left;"></div>
            </div>

             <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>
              <div style="width:100%; margin:5px; ">
                  Jeep Safari Coordinator : Mr. {{ \App\Models\Vendor::find($safari->vendor)->name }}({{ \App\Models\Vendor::find($safari->vendor)->phone }}, {{ \App\Models\Vendor::find($safari->vendor)->alternate }}).Kindly give him a call once reached in  @if($safari->sanctuary == 'ranthambore')
                                Ranthambore
                            @elseif($safari->sanctuary == 'gir')
                                Gir National Park
                            @elseif($safari->sanctuary == 'jim')
                                Jim Corbett National Park
                            @endif
                            .
                            @isset($safari->note)
                            <p>Note:{!! $safari->note !!}</p>
                            @endisset
              </div>
              @if ($safari->safari_due_amount > 0)
               <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>
               <div style="width:100%; margin:5px; text-align: center;color:red;">
                  You have to Pay INR  {{ $safari->safari_due_amount }} to the jeep driver/safari coordinator before safari start.
              </div>
              @endif
               <div style="width:100%;border-top: 1px solid black; margin:5px; "></div>

           
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
</body>

</html>
