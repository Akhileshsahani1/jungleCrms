@extends('front.layouts.app')
@section('title', 'Refund ')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Refund </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.bookings') }}">Bookings</a></li>
                        <li class="breadcrumb-item active">Refund </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-header bg-orange">
                                       Refund Details
                                    </div>

                                    <div class="card-body">
                                     <table id="customers" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Transaction Id</th>
                                <th>Attachment</th>
                                <th>Other Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($booking->refundtransactions as $refund)
                                <tr>
                                    <td>
                                        <span class="right badge badge-danger">{{ $refund->date }}</span>
                                    </td>
                                    <td>₹{{ $refund->amount }}</td>
                                    <td>{{ ucfirst($refund->mode) }}</td>
                                    <td>{{ $refund->transaction_id }}</td>
                                     @isset($refund->attachment)
                                    <td>
                                          {{ $refund->attachment }}      
                                        <a href="{{ asset('storage/uploads/bookings/refund/' . $refund->booking_id . '/' . $refund->attachment) }}"
                                                    class="btn btn-sm btn-warning" download><i class="fas fa-download"></i></a>
                                    </td>
                                @else
                                    <td>N/A</td>
                                @endisset
                                    <td>{{ $refund->note }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                                       
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
              
            </div>
    </section>
@endsection
