@extends('layouts.master')
@section('title', 'Copy Estimate Link')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-calculator"></i> Copy Estimate link</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <div class="btn-group">
                        <a href="{{ route('estimates.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Estimate link</label>
                    <input type="text" class="form-control" name="short_url" id="short_url" placeholder="Short URL"
                        value={{ $shortURL }} readonly />
                </div>
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" onclick="copyToClipboard()">Copy</button>
                    <a class="btn btn-sm btn-secondary" href="{{ route('estimates.send-whatsapp-message', ['id' => $estimate->id, 'link' => $shortURL ]  ) }}">
                        @if($estimate->share_count == 0 || $estimate->share_count == '') 
                    Send to Whattsapp
                @else
                Resend({{ $estimate->share_count }}) to Whattsapp
                @endif</a>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="content">
        <div class="card">
            <div class="card-body">
                <form id="linkForm" method="POST" action="{{ route('estimates.send-link-message', $estimate->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" class="form-control" name="link" id="link" placeholder="Short URL"
                        value={{ $shortURL }}/>
                    <div class="form-group">
                        <label>Customer Mobile Number</label>
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone Number"
                            value={{ $estimate->customer->mobile }}>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-sm btn-primary" type="submit" form="linkForm">Send Link</button>
                    </div>
                </form>
            </div>
        </div>
    </section> --}}
@endsection
@push('scripts')
    <script>
        function copyToClipboard() {
            var textBox = document.getElementById("short_url");
            textBox.select();
            document.execCommand("copy");
            alert("Link copied");
        }
    </script>
@endpush
