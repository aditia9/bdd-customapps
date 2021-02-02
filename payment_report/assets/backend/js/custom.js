$(document).ready(function() {

    var pathparts = location.pathname.split('/');
    if (location.host == 'localhost') {
        var base_url = location.origin+'/'+pathparts[1].trim('/'); // http://localhost/
    }else{
        var base_url = location.origin; 
    }

    $('.select2').select2({
        tags: true,
        dropdownParent: $(".modal")
    });

    $('.btn-print').click(function(){
        $(".card-body").printThis({
            importCSS: true,
            importStyle: true,
            header: "<h1 class='header-print'>Clearence Card</h1>",

        });
    });

    $(".dpicker").datepicker({
        dateFormat: 'dd-mm-yy',
        changeMonth: true,
        changeMonth: true,
        changeYear: true,
        yearRange: "1980:2019"
    });

    $('.basic-datatables').DataTable({
        "pageLength": 10,
    });

    $('.complex-body-datatables').DataTable({
        'rowsGroup': [2]
    });

    $('#multi-filter-select').DataTable( {
        "pageLength": 5,
        initComplete: function () {
            this.api().columns().every( function () {
                var column = this;
                var select = $('<select class="form-control"><option value=""></option></select>')
                .appendTo( $(column.footer()).empty() )
                .on( 'change', function () {
                    var val = $.fn.dataTable.util.escapeRegex(
                        $(this).val()
                    );

                    column
                    .search( val ? '^'+val+'$' : '', true, false )
                    .draw();
                } );

                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
            } );
        }
    });

    // Add Row
    $('#add-row').DataTable({
        "pageLength": 5,
    });

    var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

    $('#addRowButton').click(function() {
        $('#add-row').dataTable().fnAddData([
            $("#addName").val(),
            $("#addPosition").val(),
            $("#addOffice").val(),
            action
        ]);
        $('#addRowModal').modal('hide');
    });
});