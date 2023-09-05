/**
 * Theme: Xadmino
 * Form Advanced
 */

!(function ($) {
    "use strict";

    var AdvancedForm = function () {};

    (AdvancedForm.prototype.init = function () {
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
        var minDate = new Date(Year, 0, 1);
        var maxDate = new Date(Year, 12, 31);

        var day = new Date();
        var today = day.setDate(day.getDate() - 1);
        var nextDate = new Date();
        var next = nextDate.setMonth(nextDate.getMonth() + 2);

        jQuery("#datepicker-autoclose2").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose3").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose4").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose5").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose6").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose7").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose8").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose9").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose10").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose11").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });

        jQuery("#datepicker-autoclose12").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });

        jQuery("#datepicker-autoclose13").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose14").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose15").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose16").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose17").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose18").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose19").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose20").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose21").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose22").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose23").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose24").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose25").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });

        jQuery("#datepicker-autoclose26").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose27").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose28").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose29").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose30").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose31").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose32").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose33").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose34").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose35").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose36").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose37").datepicker({
            format: "yyyy/mm/dd hh:ii",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose38").datepicker({
            format: "yyyy/mm/dd hh:ii",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose39").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose40").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose41").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose42").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose43").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose44").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format2").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclosea1").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) {
                    return { enabled: false };
                } else {
                    return {};
                }
            },
        });
        jQuery("#datepicker-autoclosea2").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) {
                    return { enabled: false };
                } else {
                    return {};
                }
            },
        });
        jQuery("#datepicker-autoclosea3").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) {
                    return { enabled: false };
                } else {
                    return {};
                }
            },
        });
        jQuery("#datepicker-autoclosea4").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) {
                    return { enabled: false };
                } else {
                    return {};
                }
            },
        });
        jQuery("#datepicker-autoclose-format-a").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-b").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-c").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-d").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-e").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-f").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-g").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-h").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-i").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-j").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-k").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-l").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-m").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-n").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-o").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-p").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-q").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-r").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-s").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
         jQuery("#datepicker-autoclose-format-t").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-u").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-v").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-w").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-x").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-y").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-z").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-aa").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-ab").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-ac").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-ad").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-ae").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-af").datepicker({
            format: "yyyy",
            autoclose: true,
            todayHighlight: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclose-format-ag").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format-ah").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format-ai").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format-aj").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format-ak").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format-al").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format-am").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format-an").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format-ao").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format-ap").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format-aq").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose-format-ar").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        // jQuery("#datepicker-autoclosec").datepicker({
        //     format: "dd/mm/yyyy",
        //     autoclose: true,
        //     todayHighlight: true,
        //     beforeShowDay: function (date) {
        //         if (date < today || date > next) {
        //             return { enabled: false };
        //         } else {
        //             return {};
        //         }
        //     },
        // });

        // jQuery("#datepicker-autoclosed").datepicker({
        //     format: "dd/mm/yyyy",
        //     autoclose: true,
        //     todayHighlight: true,
        //     beforeShowDay: function (date) {
        //         if (date < today || date > next) {
        //             return { enabled: false };
        //         } else {
        //             return {};
        //         }
        //     },
        // });

        // jQuery("#datepicker-autoclosex").datepicker({
        //     format: "dd/mm/yyyy",
        //     autoclose: true,
        //     todayHighlight: true,
        //     beforeShowDay: function (date) {
        //         if (date < today || date > next) {
        //             return { enabled: false };
        //         } else {
        //             return {};
        //         }
        //     },
        // });

        jQuery("#datepicker-autoclosec").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });

        jQuery("#datepicker-autoclosed").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });

        jQuery("#datepicker-autoclosex").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });

        jQuery("#datepicker-autocloseu").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < today || date > next) {
                    return { enabled: false };
                } else {
                    return {};
                }
            },
        });

        jQuery("#datepicker-autoclosev").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < today || date > next) {
                    return { enabled: false };
                } else {
                    return {};
                }
            },
        });

        jQuery("#datepicker-autoclosee").datepicker({
            format: "yyyy/mm/dd",
            autoclose: true,
            todayHighlight: true,
        });

        //pengajuan cuti oleh karyawan
        // var aktif_dari = $("#aktif_dari").val();
        // var sampai = $("#sampai").val();
        // var startDate = new Date(aktif_dari);
        // var endDate = new Date(sampai);
        // console.log(startDate);

        // $.ajax({
        //     url: '/getlibur',
        //     type: 'GET',
        //     dataType: 'json',
        //     success: function(data) {
        //       var liburDates = data.map(function(libur) {
        //         return new Date(libur.tanggal).getTime();
        //       });

        //       // Tambahkan logika untuk menonaktifkan tanggal pada datepicker
        //       jQuery("#datepicker-autoclosef").datepicker({
        //         format: "yyyy-mm-dd",
        //         autoclose: true,
        //         minDate: minDate,
        //         maxDate: maxDate,
        //         todayHighlight: true,
        //         beforeShowDay: function(date) {
        //           var dateMillis = date.getTime();
        //         //   console.log(dateMillis);

        //           if (dateMillis < minDate.getTime() || dateMillis > maxDate.getTime()) {
        //             return { enabled: false };
        //           }
        //           else if (liburDates.includes(dateMillis)) {
        //             return { enabled: true, classes: 'disabled-date' };
        //           }
        //           else {
        //             return { enabled: true };
        //           }
        //         },
        //       });

        //       jQuery("#datepicker-autocloseg").datepicker({
        //         format: "yyyy-mm-dd",
        //         autoclose: true,
        //         minDate: minDate,
        //         maxDate: maxDate,
        //         todayHighlight: true,
        //         beforeShowDay: function(date) {
        //           var dateMillis = date.getTime();

        //           if (dateMillis < minDate.getTime() || dateMillis > maxDate.getTime()) {
        //             return { enabled: false };
        //           }
        //           else if (liburDates.includes(dateMillis)) {
        //             return { enabled: true, classes: 'disabled-date' };
        //           }
        //           else {
        //             return { enabled: true };
        //           }
        //         },
        //       });
        //     },
        //     error: function(jqXHR, textStatus, errorThrown) {
        //       console.log(textStatus, errorThrown);
        //     }
        // });
        jQuery("#datepicker-autoclosef").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autoclosew").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autoclose76").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autocloseg").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autocloses").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autoclose44").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autocloset").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autoclose45").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autocloseh").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autoclosei").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autocloseq").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autocloser").datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autoclosej").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclosek").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclosel").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclosem").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclosen").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autocloseo").datepicker({
            format: "yyyy",
            autoclose: true,
            viewMode: "years",
            minViewMode: "years",
        });
        jQuery("#datepicker-autoclosep").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclosey").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });

        jQuery("#datepicker-autoclosez").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autoclosezz").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });

        jQuery("#datepicker-autoclose47").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });

        jQuery("#datepicker-autoclose48").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });
        jQuery("#datepicker-autoclose49").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });

        jQuery("#datepicker-autoclose50").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minDate: minDate,
            maxDate: maxDate,
            todayHighlight: true,
            beforeShowDay: function (date) {
                if (date < minDate || date > maxDate) return { enabled: false };
                return;
            },
        });

        jQuery("#datepicker-autoclose51").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            todayHighlight: true,
        });

        jQuery("#datepicker-inline").datepicker();
        jQuery("#datepicker-multiple-date").datepicker({
            format: "yyyy/mm/dd",
            clearBtn: true,
            multidate: true,
            multidateSeparator: ",",
        });
        jQuery("#date-range").datepicker({
            // autoclose: true,
            format: "dd/mm/yyyy",
            toggleActive: true,
        });

        jQuery("#date-range2").datepicker({
            format: "dd/mm/yyyy",
            toggleActive: true,
        });
        jQuery("#date-range6").datepicker({
            format: "dd/mm/yyyy",
            toggleActive: true,
        });
        jQuery("#date-range7").datepicker({
            format: "dd/mm/yyyy",
            toggleActive: true,
        });

        jQuery("#date-range3").datepicker({
            // autoclose: true,
            toggleActive: true,
        });
        jQuery("#date-range4").datepicker({
            // autoclose: true,
            toggleActive: true,
        });
        jQuery("#date-range5").datepicker({
            toggleActive: true,
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
    }),
        //init
        ($.AdvancedForm = new AdvancedForm()),
        ($.AdvancedForm.Constructor = AdvancedForm);
})(window.jQuery),
    //initializing
    (function ($) {
        "use strict";
        $.AdvancedForm.init();
    })(window.jQuery);
