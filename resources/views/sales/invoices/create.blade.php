@extends('layouts.master')
@section('title', 'Create Invoice')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="fas fa-globe-asia"></i> Create Invoice</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoices</a></li>
                        <li class="breadcrumb-item active">Create Invoice</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                <div class="card-tools">
                    <a href="{{ url()->previous() }}" class="btn btn-dark">Back</a>
                    <button class="btn btn-success" type="submit" form="invoiceForm">Submit</button>
                </div>
            </div>
            <form method="POST" action="{{ route('invoices.store') }}" id="invoiceForm">
                @csrf
                <div class="card-body">
                    <div class="row">
                        @include('customers.select-customer')
                    </div>
                </div>
                <div class="card-body mt-2">
                    <div class="row">

                    </div>
                </div>
            </form>
        </div>
    </section>
    @include('customers.create')
@endsection
@push('scripts')
    <script>
        <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
        $('#customer_id').select2({
            theme: 'bootstrap4',
            placeholder: "Select Customer",
            allowClear: true,
        })

        setTimeout(function() {
            $('.alert').slideUp();
        }, 4000);

        $('#customer_id').change(function(e) {
            e.preventDefault();
            var customer_id = $(this).val();
            if (customer_id) {
                var url = '{{ route('customers.show', ':id') }}';
                url = url.replace(':id', customer_id);
                $('#customer-detail').slideUp();
                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "json",
                    success: function(response) {
                        $('#customer_name').text(response.name);
                        $('#customer_email').text(response.email);
                        $('#customer_mobile').text(response.mobile);
                        $('#customer_state').text(response.state);
                        $('#customer_address').text(response.address);
                        $('#customer-detail').slideDown();
                        $('#customer-choose').css('display', 'none');
                    }
                });
            } else {
                $('#customer-detail').css('display', 'none');
                $('#customer-choose').css('display', 'block');
            }
        });
    });
    </script>
@endpush
