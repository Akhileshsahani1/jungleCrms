@extends('layouts.master')
@section('title', 'Reports')
@section('head')
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reports</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Sales</a></li>
                        <li class="breadcrumb-item active">Reports</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fa fa-file-invoice"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Performa Invoices Generated</span>
                      <span class="info-box-number">{{ $proforma_invoices_count }}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-4 col-sm-6 col-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-success"><i class="fa fa-file-invoice-dollar"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Tax Invoices Generated</span>
                      <span class="info-box-number">{{ $tax_invoices_count }}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-4 col-sm-6 col-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-warning"><i class="fa fa-file-invoice-dollar"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Tax Invoices Pending</span>
                      <span class="info-box-number">{{$proforma_invoices_count - $tax_invoices_count  }}</span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                  <!-- /.info-box -->
                </div>
              </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header">
                @include('sales.reports.filter')
            </div>
            <div class="card-body">
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                        <th>Invoice No.</th>
                        <th>Invoice Date</th>
                        <th>Customer</th>
                        <th>Mobile</th>
                        <th>Total</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ 10000 +$invoice->id }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->date)->format('d-m-Y') }}</td>
                            <td>{{ $invoice->booking->customer->name }}</td>
                            <td>{{ $invoice->booking->customer->mobile }}</td>
                            <td>₹{{ $invoice->transaction->amount }}</td>
                            <td>

                                <a href="{{ route('tax.invoice', $invoice->transaction_id) }}" class="btn btn-primary"> <i class="fas fa-eye"></i> </a>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('layouts.utilities')
    <script>
        $("#filter").on("click", function(e){
            e.preventDefault();
            $('#form-filter').attr('action', "{{ route('reports.index') }}").submit();
        });

        $("#download").on("click", function(e){
            e.preventDefault();
            $('#form-filter').attr('action', "{{ route('reports.create') }}").submit();
        });

        $("#export").on("click", function(e){
            e.preventDefault();
            $('#form-filter').attr('action', "{{ route('reports.show', 0) }}").submit();
        });
    </script>
@endpush
