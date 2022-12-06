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
      <div class="panel-heading">
        <h4 class="panel-title">Sisa Cuti Anda</h4>
      </div>
      <div class="panel-body">
        <h3 class=""><b>2568</b></h3>
        <p class="text-muted"><b>Total Pengajuan Cuti dan Izin Anda</b> </p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="panel panel-primary text-center">
      <div class="panel-heading">
        <h4 class="panel-title">Dinas Luar Kota Anda</h4>
      </div>
      <div class="panel-body">
        <h3 class=""><b>666</b></h3>
        <p class="text-muted"><b>Total Dinas Keluar Kota Anda</b> </p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="panel panel-primary text-center">
      <div class="panel-heading">
        <h4 class="panel-title">Jumlah Tidak Hadir Anda</h4>
      </div>
      <div class="panel-body">
        <h3 class=""><b>77</b></h3>
        <p class="text-muted"><b>Total Jumlah Tidak Hadir Anda</b> </p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="panel panel-primary text-center">
      <div class="panel-heading">
        <h4 class="panel-title">Jumlah Terlambat Anda</h4>
      </div>
      <div class="panel-body">
        <h3 class=""><b>14</b></h3>
        <p class="text-muted"><b>Total Jumlah Terlambat Anda</b> </p>
      </div>
    </div>
  </div>
</div>


</div>
<!-- END wrapper -->
@endsection