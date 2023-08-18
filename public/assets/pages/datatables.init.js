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
        $('#datatable-responsive25').DataTable();
        $('#datatable-responsive26').DataTable();
        $('#datatable-responsive27').DataTable();
        $('#datatable-responsive28').DataTable();
        $('#datatable-responsive29').DataTable();
        $('#datatable-responsive30').DataTable();
        $('#datatable-responsive31').DataTable();
        $('#datatable-responsive32').DataTable();
        $('#datatable-responsive33').DataTable();
        $('#datatable-responsive34').DataTable();
        $('#datatable-responsive35').DataTable();
        $('#datatable-responsive36').DataTable();
        $('#datatable-responsive37').DataTable();
        $('#datatable-responsive38').DataTable();
        $('#datatable-responsive39').DataTable();
        $('#datatable-responsive40').DataTable();
        $('#datatable-responsive41').DataTable();
        $('#datatable-responsive42').DataTable();
        $('#datatable-responsive43').DataTable();
        $('#datatable-responsive44').DataTable();

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
