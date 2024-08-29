@extends('layouts.master')
@section('title', 'Create Lead Status')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Lead Status</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">Settings</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('lead-status.index') }}">Lead Status</a></li>
                        <li class="breadcrumb-item active">Create Lead Status</li>
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
                <form id="LeadStatus" method="POST" action="{{ route('lead-status.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Status Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Status Name"
                            value="{{ old('name') }}">
                        @error('name')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="LeadStatus">Save</button>
            </div>
        </div>
    </section>
@endsection
