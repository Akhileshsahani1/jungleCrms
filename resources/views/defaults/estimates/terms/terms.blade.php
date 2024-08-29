@extends('layouts.master')
@section('title', 'Terms & Conditions')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Terms & Conditions</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Defaults</li>
                        <li class="breadcrumb-item active">Terms & Conditions</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="col-12 col-sm-12">
            <div class="card card-dark card-tabs">
                <div class="card-header p-0 pt-1">
                    <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-one-cab-tab" data-toggle="pill"
                                href="#custom-tabs-one-cab" role="tab" aria-controls="custom-tabs-one-home"
                                aria-selected="true">Cab</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-hotel-tab" data-toggle="pill"
                                href="#custom-tabs-one-hotel" role="tab" aria-controls="custom-tabs-one-profile"
                                aria-selected="false">Hotel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-safari-tab" data-toggle="pill"
                                href="#custom-tabs-one-safari" role="tab" aria-controls="custom-tabs-one-messages"
                                aria-selected="false">Safari</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-tour-tab" data-toggle="pill"
                                href="#custom-tabs-one-tour" role="tab" aria-controls="custom-tabs-one-settings"
                                aria-selected="false">Tour</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="custom-tabs-one-package-tab" data-toggle="pill"
                                href="#custom-tabs-one-package" role="tab" aria-controls="custom-tabs-one-package"
                                aria-selected="false">Package</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-one-cab" role="tabpanel"
                            aria-labelledby="custom-tabs-one-cab-tab">
                            <div class="col-sm-12">
                                <strong>Cab Estimate</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-cab">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cab_terms as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-cab" data-toggle="modal" data-target="#modal-edit-cab" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('terms.destroy', $term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token' value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-hotel" role="tabpanel"
                            aria-labelledby="custom-tabs-one-hotel-tab">
                            <div class="col-sm-12">
                                <strong>Hotel Estimate</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-hotel">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Normal Terms</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hotel_normal_terms as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>{{ ucfirst($term->filter) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-hotel" data-toggle="modal" data-target="#modal-edit-hotel" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('terms.destroy', $term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Weekend Terms</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hotel_weekend_terms as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>{{ ucfirst($term->filter) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-hotel" data-toggle="modal" data-target="#modal-edit-hotel" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('terms.destroy', $term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Festival Terms</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Type</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($hotel_festival_terms as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>{{ ucfirst($term->filter) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-hotel" data-toggle="modal" data-target="#modal-edit-hotel" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('terms.destroy', $term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-safari" role="tabpanel"
                            aria-labelledby="custom-tabs-one-safari-tab">
                            <div class="col-sm-12">
                                <strong>Safari Estimate</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-safari">Add</a></span>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Gir Terms</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($safari_gir_terms as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>{{ ucfirst($term->filter) }}</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-safari" data-toggle="modal" data-target="#modal-edit-safari" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('terms.destroy', $term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Jim Corbett Terms</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($safari_jim_terms as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>Jim Corbett</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-safari" data-toggle="modal" data-target="#modal-edit-safari" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('terms.destroy', $term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Ranthambore Terms</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($safari_ran_terms as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>Ranthambore</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-safari" data-toggle="modal" data-target="#modal-edit-safari" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('terms.destroy', $term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                             <div class="col-sm-12 mt-5">
                                <h4 class="text-info text-center">Tadoba Terms</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($safari_tadoba_terms as $term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $term->content }}</td>
                                                <td>Tadoba</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-safari" data-toggle="modal" data-target="#modal-edit-safari" data-filter="{{ $term->filter }}" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                        <form id='delete-form{{ $term->id }}' action='{{route('terms.destroy', $term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-tour" role="tabpanel"
                            aria-labelledby="custom-tabs-one-tour-tab">
                            <div class="col-sm-12">
                                <strong>Tour Estimate</strong>
                                <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                        data-target="#modal-tour">Add</a></span>
                            </div>

                            <div class="col-sm-12 mt-5">
                                 <h4 class="text-info text-center">Gir Terms</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tour_gir_terms as $gir_term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $gir_term->content }}</td>
                                                <td>Gir</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-tour" data-toggle="modal" data-target="#modal-edit-tour" data-content="{{ $gir_term->content }}" data-filter="{{ $gir_term->filter }}" data-id="{{ $gir_term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $gir_term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i>
                                                        </button>
                                                        <form id='delete-form{{ $gir_term->id }}' action='{{route('terms.destroy', $gir_term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12 mt-5">
                                 <h4 class="text-info text-center">Jim Corbett Terms</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tour_jim_terms as $jim_term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $jim_term->content }}</td>
                                                <td>Jim Corbett</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-tour" data-toggle="modal" data-target="#modal-edit-tour" data-content="{{ $jim_term->content }}" data-filter="{{ $jim_term->filter }}" data-id="{{ $jim_term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $jim_term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i>
                                                        </button>
                                                        <form id='delete-form{{ $jim_term->id }}' action='{{route('terms.destroy', $jim_term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                             <div class="col-sm-12 mt-5">
                                 <h4 class="text-info text-center">Ranthambore Terms</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tour_ran_terms as $ran_term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ran_term->content }}</td>
                                                <td>Ranthambore</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-tour" data-toggle="modal" data-target="#modal-edit-tour" data-content="{{ $ran_term->content }}" data-filter="{{ $ran_term->filter }}" data-id="{{ $ran_term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $ran_term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i>
                                                        </button>
                                                        <form id='delete-form{{ $ran_term->id }}' action='{{route('terms.destroy', $ran_term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                             <div class="col-sm-12 mt-5">
                                 <h4 class="text-info text-center">Tadoba Terms</h4>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Content</th>
                                            <th>Sanctuary</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tour_tadoba_terms as $ran_term)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $ran_term->content }}</td>
                                                <td>Tadoba</td>
                                                <td>
                                                    <div class="btn-group">
                                                        <a href="javascript:void(0)" class="btn btn-warning edit-tour" data-toggle="modal" data-target="#modal-edit-tour" data-content="{{ $ran_term->content }}" data-filter="{{ $ran_term->filter }}" data-id="{{ $ran_term->id }}"> <i class="fas fa-pen"></i>
                                                        </a>
                                                        <button type="button" onclick="confirmDelete({{ $ran_term->id }})"
                                                            class="btn btn-danger"><i class="fas fa-trash"></i>
                                                        </button>
                                                        <form id='delete-form{{ $ran_term->id }}' action='{{route('terms.destroy', $ran_term->id)}}' method='POST'>
                                                            <input type='hidden' name='_token'
                                                                value='{{ csrf_token() }}'>
                                                            <input type='hidden' name='_method' value='DELETE'>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="custom-tabs-one-package" role="tabpanel"
                        aria-labelledby="custom-tabs-one-package-tab">
                        <div class="col-sm-12">
                            <strong>Package Estimate</strong>
                            <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal-package">Add</a></span>
                        </div>
                        <div class="col-sm-12 mt-5">
                             @foreach ($package_terms as $destination)
                            <h4 class="text-info text-center">{{ $destination->destination }}</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Content</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($destination->terms)
                                    @foreach ($destination->terms as $gir_term)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $gir_term->content }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="javascript:void(0)" class="btn btn-warning edit-package" data-toggle="modal" data-target="#modal-edit-package" data-content="{{ $gir_term->content }}"
                                                    data-destination-id="{{ $gir_term->destination_id }}" data-id="{{ $gir_term->id }}"> <i class="fas fa-pen"></i>
                                                    </a>
                                                    <button type="button" onclick="confirmDelete({{ $gir_term->id }})"
                                                        class="btn btn-danger"><i class="fas fa-trash"></i>
                                                    </button>
                                                    <form id='delete-form{{ $gir_term->id }}' action='{{route('terms.destroy', $gir_term->id)}}' method='POST'>
                                                        <input type='hidden' name='_token'
                                                            value='{{ csrf_token() }}'>
                                                        <input type='hidden' name='_method' value='DELETE'>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                             @endforeach
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('defaults.estimates.terms.cab')
    @include('defaults.estimates.terms.hotel')
    @include('defaults.estimates.terms.safari')
    @include('defaults.estimates.terms.tour')
    @include('defaults.estimates.terms.package')
