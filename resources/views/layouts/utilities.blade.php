<!-- DataTables  & Plugins -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
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
<script>
    $(function () {
      $("#leadDataTable").DataTable({
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "paging": true, "pageLength": 15000, "lengthChange": true, "searching": true, "ordering": false, "info": false, "autoWidth": false, "responsive": true,
      }).buttons().container().appendTo('#leadDataTable_wrapper .col-md-6:eq(0)');
    });


    $(function () {
      $("#estimateDataTable").DataTable({
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "buttons": [
            { extend: 'copy', footer: true },
            { extend: 'csv', footer: true },
            { extend: 'excel', footer: true },
            { extend: 'pdf', footer: true },
            { extend: 'print', footer: true },
            { extend: 'colvis', footer: true }
        ],
         "dom": 'Bfrtip',
        "paging": false, "pageLength": 20, "lengthChange": false, "searching": true, "ordering": true, "info": false, "autoWidth": false, "responsive": true, "order": [
                    [0, 'desc']
                ],
      }).buttons().container().appendTo('#estimateDataTable_wrapper .col-md-6:eq(0)');
    });

    $(function () {
      $("#bookings").DataTable({
        // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "buttons": [
            { extend: 'copy', footer: true },
            { extend: 'csv', footer: true },
            { extend: 'excel', footer: true },
            { extend: 'pdf', footer: true },
            { extend: 'print', footer: true },
            { extend: 'colvis', footer: true }
        ],
         "dom": 'Bfrtip',
        "paging": false, "pageLength": 20, "lengthChange": false, "searching": true, "ordering": false, "info": false, "autoWidth": false, "responsive": true,
      }).buttons().container().appendTo('#bookingsDataTable_wrapper .col-md-6:eq(0)');
    });

    $(function () {
      $("#dataTable").DataTable({
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "paging": true, "pageLength": 20, "lengthChange": false, "searching": true, "ordering": false, "info": true, "autoWidth": false, "responsive": true,
      }).buttons().container().appendTo('#dataTable_wrapper .col-md-6:eq(0)');
    });

    $(function () {
      $("#dataTable1").DataTable({
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "paging": true, "pageLength": 20, "lengthChange": false, "searching": true, "ordering": false, "info": true, "autoWidth": false, "responsive": true,
      }).buttons().container().appendTo('#dataTable1_wrapper .col-md-6:eq(0)');
    });

    $(function () {
      $("#dataTable2").DataTable({
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "paging": true, "pageLength": 20, "lengthChange": false, "searching": true, "ordering": false, "info": true, "autoWidth": false, "responsive": true,
      }).buttons().container().appendTo('#dataTable2_wrapper .col-md-6:eq(0)');
    });
</script>
