<!doctype html>
<html lang="en">

<head>
    <title>Tax Invoice</title>
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
                    <h4 class="estimate-heading">Tax Invoice</h4>
                </div>
                <div class="clearfix"></div>
                <hr>
            </header>
            <div class="row">
                <table class="table table-detail table-condensed">
                    <tbody>
                        <tr>
                            <th class="text-left">Proforma Invoice No :</th>
                            <td class="text-right">#{{ 10000 + $booking->invoice->id }}</td>
                        </tr>
                        <tr>
                            <th class="text-left"> SAC/HSN Code :</th>
                            <td class="text-right">9985</td>
                        </tr>
                        <tr>
                            <th class="text-left">Invoice Date :</th>
                            <td class="text-right">
                                {{ $booking->date ? date('F d, Y', strtotime($booking->invoice->date)) : date('F d, Y') }}
                            </td>
                        </tr>
                        @switch($booking->type)
                            @case('safari')
                                <tr>
                                    <th class="text-left">Safari Date</th>
                                    <td class="text-right">
                                        {{ $booking->safari->date ? date('F d, Y', strtotime($booking->safari->date)) : date('F d, Y') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-left">Destination</th>
                                    <td class="text-right">
                                        @if ($booking->safari->sanctuary == 'ranthambore')
                                            Ranthambore National Park
                                        @elseif($booking->safari->sanctuary == 'gir')
                                            Gir National Park
                                        @elseif($booking->safari->sanctuary == 'jim')
                                            Jim Corbett National Park
                                        @endif
                                    </td>
                                </tr>
                            @break

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
                            <td class="text-left">{{ $company->state . ', India-' . $company->pincode }}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Phone:</strong> {{ $company->phone }}</td>
                            <td class="text-right"><strong>Phone:</strong> {{ $booking->customer->mobile }}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Email:</strong> {{ $company->email }}</td>
                            @isset($booking->customer->company)
                                <td class="text-right"><strong>Company Name:</strong> {{ $booking->customer->company }}
                                </td>
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
                            @foreach ($booking->items as $item)
                                @if ($item->rate == 0 && checkFirstTransaction($booking->id, $transaction->id))
                                    <tr>
                                        <td>{{ $loop->iteration }}. {{ $item->particular }}</td>
                                        <td>1</td>
                                        <td>{{ $item->rate }} %</td>
                                        <td><span
                                                style="font-family: DejaVu Sans;">&#x20B9;</span>{{ getNonTaxableAmount($booking->id) }}
                                        </td>
                                        <td class="text-right"><span
                                                style="font-family: DejaVu Sans;">&#x20B9;</span>{{ getNonTaxableAmount($booking->id) }}
                                        </td>
                                    </tr>
                                @elseif($item->rate != 0 && checkFirstTransaction($booking->id, $transaction->id))
                                    @php
                                        $amount_taxable = $transaction->amount - getNonTaxableAmount($booking->id);
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}. {{ $item->particular }}</td>
                                        <td>1</td>
                                        <td>{{ $item->rate }} %</td>
                                        <td><span
                                                style="font-family: DejaVu Sans;">&#x20B9;</span>{{ $amount_taxable - round(($amount_taxable * $item->rate) / (100 + $item->rate), 2) }}
                                        </td>
                                        <td class="text-right"><span
                                                style="font-family: DejaVu Sans;">&#x20B9;</span>{{ $amount_taxable }}
                                        </td>
                                    </tr>
                                @elseif($item->rate != 0)
                                    @php
                                        $amount_taxable = $transaction->amount;
                                    @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}. {{ $item->particular }}</td>
                                        <td>1</td>
                                        <td>{{ $item->rate }} %</td>
                                        <td><span
                                                style="font-family: DejaVu Sans;">&#x20B9;</span>{{ $transaction->amount - round(($transaction->amount * $item->rate) / (100 + $item->rate), 2) }}
                                        </td>
                                        <td class="text-right"><span
                                                style="font-family: DejaVu Sans;">&#x20B9;</span>{{ $transaction->amount }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <span>Total in Words:</span>
                                <p><strong><em>{{ AmountInWords(round($transaction->amount)) }}</em></strong>
                                </p>
                            </td>
                            <td>
                                @php
                                    if ($booking->type == 'hotel' || $booking->type == 'cab') {
                                        $amount_taxable = $transaction->amount;
                                    }
                                @endphp
                                @php
                                    $rate = \App\Models\BookingItem::where('booking_id', $booking->id)
                                        ->where('particular', 'Taxable amount')
                                        ->value('rate');
                                    $igst = ($amount_taxable * $rate) / (100 + $rate);
                                    $gst = $igst / 2;
                                @endphp



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
                                <span class="float-left" style="font-family: DejaVu Sans;">Total</span> <span
                                    class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;
                                    {{ $transaction->amount }}</span><br>
                                <div class="clearfix"></div>
                                <span class="float-left" style="font-family: DejaVu Sans;">Paid</span> <span
                                    class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;
                                    {{ $transaction->amount }}</span><br>
                                <div class="clearfix"></div>
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
                                @foreach ($booking->transactions as $row)
                                    @if ($transaction->id == $row->id)
                                        <tr>
                                            <td>{{ $row->date ? date('F d, Y', strtotime($row->date)) : date('F d, Y') }}
                                            </td>
                                            <td>{{ $row->mode }}</td>
                                            <td><span style="font-family: DejaVu Sans;"> &#x20B9;
                                                    {{ $row->amount }}</span></td>
                                            <td>{{ $row->transaction_id }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-center mt-3">No Transactions done.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</body>

</html>
