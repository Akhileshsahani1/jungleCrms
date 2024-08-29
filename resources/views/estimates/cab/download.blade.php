<!doctype html>
<html lang="en">

<head>
    <title>Cab Estimate</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('dist/css/estimate-new.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
</head>

<body>
    <div class="container-sm estimate-container">
        <header>
            <div class="float-left col-sm-5">
                <div class="logo safarilogo">
                    <img src="{{ $company->path }}" title="Invoice" alt="Invoice">
                </div>
            </div>
            <div class="float-right col-sm-7">
                <div class="billedby">
                    <span><b>{{ $company->name }}</b></span>
                    <span>{{ $company->address_1 }}, {{ $company->address_2 }},
                        {{ $company->state . ', India-' . $company->pincode }}</span>
                    <span><strong>Email:</strong> {{ $company->email }}</span>
                    @isset($estimate->assigned_to)
                        <span><strong>Contact Person:</strong>
                            {{ $estimate->user->name }}
                        </span>
                    @endisset
                    @isset($estimate->assigned_to)
                        <span><strong>Contact Number:</strong>
                            {{ $estimate->user->phone }}</span>
                    @else
                        <span><strong>Phone:</strong>
                            {{ $company->phone }}
                        </span>
                    @endisset
                    <span><strong>GSTIN:</strong> {{ $company->gstin }}</span>
                </div>
            </div>
            <div class="clearfix"></div>
            <!-- <hr> -->
        </header>
        <div class="row">
            <div class="col-sm-7 billedcol">
                <table class="table table-billing-details table-condensed">
                    <tbody>
                        <tr>
                            <th class="text-left billedtitle">Billed To</th>
                        </tr>
                        <tr>
                            <th class="text-left billedname">{{ $estimate->customer->name }}</th>
                        </tr>
                        <tr>
                            <td class="text-left">{{ $estimate->customer->address }}</td>
                        </tr>
                        <tr>
                            <td class="text-left">{{ $estimate->customer->state }}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Email:</strong> {{ $estimate->customer->email }}</td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Phone:</strong> {{ $estimate->customer->mobile }}</td>

                        </tr>
                        <tr>
                            @isset($estimate->customer->gstin)
                                <td class="text-left"><strong>GST:</strong> {{ $estimate->customer->gstin }}</td>
                            @endisset
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-sm-5 estimatecol">
                <div class="text-right buttontype">
                    <h4 class="estimate-heading">Cab Estimate</h4>
                    <button
                        @if ($estimate->payment_status == 'unpaid') class="btn btn-danger" @elseif($estimate->payment_status == 'partially paid') class="btn bg-orange" @else class="btn btn-success" @endif
                        id="payment_status">{{ ucfirst($estimate->payment_status) }}</button>
                </div>
            </div>

            <div class="col-12">              
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    @foreach ($estimate->cab_options as $key => $option)
                        <li class="nav-item">
                            <a @if ($loop->first) class="nav-link active" @else class="nav-link" @endif
                                id="{{ $key }}-tab" data-toggle="tab" href="#tab-{{ $key }}"
                                role="tab" aria-controls="{{ $key }}"
                                @if ($loop->first) aria-selected="true" @else aria-selected="false" @endif>
                                <p class="m-0 f12 f900" style="color: red!important">Option {{ $loop->iteration }}</p>
                                <h4>₹ {{ $option->total }}/-</h4>
                                <p class="m-0 text-muted f12 f900">Total</p>
                                <p class="m-0 f16 f700">{{ $option->content }} </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content" id="myTabContent">
                    @foreach ($estimate->cab_options as $key => $option)
                        <div class="tab-pane fade @if ($loop->first) show active @endif p-2 mt-4"
                            id="tab-{{ $key }}" role="tabpanel" aria-labelledby="{{ $key }}-tab">
                            <div class="row">
                                <table class="table table-striped bookdetail">
                                    <thead>
                                        <tr>

                                            <th colspan="2" class="card-title">{{ $option->content }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><b>Trip Type: </b></td>
                                            <td><span> {{ $estimate->cab->trip_type }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Pickup: </b></td>
                                            <td><span> {{ $estimate->cab->pick_up }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Departure: </b></td>
                                            <td><span>
                                                    {{ \Carbon\Carbon::parse($estimate->cab->start_date)->format('d-m-Y') }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Time: </b></td>
                                            <td><span>
                                                    {{ \Carbon\Carbon::parse($estimate->cab->pickup_time)->format('g:i A') }}</span>
                                            </td>
                                        </tr>
                                        @foreach ($estimate->cab->halts as $halt)
                                            <tr>
                                                <td><b>Stop {{ $loop->iteration }}
                                                        ({{ \Carbon\Carbon::parse($halt->start)->format('d-m-Y') }} to
                                                        {{ \Carbon\Carbon::parse($halt->end)->format('d-m-Y') }})</b>
                                                </td>
                                                <td><span>
                                                        {{ $halt->halt }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td><b>Drop: </b></td>
                                            <td><span> {{ $estimate->cab->drop }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Return: </b></td>
                                            <td><span class="float-right">
                                                    {{ \Carbon\Carbon::parse($estimate->cab->end_date)->format('d-m-Y') }}</span>
                                            </td>
                                        </tr>
                                        {{-- <tr>
                                            <td><b>Vehicle Type: </b></td>
                                            <td><span> {{ $estimate->cab->pickup_medium }}</span></td>
                                        </tr> --}}
                                        <tr>
                                            <td><b>Vehicle: </b></td>
                                            <td><span> {{ $estimate->cab->vehicle_type }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Total Vehicle: </b></td>
                                            <td><span> {{ $estimate->cab->no_of_cab }} Vehicle</span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Total Person: </b></td>
                                            <td><span> {{ $estimate->cab->total_riders }} Person</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                @isset($estimate->cab->note)
                                    <div class="col-sm-12" style="display: -webkit-inline-box"><strong class="mr-1">Note : </strong> {!! $estimate->cab->note !!}</div>
                                @endisset
                                <div class="col-sm-8 bankdetailtable">
                                    <div class="text-center acceptedbtn mt-4 mb-3">
                                        @if ($estimate->estimate_status == 'accepted' && $option->accepted == 'yes')
                                            <a href="javascript:void(0)" class="btn text-white btn-success"
                                                disabled>Accepted</a>
                                        @elseif($estimate->estimate_status == 'accepted' && $option->accepted == 'no')
                                            <a href="javascript:void(0)" class="btn text-white btn-dark"
                                                disabled>Rejected</a>
                                        @else
                                            <form method="POST"
                                                action="{{ route('cab-estimate.accept', $option->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-2">
                                                    @php
                                                        $random_number = random_int(1000, 9999);
                                                    @endphp
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio"
                                                            id="payamount1{{ $random_number }}{{ $key }}"
                                                            name="payamount" class="custom-control-input"
                                                            value="half">
                                                        <label class="custom-control-label"
                                                            for="payamount1{{ $random_number }}{{ $key }}"><strong>
                                                                Pay 50% [ ₹{{ $option->total / 2 }} ] </strong></label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio"
                                                            id="payamount2{{ $random_number }}{{ $key }}"
                                                            name="payamount" class="custom-control-input" checked
                                                            value="full">
                                                        <label class="custom-control-label"
                                                            for="payamount2{{ $random_number }}{{ $key }}"><strong>
                                                                Pay Full [ ₹{{ $option->total }} ] </strong></label>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" name="accept" id="accept"
                                                            value="1">
                                                        <label for="accept">
                                                            I have read all <a class="text-info" href="#" data-toggle="modal" data-target="#full-width-modal">Terms
                                                                and Conditions</a> mentioned and agree to it.
                                                        </label>
                                                    </div>
                                                    @error('accept')
                                                        <span id="accept-error" class="error" style="color:red">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <input type="submit" class="btn text-white btn-success"
                                                    value="Accept">
                                            </form>
                                        @endif
                                    </div>
                                </div>

                                @if (isset($estimate->gst_filed) && ($estimate->gst_filed != 0))
                                <div class="col-sm-4 payment">
                                    @php
                                        $total_without_gst = $option->amount - $option->discount;
                                        $gst = round(($estimate->gst_filed / 100) * $total_without_gst);
                                        $total_with_gst = $total_without_gst + $gst;
                                        $pg_charges = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
                                    @endphp
                                    <strong>Amount: </strong><span class="float-right"> ₹
                                        {{ $option->amount }}/-</span><br>
                                        @if( $option->discount > 0)
                                    <strong>Discount: </strong><span class="float-right"> ₹
                                        {{ $option->discount }}/-</span><br>
                                        @endif
                                    @if (isset($estimate->gst_filed) && ($estimate->gst_filed != 0))
                                        <strong>GST {{ $estimate->gst_filed }} %: </strong><span class="float-right">
                                            ₹
                                            {{ $gst }}/-</span><br>

                                        @if ($estimate->pg_charges_filed != 0)
                                            <hr>
                                            <strong>Subtotal (INR): </strong><span class="float-right">₹
                                                {{ $total_with_gst }}/-</span><br>
                                        @endif
                                    @endif
                                    @if ($estimate->pg_charges_filed != 0)
                                        <strong>PG Charges {{ $estimate->pg_charges_filed }} %: </strong><span
                                            class="float-right">₹
                                            {{ round($pg_charges) }}/-</span><br>
                                    @endif
                                    <hr>
                                    <strong>Total (INR): </strong><span class="float-right">₹
                                        {{ $option->total }}/-</span><br>

                                </div>
                                @elseif(isset($estimate->gst_filed) && ($estimate->gst_filed == 0))
                                <div class="col-sm-4 payment">
                                    @php
                                        $total_without_gst = $option->amount - $option->discount;
                                        $pg_charges = round(($estimate->pg_charges_filed / 100) * $total_without_gst);
                                        $subtotal =  round($total_without_gst * 100/105);
                                        $gst =  round($total_without_gst - $subtotal);
                                       
                                        
                                    @endphp
                                     <strong>Amount: </strong><span class="float-right"> ₹
                                        {{ $subtotal +  $option->discount }}/-</span><br>
                                        @if( $option->discount > 0)
                                    <strong>Discount: </strong><span class="float-right"> ₹
                                        {{ $option->discount }}/-</span><br>
                                        @endif                                
                                        <strong>GST 5 %: </strong><span class="float-right">
                                            ₹
                                            {{ $gst }}/-</span><br>

                                        @if ($estimate->pg_charges_filed != 0)
                                            <hr>
                                            <strong>Subtotal (INR): </strong><span class="float-right">₹
                                                {{ $subtotal + $gst }}/-</span><br>
                                        @endif
             
                                    @if ($estimate->pg_charges_filed != 0)
                                        <strong>PG Charges {{ $estimate->pg_charges_filed }} %: </strong><span
                                            class="float-right">₹
                                            {{ round($pg_charges) }}/-</span><br>
                                    @endif
                                    <hr>
                                    <strong>Total (INR): </strong><span class="float-right">₹
                                        {{ $option->total }}/-</span><br>
                                </div>
                                @else
                                <div class="col-sm-4 payment">
                                    @php
                                        $total_without_gst = $option->amount - $option->discount;
                                        $gst = round(($estimate->gst_filed / 100) * $total_without_gst);
                                        $total_with_gst = $total_without_gst + $gst;
                                        $pg_charges = round(($estimate->pg_charges_filed / 100) * $total_with_gst);
                                    @endphp
                                    <strong>Amount: </strong><span class="float-right"> ₹
                                        {{ $option->amount }}/-</span><br>
                                        @if( $option->discount > 0)
                                    <strong>Discount: </strong><span class="float-right"> ₹
                                        {{ $option->discount }}/-</span><br>
                                        @endif
                                    @if (isset($estimate->gst_filed) && ($estimate->gst_filed != 0))
                                        <strong>GST {{ $estimate->gst_filed }} %: </strong><span class="float-right">
                                            ₹
                                            {{ $gst }}/-</span><br>

                                        @if ($estimate->pg_charges_filed != 0)
                                            <hr>
                                            <strong>Subtotal (INR): </strong><span class="float-right">₹
                                                {{ $total_with_gst }}/-</span><br>
                                        @endif
                                    @endif
                                    @if ($estimate->pg_charges_filed != 0)
                                        <strong>PG Charges {{ $estimate->pg_charges_filed }} %: </strong><span
                                            class="float-right">₹
                                            {{ round($pg_charges) }}/-</span><br>
                                    @endif
                                    <hr>
                                    <strong>Total (INR): </strong><span class="float-right">₹
                                        {{ $option->total }}/-</span><br>

                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        @if ($total)
            @if ($estimate->payment_status != 'paid')
                <div class="row">
                    @foreach ($payment_modes as $mode)
                        @if (in_array($mode->id, $estimate->payment_modes))
                            @if ($mode->mode == 'offline')
                                <div class="col-sm-8">
                                    <table class="table table-striped bookdetail">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="card-title">Bank details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><b>Account Holder Name</b></td>
                                                <td><span>{{ $mode->details['account_holder_name'] }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Account Number</b></td>
                                                <td><span>{{ $mode->details['account_number'] }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>IFSC Code</b></td>
                                                <td><span>{{ $mode->details['ifsc_code'] }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Account Type</b></td>
                                                <td><span>{{ ucfirst($mode->details['account_type']) }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Bank Name</b></td>
                                                <td><span>{{ $mode->details['bank_name'] }}</span></td>
                                            </tr>
                                            <tr>
                                                <td><b>Amount Payable</b></td>
                                                <td><span>₹{{ $total }}</span></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            @endif

                            @if ($mode->mode == 'upi')
                                <div class="col-sm-4 text-center scantopay">
                                    <p class="text-center scantitle">UPI - Scan to Pay</p>
                                    <img src="https://upiqr.in/api/qr?name={{ $mode->name }}&vpa={{ $mode->details['upi_id'] }}&amount={{ number_format($total, 2, '.', '') }}&format=png"
                                        width="90%">
                                    <p class="text-cente text-info">{{ $mode->details['upi_id'] }}</p>
                                </div>
                            @endif
                            @if ($mode->mode == 'razorpay')
                                <div class="col-sm-12 text-center mt-3">
                                    <button class="btn btn-outline-info" id="razorpay"><img
                                            src="{{ asset('dist/img/razorpayicon.png') }}" title="razorpay"
                                            alt="razorpay"> Pay Now</button>
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
            <div class="col-sm-12 Packages">
                <span><strong>The Above Packages includes the following</strong></span><br>
                @foreach ($estimate->inclusions as $inclusion)
                    <span><span class="text-success arrow"><i class="fa fa-check"></i></span>
                        {{ $inclusion->content }}</span><br>
                @endforeach
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12 Packages">
                <span><strong>The Above Packages excludes the following</strong></span><br>
                @foreach ($estimate->exclusions as $exclusion)
                    <span><span class="text-success arrow"><i class="fa fa-check"></i></span>
                        {{ $exclusion->content }}</span><br>
                @endforeach
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12 Packages">
                <span><strong>Cab Itinerary</strong></span><br>
                <div class="accordion" id="accordionExample">
                    @foreach ($estimate->iternaries as $key => $iternary)
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn accordion-toggle" type="button" data-toggle="collapse"
                                        data-target="#collapse-{{ $key }}" aria-expanded="true"
                                        aria-controls="collapseOne">
                                        <span>{{ $iternary->title }}</span>

                                        <i class="fa fa-plus"></i>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse-{{ $key }}"
                                class="collapse @if ($key == 0) show @endif"
                                aria-labelledby="headingOne" data-parent="#accordionExample">
                                <div class="card-body">
                                    {{ $iternary->text }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12 Terms">
                <span><strong>Terms & Conditions and Cancellation Policy</strong></span><br>
                @foreach ($estimate->terms as $term)
                    <span><span class="text-success arrow"><i class="fa fa-check"></i></span>
                        {{ $term->content }}</span><br>
                @endforeach
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-sm-12">
                <div class="forenquiry">
                    <h6>For any enquiry, reach out via email and call</h6>
                    <span class="text-info">{{ $company->email }}</span>
                    <span class="text-info">{{ $company->phone }}</span>.
                </div>
            </div>
        </div>
    </div>
    {{--<div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="fullWidthModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="fullWidthModalLabel">Terms and Conditions</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    {!! $content->content ??'' !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>                   
                </div>
            </div>
        </div>
    </div>--}}
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
    <script>
        $(document).ready(function() {
            // Add minus icon for collapse element which
            // is open by default
            $(".collapse.show").each(function() {
                $(this).prev(".card-header").find(".fa")
                    .addClass("fa-minus").removeClass("fa-plus");
                $(this).prev(".card-header").find(".btn")
                    .attr("data-toggle", '');
            });
            // Toggle plus minus icon on show hide
            // of collapse element
            $(".collapse").on('show.bs.collapse', function() {
                $(this).prev(".card-header").find(".fa")
                    .removeClass("fa-plus").addClass("fa-minus");
                $(this).prev(".card-header").find(".btn")
                    .attr("data-toggle", '');
            }).on('hide.bs.collapse', function() {
                $(this).prev(".card-header").find(".fa")
                    .removeClass("fa-minus").addClass("fa-plus");
                $(this).prev(".card-header").find(".btn")
                    .attr("data-toggle", 'collapse');
            });
        });
    </script>
</body>

</html>
