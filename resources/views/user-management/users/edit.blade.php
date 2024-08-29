@extends('layouts.master')
@section('title', 'Edit User')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="#">User Management</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">Edit User</li>
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
                <form id="RoleForm" method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name"
                            value="{{ old('name', $user->name) }}">
                        @error('name')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address"
                            value="{{ old('email', $user->email) }}">
                        @error('email')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password"
                            value="{{ old('password') }}">
                        <span id="name-error" class="error">Enter only to change Password</span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number"
                            value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="leads_per_day">Leads per day</label>
                        <input type="number" class="form-control" id="leads_per_day" name="leads_per_day" placeholder="Enter Leads per day"
                            value="{{ old('leads_per_day', $user->leads_per_day) }}">
                        @error('leads_per_day')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="assign_lead">Assign Lead</label>
                        <select class="form-control" id="assign_lead" name="assign_lead">
                            <option value="">Please Select</option>
                            <option value="0" {{ old('assign_lead', $user->assign_lead) == 0 ? "selected" : "" }}>Automatically (Self Assign)</option>
                            <option value="1" {{ old('assign_lead', $user->assign_lead) == 1 ? "selected" : "" }}>Manually</option>
                        </select>
                        @error('assign_lead')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Roles
                            <span class="btn btn-info btn-sm waves-effect waves-light select-all">Select All</span>
                            <span class="btn btn-dark btn-sm waves-effect waves-light deselect-all">Deselect All</span>
                        </label>
                        <select class="form-control" id="role" name="roles[]" multiple="multiple">
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}"
                                    {{ in_array($role->id, old('roles', [])) ||(isset($user) && $user->roles->contains($role->id))? 'selected': '' }}>
                                    {{ $role->name }}</option>
                            @endforeach
                        </select>
                        @error('roles')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="is_active">Status</label>
                        <select class="form-control" id="is_active" name="is_active" value="{{ old('is_active', $user->is_active) }}">
                            @if ($user->is_active == 1)
                            <option value="1" selected>Active</option>
                            <option value="0">Inactive</option>
                            @else
                            <option value="0" selected>Inactive</option>
                            <option value="1">Active</option>
                            @endif
                        </select>
                        @error('is_active')
                            <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="RoleForm">Save</button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            $('#role').select2({
                theme: 'bootstrap4'
            })
            $('.select-all').click(function() {
                let $select2 = $(this).parent().siblings('#role')
                $select2.find('option').prop('selected', 'selected')
                $select2.trigger('change')
            })
            $('.deselect-all').click(function() {
                let $select2 = $(this).parent().siblings('#role')
                $select2.find('option').prop('selected', '')
                $select2.trigger('change')
            })
        });
    </script>
@endpush
