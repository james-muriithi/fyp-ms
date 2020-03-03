$(document).ready(function() {
    $("#datatable").DataTable(), $("#datatable-buttons").DataTable({
        lengthChange: !1,
        "scrollX": true,
        buttons: [{
                extend: 'excel',
                text: '<i class="fa fa-file-excel"></i> Excel',
                title: "Available Supervisors",
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            }, {
                extend: 'pdf',
                text: '<i class="mdi mdi-file-pdf"></i> PDF',
                title: "Available Supervisors",
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
    }).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)")
});