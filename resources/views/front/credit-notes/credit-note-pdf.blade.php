@php
$booking_type = bookingType($booking->id);

if (checkFirstTransaction($booking->id, $transaction->id) && in_array('safari', $booking_type) && $booking->safari->sanctuary == 'gir') {
    $amount_taxable = $transaction->amount - getNonTaxableAmount($booking->id);
    $taxable        = $transaction->amount - getNonTaxableAmount($booking->id)  - $booking->Cancel->cancellation_charges;
} else {
    $amount_taxable = $transaction->amount;
    $taxable        = $transaction->amount;
}

$igst           = $amount_taxable - $amount_taxable * (100 / (100 + 5));
$igst_taxable   = $taxable - $taxable * (100 / (100 + 5));
$cgst           = $igst / 2;
$cgst_taxable   = $igst_taxable / 2;
$sgst           = $igst / 2;
$sgst_taxable   = $igst_taxable / 2;
$total_cancellation_charges = $booking->Cancel->cancellation_charges + $booking->Cancel->permit_cancellation_charges;
$cancel_gst     = $total_cancellation_charges -$total_cancellation_charges * (100 / (100 + 5));

@endphp
<!doctype html>
<html lang="en">

<head>
    <title>Credit Note</title>
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
                    <img src="{{ asset('dist/img/invoice-logo.png') }}" title="Invoice" alt="Invoice">
                </div>
                <div class="float-right">
                    <h4 class="estimate-heading text-right">Credit Note</h4>
                        <p  class="text-right"> <strong>Place of Service : </strong>{{ $booking->customer->state }}</p>
                </div>
                <div class="clearfix"></div>
                <hr>
            </header>
            <div class="row">
                <table class="table table-detail table-condensed">
                    <tbody>
                        <tr>
                            <th class="text-left"> S No :</th>
                            <td class="text-right">CN-{{ 1000 + $booking->credit->id }}</td>
                        </tr>
                        <tr>
                            <th class="text-left"> Credit Date :</th>
                            <td class="text-right">{{ $booking->credit->date ? date('d/m/Y', strtotime($booking->credit->date)) : date('d/m/Y') }}</td>
                        </tr>
                        <tr>
                            <th class="text-left">Invoice :</th>
                            <td class="text-right">
                                #{{ 10000 + $invoice->id }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-left">Invoice Date :</th>
                            <td class="text-right">{{ $invoice->date ? date('d/m/Y', strtotime($invoice->date)) : date('d/m/Y') }}</td>
                        </tr>
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
                    <table class="table table-billing-details table-condensed">
                        <tbody>
                            <tr>
                                <tr class="text-left"><p><strong>Subject : </strong> {{ ucfirst($booking->type) }} Booking</p></tr>
                            </tr>
                        </tbody>
                    </table>
                    <div class="table-border">
                        <table class="table table-condensed table-content">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Item & Description</th>
                                    <th>HSN/SAC</th>
                                    <th>Quantity</th>
                                    <th>Rate (%)</th>
                                    <th>Amount (INR)</th>
                                    <th>GST (INR)</th>
                                    <th class="text-right">Total (INR)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th colspan="4">Refundable Amount</th>
                                </tr>

                                <tr>
                                    <td>1. Taxable Amount</td>
                                    <td>9985</td>
                                    <td>1</td>
                                    <td>5%</td>
                                    <td><span
                                            style="font-family: DejaVu Sans;">&#x20B9;</span>{{ round($taxable - $igst_taxable, 2) }}
                                    </td>
                                    <td><span style="font-family: DejaVu Sans;">&#x20B9;</span>{{ round($igst_taxable, 2) }}</td>
                                    <td class="text-right"><span
                                            style="font-family: DejaVu Sans;">&#x20B9;</span>{{ round($taxable) }}
                                    </td>
                                </tr>

                                @if (checkFirstTransaction($booking->id, $transaction->id))
                                    @if (in_array('safari', $booking_type) && $booking->safari->sanctuary == 'gir')
                                        <tr>
                                            <td>2. Permit Cost (Non Taxable Amount)</td>
                                            <td>9985</td>
                                            <td>1</td>
                                            <td>0%</td>
                                            <td><span
                                                    style="font-family: DejaVu Sans;">&#x20B9;</span>{{ getNonTaxableAmount($booking->id) - $booking->Cancel->permit_cancellation_charges }}
                                            </td>
                                            <td><span style="font-family: DejaVu Sans;">&#x20B9;</span>0</td>
                                            <td class="text-right"><span
                                                    style="font-family: DejaVu Sans;">&#x20B9;</span>{{ getNonTaxableAmount($booking->id) - $booking->Cancel->permit_cancellation_charges }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th colspan="4">Non Refundable Amount</th>
                                    </tr>
                                    <tr>
                                        <td>1. Cancellation Charge</td>
                                        <td>9985</td>
                                        <td>1</td>
                                        <td>5%</td>
                                        <td><span
                                                style="font-family: DejaVu Sans;">&#x20B9;</span>{{ round($total_cancellation_charges - $cancel_gst, 2) }}
                                        </td>
                                        <td><span
                                                style="font-family: DejaVu Sans;">&#x20B9;</span>{{ round($cancel_gst, 2) }}
                                        </td>
                                        <td class="text-right"><span
                                                style="font-family: DejaVu Sans;">&#x20B9;</span>{{ round($total_cancellation_charges) }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td style="60%">
                                    <span>Total in Words:</span>
                                    @if (checkFirstTransaction($booking->id, $transaction->id))
                                    @if (in_array('safari', $booking_type) && $booking->safari->sanctuary == 'gir')
                                            <p><strong><em>{{ AmountInWords(round($amount_taxable) + getNonTaxableAmount($booking->id) - round($total_cancellation_charges)) }}</em></strong>
                                            </p>
                                        @else
                                            <p><strong><em>{{ AmountInWords(round($amount_taxable) - round($total_cancellation_charges)) }}</em></strong>
                                            </p>
                                        @endif
                                    @else
                                        <p><strong><em>{{ AmountInWords(round($amount_taxable)) }}</em></strong></p>
                                    @endif
                                </td>
                                <td class="text-right pr-2" style="line-height: 30px;">
                                    @if (checkFirstTransaction($booking->id, $transaction->id))
                                    @if (in_array('safari', $booking_type) && $booking->safari->sanctuary == 'gir')
                                            <span class="float-left"
                                                style="font-family: DejaVu Sans;"><strong>Total</strong></span> <span
                                                class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;
                                                {{ round($amount_taxable) + getNonTaxableAmount($booking->id) }}</span><br>
                                            <div class="clearfix"></div>
                                            <span class="float-left" style="font-family: DejaVu Sans;"><strong>Cancellation
                                                    Charge</strong></span> <span class="float-right"
                                                style="font-family: DejaVu Sans; color:red">&#8722; &#x20B9;
                                                {{ round($total_cancellation_charges) }}</span><br>
                                            <div class="clearfix"></div>
                                            <span class="float-left" style="font-family: DejaVu Sans;"><strong>Credit
                                                    Remaining</strong></span> <span class="float-right"
                                                style="font-family: DejaVu Sans;"> &#x20B9;
                                                {{ round($amount_taxable) + getNonTaxableAmount($booking->id) - round($total_cancellation_charges) }}</span><br>
                                        @else
                                            <span class="float-left"
                                                style="font-family: DejaVu Sans;"><strong>Total</strong></span> <span
                                                class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;
                                                {{ round($amount_taxable) }}</span><br>
                                            <div class="clearfix"></div>
                                            <span class="float-left" style="font-family: DejaVu Sans;"><strong>Cancellation
                                                    Charge</strong></span> <span class="float-right"
                                                style="font-family: DejaVu Sans; color:red">&#8722; &#x20B9;
                                                {{ round($total_cancellation_charges) }}</span><br>
                                            <div class="clearfix"></div>
                                            <span class="float-left" style="font-family: DejaVu Sans;"><strong>Credit
                                                    Remaining</strong></span> <span class="float-right"
                                                style="font-family: DejaVu Sans;"> &#x20B9;
                                                {{ round($amount_taxable) - round($total_cancellation_charges) }}</span><br>
                                        @endif
                                    @else
                                        <span class="float-left"
                                            style="font-family: DejaVu Sans;"><strong>Total</strong></span> <span
                                            class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;
                                            {{ round($amount_taxable) }}</span><br>
                                        <div class="clearfix"></div>
                                        <span class="float-left" style="font-family: DejaVu Sans;"><strong>Credit
                                                Remaining</strong></span> <span class="float-right"
                                            style="font-family: DejaVu Sans;"> &#x20B9;
                                            {{ round($amount_taxable) }}</span><br>
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
                                @foreach($booking->transactions as $row)
                                @if($transaction->id == $row->id)
                                <tr>
                                    <td>{{ $row->date ?  date('F d, Y', strtotime($row->date)) : date('F d, Y') }}</td>
                                    <td>{{ $row->mode}}</td>
                                    <td><span style="font-family: DejaVu Sans;"> &#x20B9; {{ $row->amount }}</span></td>
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
