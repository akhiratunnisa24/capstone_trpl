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
      <div class="panel-heading">
        <h4 class="panel-title">Pengajuan Cuti dan Izin</h4>
      </div>
      <div class="panel-body">
        <h3 class=""><b>2568</b></h3>
        <p class="text-muted"><b>Total Pengajuan Cuti dan Izin</b> </p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="panel panel-primary text-center">
      <div class="panel-heading">
        <h4 class="panel-title">Dinas Luar Kota</h4>
      </div>
      <div class="panel-body">
        <h3 class=""><b>666</b></h3>
        <p class="text-muted"><b>Total Dinas Keluar Kota</b> </p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="panel panel-primary text-center">
      <div class="panel-heading">
        <h4 class="panel-title">Absen Masuk</h4>
      </div>
      <div class="panel-body">
        <h3 class=""><b>77</b></h3>
        <p class="text-muted"><b>Total Absen Masuk</b> </p>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-lg-3">
    <div class="panel panel-primary text-center">
      <div class="panel-heading">
        <h4 class="panel-title">Yang Tidak Masuk</h4>
      </div>
      <div class="panel-body">
        <h3 class=""><b>14</b></h3>
        <p class="text-muted"><b>Total Yang Tidak Masuk</b> </p>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-lg-6">
    <div class="panel panel-border panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Pengajuan Cuti dan Izin</h3>
      </div>
      <div class="panel-body">
        <canvas id="lineChart" height="300"></canvas>
      </div>
    </div>
  </div>

  

  <!-- END wrapper -->
  @endsection