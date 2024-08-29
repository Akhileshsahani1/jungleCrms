<!doctype html>
<html lang="en">

<head>
    <title>Hotel Estimate</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/estimate.css') }}">
</head>

<body>
    <div class="container-sm estimate-container">
        <header>
            <div class="float-left">
                <img src="{{ asset('dist/img/invoice-logo.png') }}" title="Invoice" alt="Invoice">
            </div>
            <div class="float-right">
                <h4 class="estimate-heading">Hotel Estimate</h4>
                <div class="text-right">
                    <button class="btn btn-outline-success"
                        id="payment_status">{{ ucfirst($estimate->payment_status) }}</button>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr>
        </header>
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
                            <th class="text-right">{{ $estimate->customer->name }}</th>
                        </tr>
                        <tr>
                            <td class="text-left">{{ $company->address_1 }}</td>
                            <td class="text-right">{{ $estimate->customer->address }}</td>
                        </tr>
                        <tr>
                            <td class="text-left">{{ $company->address_2 }}</td>
                            <td class="text-right">{{ $estimate->customer->state }}</td>
                        </tr>
                        <tr>
                            <td class="text-left">{{ $company->state.", India-".$company->pincode }}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Email:</strong> {{ $company->email }}</td>
                            <td class="text-right"><strong>Email:</strong> {{ $estimate->customer->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Company GST:</strong> {{ $company->gstin }}</td>
                            <td class="text-right"><strong>Phone:</strong> {{ $estimate->customer->mobile }}</td>

                        </tr>
                        <tr>
                            @isset($estimate->assigned_to)
                            <td class="text-left"><strong>Contact Person:</strong>
                                 {{ $estimate->user->name }}
                            </td>
                            @else
                            <td class="text-left"><strong>Phone:</strong>
                                {{ $company->phone }}
                            </td>
                            @endisset
                            @isset($estimate->customer->gstin)
                            <td class="text-right"><strong>GST:</strong> {{ $estimate->customer->gstin }}</td>
                            @endisset
                        </tr>
                        <tr>
                            @isset($estimate->assigned_to)
                            <td class="text-left"><strong>Contact Number:</strong>
                                 {{ $estimate->user->phone }}
                            </td>
                            @endisset
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <h2 class="detail-heading">Hotel Booking Details</h2>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-4">
                <strong>Destination:</strong><span class="mobile-details"> {{ $estimate->hotel->destination }}</span>
            </div>
            <div class="col-sm-4">
                <strong>No. of Nights:</strong> <span class="mobile-details">
                    {{ date_diff(new \DateTime($estimate->hotel->check_in), new \DateTime($estimate->hotel->check_out))->format('%d') }}
            </div>
            <div class="col-sm-4">
                <strong>Pas:</strong><span class="mobile-details"> {{ $estimate->hotel->adult }} Adults +
                    {{ $estimate->hotel->child }} Child</span>
            </div>
            <div class="col-sm-4">
                <strong>Check In:</strong><span class="mobile-details">
                    {{ \Carbon\Carbon::parse($estimate->hotel->check_in)->format('d-m-Y') }}</span>
            </div>
            <div class="col-sm-4">
                <strong>Check Out:</strong><span class="mobile-details">
                    {{ \Carbon\Carbon::parse($estimate->hotel->check_out)->format('d-m-Y') }}</span>
            </div>
        </div>
        <hr>
        <div class="row">
            @foreach ($estimate->hotel_options as $option)
                <div class="col-sm-12 mb-4">
                    <h6><strong>OPTION {{ $loop->iteration }}</strong></h6>
                    <div class="table-border">
                        <table class="table table-condensed table-content">
                            <thead class="bg-dark text-white">
                                <tr>
                                    <th>Content</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @php
                                        $hotel = \App\Models\Hotel::find($option->hotel_id);
                                    @endphp
                                    <td>
                                        {{ $hotel->name }}
                                        <br>
                                        @for ($i = 0; $i < $hotel->rating; $i++)
                                            <span class="fas fa-star text-warning"></span>
                                        @endfor
                                    </td>
                                    <td>
                                        <strong>Package: </strong>₹{{ $option->amount }} <br>
                                        <strong>Room: </strong>{{ $estimate->hotel->room }} Rooms +
                                        {{ $estimate->hotel->bed }} Extra Bed <br>
                                        <strong>Category: </strong>{{ \App\Models\HotelRoom::where('id', $option->room_id)->value('room') }}<br>
                                        <strong>Meals:
                                        </strong>{{ \App\Models\HotelRoomService::find($option->service_id)->service }}
                                        <br>
                                    </td>
                                    <td>₹{{ $option->amount }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <table class="table table-desktop table-condensed">
                            <thead>
                                <tr>
                                    <td style="width:26%"></td>
                                    <td style="width:48%" class="text-center">
                                        @if ($estimate->estimate_status == 'accepted' && $option->accepted == 'yes')
                                            <a href="javascript:void(0)" class="btn btn-success mt-4"
                                                disabled>Accepted</a>
                                        @elseif($estimate->estimate_status == 'accepted' && $option->accepted == 'no')
                                            <a href="javascript:void(0)" class="btn bg-grey mt-4" disabled>Rejected</a>
                                        @else
                                            <a href="{{ route('hotel-estimate.accept', $option->id) }}"
                                                class="btn btn-success mt-4">Accept</a>
                                        @endif
                                    </td>
                                    <td style="width:26%">
                                        <ul class="list-unstyled final-amount">
                                            <li><strong>Total Amount</strong><span
                                                    class="float-right">₹{{ $option->amount }}</span></li>
                                            <li style="border-bottom:1px #000 solid;"><strong>Discount</strong><span
                                                    class="float-right">₹{{ $option->discount }}</span></li>
                                            <li style="border-bottom:1px #000 solid;"><strong>Total (INR)</strong><span
                                                    class="float-right">₹{{ $option->amount - $option->discount }}</span>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        <table class="table table-mobile table-condensed">
                            <thead>
                                <tr>
                                    <td>
                                        @if ($estimate->estimate_status == 'accepted' && $option->accepted == 'yes')
                                            <a href="javascript:void(0)" class="btn btn-success mt-4"
                                                disabled>Accepted</a>
                                        @elseif($estimate->estimate_status == 'accepted' && $option->accepted == 'no')
                                            <a href="javascript:void(0)" class="btn bg-grey mt-4" disabled>Rejected</a>
                                        @else
                                            <a href="{{ route('hotel-estimate.accept', $option->id) }}"
                                                class="btn btn-success mt-4">Accept</a>
                                        @endif
                                    </td>
                                    <td>
                                        <table class="table table-billing-details total-table table-condensed">
                                            <tbody>
                                                <tr>
                                                    <td><strong>Total Amount</strong></td>
                                                    <td>₹{{ $option->amount }}</td>
                                                </tr>
                                                <tr style="border-bottom:1px #000 solid;">
                                                    <td><strong>Discount</strong></td>
                                                    <td>₹{{ $option->discount }}</td>
                                                </tr>
                                                <tr style="border-bottom:1px #000 solid;">
                                                    <td><strong id="tour_total1">Total(INR)</strong></td>
                                                    <td>₹{{ $option->amount - $option->discount }}</td>
                                                    <input type="hidden" id="tour_total" value="22600">
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </thead>
                        </table>
                        <span class="ml-2"><strong>The inclusions of the packages are given below the
                                options</strong></span>
                    </div>
                </div>
            @endforeach
        </div>
        @if ($total)
            @if ($estimate->payment_status != 'paid')
                <div class="row">
                    @foreach ($payment_modes as $mode)
                        @if (in_array($mode->id, $estimate->payment_modes))
                            @if ($mode->mode == 'offline')
                                <div class="col-sm-7">
                                    <p class="text-center bg-dark text-white">Bank details</p>
                                    <div class="col-xs-12"><strong>Account Holder Name</strong><span
                                            class="bank-details">{{ $mode->details['account_holder_name'] }}</span>
                                    </div>
                                    <div class="col-xs-12"><strong>Account Number</strong><span
                                            class="bank-details">{{ $mode->details['account_number'] }}</span>
                                    </div>
                                    <div class="col-xs-12"><strong>IFSC Code</strong><span
                                            class="bank-details">{{ $mode->details['ifsc_code'] }}</span>
                                    </div>
                                    <div class="col-xs-12"><strong>Account Type</strong><span
                                            class="bank-details">{{ ucfirst($mode->details['account_type']) }}</span>
                                    </div>
                                    <div class="col-xs-12"><strong>Bank Name</strong><span
                                            class="bank-details">{{ $mode->details['bank_name'] }}</span>
                                    </div>
                                    <div class="col-xs-12"><strong>Amount Payable</strong><span
                                            class="bank-details">₹{{ $total }}</span>
                                    </div>
                                    </ul>
                                </div>
                            @endif
                            @if ($mode->mode == 'upi')
                                <div class="col-sm-5 text-center">
                                    <p class="text-center bg-dark text-white">UPI - Scan to Pay</p>
                                    <img src="https://upiqr.in/api/qr?name={{ $mode->name }}&vpa={{ $mode->details['upi_id'] }}&amount={{ $total }}&format=png"
                                        width="32%">
                                    <p class="text-cente text-info">{{ $mode->details['upi_id'] }}</p>
                                </div>
                            @endif
                            @if ($mode->mode == 'razorpay')
                                <div class="col-sm-12 text-center mt-3">
                                    <button class="btn btn-info" id="razorpay">Pay Now</button>
                                </div>
                            @endif
                        @endif
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-sm-12 text-center mt-3">
                        <button class="btn btn-success" disabled>Paid</button>
                    </div>
                </div>
            @endif
        @endif
        <div class="row mt-3">
            <div class="col-sm-12">
                <span><strong>The Above Packages includes the following</strong></span><br>
                @foreach ($estimate->inclusions as $inclusion)
                    <span>{{ $loop->iteration }}. {{ $inclusion->content }}</span><br>
                @endforeach
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12">
                <span><strong>Terms & Conditions and Cancellation Policy</strong></span><br>
                @foreach ($estimate->terms as $term)
                    <span>{{ $loop->iteration }}. {{ $term->content }}</span><br>
                @endforeach
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12 text-center">
                For any enquiry, reach out via email at <span class="text-info">{{ $company->email }}</span> or call on <span class="text-info">{{$company->phone}}</span>.
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        $('#razorpay').on('click', function(event) {
            var key = '{{ getRazorpayKey() }}';
            var dorazorpay = true;
            var secretkey = '{{ getRazorpaySecretKey() }}';
            var amount = '{{ $total }}';
            var estimate_id = '{{ $estimate->id }}';

            var options = {
                // "key": "rzp_live_MaDPyLqwM5pEDM",
                "key_secret": secretkey,
                "key": key,
                "amount": Math.round(amount * 100),
                "name": "Jungle Safari India",
                "description": "Payment",
                "image": "https://ranthamboretigerreserve.in/admin/uploads/invoice-logo.png",
                "handler": function(response) {

                    if (typeof response.razorpay_payment_id != 'undefined' || response.razorpay_payment_id >
                        1 || response.razorpay_payment_id != '') {

                        $.ajax({
                            url: '{{ route('estimate.payment-success') }}',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                '_token': '{{ csrf_token() }}',
                                razorpay_payment_id: response.razorpay_payment_id,
                                amount: amount,
                                estimate_id: estimate_id,
                            },
                            success: function(msg) {

                                window.location.href = '';
                            }
                        });

                        return false;

                    }

                },
                "modal": {
                    "ondismiss": function() {
                        return false;
                    },
                },
                "prefill": {
                    "contact": $('#mobile').val(),
                    "email": $('#email').val(),
                },
                "theme": {
                    "color": "#528FF0"
                }
            };

            setTimeout(function() {
                if (dorazorpay == false) {
                    window.location.href = '/';
                    return false;
                }
                var rzp1 = new Razorpay(options);
                rzp1.open();
                event.preventDefault();
            }, 500);

            $('#save').attr('disabled', false);
        });
    </script>
</body>

</html>
