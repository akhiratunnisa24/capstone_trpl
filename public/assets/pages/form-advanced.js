/**
 * Theme: Xadmino
 * Form Advanced
 */

!function($) {
    "use strict";

    var AdvancedForm = function() {};
    
    AdvancedForm.prototype.init = function() {
        //creating various controls

        // Time Pickers
        // jQuery('#timepicker').timepicker({defaultTIme: false});
        // jQuery('#timepicker2').timepicker({showMeridian: false});
        // jQuery('#timepicker3').timepicker({minuteStep: 15});

        // //colorpicker start
        // $('.colorpicker-default').colorpicker({
        //     format: 'hex'
        // });
        // $('.colorpicker-rgba').colorpicker();

        // Date Picker
        // jQuery('#datepicker').datepicker();
        // jQuery('#datepicker-autoclose').datepicker({
        //     autoclose: true,
        //     todayHighlight: true
        // });
        //untuk add alokasicuti
        var Year = new Date().getFullYear();
        var minDate = new Date(Year,0,1);
        var maxDate = new Date(Year,11,31);

        var day = new Date();
        var today = day.setDate(day.getDate() - 1);
        var nextDate = new Date();
        var next = nextDate.setMonth(nextDate.getMonth() + 2);
        
        jQuery('#datepicker-autoclose2').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose3').datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years", 
            minViewMode: "years",
        });
        jQuery('#datepicker-autoclose4').datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years", 
            minViewMode: "years",
        });
        jQuery('#datepicker-autoclose5').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose6').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose7').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose8').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose9').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose10').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose11').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        
        jQuery('#datepicker-autoclose12').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        
        jQuery('#datepicker-autoclose13').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose14').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose15').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose16').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose17').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose18').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose19').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        jQuery('#datepicker-autoclose20').datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years", 
            minViewMode: "years",
        });
        jQuery('#datepicker-autoclose21').datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years", 
            minViewMode: "years",
        });
        jQuery('#datepicker-autoclose22').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true
        });
        
        jQuery('#datepicker-autoclosea1').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            minDate:minDate,
            maxDate:maxDate,
            todayHighlight: true,
            beforeShowDay: function(date){
                if (date < minDate || date > maxDate) {
                    return {enabled : false};
                } else {
                    return {};
                }
            }
        });
        jQuery('#datepicker-autoclosea2').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            minDate:minDate,
            maxDate:maxDate,
            todayHighlight: true,
            beforeShowDay: function(date){
                if (date < minDate || date > maxDate) {
                    return {enabled : false};
                } else {
                    return {};
                }
            }
        });
        jQuery('#datepicker-autoclosea3').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            minDate:minDate,
            maxDate:maxDate,
            todayHighlight: true,
            beforeShowDay: function(date){
                if (date < minDate || date > maxDate) {
                    return {enabled : false};
                } else {
                    return {};
                }
            }
        });
        jQuery('#datepicker-autoclosea4').datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            minDate:minDate,
            maxDate:maxDate,
            todayHighlight: true,
            beforeShowDay: function(date){
                if (date < minDate || date > maxDate) {
                    return {enabled : false};
                } else {
                    return {};
                }
            }
        });
        jQuery('#datepicker-autoclosec').datepicker({
            format:"yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
            beforeShowDay: function(date){
                if (date < today || date >  next) {
                    return {enabled : false};
                } else {
                    return {};
                }
            }   
        });

        jQuery('#datepicker-autoclosed').datepicker({
            format:"yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
            beforeShowDay: function(date){
                if (date < today || date >  next) {
                    return {enabled : false};
                } else {
                    return {};
                }
            }  
        });

        //pengajuan cuti oleh karyawan
        // var aktif_dari = $("#aktif_dari").val();
        // var sampai = $("#sampai").val();
        // var startDate = new Date(aktif_dari);
        // var endDate = new Date(sampai);
        // console.log(startDate);

        jQuery('#datepicker-autoclosef').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function(date){
                if (date < minDate || date >  maxDate)
                    return {enabled : false};
                return;
            }
         });
        jQuery('#datepicker-autocloseg').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            minDate: minDate,
            maxDate:  maxDate,
            todayHighlight: true,
            beforeShowDay: function(date){
                if (date < minDate || date >  maxDate)
                    return {enabled : false};
                return;
            }
        });
        // });
       
        jQuery('#datepicker-inline').datepicker();
        jQuery('#datepicker-multiple-date').datepicker({
            format: "yyyy/mm/dd",
            clearBtn: true,
            multidate: true,
            multidateSeparator: ","
        });
        jQuery('#date-range').datepicker({
            toggleActive: true
        });

        jQuery('#date-range2').datepicker({
            toggleActive: true
        });

        //Bootstrap-MaxLength
        // $('input#defaultconfig').maxlength();

        // $('input#thresholdconfig').maxlength({
        //     threshold: 20
        // });

        // $('input#moreoptions').maxlength({
        //     alwaysShow: true,
        //     warningClass: "label label-success",
        //     limitReachedClass: "label label-danger"
        // });

        // $('input#alloptions').maxlength({
        //     alwaysShow: true,
        //     warningClass: "label label-success",
        //     limitReachedClass: "label label-danger",
        //     separator: ' out of ',
        //     preText: 'You typed ',
        //     postText: ' chars available.',
        //     validate: true
        // });

        // $('textarea#textarea').maxlength({
        //     alwaysShow: true
        // });

        // $('input#placement').maxlength({
        //     alwaysShow: true,
        //     placement: 'top-left'
        // });

        //Bootstrap-TouchSpin
        // $(".vertical-spin").TouchSpin({
        //     verticalbuttons: true,
        //     verticalupclass: 'ion-plus-round',
        //     verticaldownclass: 'ion-minus-round'
        // });

        // $("input[name='demo1']").TouchSpin({
        //     min: 0,
        //     max: 100,
        //     step: 0.1,
        //     decimals: 2,
        //     boostat: 5,
        //     maxboostedstep: 10,
        //     postfix: '%'
        // });
        // $("input[name='demo2']").TouchSpin({
        //     min: -1000000000,
        //     max: 1000000000,
        //     stepinterval: 50,
        //     maxboostedstep: 10000000,
        //     prefix: '$'
        // });
        // $("input[name='demo3']").TouchSpin();
        // $("input[name='demo3_21']").TouchSpin({
        //     initval: 40
        // });
        // $("input[name='demo3_22']").TouchSpin({
        //     initval: 40
        // });

        // $("input[name='demo5']").TouchSpin({
        //     prefix: "pre",
        //     postfix: "post"
        // });
        // $("input[name='demo0']").TouchSpin({});
    },
    //init
    $.AdvancedForm = new AdvancedForm, $.AdvancedForm.Constructor = AdvancedForm
}(window.jQuery),

//initializing
function ($) {
    "use strict";
    $.AdvancedForm.init();
}(window.jQuery);