@extends('layouts.default')
@section('content')

<!-- Header -->

<div class="row">
    <div class="col-sm-12">

        <div class="page-header-title">
            <h4 class="pull-left page-title">Data Absen Masuk </h4>

            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Data Absen Masuk </li>
            </ol>

            <div class="clearfix">
            </div>
        </div>
    </div>
</div>
<!-- Close Header -->

<!-- Start right Content here -->
<!-- Start content -->
<?php session_start(); ?>
<div class="content">
    <div class="container">
        <div class="row">

            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading  col-15 m-b-10">
                    <h4>Absen Masuk Hari Ini</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive30" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jadwal Masuk</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Terlambat</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($absen as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->jadwal_masuk}}</td>
                                        <td>{{$k->jam_masuk}}</td>
                                        <td>{{$k->jam_keluar}}</td>
                                        <td>{{$k->terlambat}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tanggal)->format('d/m/Y')}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading  col-15 m-b-10">
                    <h4>Absen Masuk Bulan Ini</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive31" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jadwal Masuk</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Terlambat</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($absenBulanIni as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->jadwal_masuk}}</td>
                                        <td>{{$k->jam_masuk}}</td>
                                        <td>{{$k->jam_keluar}}</td>
                                        <td>{{$k->terlambat}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tanggal)->format('d/m/Y')}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


             <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading  col-15 m-b-10">
                    <h4>Absen Masuk Bulan Lalu</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive32" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jadwal Masuk</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Terlambat</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($absenBulanLalu as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->jadwal_masuk}}</td>
                                        <td>{{$k->jam_masuk}}</td>
                                        <td>{{$k->jam_keluar}}</td>
                                        <td>{{$k->terlambat}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tanggal)->format('d/m/Y')}}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>


@endsection