@endsection
@push('scripts')
<script type="text/javascript">
    $("#custom-tabs-one-{{ $type }}-tab").trigger('click');
</script>
<script>
    $(".edit-cab").click(function () {
            var id = $(this).data('id');
            var content = $(this).data('content');
            $('#edit_cab_content').val(content);
            $('#cab_term_id').val(id);
        });
</script>
<script>
    $(".edit-hotel").click(function () {
            var id = $(this).data('id');
            var content = $(this).data('content');
            var filter = $(this).data('filter');
            $('#edit_hotel_content').val(content);
            $('#hotel_term_id').val(id);
            $("#edit_hotel_filter").val(filter).change();
        });
</script>
<script>
    $(".edit-safari").click(function () {
            var id = $(this).data('id');
            var content = $(this).data('content');
            var filter = $(this).data('filter');
            $('#edit_safari_content').val(content);
            $('#safari_term_id').val(id);
            $("#edit_safari_filter").val(filter).change();
        });
</script>
<script>
    $(".edit-tour").click(function () {
            var id = $(this).data('id');
            var content = $(this).data('content');
            var filter = $(this).data('filter');
            $('#edit_tour_content').val(content);
            $('#tour_term_id').val(id);
            $("#edit_tour_filter").val(filter).change();
        });
</script>
<script>
    $(".edit-package").click(function () {
            var id = $(this).data('id');
            var content = $(this).data('content');
            var destination_id = $(this).data('destination-id');
            $('#edit_package_content').val(content);
            $('#package_term_id').val(id);
             $("#edit_destination_id").val(destination_id).change();
        });
</script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript">
    function confirmDelete(no){
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form'+no).submit();
            }
        })
    };
</script>

@endpush
