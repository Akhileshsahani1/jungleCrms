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
    <link rel="stylesheet" href="{{ asset('dist/css/estimate-new.css') }}">
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
            <div class="col-sm-12">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                  @foreach ($estimate->hotel_options as $key => $option)
                  @php
                  $hotel_view = \App\Models\Hotel::find($option->hotel_id);
                  @endphp
                    <li class="nav-item">
                        <a @if($loop->first) class="nav-link active" @else class="nav-link" @endif id="{{ $key }}-tab" data-toggle="tab" href="#tab-{{ $key }}" role="tab" aria-controls="{{ $key }}" @if($loop->first) aria-selected="true" @else aria-selected="false" @endif>
                        <h4>₹ {{ $option->amount - $option->discount }}/-</h4>
                        <p class="m-0 text-muted f12 f900">Total</p>
                        <p class="m-0 f12 f700">{{ $hotel_view->name }} </p>
                        </a>
                    </li>
                   @endforeach
                </ul>
                <div class="tab-content" id="myTabContent">
                    @foreach ($estimate->hotel_options as $key => $option)
                    @php
                    $hotel_view = \App\Models\Hotel::find($option->hotel_id);
                    @endphp
                    <div class="tab-pane fade @if($loop->first) show active @endif p-2 mt-4" id="tab-{{  $key }}" role="tabpanel" aria-labelledby="{{  $key }}-tab">
                        <div class="row">
                            <div class="col-sm-8 mb-4">
                                <h5 class="card-title"> <span class="text-success"> {{ $hotel_view->name }} </span>@for ($i = 0; $i < $hotel_view->rating; $i++) <span class="fas fa-star text-warning float-right"></span> @endfor</h5>
                                <strong>Destination: </strong><span class="float-right">{{ $estimate->hotel->destination }}</span><br>
                                <strong>Check In: </strong><span class="float-right">{{ \Carbon\Carbon::parse($estimate->hotel->check_in)->format('d-m-Y') }}</span><br>
                                <strong>Check Out: </strong><span class="float-right"> {{ \Carbon\Carbon::parse($estimate->hotel->check_out)->format('d-m-Y') }}</span><br>
                                <strong>Total Person: </strong><span class="float-right"> {{ $estimate->hotel->adult }} Adults
                                @if ($estimate->hotel->child > 0)
                                + {{ $estimate->hotel->child }} Child
                                @endif</span><br>
                                <strong>Room: </strong><span class="float-right">{{ $estimate->hotel->room }} Room @if ($estimate->hotel->bed > 0)
                                + {{ $estimate->hotel->bed }} Extra Bed
                                @endif</span><br>
                                <strong>Category:</strong><span class="float-right">{{ \App\Models\HotelRoom::where('id', $option->room_id)->value('room') }}</span><br>
                                <strong>Meals: </strong><span class="float-right">{{ \App\Models\HotelRoomService::find($option->service_id)->service }}</span><br>
                                <div class="text-center mt-3">
                                    <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modal-sm-{{ $key }}">
                                        View Images
                                      </button>
                                </div>
                            </div>
                            <div class="col-sm-4 payment">
                                <h5 class="card-title mt-3">Payment Details</h5>
                                <strong>Total Amount: </strong><span class="float-right"> ₹ {{ $option->amount }}/-</span><br>
                                <strong>Discount: </strong><span class="float-right"> ₹ {{ $option->discount }}/-</span><br><hr>
                                <strong>Total (INR): </strong><span class="float-right">₹ {{ $option->amount - $option->discount }}/-</span><br>
                                <div class="text-center mt-5 mb-3">
                                    @if ($estimate->estimate_status == 'accepted' && $option->accepted == 'yes')
                                    <a href="javascript:void(0)" class="btn text-white btn-success"
                                        disabled>Accepted</a>
                                @elseif($estimate->estimate_status == 'accepted' && $option->accepted == 'no')
                                    <a href="javascript:void(0)" class="btn text-white btn-dark" disabled>Rejected</a>
                                @else
                                    <a href="{{ route('hotel-estimate.accept', $option->id) }}"
                                        class="btn text-white btn-success">Accept</a>
                                @endif
                                </div>
                        </div>
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
    @foreach($estimate->hotel_options as $key => $option)
    @php
        $hotel_images = \App\Models\HotelImage::where('hotel_id', $option->hotel_id)->get();
        $hotel_view = \App\Models\Hotel::find($option->hotel_id);
    @endphp
    <div class="modal fade" id="modal-sm-{{ $key }}">
        <div class="modal-dialog modal-sm-{{ $key }}">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">{{ $hotel_view->name }}</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                @if(count($hotel_images) > 0)
                <div id="carousel{{ $key }}" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach ($hotel_images as $newkey => $image)
                            <li data-target="#carousel{{ $key }}" data-slide-to="{{ $newkey }}"
                                @if ($loop->first) class="active" @endif></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach ($hotel_images as $image)
                            <div class="carousel-item  @if ($loop->first) active @endif">
                                <img class="d-block img-fluid" src="{{ asset('storage/uploads/hotels/' . $option->hotel_id . '/' . $image->image) }}" alt="{{ $image->image }}"
                                    width="514" height="343">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carousel{{ $key }}" role="button"
                        data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel{{ $key }}" role="button"
                        data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                @else
                <p class="text-center mt-3">No Images found.</p>
                @endif
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    @endforeach
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
