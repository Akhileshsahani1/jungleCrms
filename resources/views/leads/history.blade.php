@extends('layouts.master')
@section('title', 'Leads')
@section('head')
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@endsection
@section('content')
     <section class="content">
        <div class="card">
            <div class="card-body">
                <table id="leadDataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>State</th>
                            <th>Mobile</th>
                            <th>Booking Type</th>
                            <th>Website</th>
                            <th>Lead Status</th>
                            <th>Comment</th>
                            <th>Comment By</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lead_crm['data'] as $lead2)
                            <tr>
                                <td>{{ $lead2['name'] }}</td>  
                                <td>{{ isset($lead2['email']) ? $lead2['email'] : ''  }}</td>
                                <td>{{ isset($lead2['address']) ? $lead2['address'] : ''  }}</td>
                                <td>{{ isset($lead2['state']) ? $lead2['state'] : ''  }}</td>
                                <td>{{ $lead2['mobile'] }}</td>   
                                <td>{{ isset($lead2['meta']) ? $lead2['meta'] : ''  }}</td>                      
                                <td><span class="badge bg-danger">{{ $lead2['website'] }}</span></td>
                                <td>{{ $lead2['lead_status'] == 0 ? 'Generated' : \App\Models\LeadStatus::find($lead2['lead_status'])->name }}</td>
                                <td>{{ isset($lead2['comment']) ? $lead2['comment'] : '' }}</td>
                                <td>{{ isset($lead2['userName']) ? $lead2['userName'] : '' }}</td>
                                <td>{{ isset($lead2['created_at']) ? \Carbon\Carbon::parse($lead2['created_at'])->diffForHumans() : ''  }}</td>
                            </tr>
                        @endforeach

                        @foreach ($leads as $lead)
                            <tr>
                                <td>{{ isset($lead['name']) ? $lead['name'] : '' }}</td>  
                                <td>{{ isset($lead['email']) ? $lead['email'] : ''  }}</td>
                                <td>{{ isset($lead['address']) ? $lead['address'] : ''  }}</td>
                                <td>{{ isset($lead['state']) ? $lead['state'] : ''  }}</td>
                                <td>{{ $lead['mobile'] }}</td>    
                                <td>{{ isset($lead['custom_data']) ? $lead['custom_data'] : (isset($lead['booking_type']) ? $lead['booking_type'] : '')  }}</td>                     
                                <td><span class="badge bg-danger">{{ isset($lead['website']) ? $lead['website'] : '' }}</span></td>
                                <td>{{  isset($lead['lead_status']) ? $lead['lead_status'] : '' }}</td>
                                <td></td>
                                <td></td>
                                <td>{{ isset($lead['createdAt']) ? \Carbon\Carbon::parse($lead['createdAt'])->diffForHumans() : ''  }}</td>
                            </tr>
                        @endforeach

                        
                    </tbody>
            </table>
        </div>
        <div class="mt-2">
            
        </div>
        </div>
    </section>
@endsection
@push('scripts')
    @include('layouts.utilities')
    <script>
        $("#assign_button").on('click', function() {

            var user_id = $("#userlist").val();

            var arr = [];
            $.each($("input[name='checkbox']:checked"), function() {
                arr.push($(this).val());
            });

            if (arr.length === 0) {
                $('#assign-message').css('display', 'block');
            } else {
                swal.fire({
                        title: `Are you sure you want to assign selected leads?`,
                        text: "If you choose to assign, it will be assigned forever.",
                        icon: "warning",
                        buttons: true,
                        showCancelButton: true,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Yes, assign it!",
                        closeOnConfirm: true
                    })
                    .then((result) => {

                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('assign-leads') }}",
                                dataType: 'json',
                                data: {
                                    user_id: user_id,
                                    arr: arr,
                                    "_token": "{{ csrf_token() }}",
                                },
                                type: "POST",
                                success: function(data) {

                                    location.reload();

                                }
                            });
                        }

                    });
            }



        });
    </script>
    <script>
        $("#delete_button").on('click', function() {


            var arr = [];
            $.each($("input[name='checkbox']:checked"), function() {
                arr.push($(this).val());
            });

            if (arr.length === 0) {
                $('#delete-message').css('display', 'block');
            } else {
                swal.fire({
                        title: `Are you sure you want to delete selected records?`,
                        text: "If you delete this, it will be gone forever.",
                        icon: "warning",
                        buttons: true,
                        showCancelButton: true,
                        confirmButtonClass: "btn-success",
                        confirmButtonText: "Yes, delete it!",
                        closeOnConfirm: true
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('delete-leads') }}",
                                dataType: 'json',
                                data: {
                                    arr: arr,
                                    "_token": "{{ csrf_token() }}",
                                },
                                type: "POST",
                                success: function(data) {

                                    location.reload();

                                }
                            });
                        }
                    });
            }

        });
    </script>

<script>
function filterGlobal(inp) {
   
    $.ajax({
        url : "{{ route('search-leads') }}",
        dataType: 'json',
        data: {
            inp: inp,
            "_token": "{{ csrf_token() }}",
        },
        type: "POST",
        success: function(res) {
        
        var htm = '';
    
        if(res.data != 404){
            $('#leadDataTable tbody tr').remove();
            for(var i = 0; i< res.data.length; i++){
                
                var d = res.data[i];
                (i%2 == 0) ? cls = 'even' : cls = 'odd'; 

                htm = '<tr class="'+cls+'">';
                htm += '<td class="dtr-control" tabindex="0"><input type="checkbox" name="checkbox" id='+d.id+' class="checkbox" value="'+d.id+'"></td>';
                htm += '   <td>'+d.id+'</td>';
                htm += '   <td>'+d.name+'<br>';
                htm += '        <span class="badge bg-dark">Created</span>';
                htm += '    </td>';
                htm += '   <td>'+d.mobile+'</td>';
                htm += '   <td><span class="badge bg-danger">'+d.website+'</span></td>';
                htm += '    <td>'+d.leadstatus_name+'</td>';
                htm += '    <td>'+d.assign_name+'</td>';
                htm += '    <td>'+d.lead_time_now+'</td>';
                htm += '    <td>';
                htm += '        <div class="btn-group">';
                htm += '           <a href="/leads/'+d.id+'/edit" class="btn btn-info"> <i class="fas fa-pen"></i> </a>';
                htm += '           <a href="/leads/'+d.id+'" class="btn btn-warning"> <i class="fas fa-eye"></i> </a>';
                htm += '           <button type="button" onclick="confirmDelete(35)" class="btn btn-danger"><i class="fas fa-trash"></i> </button>';
                htm += '            <form id="delete-form35" action="/leads/'+d.id+'" method="POST">';
                htm += '                <input type="hidden" name="_token" value="{{ csrf_token() }}">';
                htm += '                <input type="hidden" name="_method" value="DELETE">';
                htm += '            </form>';
                htm += '        </div>';
                htm += '    </td>';
                htm += '    </tr>';
          
                $('#leadDataTable tbody').append(htm);
               
            }
       
        }
         
    }

 });
   

}

$(document).ready(function ($) {
  
    $('input[type="search"]').on('input',function () {
        filterGlobal($(this).val());
        if($(this).val() == ''){
            location.reload();
       }
    });

 
});
</script>

@endpush
