@extends('layouts.master')
@section('title', 'Edit UPI Mode')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit UPI Mode</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Payment Modes</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('upi-mode.index') }}">Offline Modes</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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
                </div>
            </div>
            <div class="card-body">
                <form id="PaymentModeForm" method="POST" action="{{ route('upi-mode.update', $mode->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Payment Mode Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Payment Mode Name"
                            value="{{ old('name', $mode->details['name']) }}">
                        @error('name')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="upi_id">UPI Id or Mobile Number</label>
                        <input type="text" class="form-control" id="upi_id" name="upi_id" placeholder="Enter Account Holder Name"
                            value="{{ old('upi_id', $mode->details['upi_id']) }}">
                        @error('upi_id')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="PaymentModeForm">Update</button>
            </div>
        </div>
    </section>
@endsection
