@extends('layouts.default')
@section('content')

<!-- Header -->

<div class="row">
    <div class="col-sm-12">

        <div class="page-header-title">
            <h4 class="pull-left page-title">Data Cuti dan Izin </h4>

            <ol class="breadcrumb pull-right">
                <li>Rynest Employee Management System</li>
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
                        <table id="datatable-responsive33" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Pelaksanaan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($izin as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->jenisizins->jenis_izin}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}} @if($k->tgl_selesai != NULL) s.d {{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}} @endif</td>
                                        {{-- <td>{{$k->status}}</td>               --}}
                                        <td>
                                            @if($k->status == $k->statuses->id)
                                                <span class="badge badge-{{ $k->status == 1 ? 'warning' : ($k->status == 2 ? 'info' : ($k->status == 5 ? 'danger' : ($k->status == 6 ? 'secondary' : ($k->status == 7 ? 'success' : ($k->status == 9 ? 'danger' : ($k->status == 10 ? 'danger' : ($k->status == 11 ? 'warning' : ($k->status == 12 ? 'secondary' : ($k->status == 13 ? 'success' : ($k->status == 14 ? 'warning' :($k->status == 15 ? 'primary' : ($k->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                    {{ $k->status == 1 ? $k->statuses->name_status : ($k->status == 2 ?  $k->statuses->name_status : ($k->status == 5 ?  $k->statuses->name_status : ($k->status == 6 ?  $k->statuses->name_status : ($k->status == 7 ?  $k->statuses->name_status : ($k->status == 9 ?  $k->statuses->name_status : ($k->status == 10 ?  $k->statuses->name_status : ($k->status == 11 ?  $k->statuses->name_status : ($k->status == 12 ?  $k->statuses->name_status : ($k->status == 13 ?  $k->statuses->name_status :  ($k->status == 14 ?  $k->statuses->name_status :  ($k->status == 15 ?  $k->statuses->name_status :  ($k->status == 16 ?  $k->statuses->name_status : '')))))))))))) }}
                                                </span>
                                            @endif
                                        </td>

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
                        <table id="datatable-responsive34" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kategori Cuti</th>
                                    <th>Tanggal Pelaksanaan</th>
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
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}} @if($k->tgl_selesai != NULL) s.d {{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}} @endif</td>
                                        <td>{{$k->jml_cuti}}</td>
                                        <td>
                                            {{-- {{$k->status}} --}}
                                            @if($k->status == $k->statuses->id)
                                                <span class="badge badge-{{ $k->status == 1 ? 'warning' : ($k->status == 2 ? 'info' : ($k->status == 5 ? 'danger' : ($k->status == 6 ? 'secondary' : ($k->status == 7 ? 'success' : ($k->status == 9 ? 'danger' : ($k->status == 10 ? 'danger' : ($k->status == 11 ? 'warning' : ($k->status == 12 ? 'secondary' : ($k->status == 13 ? 'success' : ($k->status == 14 ? 'warning' :($k->status == 15 ? 'primary' : ($k->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                    {{ $k->status == 1 ? $k->statuses->name_status : ($k->status == 2 ?  $k->statuses->name_status : ($k->status == 5 ?  $k->statuses->name_status : ($k->status == 6 ?  $k->statuses->name_status : ($k->status == 7 ?  $k->statuses->name_status : ($k->status == 9 ?  $k->statuses->name_status : ($k->status == 10 ?  $k->statuses->name_status : ($k->status == 11 ?  $k->statuses->name_status : ($k->status == 12 ?  $k->statuses->name_status : ($k->status == 13 ?  $k->statuses->name_status :  ($k->status == 14 ?  $k->statuses->name_status :  ($k->status == 15 ?  $k->statuses->name_status :  ($k->status == 16 ?  $k->statuses->name_status : '')))))))))))) }}
                                                </span>
                                            @endif
                                        </td>

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
                        <table id="datatable-responsive35" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Pelaksanaan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($izinBulanIni as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->jenisizins->jenis_izin}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}} @if($k->tgl_selesai !== NULL) s.d {{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}} @endif</td>
                                        <td>
                                            @if($k->status == $k->statuses->id)
                                                <span class="badge badge-{{ $k->status == 1 ? 'warning' : ($k->status == 2 ? 'info' : ($k->status == 5 ? 'danger' : ($k->status == 6 ? 'secondary' : ($k->status == 7 ? 'success' : ($k->status == 9 ? 'danger' : ($k->status == 10 ? 'danger' : ($k->status == 11 ? 'warning' : ($k->status == 12 ? 'secondary' : ($k->status == 13 ? 'success' : ($k->status == 14 ? 'warning' :($k->status == 15 ? 'primary' : ($k->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                    {{ $k->status == 1 ? $k->statuses->name_status : ($k->status == 2 ?  $k->statuses->name_status : ($k->status == 5 ?  $k->statuses->name_status : ($k->status == 6 ?  $k->statuses->name_status : ($k->status == 7 ?  $k->statuses->name_status : ($k->status == 9 ?  $k->statuses->name_status : ($k->status == 10 ?  $k->statuses->name_status : ($k->status == 11 ?  $k->statuses->name_status : ($k->status == 12 ?  $k->statuses->name_status : ($k->status == 13 ?  $k->statuses->name_status :  ($k->status == 14 ?  $k->statuses->name_status :  ($k->status == 15 ?  $k->statuses->name_status :  ($k->status == 16 ?  $k->statuses->name_status : '')))))))))))) }}
                                                </span>
                                            @endif
                                        </td>
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
                        <table id="datatable-responsive36" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kategori Cuti</th>
                                    <th>Tanggal Pelaksanaan</th>
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
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}} @if($k->tgl_selesai != NULL) s.d {{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}} @endif</td>
                                        <td>{{$k->jml_cuti}}</td>
                                        <td>
                                            @if($k->status == $k->statuses->id)
                                                <span class="badge badge-{{ $k->status == 1 ? 'warning' : ($k->status == 2 ? 'info' : ($k->status == 5 ? 'danger' : ($k->status == 6 ? 'secondary' : ($k->status == 7 ? 'success' : ($k->status == 9 ? 'danger' : ($k->status == 10 ? 'danger' : ($k->status == 11 ? 'warning' : ($k->status == 12 ? 'secondary' : ($k->status == 13 ? 'success' : ($k->status == 14 ? 'warning' :($k->status == 15 ? 'primary' : ($k->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                    {{ $k->status == 1 ? $k->statuses->name_status : ($k->status == 2 ?  $k->statuses->name_status : ($k->status == 5 ?  $k->statuses->name_status : ($k->status == 6 ?  $k->statuses->name_status : ($k->status == 7 ?  $k->statuses->name_status : ($k->status == 9 ?  $k->statuses->name_status : ($k->status == 10 ?  $k->statuses->name_status : ($k->status == 11 ?  $k->statuses->name_status : ($k->status == 12 ?  $k->statuses->name_status : ($k->status == 13 ?  $k->statuses->name_status :  ($k->status == 14 ?  $k->statuses->name_status :  ($k->status == 15 ?  $k->statuses->name_status :  ($k->status == 16 ?  $k->statuses->name_status : '')))))))))))) }}
                                                </span>
                                            @endif
                                        </td>

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
                        <table id="datatable-responsive37" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Tanggal Pelaksanaan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($izinBulanLalu as $k)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$k->karyawan->nama}}</td>
                                        <td>{{$k->jenisizins->jenis_izin}}</td>
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}} @if($k->tgl_selesai !== NULL) s.d {{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}} @endif</td>

                                        {{-- <td>{{$k->status}}</td>               --}}
                                        <td>
                                            @if($k->status == $k->statuses->id)
                                                <span class="badge badge-{{ $k->status == 1 ? 'warning' : ($k->status == 2 ? 'info' : ($k->status == 5 ? 'danger' : ($k->status == 6 ? 'secondary' : ($k->status == 7 ? 'success' : ($k->status == 9 ? 'danger' : ($k->status == 10 ? 'danger' : ($k->status == 11 ? 'warning' : ($k->status == 12 ? 'secondary' : ($k->status == 13 ? 'success' : ($k->status == 14 ? 'warning' :($k->status == 15 ? 'primary' : ($k->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                    {{ $k->status == 1 ? $k->statuses->name_status : ($k->status == 2 ?  $k->statuses->name_status : ($k->status == 5 ?  $k->statuses->name_status : ($k->status == 6 ?  $k->statuses->name_status : ($k->status == 7 ?  $k->statuses->name_status : ($k->status == 9 ?  $k->statuses->name_status : ($k->status == 10 ?  $k->statuses->name_status : ($k->status == 11 ?  $k->statuses->name_status : ($k->status == 12 ?  $k->statuses->name_status : ($k->status == 13 ?  $k->statuses->name_status :  ($k->status == 14 ?  $k->statuses->name_status :  ($k->status == 15 ?  $k->statuses->name_status :  ($k->status == 16 ?  $k->statuses->name_status : '')))))))))))) }}
                                                </span>
                                            @endif
                                        </td>

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
                        <table id="datatable-responsive38" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Kategori Cuti</th>
                                    <th>Tanggal Pelaksanaan</th>
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
                                        <td>{{\Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y')}} @if($k->tgl_selesai != NULL) s.d {{\Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y')}} @endif</td>
                                        <td>{{$k->jml_cuti}}</td>
                                        <td>
                                            {{-- {{$k->status}} --}}
                                            @if($k->status == $k->statuses->id)
                                                <span class="badge badge-{{ $k->status == 1 ? 'warning' : ($k->status == 2 ? 'info' : ($k->status == 5 ? 'danger' : ($k->status == 6 ? 'secondary' : ($k->status == 7 ? 'success' : ($k->status == 9 ? 'danger' : ($k->status == 10 ? 'danger' : ($k->status == 11 ? 'warning' : ($k->status == 12 ? 'secondary' : ($k->status == 13 ? 'success' : ($k->status == 14 ? 'warning' :($k->status == 15 ? 'primary' : ($k->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                    {{ $k->status == 1 ? $k->statuses->name_status : ($k->status == 2 ?  $k->statuses->name_status : ($k->status == 5 ?  $k->statuses->name_status : ($k->status == 6 ?  $k->statuses->name_status : ($k->status == 7 ?  $k->statuses->name_status : ($k->status == 9 ?  $k->statuses->name_status : ($k->status == 10 ?  $k->statuses->name_status : ($k->status == 11 ?  $k->statuses->name_status : ($k->status == 12 ?  $k->statuses->name_status : ($k->status == 13 ?  $k->statuses->name_status :  ($k->status == 14 ?  $k->statuses->name_status :  ($k->status == 15 ?  $k->statuses->name_status :  ($k->status == 16 ?  $k->statuses->name_status : '')))))))))))) }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="/" class="btn btn-sm btn-danger pull-right" style="margin-right:15px;">Kembali <i class="fa fa-home"></i></a>
</div>
@endsection


