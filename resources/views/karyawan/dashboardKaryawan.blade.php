@extends('layouts.default')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Dashboard Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Dashboard Karyawan</li>
                </ol>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-primary text-center">
                <div class="panel-heading btn-info">
                    <h4 class="panel-title">Sisa Cuti Anda</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $row->cuti_tahunan }}</b></h3>
                    <p class="text-muted"><b>Total Sisa Cuti Anda</b> </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-primary text-center">
                <div class="panel-heading btn-info">
                    <h4 class="panel-title">Absen Hari Ini</h4>
                </div>

                
        <?php
            use Illuminate\Support\Facades\Auth;
            use App\Models\Absensi;

            if ($absenKaryawan == 1 ) { ?>
              <div class="panel-body">
                  <h3 class=""><b class= "text text-success" >Sukses</b></h3>
                  <p class="text-muted"><b>Anda Sudah Berhasil Absen</b></p>
              </div>  
                    <?php
                } else { ?>
                    <div class="panel-body">
                      <h3 class=""><b class= "text text-success" >Belum Absen</b></h3>
                      <p class="text-muted"><b>Anda Sudah Berhasil Absen</b></p>
                  </div>
                    <?php } ?>

            </div>
        </div>


        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-primary text-center">
                <div class="panel-heading btn-warning">
                    <h4 class="panel-title">Jumlah Terlambat Anda</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{$absenTerlambatkaryawan}}</b></h3>
                    <p class="text-muted"><b>Total Jumlah Terlambat Anda</b> </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-primary text-center">
                <div class="panel-heading btn-danger">
                    <h4 class="panel-title">Tidak Hadir Anda Bulan Ini</h4>
                </div>

                <div class="panel-body">
                    
        <?php

        if ($absenTidakmasuk == 2 ) { ?>
              <h3 class=""><b class= "text text-success" >Masuk</b></h3>
                <?php
            } else { ?>
                  <h3 class=""><b class= "text text-success" >Total cuti + Total izin + tidak ada keterangan</b></h3>
                <?php } ?>

                    <p class="text-muted"><b>Total Jumlah Tidak Hadir Anda</b> </p>
                </div>

            </div>
        </div>


        </div>

    </div>


{{--     
<div class="row">
  <!-- BAR Chart -->
  <div class="col-lg-12">
    <div class="panel panel-border panel-info">
      <div class="panel-heading ">
        <h3 class="panel-title text-white">Total Cuti dan Izin Anda</h3>
      </div>
      <div class="panel-body">
        <div id="morris-bar-example" style="height: 300px"></div>
      </div>
    </div>
  </div> <!-- col -->
  
  <!-- BAR Chart -->
  <div class="col-lg-12">
    <div class="panel panel-border panel-warning">
      <div class="panel-heading">
        <h3 class="panel-title text-white">Total Dinas Luar Kota Anda</h3>
      </div>
      <div class="panel-body">
        <div id="morris-bar-example2" style="height: 300px"></div>
      </div>
    </div>
  </div> <!-- col -->
  
  <!-- BAR Chart -->
  <div class="col-lg-12">
    <div class="panel panel-border panel-success">
      <div class="panel-heading">
        <h3 class="panel-title text-white">Absen Masuk</h3>
      </div>
      <div class="panel-body">
        <div id="morris-bar-example3" style="height: 300px"></div>
      </div>
    </div>
  </div> <!-- col -->
  
  <!-- BAR Chart -->
  <div class="col-lg-12">
    <div class="panel panel-border panel-danger">
      <div class="panel-heading">
        <h3 class="panel-title text-white">Absen Tidak Masuk</h3>
      </div>
      <div class="panel-body">
        <div id="morris-bar-example4" style="height: 300px"></div>
      </div>
    </div>
  </div> <!-- col -->

</div> <!-- End Row -->

<div class="row" hidden>
  
  <!--  Line Chart -->
  <div class="col-lg-12">
    <div class="panel panel-border panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Absen Tidak Masuk</h3>
      </div>
      <div class="panel-body">
        <div id="morris-line-example" style="height: 300px"></div>
      </div>
    </div>
  </div> <!-- col -->
  
</div> <!-- End row-->


<div class="row" hidden>
  
  <!-- Area Chart -->
  <div class="col-lg-12">
    <div class="panel panel-border panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Absen Tidak Masuk </h3>
      </div>
      <div class="panel-body">
        <div id="morris-area-example" style="height: 300px"></div>
      </div>
    </div>
  </div> <!-- col -->
   
</div> <!-- End row-->

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
<script src="assets/pages/morris.init.js"></script> --}}



    <!-- END wrapper -->
@endsection
