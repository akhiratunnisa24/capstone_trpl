@extends('layouts.default')
@section('content')
    <!-- Header -->

    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Data Absen Tidak Masuk</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Data Absen Tidak Masuk </li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <?php session_start(); ?>
    <div class="content">
        <div class="container">
            <div class="row">

                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading  col-15 m-b-10">
                            <h4>Absen Tidak Masuk Hari Ini</h4>

                        </div>
                        <div class="panel-body">
                            <table id="datatable-responsive6"
                                class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0"
                                width="100%">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Divisi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tidakMasuk as $k)
                                        <tr>
                                            <td>{{ $loop->iteration ?? '' }}</td>
                                            <td>{{ $k->nama ?? ''}}</td>
                                            <td>{{ $k->departemen->nama_departemen ?? ''}}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') ?? '' }}</td>
                                            <td>{{ $k->status  ?? ''}}</td>

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
                        <div class="panel-body">
                            <table id="datatable-responsive25"  class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Divisi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tidakMasukBulanIni as $k)
                                        <tr>
                                            <td>{{ $loop->iteration ?? '' }}</td>
                                            <td>{{ $k->nama ?? ''}}</td>
                                            <td>{{ $k->departemen->nama_departemen ?? ''}}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') ?? ''}}</td>
                                            <td>{{ $k->status ?? ''}}</td>
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
                        <div class="panel-body">
                            <table id="datatable-responsive26" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0"
                                width="100%">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Divisi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tidakMasukBulanLalu as $k)
                                        <tr>
                                            <td>{{ $loop->iteration ?? ''}}</td>
                                            <td>{{ $k->nama ?? ''}}</td>
                                            <td>{{ $k->departemen->nama_departemen ?? ''}}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tanggal)->format('d/m/Y') ?? ''}}</td>
                                            <td>{{ $k->status ?? ''}}</td>
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
