@extends('layouts.master')
@section('title', 'Show Ticket')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link href="https://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.min.css" rel="stylesheet">
@endsection
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><i class="nav-icon fas fa-ticket"></i> Show Ticket</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">

            <div class="card-body">
                <form action="{{ route('support.store') }}" method="POST" id="ticketForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="col-form-label" for="subject">Subject*</label>
                            <input type="text" id="subject" class="form-control" placeholder="Subject" name="subject"
                                value="{{ old('subject') }}" >
                            @error('subject')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-12">
                            <label class="col-form-label" for="description">Description*</label>
                            <textarea type="text" id="description" class="form-control" rows="4"
                                placeholder="Please explain about issue here" name="description" >{{ old('description') }}</textarea>
                            @error('description')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                                <label for="customer_id">For Customer</label>
                                <input class="form form-control" type="text" id="customer-search-id" name="customer_name">
                                 <input  type="hidden" name="customer_id" id="customer-id">
                             @error('customer_name')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                         </div>
                      
                         <div class="col-sm-6">
                                <label for="booking_id">For Booking</label>
                                <select name="booking_id" id="booking_id" class="form-control" >
                                <option value="">Please Select Booking</option>
                            </select>

                          </div>
                          <div class="col-sm-6">
                            <label for="attachment">Attachment</label>
                            <input type="file" class="form-control" name="attachment" id="attachment">
                            @error('attachment')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                          <div class="col-sm-6">
                            <label class="col-form-label" for="priority">Priority*</label>
                            <select name="priority" id="priority" class="form-control" >
                                <option value="">Please Select</option>
                                <option value="High">
                                    High</option>
                                <option value="Low">
                                    Low</option>
                                <option value="Medium">Medium</option>
                            </select>
                            @error('priority')
                                <span id="subject-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </form>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('support.index') }}" class="btn btn-dark mr-1">Back</a>
                <button type="submit" class="btn btn-success" form="ticketForm">Submit</button>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('layouts.utilities')
    <script src="https://code.jquery.com/ui/1.10.2/jquery-ui.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script>

    $(document).ready(function() {

    		$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});
         $('#customer-search-id').autocomplete({
          'source': function(request, response) {
              $.ajax({
                  url: "{{ route('customers.search') }}",
                  dataType: 'json',
                  type: "GET",
                  data: 'query=' + $('#customer-search-id').val(),
                  success: function(json) {
                      response($.map(json, function(item) {
                          return {
                              label: item.name,
                              value: item.name,
                              data: item.id
                          }
                      }));
                  }
              });
          },
          'select': function(item,ui) {
              $('#customer-search-id').val(ui.item.label);
              $('#customer-id').val(ui.item.data);
              getBookings(ui.item.data);
          }
        });

         function getBookings(id){
             $.ajax({
                  url: "{{ route('bookings.customer') }}",
                  dataType: 'json',
                  type: "GET",
                  data: 'customer_id=' + id,
                  success: function(json) {
                     let html = '<option>Please Select Booking</option>';
                     if((json.bookings).length > 0 ){
                         (json.bookings).map(function(item){
                            html += '<option value="'+ item.id +'"> Id-'+ item.id +',Booking Date '+ item.date +'</option>';
                         });
                     }else{
                         html = '<option> No booking found</option>';;
                     }
                     $('#booking_id').html(html);
                  }
              });
         }
    });
    </script>
@endpush
