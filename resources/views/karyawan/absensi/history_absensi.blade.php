@extends('layouts.default')
@section('content')

    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">History Absensi</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Human Resources Management System</a></li>
                    <li class="active">History Absensi</li>
                </ol>
                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Close Header -->
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">History Absensi Anda</h3>
                        </div>
                        <div class="panel-body m-b-5">
                            {{-- <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12"> --}}
                                    <table id="datatable-responsive8" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Karyawan</th>
                                                <th>Tanggal</th>
                                                <th>Jam Masuk</th>
                                                <th>Jam Keluar</th>
                                                <th>Jml Hadir</th>
                                                <th>Telat</th>
                                                <th>P. cepat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($historyabsensi as $data)
                                                {{-- @if($data->id_karyawan == Auth::user()->id_pegawai) --}}
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$data->karyawans->nama}}</td>
                                                        <td>{{\Carbon\Carbon::parse($data->tanggal)->format('d/m/Y')}}</td>
                                                        <td>{{$data->jam_masuk}}</td>
                                                        <td>{{$data->jam_keluar}}</td>
                                                        <td>{{$data->jam_kerja}}</td>
                                                        <td>{{$data->terlambat}}</td>
                                                        <td>{{$data->plg_cepat}}</td>
                                                    </tr>
                                                {{-- @endif --}}
                                            @endforeach
                                        </tbody>
                                    </table>
                                {{-- </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div> <!-- End Row -->
        </div> <!-- container -->
    </div> <!-- content -->
       
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
    <script src="assets/js/app.js"></script>
@endsection