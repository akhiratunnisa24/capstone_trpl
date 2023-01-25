@extends('layouts.default')
@section('content')

<!-- Header -->

<div class="row">
    <div class="col-sm-12">

        <div class="page-header-title">
            <h4 class="pull-left page-title">Data Absen Tidak Masuk</h4>

            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Data Absen Tidak Masuk </li>
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
                    <h4>Absen Tidak Masuk Hari Ini</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Email</th>
                                    <th>Divisi</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($tidakMasuk as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->nama}}</td>
                                        <td>{{$k->karyawan2->jenis_kelamin}}</td>
                                        <td>{{$k->karyawan2->email}}</td>
                                        <td>{{$k->departemen->nama_departemen}}</td>
                                        <td>{{\Carbon\Carbon::now()->format('d/m/Y')}}</td>

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
                    <h4>Absen Tidak Masuk Bulan Ini</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                             <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Email</th>
                                    <th>Divisi</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($tidakMasukBulanIni as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->nama}}</td>
                                        <td>{{$k->karyawan2->jenis_kelamin}}</td>
                                        <td>{{$k->karyawan2->email}}</td>
                                        <td>{{$k->departemen->nama_departemen}}</td>
                                        <td>{{\Carbon\Carbon::now()->format('d/m/Y')}}</td>

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
                    <h4>Absen Tidak Masuk Bulan Lalu</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                             <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Email</th>
                                    <th>Divisi</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($tidakMasukBulanLalu as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->nama}}</td>
                                        <td>{{$k->karyawan2->jenis_kelamin}}</td>
                                        <td>{{$k->karyawan2->email}}</td>
                                        <td>{{$k->departemen->nama_departemen}}</td>
                                        <td>{{\Carbon\Carbon::now()->format('d/m/Y')}}</td>

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


