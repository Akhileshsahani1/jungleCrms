@extends('layouts.master')
@section('title', 'Create Offline Mode')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Offline Mode</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Payment Modes</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('offline-mode.index') }}">Offline Modes</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
                <form id="PaymentModeForm" method="POST" action="{{ route('offline-mode.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Payment Mode Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Payment Mode Name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="account_holder_name">Account Holder Name</label>
                        <input type="text" class="form-control" id="account_holder_name" name="account_holder_name" placeholder="Enter Account Holder Name"
                            value="{{ old('account_holder_name') }}">
                        @error('account_holder_name')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="account_number">Account Number</label>
                        <input type="number" class="form-control" id="account_number" name="account_number" placeholder="Enter Account Number"
                            value="{{ old('account_number') }}">
                        @error('account_number')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="ifsc_code">IFSC Code</label>
                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="Enter IFSC Code"
                            value="{{ old('ifsc_code') }}">
                        @error('ifsc_code')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="account_type">Account Type</label>
                        <select class="form-control" id="account_type" name="account_type">
                                <option value="" selected>Select Account Type</option>
                                <option value="current">Current</option>
                                <option value="savings">Saving</option>
                        </select>
                        @error('account_type')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="bank_name">Bank Name</label>
                        <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Enter Bank Name"
                            value="{{ old('bank_name') }}">
                        @error('bank_name')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="PaymentModeForm">Save</button>
            </div>
        </div>
    </section>
@endsection
