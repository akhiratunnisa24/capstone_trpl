@extends('layouts.default')

@section('content')
<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <h4 class="pull-left page-title">Dashboard HRD</h4>

            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Dashboard HRD</li>
            </ol>

            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-info">
                <h4 class="panel-title ">Cuti dan Izin Hari Ini</h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $cutiHariini }}</b></h3>
                <p class="text-muted"><b>Total Pengajuan Cuti dan Izin </b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-success">
                <h4 class="panel-title">Absen Masuk Hari Ini</h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $absenHariini }}</b></h3>
                <p class="text-muted"><b>Total Absen Masuk </b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-warning">
                <h4 class="panel-title">Terlambat Hari Ini</h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $absenTerlambat }}</b></h3>
                <p class="text-muted"><b>Lorem Ipsum </b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-danger">
                <h4 class="panel-title"> Belum / Tidak Masuk Hari Ini</h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>0</b></h3>
                <p class="text-muted"><b>Total Absen Tidak Masuk </b> </p>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-info">
                <h4 class="panel-title ">Cuti dan Izin Bulan Ini</h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $cutiPerbulan }}</b></h3>
                <p class="text-muted"><b>Total Pengajuan Cuti dan Izin </b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-success">
                <h4 class="panel-title">Absen Masuk Bulan Ini</h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $absenBulanini }}</b></h3>
                <p class="text-muted"><b>Total Absen Masuk </b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-warning">
                <h4 class="panel-title">Terlambat Bulan Ini</h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $absenTerlambat }}</b></h3>
                <p class="text-muted"><b>Lorem Ipsum </b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-danger">
                <h4 class="panel-title"> Belum / Tidak Masuk Bulan Ini</h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>0</b></h3>
                <p class="text-muted"><b>Total Absen Tidak Masuk </b> </p>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-info">
                <h4 class="panel-title">Cuti dan Izin Bulan Lalu</h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $cutiBulanlalu }} </b></h3>
                <p class="text-muted"><b>Total Cuti dan Izin</b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-success">
                <h4 class="panel-title">Absen Masuk Bulan Lalu</h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $absenBulanlalu }}</b></h3>
                <p class="text-muted"><b>Total Absen Masuk</b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-warning">
                <h4 class="panel-title">Terlambat Bulan Lalu</h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $absenTerlambatbulanlalu }}</b></h3>
                <p class="text-muted"><b>Lorem Ipsum </b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-danger">
                <h4 class="panel-title">Tidak Masuk Bulan Lalu </h4>
            </div>
            <div class="panel-body">
                <h3 class=""><b>10</b></h3>
                <p class="text-muted"><b>Total Absen Tidak Masuk</b> </p>
            </div>
        </div>
    </div>

</div>


<div class="row">

 <!-- Chart JS -->
 <div class="col-lg-12">
        <div class="panel panel-border panel-info">
            <div class="panel-heading">
                <h3 class="panel-title text-white">Cuti</h3>
            </div>
            <div class="panel-body">
                <div>
                    <canvas id="myChart" style="height: 300px"></canvas>
                </div>
            </div>
        </div>
    </div> <!-- col -->

</div> <!-- End Row -->



</div> <!-- container -->

</div> <!-- content -->

</div>
<!-- End Right content here -->

</div>
<!-- END wrapper -->


<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>

<!--Morris Chart-->
<script src="assets/plugins/morris/morris.min.js"></script>
<script src="assets/plugins/raphael/raphael-min.js"></script>
<script src="assets/pages/morris.init.js"></script>



<!--Chart JS-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- 
<script>
    (async function() {
  const data = [
    { month: 'Jan', count: 10 },
    { month: 'Feb', count: 20 },
    { month: 'Mar', count: 15 },
    { month: 'Apr', count: 25 },
    { month: 'Mei', count: 22 },
    { month: 'Jun', count: 3 },
    { month: 'Jul', count: 2 },
    { month: 'Agu', count: 8 },
    { month: 'Sept', count: 4 },
    { month: 'Okt', count: 6 },
    { month: 'Nov', count: 20},
    { month: 'Des', count: 15 },
  ];

  new Chart(
    document.getElementById('myChart'),
    {
      type: 'bar',
      data: {
        labels: data.map(row => row.month),
        datasets: [
          {
            label: 'Cuti',
            data: data.map(row => row.count)
          }
        ]
      }
    }
  );
})();
</script> -->

<script>
      var users2 =  {{ Js::from($data) }};   
      var labelBulan = {{ Js::from($labelBulan) }}
  
      const data = {
        labels: labelBulan,
        datasets: [{
          label: 'Cuti dan Izin',
          backgroundColor: '#18bae2',
          borderColor: '#18bae2',
          data: users2,
        }]
      };
  
      const config = {
        type: 'line',
        data: data,
        options: {}
      };
  
      const myChart = new Chart(
        document.getElementById('myChart'),
        config
      );
</script>



@endsection