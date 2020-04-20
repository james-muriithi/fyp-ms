$(document).ready(function() {
    $("#datatable").DataTable();
        var table = $("#datatable-buttons").DataTable({
        "scrollX": true,
            order: [[0,"asc"]],
            autoWidth: false,
            sScrollX: '100%',
            bAutoWidth: false,
            initComplete: function () {
            },
            columnDefs: [
                {orderable: false, targets: -1}
            ],
        buttons: [{
                extend: 'excel',
                text: '<i class="fa fa-file-excel"></i> Excel',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            }, {
                extend: 'pdf',
                text: '<i class="mdi mdi-file-pdf"></i> PDF',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            },
            {
                extend: 'print',
                text: '<i class="fa fa-print"></i> Print',
                exportOptions: {
                    modifier: {
                        page: 'current'
                    },
                    columns: 'th:not(:last-child)'
                }
            }, "colvis"
        ]
    });
    table.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)")
    setTimeout(()=>{
        table.draw();
    },100)
});