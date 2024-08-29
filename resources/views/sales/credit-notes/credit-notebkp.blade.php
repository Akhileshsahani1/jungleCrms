@php
if(checkFirstTransaction($booking->id, $transaction->id)){
    $amount_taxable = $transaction->amount - getNonTaxableAmount($booking->id);
}else{
    $amount_taxable = $transaction->amount;
}
$igst = $amount_taxable - $amount_taxable * (100 / (100 + 5));
$cgst = $igst / 2;
$sgst = $igst / 2;
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
    <link rel="stylesheet" href="{{ asset('dist/css/estimate.css') }}">
</head>

<body>
    <div class="container-sm estimate-container">
        <header>
            <div class="float-left">
                <img src="{{ asset('dist/img/invoice-logo.png') }}" title="Invoice" alt="Invoice">
            </div>
            <div class="float-right">
                <h4 class="estimate-heading text-right">Credit Note</h4>
                <p> <strong>Place of Service : </strong>{{ $booking->customer->state }}</p>
            </div>
            <div class="clearfix"></div>
            <hr>
        </header>
        <div class="row">
            <div class="col-sm-4 text-sm-end">
                <strong>S No :</strong><span class="mobile-details"> CN-{{ 1000 + $booking->credit->id }}</span>
            </div>
            <div class="col-sm-8 text-right">
                <strong>Credit Date :</strong><span class="mobile-details">
                    {{ $booking->credit->date ? date('d/m/Y', strtotime($booking->credit->date)) : date('d/m/Y') }}</span>
            </div>
                <div class="col-sm-4 text-sm-end">
                    <strong>Invoice :</strong><span class="mobile-details">
                        #{{ 10000 + $invoice->id }}</span>
                </div>
                <div class="col-sm-8 text-right">
                    <strong>Invoice Date :</strong><span class="mobile-details">
                        {{ $invoice->date ? date('d/m/Y', strtotime($invoice->date)) : date('d/m/Y') }}</span>
                </div>

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
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <p><strong>Subject : </strong> {{ ucfirst($booking->type) }} Booking</p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-border">
                    <table class="table table-condensed table-content">
                        <thead class="bg-dark text-white">
                            <tr>
                                <th>Item & Description</th>
                                <th>HSN/SAC</th>
                                <th>Quantity</th>
                                <th>Rate (INR)</th>
                                <th>Amount (INR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php

                            @endphp
                            <tr>
                                <td>{{ ucfirst($booking->type) }} Booking Refund
                                    <br>
                                    {{ $booking->customer->name }}
                                    <br>
                                    {{ $invoice->date ? date('M Y', strtotime($invoice->date)) : date('M Y') }}
                                </td>
                                <td>9985</td>
                                <td>1</td>
                                <td><span
                                        style="font-family: DejaVu Sans;">&#x20B9;</span>{{ round($amount_taxable - $igst ,2) }}
                                </td>
                                <td><span
                                        style="font-family: DejaVu Sans;">&#x20B9;</span>{{ round($amount_taxable) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <table width="100%">
                    <tbody>
                        <tr>
                            <td style="60%">
                                <span>Total in Words:</span>
                                <p><strong><em>{{ AmountInWords(round($transaction->amount)) }}</em></strong>
                                </p>
                            </td>
                            <td class="text-right pr-2" style="line-height: 30px;">
                                <span class="float-left" style="font-family: DejaVu Sans;"><strong>Sub-Total</strong></span> <span class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;  {{ round($amount_taxable - $igst ,2) }}</span><br>
                                   <div class="clearfix"></div>

                                   @if(checkFirstTransaction($booking->id, $transaction->id))
                                   <span class="float-left" style="font-family: DejaVu Sans;"><strong>Non Taxable Amount</strong></span> <span class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;  {{getNonTaxableAmount($booking->id)}}</span><br>
                                   <div class="clearfix"></div>
                                   @endif

                                   <span class="float-left" style="font-family: DejaVu Sans;"><strong>IGST (5%)</strong></span> <span class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;  {{  $company->state == $booking->customer->state ? '0' : round($igst, 2)}}</span><br>
                                   <div class="clearfix"></div>

                                   <span class="float-left" style="font-family: DejaVu Sans;"><strong>CGST (2.5%)</strong></span> <span class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;  {{  $company->state == $booking->customer->state ? round($cgst, 2) : '0'}}</span><br>
                                   <div class="clearfix"></div>

                                   <span class="float-left" style="font-family: DejaVu Sans;"><strong>SGST (2.5%)</strong></span> <span class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;  {{  $company->state == $booking->customer->state ? round($sgst, 2) : '0'}}</span><br>
                                   <div class="clearfix"></div>
                                   <span class="float-left" style="font-family: DejaVu Sans;"><strong>Total</strong></span> <span class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;  {{ $transaction->amount }}</span><br>
                                   <div class="clearfix"></div>
                                   <span class="float-left" style="font-family: DejaVu Sans;"><strong>Credit Remaining</strong></span> <span class="float-right" style="font-family: DejaVu Sans;"> &#x20B9;  {{ $transaction->amount }}</span><br>
                                   <div class="clearfix"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <h6>Transactions</h6>
                <div class="table-border mb-5">
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
                                @if($transaction->id == $row->id)
                                    <tr>
                                        <td>{{ $row->date ? date('F d, Y', strtotime($row->date)) : date('F d, Y') }}
                                        </td>
                                        <td>{{ $row->mode }}</td>
                                        <td>&#x20B9;{{ $row->amount }}</td>
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
    <div class="row">
        <div class="col-sm-12 mt-2">
            <p class="text-center mt-5">For any enquiry, reach out via email at <a
                    href="mailto:someone@example.com"><strong>junglesafari360@gmail.com</strong></a> or call on <a
                    href="tel:01135600224"><strong>01135600224</strong></a></p>
        </div>
    </div>
    <div class="text-center mb-4">
        <a class="btn btn-warning" href="{{ route('download.credit.note', $transaction->id) }}">Download</a>
    </div>
</body>

</html>
