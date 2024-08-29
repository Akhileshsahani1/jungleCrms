@extends('layouts.master')
@section('title', 'Create Marquee')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Marquee</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('marquees.index') }}">Marquees</a></li>
                        <li class="breadcrumb-item active">Create Marquee</li>
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
                <form method="post" id="weekendForm" action="{{ route('marquees.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="content">Content*</label>
                                <input type="text" id="content" class="form-control" placeholder="Content"
                                name="content" value="{{ old('content') }}">
                                @error('content')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="text_color">Text Color*</label>
                                <input type="color" id="text_color" class="form-control" placeholder="Text Color"
                                name="text_color" value="{{ old('text_color', '#ffffff') }}">
                                @error('text_color')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="background_color">Background Color*</label>
                                <input type="color" id="background_color" class="form-control" placeholder="Text Color"
                                name="background_color" value="{{ old('background_color') }}">
                                @error('background_color')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="statuses">Status*</label>
                                <select id="statuses" class="form-control" name="status">
                                    <option value="1" {{ old('status') == 1 ? "selected" : "" }}>Active</option>
                                    <option value="0" {{ old('status') == 0 ? "selected" : "" }}>Inactive</option>
                                </select>
                                @error('status')
                                    <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
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
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <button type="submit" class="btn btn-success" form="weekendForm">Add</button>
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