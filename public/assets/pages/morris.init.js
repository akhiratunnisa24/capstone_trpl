
/**
* Theme: Xadmino
* Morris Chart
*/

!function($) {
    "use strict";

    var MorrisCharts = function() {};

    //creates line chart
    MorrisCharts.prototype.createLineChart = function(element, data, xkey, ykeys, labels, lineColors) {
        Morris.Line({
          element: element,
          data: data,
          xkey: xkey,
          ykeys: ykeys,
          labels: labels,
          gridLineColor: '#eef0f2',
        //   resize: true, //defaulted to true
          lineColors: lineColors
        });
    },
    //creates area chart
    MorrisCharts.prototype.createAreaChart = function(element, pointSize, lineWidth, data, xkey, ykeys, labels, lineColors) {
        Morris.Area({
            element: element,
            pointSize: 3,
            lineWidth: 0,
            data: data,
            xkey: xkey,
            ykeys: ykeys,
            labels: labels,
            resize: true,
            gridLineColor: '#eef0f2',
            lineColors: lineColors
        });
    },
    //creates Bar chart
    MorrisCharts.prototype.createBarChart  = function(element, data, xkey, ykeys, labels, lineColors) {
        Morris.Bar({
            element: element,
            data: data,
            xkey: xkey,
            ykeys: ykeys,
            labels: labels,
            gridLineColor: '#eef0f2',
            barColors: lineColors
        });
    },
    //creates Donut chart
    MorrisCharts.prototype.createDonutChart = function(element, data, colors) {
        Morris.Donut({
            element: element,
            data: data,
            colors: colors
        });
    },
    MorrisCharts.prototype.init = function() {

        //create line chart
        var $data  = [
            { y: '2009', a: 100, b: 90 },
            { y: '2010', a: 75,  b: 65 },
            { y: '2011', a: 50,  b: 40 },
            { y: '2012', a: 75,  b: 65 },
            { y: '2013', a: 50,  b: 40 },
            { y: '2014', a: 75,  b: 65 },
            { y: '2015', a: 100, b: 90 }
          ];
        this.createLineChart('morris-line-example', $data, 'y', ['a', 'b'], ['Series A', 'Series B'], ['#03a9f4', '#dcdcdc']);

        //creating area chart
        var $areaData = [
                { y: '2009', a: 10, b: 20 },
                { y: '2010', a: 75,  b: 65 },
                { y: '2011', a: 50,  b: 40 },
                { y: '2012', a: 75,  b: 65 },
                { y: '2013', a: 50,  b: 40 },
                { y: '2014', a: 75,  b: 65 },
                { y: '2015', a: 90, b: 60 }
            ];
        this.createAreaChart('morris-area-example', 0, 0, $areaData, 'y', ['a', 'b'], ['Series A', 'Series B'], ['#03a9f4', '#bdbdbd']);

        //creating bar chart Pengajuan Cuti dan Izin
        var $barData  = [
            { y: 'Jan', a: 100, b: 90 },
            { y: 'Feb', a: 75,  b: 65 },
            { y: 'Mar', a: 50,  b: 40 },
            { y: 'Apr', a: 75,  b: 65 },
            { y: 'Mei', a: 50,  b: 40 },
            { y: 'Jun', a: 75,  b: 65 },
            { y: 'Jul', a: 100, b: 90 },
            { y: 'Agu', a: 100, b: 90 },
            { y: 'Sept', a: 100, b: 90 },
            { y: 'Okt', a: 100, b: 90 },
            { y: 'Nov', a: 100, b: 90 },
            { y: 'Des', a: 100, b: 90 }
        ];
        this.createBarChart('morris-bar-example', $barData, 'y', ['a', 'b'], ['Bulan Ini', 'Bulan Lalu'], ['#18bae2', '#dcdcdc']);

        //creating bar chart Dinas Luar Kota
        var $barData  = [
            { y: 'Jan', a: 74, b: 53 },
            { y: 'Feb', a: 64,  b: 65 },
            { y: 'Mar', a: 34,  b: 98 },
            { y: 'Apr', a: 52,  b: 32 },
            { y: 'Mei', a: 50,  b: 40 },
            { y: 'Jun', a: 75,  b: 65 },
            { y: 'Jul', a: 35, b: 90 },
            { y: 'Agu', a: 56, b: 87 },
            { y: 'Sept', a: 64, b: 98 },
            { y: 'Okt', a: 63, b: 73 },
            { y: 'Nov', a: 73, b: 45 },
            { y: 'Des', a: 63, b: 53 }
        ];
        this.createBarChart('morris-bar-example2', $barData, 'y', ['a', 'b'], ['Bulan Ini', 'Bulan Lalu'], ['#f8ca4e', '#dcdcdc']);

        //creating bar chart Absen Masuk
        var $barData  = [
            { y: 'Jan', a: 74, b: 53 },
            { y: 'Feb', a: 64,  b: 65 },
            { y: 'Mar', a: 34,  b: 98 },
            { y: 'Apr', a: 52,  b: 32 },
            { y: 'Mei', a: 50,  b: 40 },
            { y: 'Jun', a: 75,  b: 65 },
            { y: 'Jul', a: 35, b: 90 },
            { y: 'Agu', a: 56, b: 87 },
            { y: 'Sept', a: 64, b: 98 },
            { y: 'Okt', a: 63, b: 73 },
            { y: 'Nov', a: 73, b: 45 },
            { y: 'Des', a: 63, b: 53 }
        ];
        this.createBarChart('morris-bar-example3', $barData, 'y', ['a', 'b'], ['Bulan Ini', 'Bulan Lalu'], ['#01ba9a', '#dcdcdc']);

        //creating bar chart Absen Tidak Masuk
        var $barData  = [
            { y: 'Jan', a: 74, b: 53 },
            { y: 'Feb', a: 64,  b: 65 },
            { y: 'Mar', a: 34,  b: 98 },
            { y: 'Apr', a: 52,  b: 32 },
            { y: 'Mei', a: 50,  b: 40 },
            { y: 'Jun', a: 75,  b: 65 },
            { y: 'Jul', a: 35, b: 90 },
            { y: 'Agu', a: 56, b: 87 },
            { y: 'Sept', a: 64, b: 98 },
            { y: 'Okt', a: 63, b: 73 },
            { y: 'Nov', a: 73, b: 45 },
            { y: 'Des', a: 63, b: 53 }
        ];
        this.createBarChart('morris-bar-example4', $barData, 'y', ['a', 'b'], ['Bulan Ini', 'Bulan Lalu'], ['#f62f37', '#dcdcdc']);
        // Grafik Karyawan

         //creating bar chart Cuti dan Izin Karyawan
         var $barData  = [
            { y: 'Jan', a: 74, b: 53 },
            { y: 'Feb', a: 64,  b: 65 },
            { y: 'Mar', a: 34,  b: 98 },
            { y: 'Apr', a: 52,  b: 32 },
            { y: 'Mei', a: 50,  b: 40 },
            { y: 'Jun', a: 75,  b: 65 },
            { y: 'Jul', a: 35, b: 90 },
            { y: 'Agu', a: 56, b: 87 },
            { y: 'Sept', a: 64, b: 98 },
            { y: 'Okt', a: 63, b: 73 },
            { y: 'Nov', a: 73, b: 45 },
            { y: 'Des', a: 63, b: 53 }
        ];
        this.createBarChart('morris-bar-example5', $barData, 'y', ['a', 'b'], ['Bulan Ini', 'Bulan Lalu'], ['#18bae2', '#dcdcdc']);

        //creating bar chart Dinas Luar Kota Karyawan
        var $barData  = [
            { y: 'Jan', a: 74, b: 53 },
            { y: 'Feb', a: 64,  b: 65 },
            { y: 'Mar', a: 34,  b: 98 },
            { y: 'Apr', a: 52,  b: 32 },
            { y: 'Mei', a: 50,  b: 40 },
            { y: 'Jun', a: 75,  b: 65 },
            { y: 'Jul', a: 35, b: 90 },
            { y: 'Agu', a: 56, b: 87 },
            { y: 'Sept', a: 64, b: 98 },
            { y: 'Okt', a: 63, b: 73 },
            { y: 'Nov', a: 73, b: 45 },
            { y: 'Des', a: 63, b: 53 }
        ];
        this.createBarChart('morris-bar-example6', $barData, 'y', ['a', 'b'], ['Bulan Ini', 'Bulan Lalu'], ['#f8ca4e', '#dcdcdc']);

        //creating bar chart Absen Masuk Karyawan
        var $barData  = [
            { y: 'Jan', a: 74, b: 53 },
            { y: 'Feb', a: 64,  b: 65 },
            { y: 'Mar', a: 34,  b: 98 },
            { y: 'Apr', a: 52,  b: 32 },
            { y: 'Mei', a: 50,  b: 40 },
            { y: 'Jun', a: 75,  b: 65 },
            { y: 'Jul', a: 35, b: 90 },
            { y: 'Agu', a: 56, b: 87 },
            { y: 'Sept', a: 64, b: 98 },
            { y: 'Okt', a: 63, b: 73 },
            { y: 'Nov', a: 73, b: 45 },
            { y: 'Des', a: 63, b: 53 }
        ];
        this.createBarChart('morris-bar-example7', $barData, 'y', ['a', 'b'], ['Bulan Ini', 'Bulan Lalu'], ['#01ba9a', '#dcdcdc']);

        //creating bar chart Absen Tidak Masuk Karyawan
        var $barData  = [
            { y: 'Jan', a: 74, b: 53 },
            { y: 'Feb', a: 64,  b: 65 },
            { y: 'Mar', a: 34,  b: 98 },
            { y: 'Apr', a: 52,  b: 32 },
            { y: 'Mei', a: 50,  b: 40 },
            { y: 'Jun', a: 75,  b: 65 },
            { y: 'Jul', a: 35, b: 90 },
            { y: 'Agu', a: 56, b: 87 },
            { y: 'Sept', a: 64, b: 98 },
            { y: 'Okt', a: 63, b: 73 },
            { y: 'Nov', a: 73, b: 45 },
            { y: 'Des', a: 63, b: 53 }
        ];
        this.createBarChart('morris-bar-example8', $barData, 'y', ['a', 'b'], ['Bulan Ini', 'Bulan Lalu'], ['#f62f37', '#dcdcdc']);

        //creating donut chart
        var $donutData = [
                {label: "Download Sales", value: 12},
                {label: "In-Store Sales", value: 30},
                {label: "Mail-Order Sales", value: 20}
            ];
        this.createDonutChart('morris-donut-example', $donutData, ['#dcdcdc', '#03a9f4', '#01ba9a']);
    },
    //init
    $.MorrisCharts = new MorrisCharts, $.MorrisCharts.Constructor = MorrisCharts
}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.MorrisCharts.init();
}(window.jQuery);