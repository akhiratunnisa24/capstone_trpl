@extends('layouts.default')

@section('content')
<!-- Header -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <h4 class="pull-left page-title">Data karyawan</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Rynest Employee Management System</a></li>
                <li class="active">Data Staff Departemen</li>
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
                        <h3 class="panel-title">Data Staff Departemen</h3>
                    </div>
                    <div class="panel-body m-b-5">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="datatable-responsive9" class="table table-striped dt-responsive table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Staff</th>
                                            <th>NIK</th>
                                            <th>Departemen</th>
                                            <th>Alamat</th>
                                            <th>Tgl. Masuk</th>
                                            <th>Jabatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($staff as $data)
                                        {{-- @if($data->) --}}
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$data->nama}}</td>
                                                <td>{{$data->nik}}</td>
                                                <td>{{$data->departemens->nama_departemen}}</td>
                                                <td>{{$data->alamat}}</td>
                                                <td>{{\Carbon\Carbon::parse($data->tglmasuk)->format('d/m/Y')}}</td>
                                                <td>{{$data->jabatan}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Row -->
    </div> <!-- container -->
</div> <!-- content -->
                  
    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
    <script src="assets/js/app.js"></script>                        

@endsection