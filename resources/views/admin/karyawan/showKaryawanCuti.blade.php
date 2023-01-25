@extends('layouts.default')
@section('content')

<!-- Header -->

<div class="row">
    <div class="col-sm-12">

        <div class="page-header-title">
            <h4 class="pull-left page-title">Data Cuti dan Izin </h4>

            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Data Cuti dan Izin </li>
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
                    <h4>Izin Hari Ini</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Keperluan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Jumlah Hari</th>
                                    <th>Status</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($izin as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->keperluan}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}}</td>
                                        <td>{{$k->jml_hari}}</td>
                                        <td>{{$k->jam_mulai}}</td>
                                        <td>{{$k->jam_selesai}}</td>
                                        <td>{{$k->status}}</td>              
                                    
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
                    <h4>Cuti Hari Ini</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Jumlah Hari</th>
                                    <th>Status</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($cuti as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->jeniscuti->jenis_cuti}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}}</td>
                                        <td>{{$k->jml_cuti}}</td>
                                        <td>{{$k->status}}</td>             
                                    
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
                    <h4>Izin Bulan Ini</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Keperluan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Jumlah Hari</th>
                                    <th>Status</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($izinBulanIni as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->keperluan}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}}</td>
                                        <td>{{$k->jml_hari}}</td>
                                        <td>{{$k->jam_mulai}}</td>
                                        <td>{{$k->jam_selesai}}</td>
                                        <td>{{$k->status}}</td>              
                                    
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
                    <h4>Cuti Bulan Ini</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Jumlah Hari</th>
                                    <th>Status</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($cutiBulanIni as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->jeniscuti->jenis_cuti}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}}</td>
                                        <td>{{$k->jml_cuti}}</td>
                                        <td>{{$k->status}}</td>             
                                    
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
                    <h4>Izin Bulan Lalu</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Keperluan</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Jumlah Hari</th>
                                    <th>Status</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($izinBulanLalu as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->keperluan}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}}</td>
                                        <td>{{$k->jml_hari}}</td>
                                        <td>{{$k->jam_mulai}}</td>
                                        <td>{{$k->jam_selesai}}</td>
                                        <td>{{$k->status}}</td>              
                                    
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
                    <h4>Cuti Bulan Lalu</h4>

                    </div>
                    <div class="panel-body" >
                        <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Jumlah Hari</th>
                                    <th>Status</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($cutiBulanLalu as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->jeniscuti->jenis_cuti}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}}</td>
                                        <td>{{$k->jml_cuti}}</td>
                                        <td>{{$k->status}}</td>             
                                    
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


