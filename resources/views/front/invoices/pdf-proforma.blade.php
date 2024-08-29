<!doctype html>
<html lang="en">

<head>
    <title>Proforma Invoice</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('dist/css/voucher.css') }}">
</head>

<body>
    <div class="main-page">
        <div class="sub-page">
            <header>
                <div class="float-left">
                    <img src="{{ $company->path }}" title="Invoice" alt="Invoice">
                </div>
                <div class="float-right">
                    <h4 class="estimate-heading">Proforma Invoice</h4>
                    <div class="text-right">
                        @if ($booking->items->sum('amount') - $booking->transactions->sum('amount') > 0)
                            @if($booking->transactions->sum('amount') > 0)
                            <button class="btn btn-outline-success"
                            id="payment_status">Partially Paid</button>
                            @else
                            <button class="btn btn-outline-success"
                            id="payment_status">Unpaid</button>
                            @endif
                        @else
                            <button class="btn btn-outline-success"
                            id="payment_status">Paid</button>
                        @endif
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr>
            </header>
            <div class="row">
                <table class="table table-detail table-condensed">
                    <tbody>
                        <tr>
                            <th class="text-left">Proforma Invoice No :</th>
                            <td class="text-right">#{{ $booking->id }}</td>
                        </tr>
                        <tr>
                            <th class="text-left"> SAC/HSN Code :</th>
                            <td class="text-right">9985</td>
                        </tr>
                        <tr>
                            <th class="text-left">Invoice Date :</th>
                            <td class="text-right">
                                {{ $booking->date ? date('F d, Y', strtotime($booking->date)) : date('F d, Y') }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left">Order Date :</th>
                            <td class="text-right">{{ $booking->date ? date('F d, Y', strtotime($booking->date)) : date('F d, Y') }}</td>
                        </tr>
                        @switch($booking->type)
                        @case('cab')
                            <tr>
                                <th class="text-left">Booking Type :</th>
                                <td class="text-right">
                                    Cab Booking
                                </td>
                            </tr>
                            <tr>
                                <th class="text-left">Pickup Date :</th>
                                <td class="text-right">
                                    {{ $booking->cab->start_date ? date('F d, Y', strtotime($booking->cab->start_date)) : date('F d, Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-left">Drop Date :</th>
                                <td class="text-right">
                                    {{ $booking->cab->end_date ? date('F d, Y', strtotime($booking->cab->end_date)) : date('F d, Y') }}
                                </td>
                            </tr>
                        @break

                        @case('safari')
                            <tr>
                                <th class="text-left">Booking Type :</th>
                                <td class="text-right">
                                    Safari Booking
                                </td>
                            </tr>
                            <tr>
                                <th class="text-left">Safari Date:</th>
                                <td class="text-right">
                                    {{ $booking->safari->date ? date('F d, Y', strtotime($booking->safari->date)) : date('F d, Y') }}
                                </td>
                            </tr>
                            @if ($booking->safari->sanctuary == 'ranthambore')
                            <tr>
                                <th class="text-left">Destination:</th>
                                <td class="text-right">
                                    Ranthambore National Park
                                </td>
                            </tr>
                            @elseif($booking->safari->sanctuary == 'gir')
                            <tr>
                                <th class="text-left">Destination:</th>
                                <td class="text-right">
                                    Gir National Park
                                </td>
                            </tr>
                            @elseif($booking->safari->sanctuary == 'jim')
                            <tr>
                                <th class="text-left">Destination:</th>
                                <td class="text-right">
                                    Jim Corbett National Park
                                </td>
                            </tr>
                            @endif
                        @break

                        @case('hotel')
                            <tr>
                                <th class="text-left">Booking Type :</th>
                                <td class="text-right">
                                    Hotel Booking
                                </td>
                            </tr>
                            <tr>
                                <th class="text-left">Checkin Date:</th>
                                <td class="text-right">
                                    {{ $booking->hotel->check_in ? date('F d, Y', strtotime($booking->hotel->check_in)) : date('F d, Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-left">Checkout Date:</th>
                                <td class="text-right">
                                    {{ $booking->hotel->check_out ? date('F d, Y', strtotime($booking->hotel->check_out)) : date('F d, Y') }}
                                </td>
                            </tr>
                        @break

                        @case('tour')
                            <tr>
                                <th class="text-left">Booking Type :</th>
                                <td class="text-right">
                                    Tour Booking
                                </td>
                            </tr>
                            <tr>
                                <th class="text-left">Checkin Date:</th>
                                <td class="text-right">
                                    {{ $booking->hotel->check_in ? date('F d, Y', strtotime($booking->hotel->check_in)) : date('F d, Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-left">Checkout Date:</th>
                                <td class="text-right">
                                    {{ $booking->hotel->check_out ? date('F d, Y', strtotime($booking->hotel->check_out)) : date('F d, Y') }}
                                </td>
                            </tr>
                        @break

                        @case('package')
                            @foreach ($booking->destinations as $destination)
                                <tr>
                                    <th class="text-left">Destination {{ $loop->iteration }} :</th>
                                    <td class="text-right">
                                        {{ $destination->destination }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-left">Checkin Date:</th>
                                    <td class="text-right">
                                        {{ $destination->check_in ? date('F d, Y', strtotime($destination->check_in)) : date('F d, Y') }}
                                   </td>
                                </tr>
                                <tr>
                                    <th class="text-left">Checkout Date:</th>
                                    <td class="text-right">
                                        {{ $destination->check_out ? date('F d, Y', strtotime($destination->check_out)) : date('F d, Y') }}
                                   </td>
                                </tr>
                            @endforeach
                        @break

                        @default
                    @endswitch

                    </tbody>
                </table>
                <hr>

                    <table class="table table-billing-details table-condensed">
                        <tbody>
                            <tr>
                                <th class="text-left">Billed By:</th>
                                <th class="text-right">Billed To:</th>
                            </tr>
                            <tr>
                                <th class="text-left">{{ $company->name }}</th>
                                <th class="text-right">{{ $booking->customer->name }}</th>
                            </tr>
                            <tr>
                                <td class="text-left">{{ $company->address_1 }}</td>
                                <td class="text-right">{{ $booking->customer->address }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">{{ $company->address_2 }}</td>
                                <td class="text-right">{{ $booking->customer->state }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">{{ $company->state.", India-".$company->pincode }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Phone:</strong> {{ $company->phone }}</td>
                                <td class="text-right"><strong>Phone:</strong> {{ $booking->customer->mobile }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Email:</strong> {{ $company->email }}</td>
                                @isset($booking->customer->company)
                                <td class="text-right"><strong>Company Name:</strong> {{ $booking->customer->company }}</td>
                                @endisset
                            </tr>
                            <tr>
                                <td class="text-left"><strong>GST:</strong> {{ $company->gstin }}</td>
                                @isset($booking->customer->gstin)
                                <td class="text-right"><strong>Company GST:</strong> {{ $booking->customer->gstin }}</td>
                                @endisset
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-border">
                        <table class="table table-condensed table-content">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                    <th>Rate (%)</th>
                                    <th>Amount (INR)</th>
                                    <th class="text-right">Total (INR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}. {{ $item->particular }}</td>
                                    <td>1</td>
                                    <td>{{ $item->rate }} %</td>
                                    <td><span style="font-family: DejaVu Sans;">&#x20B9;</span>{{ $item->amount - round($item->amount * $item->rate /(100 + $item->rate ), 2) }}</td>
                                    <td class="text-right"><span style="font-family: DejaVu Sans;">&#x20B9; {{ $item->amount }} </span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <span>Total in Words:</span>
                                    <p><strong><em>{{ AmountInWords(round($booking->items->sum('amount'))) }}</em></strong></p>
                                </td>
                                <td>
                                    @php
                                    $taxable = \App\Models\BookingItem::where('booking_id', $booking->id)->where('particular', 'Taxable amount')->first();
                                    $igst = $taxable->amount * $taxable->rate /(100 + $taxable->rate );
                                    $gst = $igst/2;
                                   @endphp
                                    @isset($taxable)
                                    @if ($company->state == $booking->customer->state)
                                    <span class="float-left">CGST</span> <span class="float-right"
                                        style="font-family: DejaVu Sans;"> &#x20B9;
                                        {{ round($gst, 2) }}</span><br>

                                    <div class="clearfix"></div>
                                    <span class="float-left">SGST</span> <span class="float-right"
                                        style="font-family: DejaVu Sans;"> &#x20B9;
                                        {{ round($gst, 2) }}</span><br>
                                @else
                                    <span class="float-left">IGST</span> <span class="float-right"
                                        style="font-family: DejaVu Sans;"> &#x20B9;
                                        {{ round($igst, 2) }}</span><br>
                                @endif
                                    <div class="clearfix"></div>
                                    @else
                                    <span class="float-left" style="font-family: DejaVu Sans;">GST</span> <span class="float-right" style="font-family: DejaVu Sans;"> &#x20B9; 0</span><br>
                                    <div class="clearfix"></div>
                                    @endisset
                                    <span class="float-left" style="font-family: DejaVu Sans;">Total</span> <span class="float-right"  style="font-family: DejaVu Sans;"> &#x20B9; {{ $booking->items->sum('amount') }}</span><br>
                                    <div class="clearfix"></div>
                                    <span class="float-left" style="font-family: DejaVu Sans; color:green">Paid</span> <span  class="float-right" style="font-family: DejaVu Sans; color:green"> &#x20B9; {{ $booking->transactions->sum('amount') }}</span><br>
                                    <div class="clearfix"></div>
                                    @if ($booking->items->sum('amount') - $booking->transactions->sum('amount') > 0)
                                    <span class="float-left" style="font-family: DejaVu Sans; color:red">Balance</span> <span  class="float-right" style="font-family: DejaVu Sans; color:red"> &#x20B9; {{ $booking->items->sum('amount') - $booking->transactions->sum('amount') }}</span><br>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h6>Transactions</h6>
                    <div class="table-border">
                        @if(count($booking->transactions) > 0)
                        <table class="table table-condensed table-content">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Date</th>
                                    <th>Mode</th>
                                    <th>Amount (INR)</th>
                                    <th>Transaction Id</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->date ?  date('F d, Y', strtotime($transaction->date)) : date('F d, Y') }}</td>
                                    <td>{{ $transaction->mode}}</td>
                                    <td><span style="font-family: DejaVu Sans;"> &#x20B9; {{ $transaction->amount }}</span></td>
                                    <td>{{ $transaction->transaction_id }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                            <p class="text-center mt-3">No Transactions done.</p>
                        @endif
                    </div>
                    <h6 class="mt-3">Terms & Conditions</h6>
                    @foreach ($terms as $term)
                        <span>{{ $loop->iteration }}. {{ $term->content }}</span><br>
                    @endforeach
            </div>
        </div>
    </div>
</body>
</html>
