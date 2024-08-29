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
                    <img src="{{ asset('dist/img/invoice-logo.png') }}" title="Invoice" alt="Invoice">
                </div>
                <div class="float-right">
                    <h4 class="estimate-heading">Proforma Invoice</h4>
                </div>
                <div class="clearfix"></div>
                <hr>
            </header>
            <div class="row">
                <div class="col-sm-4">
                    <strong>Invoice Date&nbsp;&nbsp;:</strong><span class="mobile-details"> {{ $booking->date ?  date('F d, Y', strtotime($booking->date)) : date('F d, Y') }}</span>
                </div>
                <div class="col-sm-4 pl-5">

                @switch($booking->type)
                    @case('cab')
                    <strong>Pickup Date:</strong><span class="mobile-details">
                        {{ $booking->cab->start_date ?  date('F d, Y', strtotime($booking->cab->start_date)) : date('F d, Y') }}
                    </span>
                    @break
                    @case('safari')
                    <strong>Safari Date:</strong><span class="mobile-details">
                        {{ $booking->safari->date ?  date('F d, Y', strtotime($booking->safari->date)) : date('F d, Y') }}
                    </span>
                    @break
                    @case('hotel')
                    <strong>Hotel Date:</strong><span class="mobile-details">
                        {{ $booking->hotel->check_in ?  date('F d, Y', strtotime($booking->hotel->check_in)) : date('F d, Y') }}
                    </span>
                    @break
                    @case('tour')

                    @break
                    @case('package')

                    @break

                    @default

                @endswitch
                </div>
                <div class="col-sm-4 text-right">
                    <strong>Proforma Invoice No</strong><span class="mobile-details"> #{{ $booking->id }}</span>
                </div>
                <div class="col-sm-4">
                    <strong>Due Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong><span class="mobile-details"> {{ $booking->date ?  date('F d, Y', strtotime($booking->date)) : date('F d, Y') }}</span>
                </div>
                <div class="col-sm-8 text-right">
                    <button class="btn btn-sm btn-success">{{ ucfirst($booking->payment_status) }}</button>
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
                                <th class="text-left">Jungle safari India</th>
                                <th class="text-right">{{ $booking->customer->name }}</th>
                            </tr>
                            <tr>
                                <td class="text-left">A-2 Second Floor, Ganesh Nagar,</td>
                                <td class="text-right">{{ $booking->customer->address }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">Pandav Nagar Complex, near Aggarwal Sweets</td>
                                <td class="text-right">{{ $booking->customer->state }}</td>
                            </tr>
                            <tr>
                                <td class="text-left">New Delhi, India - 110092</td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Email:</strong> junglesafari360@gmail.com</td>
                                <td class="text-right"><strong>Phone:</strong> {{ $booking->customer->mobile }}</td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Phone:</strong> 01135600224</td>
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
                                    <td><span style="font-family: DejaVu Sans;">&#x20B9;</span>{{ $item->amount - $item->amount * $item->rate/100 }}</td>
                                    <td class="text-right"><span style="font-family: DejaVu Sans;">&#x20B9;</span>{{ $item->amount }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <table width="100%">
                        <tbody>
                            <tr>
                                <td>
                                    <span>Total in Words:</span>
                                    <p><strong><em>{{ AmountInWords(round($booking->items->sum('amount'))) }}</em></strong></p>
                                </td>
                                <td class="text-right pr-2" style="line-height: 30px;">
                                    <span class="float-left">GST</span> <span class="float-right" style="font-family: DejaVu Sans;"> &#x20B9; {{ $booking->items->sum('rate') * $booking->items->sum('amount') / 100 }}</span><br>
                                   <div class="clearfix"></div>
                                   <strong>
                                   <span class="float-left">Total (INR)</span> <span class="float-right"  style="font-family: DejaVu Sans;"> &#x20B9; {{ $booking->items->sum('amount') }}</span><br>
                                   <div class="clearfix" style="border-bottom: 1px solid black;"></div>
                                   <span class="float-left text-success">Advance Paid</span> <span class="float-right text-success" style="font-family: DejaVu Sans;"> &#x20B9; {{ $booking->transactions->sum('amount') }}</span><br>
                                   <div class="clearfix" style="border-bottom: 1px solid black;"></div>
                                   @if($booking->items->sum('amount') - $booking->transactions->sum('amount') > 0)
                                   <span class="float-left text-danger">Balance</span> <span class="float-right text-danger" style="font-family: DejaVu Sans;"> &#x20B9; {{ $booking->items->sum('amount') - $booking->transactions->sum('amount') }}</span><br>
                                   <div class="clearfix" style="border-bottom: 1px solid black;"></div>
                                   @endif
                                   </strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <h6>Transactions</h6>
                    <div class="table-border">
                        @if(count($booking->transactions) > 1)
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
                </div>
            </div>
        </div>
        <div style="width:100%;height:100%;z-index:100;">
        <p class="text-center pb-2">For any enquiry, reach out via email at <a href="mailto:someone@example.com"><strong>junglesafari360@gmail.com</strong></a> or call on <a href="tel:01135600224"><strong>01135600224</strong></a></p>
        </div>
    </div>
    <div class="text-center mb-4">
    <a class="btn btn-warning" href="{{ route('invoices.edit', $booking->id) }}">Download</a>
    </div>
</body>
</html>
