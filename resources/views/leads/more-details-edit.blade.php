@extends('layouts.master')
@section('title', 'Edit Lead')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Lead</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('leads.index') }}">Leads</a></li>
                        <li class="breadcrumb-item active">Edit Lead</li>
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
            <form action="{{ route('leads.update-more-details', $lead->id) }}" method="POST" enctype="multipart/form-data" id="leadform">
                @csrf
                @method('PUT')               
                <div class="card-header bg-dark">
                    <h6>More Details</h6>
                </div>
                <div class="card-body row">
                    <div class="form-group col-sm-6">
                        <label for="dob">Date of Birth</label>
                        <input type="date" class="form-control" name="dob" id="dob" placeholder="Date of Birth" value="{{ old('dob',$lead->dob) }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="anniversary">Anniversary Date</label>
                        <input type="date" class="form-control" name="anniversary" id="anniversary" placeholder="Anniversary Date" value="{{ old('anniversary', $lead->anniversary) }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="address">Address</label>
                        <textarea class="form-control" name="address" id="address" placeholder="Address" rows="3">{{ old('address', $lead->address) }}</textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="more_details">More Details</label>
                        <textarea class="form-control" name="more_details" id="more_details" placeholder="More Details" rows="3">{{ old('more_details', $lead->more_details) }}</textarea>
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="total_traveller">Total Traveler</label>
                        <input type="text" class="form-control" name="total_traveller" id="total_traveller" placeholder="Total Traveler" value="{{ old('total_traveller',$lead->total_traveller) }}">
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="travel_date">Travel Date</label>
                        <input type="date" class="form-control" name="travel_date" id="travel_date" placeholder="Travel Date" value="{{ old('travel_date', $lead->travel_date) }}">
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="meal_plan">Meal Plan</label>
                        <textarea class="form-control" name="meal_plan" id="meal_plan" placeholder="Meal Plan" rows="3">{{ old('meal_plan', $lead->meal_plan) }}</textarea>
                    </div>
                </div>
            </form>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="leadform">Save</button>
            </div>
        </div>
    </section>
@endsection
