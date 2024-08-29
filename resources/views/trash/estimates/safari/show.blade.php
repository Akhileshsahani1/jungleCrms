<!doctype html>
<html lang="en">

<head>
    <title>Safari Estimate</title>
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
    <link rel="stylesheet" href="{{ asset('dist/css/estimate-new.css') }}">
     @if($company->dark_color)
       <style>
         .table-condensed tr th.billedname{
            color:{{ $company->dark_color }};
         }
         .table-striped tbody tr:nth-of-type(odd){
            background: {{ $company->light_color }} !important;
         }
         .forenquiry{
            border-left: 2px solid {{ $company->dark_color }};
            background-color: {{ $company->light_color }};
         }
         .btn-success{
            background-color: {{ $company->dark_color }};
         }
         .text-success{
            color:{{ $company->dark_color }} !important;
         }
         #accordionExample .btn .fa{
            color:{{ $company->dark_color }};
         }
         .nav-link.active{
            color:{{ $company->dark_color }} !important;
         }
         .bookdetail tr th.card-title,.scantopay p.scantitle{
            background: {{ $company->dark_color }} !important;
         }
         .bookdetail{
                 border-bottom: 2px solid {{ $company->dark_color }};
             }

        </style>
    @endif
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
                <!-- <h4 class="estimate-heading">Safari Estimate</h4> -->
                <div class="billedby">
                    <span><b>{{ $company->name }}</b></span>
                    @if (in_array($estimate->website, ['dailytourandtravel.com','internationaltrips.in']))
                        <span>{{ $company->address_1 }}, {{ $company->address_2 }}</span>
                        <span>{{ $company->state . ', India-' . $company->pincode }}</span>
                        <span><strong>Company GST:</strong> {{ $company->gstin }}</span>
                    @else
                        <!-- <span>{{ $company->address_1 }}, {{ $company->address_2 }} </span>
                    <span>{{ $company->state . ', India-' . $company->pincode }}</span> -->
                        @isset($local_address)
                            <span>
                                <!-- <strong>Local Address:</strong> --> {{ $local_address->address_1 }},
                                {{ $local_address->address_2 }}
                            </span>
                            <span>{{ $local_address->state . ', India-' . $local_address->pincode }}</span>
                        @endisset
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
                        <!-- <span><strong>Company GST:</strong> {{ $company->gstin }}</span> -->
                    @endif
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
                            <!-- <th class="text-left">Billed By:</th> -->
                            <th class="text-left billedtitle">Billed To</th>
                        </tr>
                        <tr>
                            <!-- <th class="text-left">{{ $company->name }}</th> -->
                            <th class="text-left billedname">{{ $estimate->customer->name }}</th>
                        </tr>
                        <tr>
                            <!-- <td class="text-left">{{ $company->address_1 }}</td> -->
                            <td class="text-left">{{ $estimate->customer->address }}</td>
                        </tr>
                        <tr>
                            <!-- <td class="text-left">{{ $company->address_2 }}</td> -->
                            <td class="text-left">{{ $estimate->customer->state }}</td>
                        </tr>
                        <tr>
                            <!--  <td class="text-left">{{ $company->state . ', India-' . $company->pincode }}</td> -->
                        </tr>
                        <tr>
                            <!-- <td class="text-left"><strong>Email:</strong> {{ $company->email }}</td> -->
                            <td class="text-left"><strong>Email:</strong> {{ $estimate->customer->email }}</td>
                        </tr>
                        <tr>
                            <!-- <td class="text-left"><strong>Company GST:</strong> {{ $company->gstin }}</td> -->
                            <td class="text-left"><strong>Phone:</strong> {{ $estimate->customer->mobile }}</td>

                        </tr>

                        <tr>

                            @isset($estimate->customer->gstin)
                                <td class="text-left"><strong>GST:</strong> {{ $estimate->customer->gstin }}</td>
                            @endisset
                        </tr>
                        <tr>
                            @isset($estimate->assigned_to)
                                <!--  <td class="text-left"><strong>Contact Number:</strong>
                                         {{ $estimate->user->phone }}
                                    </td> -->
                            @endisset
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-sm-5 estimatecol">
                <div class="text-right buttontype">
                    <h4 class="estimate-heading">Safari Estimate</h4>
                    <button
                        @if ($estimate->payment_status == 'unpaid') class="btn btn-danger" @elseif($estimate->payment_status == 'partially paid') class="btn bg-orange" @else class="btn btn-success" @endif
                        id="payment_status">{{ ucfirst($estimate->payment_status) }}</button>
                </div>
            </div>
            <div class="col-12">
                <ul class="nav nav-tabs card-header-tabs" id="myTabSafari" role="tablist">
                    @foreach ($estimate->safari_options as $key => $option)
                        <li class="nav-item">
                            <a @if ($loop->first) class="nav-link active" @else class="nav-link" @endif
                                id="{{ $key }}-tab-safari" data-toggle="tab"
                                href="#tab-safari-{{ $key }}" role="tab"
                                aria-controls="{{ $key }}"
                                @if ($loop->first) aria-selected="true" @else aria-selected="false" @endif>
                                <p class="m-0 f12 f900" style="color: red!important">Option {{ $loop->iteration }}</p>
                                <h4>₹ {{ $option->total }}/-</h4>
                                <p class="m-0 text-muted f12 f900">Total</p>
                                <p class="m-0 f16 f700">{{ $option->content }} </p>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="tab-content" id="myTabSafariContent">
                    @foreach ($estimate->safari_options as $key => $option)
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
                                        @if ($estimate->safari->sanctuary == 'ranthambore')
                                            <tr>
                                                <td><b>Destination: </b></td>
                                                <td><span> {{ $estimate->safari->area }}</span></td>
                                            </tr>
                                        @elseif ($estimate->safari->sanctuary == 'jim')
                                            <tr>
                                                <td><b>Destination: </b></td>
                                                <td><span> Jim Corbett National Park</span></td>
                                            </tr>
                                        @elseif ($estimate->safari->sanctuary == 'gir')
                                            <tr>
                                                <td><b>Destination: </b></td>
                                                <td><span>Gir National Park</span></td>
                                            </tr>
                                        @endif
                                        @if ($estimate->safari->sanctuary == 'jim')
                                            <tr>
                                                <td><b>Safari Zone: </b></td>
                                                <td><span>{{ $estimate->safari->area }}</span></td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td><b>Safari Zone: </b></td>
                                                <td><span>{{ $estimate->safari->zone }}</span></td>
                                            </tr>
                                        @endif
                                        @if ($estimate->safari->sanctuary == 'ranthambore')
                                            <tr>
                                                <td><b>Total Person: </b></td>
                                                <td><span> {{ $estimate->safari->total_person }}</span></td>
                                            </tr>
                                        @elseif ($estimate->safari->sanctuary == 'jim')
                                            <tr>
                                                <td><b>Total Person: </b></td>
                                                <td><span>{{ $estimate->safari->total_person }}</span></td>
                                            </tr>
                                        @elseif ($estimate->safari->sanctuary == 'gir')
                                            <tr>
                                                <td><b>Total Person: </b></td>
                                                <td><span> {{ $estimate->safari->adult }} Adults +
                                                        {{ $estimate->safari->child }} Child</span></td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td><b>Safari Date: </b></td>
                                            <td><span>
                                                    {{ \Carbon\Carbon::parse($estimate->safari->date)->format('d-m-Y') }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Safari Time: </b></td>
                                            <td><span> {{ $estimate->safari->time }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><b>Safari Vehicle: </b></td>
                                            <td> <span> {{ $estimate->safari->mode }}</span></td>
                                        </tr>
                                        <tr>
                                            <td><b>No. of Vehicle: </b></td>
                                            <td> <span> {{ $estimate->safari->jeeps }}</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                                @isset($estimate->safari->note)
                                    <div class="col-sm-12 mb-2" style="display: -webkit-inline-box"><strong
                                            class="mr-1">Note : </strong> {!! $estimate->safari->note !!}</div>
                                @endisset
                                <div class="col-sm-8 bankdetailtable">
                                    <div class="text-center acceptedbtn mt-5 mb-3">
                                        @if ($estimate->estimate_status == 'accepted' && $option->accepted == 'yes')
                                            <a href="javascript:void(0)" class="btn text-white btn-success"
                                                disabled>Accepted</a>
                                        @elseif($estimate->estimate_status == 'accepted' && $option->accepted == 'no')
                                            <a href="javascript:void(0)" class="btn text-white btn-dark"
                                                disabled>Rejected</a>
                                        @else
                                            <form method="POST"
                                                action="{{ route('safari-estimate.accept', $option->id) }}">
                                                @csrf
                                                @method('PUT')
                                                {{-- @if ($estimate->safari->sanctuary == 'jim')
                                                    <div class="mb-4">
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
                                                                    Pay 50% [
                                                                    ₹{{ ($option->amount - $option->discount) / 2 }} ]
                                                                </strong></label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio"
                                                                id="payamount2{{ $random_number }}{{ $key }}"
                                                                name="payamount" class="custom-control-input" checked
                                                                value="full">
                                                            <label class="custom-control-label"
                                                                for="payamount2{{ $random_number }}{{ $key }}"><strong>
                                                                    Pay Full [
                                                                    ₹{{ $option->amount - $option->discount }} ]
                                                                </strong></label>
                                                        </div>
                                                    </div>
                                                @else --}}
                                                @php
                                                    $random_number = random_int(1000, 9999);
                                                @endphp
                                                <div class="custom-control custom-radio custom-control-inline"
                                                    style="display: none;">
                                                    <input type="radio"
                                                        id="payamount2{{ $random_number }}{{ $key }}"
                                                        name="payamount" class="custom-control-input" checked
                                                        value="full">
                                                    <label class="custom-control-label"
                                                        for="payamount2{{ $random_number }}{{ $key }}"><strong>
                                                            Pay Full [ ₹{{ $option->total }} ]
                                                        </strong></label>
                                                </div>
                                                <div class="mb-4">
                                                    <div class="icheck-primary">
                                                        <input type="checkbox" name="accept" id="accept"
                                                            value="1">
                                                        <label for="accept">
                                                            I have read all <a class="text-info" href="#"
                                                                data-toggle="modal"
                                                                data-target="#full-width-modal">Terms
                                                                and Conditions</a> mentioned and agree to it.
                                                        </label>
                                                    </div>
                                                    @error('accept')
                                                        <span id="accept-error" class="error"
                                                            style="color:red">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                {{-- @endif --}}
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
                                    <!-- <h5 class="card-title mt-3">Payment Details</h5> -->
                                    <strong>Total Amount: </strong><span class="float-right"> ₹
                                        {{ $option->amount }}/-</span><br>
                                    @if ($option->discount > 0)
                                        <strong>Discount: </strong><span class="float-right"> ₹
                                            {{ $option->discount }}/-</span><br>
                                    @endif
                                    @if (isset($estimate->gst_filed) && $estimate->gst_filed != 0)
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
                    <div class="fbilledby">
                        <span><b>{{ $company->name }}</b></span>
                        <span>{{ $company->address_1 }}, {{ $company->address_2 }},
                            {{ $company->state . ', India-' . $company->pincode }}</span>
                        <span><strong>GSTIN:</strong> {{ $company->gstin }}</span>
                    </div>
                    <h6>For any enquiry, reach out via email and call</h6>
                    <span class="text-info">{{ $company->email }}</span>
                    <span class="text-info">{{ $company->phone }}</span>.
                </div>
            </div>
        </div>
    </div>
    <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="fullWidthModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="fullWidthModalLabel">Terms and Conditions</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    {!! $content->content ?? '' !!}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
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
