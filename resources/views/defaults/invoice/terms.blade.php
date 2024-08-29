@extends('layouts.master')
@section('title', 'Invoices')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invoices</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Defaults</li>
                        <li class="breadcrumb-item active">Invoices</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="col-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-sm-12">
                        <strong>Invoice Terms</strong>
                        <span class="float-right"><a href="javascript:void(0)" class="btn btn-primary" data-toggle="modal"
                                data-target="#modal-invoice">Add</a></span>
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
                                @foreach ($terms as $term)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $term->content }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="javascript:void(0)" class="btn btn-warning edit-invoice" data-toggle="modal" data-target="#modal-edit-invoice" data-content="{{ $term->content }}" data-id="{{ $term->id }}"> <i class="fas fa-pen"></i>
                                                </a>
                                                <button type="button" onclick="confirmDelete({{ $term->id }})"
                                                    class="btn btn-danger"><i class="fas fa-trash"></i> </button>
                                                <form id='delete-form{{ $term->id }}' action='{{route('invoice.terms.destroy', $term->id)}}' method='POST'>
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
            </div>
        </div>
    </section>
    <div class="modal fade" id="modal-invoice">
        <div class="modal-dialog modal-invoice">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Invoice (Terms & Conditions)</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="invoiceForm" action="{{ route('invoice.terms.save') }}">
                        @csrf
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control" id="content" name="content" placeholder="Enter Content here" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="invoiceForm">Save</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit-invoice">
        <div class="modal-dialog modal-edit-invoice">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Invoice (Terms & Conditions)</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="updateinvoiceForm" action="{{ route('invoice.terms.update') }}">
                        @csrf
                        <input type="hidden" value="" name="id" id="invoice_term_id">
                        <div class="form-group">
                            <label for="edit_invoice_content">Content</label>
                            <textarea class="form-control" id="edit_invoice_content" name="content" placeholder="Enter Content here" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" form="updateinvoiceForm">Update</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script>
    $(".edit-invoice").click(function () {
            var id = $(this).data('id');
            var content = $(this).data('content');
            $('#edit_invoice_content').val(content);
            $('#invoice_term_id').val(id);
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
