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
    <link rel="stylesheet" href="{{ asset('dist/css/estimate.css') }}">
</head>

<body>
    <div class="container-sm estimate-container">
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
            <div class="col-sm-4 text-sm-end">
                <strong>Proforma Invoice No</strong><span class="mobile-details"> #{{ $booking->id }}</span>
            </div>
            <div class="col-sm-4">
                <strong>SAC/HSN Code :</strong><span class="mobile-details"> 9985</span>
            </div>
            <div class="col-sm-4">
                <strong>Invoice Date :</strong><span class="mobile-details">
                    {{ $booking->date ? date('F d, Y', strtotime($booking->date)) : date('F d, Y') }}</span>
            </div>
            <div class="col-sm-4">
                <strong>Order Date :</strong><span class="mobile-details">
                    {{ $booking->date ? date('F d, Y', strtotime($booking->date)) : date('F d, Y') }}</span>
            </div>


            @switch($booking->type)
                @case('cab')
                    <div class="col-sm-4">
                        <strong>Booking Type :</strong><span class="mobile-details">
                            Cab Booking
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <strong>Pickup Date :</strong><span class="mobile-details">
                            {{ $booking->cab->start_date ? date('F d, Y', strtotime($booking->cab->start_date)) : date('F d, Y') }}
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <strong>Drop Date :</strong><span class="mobile-details">
                            {{ $booking->cab->end_date ? date('F d, Y', strtotime($booking->cab->end_date)) : date('F d, Y') }}
                        </span>
                    </div>
                @break

                @case('safari')
                    <div class="col-sm-4">
                        <strong>Booking Type :</strong><span class="mobile-details">
                            Safari Booking
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <strong>Safari Date:</strong><span class="mobile-details">
                            {{ $booking->safari->date ? date('F d, Y', strtotime($booking->safari->date)) : date('F d, Y') }}
                        </span>
                    </div>
                    @if ($booking->safari->sanctuary == 'ranthambore')
                        <div class="col-sm-4">
                            <strong>Destination:</strong><span class="mobile-details"> Ranthambore National Park</span>
                        </div>
                    @elseif($booking->safari->sanctuary == 'gir')
                        <div class="col-sm-4">
                            <strong>Destination:</strong><span class="mobile-details"> Gir National Park</span>
                        </div>
                    @elseif($booking->safari->sanctuary == 'jim')
                        <div class="col-sm-4">
                            <strong>Destination:</strong><span class="mobile-details"> Jim Corbett National Park</span>
                        </div>
                    @endif
                @break

                @case('hotel')
                    <div class="col-sm-4">
                        <strong>Booking Type :</strong><span class="mobile-details">
                            Hotel Booking
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <strong>Checkin Date:</strong><span class="mobile-details">
                            {{ $booking->hotel->check_in ? date('F d, Y', strtotime($booking->hotel->check_in)) : date('F d, Y') }}
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <strong>Checkout Date:</strong><span class="mobile-details">
                            {{ $booking->hotel->check_out ? date('F d, Y', strtotime($booking->hotel->check_out)) : date('F d, Y') }}
                        </span>
                    </div>
                @break

                @case('tour')
                    <div class="col-sm-4">
                        <strong>Booking Type :</strong><span class="mobile-details">
                            Tour Booking
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <strong>Checkin Date:</strong><span class="mobile-details">
                            {{ $booking->hotel->check_in ? date('F d, Y', strtotime($booking->hotel->check_in)) : date('F d, Y') }}
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <strong>Checkout Date:</strong><span class="mobile-details">
                            {{ $booking->hotel->check_out ? date('F d, Y', strtotime($booking->hotel->check_out)) : date('F d, Y') }}
                        </span>
                    </div>
                @break

                @case('package')
                    @foreach ($booking->destinations as $destination)
                        <div class="col-sm-4">
                            <strong>Destination {{ $loop->iteration }} :</strong><span class="mobile-details">
                                {{ $destination->destination }}
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <strong>Checkin Date:</strong><span class="mobile-details">
                                {{ $destination->check_in ? date('F d, Y', strtotime($destination->check_in)) : date('F d, Y') }}
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <strong>Checkout Date:</strong><span class="mobile-details">
                                {{ $destination->check_out ? date('F d, Y', strtotime($destination->check_out)) : date('F d, Y') }}
                            </span>
                        </div>
                    @endforeach
                @break

                @default
            @endswitch

        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12">
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
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
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
                            @foreach ($booking->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}. {{ $item->particular }}</td>
                                    <td>1</td>
                                    <td>{{ $item->rate }} %</td>
                                    <td><span
                                            style="font-family: DejaVu Sans;">&#x20B9;</span>{{ $item->amount - round($item->amount * $item->rate /(100 + $item->rate ), 2) }}
                                    </td>
                                    <td class="text-right"><span
                                            style="font-family: DejaVu Sans;">&#x20B9;</span>{{ $item->amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <table width="100%">
                    <tbody>
                        <tr>
                            <td style="60%">
                                <span>Total in Words:</span>
                                <p><strong><em>{{ AmountInWords(round($booking->items->sum('amount'))) }}</em></strong>
                                </p>
                            </td>
                            <td class="text-right pr-2" style="line-height: 30px;">
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
                                <span class="float-left">GST</span> <span class="float-right"
                                    style="font-family: DejaVu Sans;"> &#x20B9;
                                    0</span><br>
                                <div class="clearfix"></div>
                                @endisset
                                <strong>
                                    <span class="float-left">Total (INR)</span> <span class="float-right"
                                        style="font-family: DejaVu Sans;"> &#x20B9;
                                        {{ $booking->items->sum('amount') }}</span><br>
                                    <div class="clearfix" style="border-bottom: 1px solid black;"></div>
                                    <span class="float-left text-success">Paid (INR)</span> <span
                                        class="float-right text-success" style="font-family: DejaVu Sans;"> &#x20B9;
                                        {{ $booking->transactions->sum('amount') }}</span><br>
                                    <div class="clearfix" style="border-bottom: 1px solid black;"></div>
                                    @if ($booking->items->sum('amount') - $booking->transactions->sum('amount') > 0)
                                        <span class="float-left text-danger">Balance</span> <span
                                            class="float-right text-danger" style="font-family: DejaVu Sans;"> &#x20B9;
                                            {{ $booking->items->sum('amount') - $booking->transactions->sum('amount') }}</span><br>
                                        <div class="clearfix" style="border-bottom: 1px solid black;"></div>
                                    @endif
                                </strong>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h6>Transactions</h6>
                <div class="table-border">
                    @if (count($booking->transactions) > 0)
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
                                @foreach ($booking->transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->date ? date('F d, Y', strtotime($transaction->date)) : date('F d, Y') }}
                                        </td>
                                        <td>{{ $transaction->mode }}</td>
                                        <td>&#x20B9;{{ $transaction->amount }}</td>
                                        <td>{{ $transaction->transaction_id }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center mt-3">No Transactions done.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 mt-2">
                <span><strong>Terms & Conditions</strong></span><br>
                @foreach ($terms as $term)
                    <span>{{ $loop->iteration }}. {{ $term->content }}</span><br>
                @endforeach
                <p class="text-center mt-5">For any enquiry, reach out via email at <a
                        href="mailto:{{$company->email}}"><strong>{{$company->email}}</strong></a> or call on <a
                        href="tel:{{$company->phone}}"><strong>{{$company->phone}}</strong></a></p>
            </div>
        </div>
    </div>
<div class="text-center mb-4">
    <a class="btn btn-warning" href="{{ route('invoices.edit', $booking->id) }}">Download</a>
    </div>
</body>

</html>
