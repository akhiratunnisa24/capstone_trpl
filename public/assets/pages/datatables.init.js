/**
 * Theme: Xadmino
 * Datatable
 */

!function($) {
    "use strict";

    var DataTable = function() {
        this.$dataTableButtons = $("#datatable-buttons")
    };
    DataTable.prototype.createDataTableButtons = function() {
        0 !== this.$dataTableButtons.length && this.$dataTableButtons.DataTable({
            dom: "Bfrtip",
            buttons: [{
                extend: "copy",
                className: "btn-success"
            }, {
                extend: "csv"
            }, {
                extend: "excel"
            }, {
                extend: "pdf"
            }, {
                extend: "print"
            }],
            responsive: !0
        });
    },
    DataTable.prototype.init = function() {
        //creating demo tabels
        // $('#datatable').dataTable();
        // $('#datatable-keytable').DataTable({keys: true});
        $('#datatable-responsive').DataTable(); 
        $('#datatable-responsive1').DataTable();
        $('#datatable-responsive2').DataTable();
        $('#datatable-responsive3').DataTable();
        $('#datatable-responsive4').DataTable();
        $('#datatable-responsive5').DataTable();
        $('#datatable-responsive6').DataTable();
        $('#datatable-responsive7').DataTable();
        $('#datatable-responsive8').DataTable();
        $('#datatable-responsive9').DataTable();
        $('#datatable-responsive10').DataTable();
        $('#datatable-responsive11').DataTable();
        $('#datatable-responsive12').DataTable();
        $('#datatable-responsive13').DataTable();
        $('#datatable-responsive14').DataTable();
        $('#datatable-responsive15').DataTable();
        $('#datatable-responsive16').DataTable();
        $('#datatable-responsive17').DataTable(
            {
                ajax: "assets/plugins/datatables/json/scroller-demo.json",
                deferRender: true,
                scrollY: 380,
                scrollCollapse: true,
                scroller: true,
                scrollX: true // Menambahkan opsi scrollX untuk scroll horizontal
            }
        );
        $('#datatable-responsive18').DataTable();
        $('#datatable-responsive19').DataTable();
        $('#datatable-responsive20').DataTable();
        $('#datatable-responsive21').DataTable();
        $('#datatable-responsive22').DataTable();
        $('#datatable-responsive23').DataTable();
        $('#datatable-responsive24').DataTable();
        
        $('#datatable-scrollera').DataTable({
            ajax: "assets/plugins/datatables/json/scroller-demo.json",
            deferRender: true,
            scrollY: 380,
            scrollCollapse: true,
            scroller: true
        });
        var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});

        //creating table with button
        this.createDataTableButtons();
    },
    //init
    $.DataTable = new DataTable, $.DataTable.Constructor = DataTable
}(window.jQuery),

//initializing
function ($) {
    "use strict";
    $.DataTable.init();
}(window.jQuery);