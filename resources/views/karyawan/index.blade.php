@extends('layouts.default')
@section('content')

<!-- Sweet Alert -->
<link href="assets/plugins/bootstrap-sweetalert/sweet-alert.css" rel="stylesheet" type="text/css">

    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Data Karyawan</h4>

                  <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Data Karyawan</li>
                  </ol>

                    <div class="clearfix">
                    </div>
            </div>
        </div>
    </div>
    <!-- Close Header -->
                
                <!-- Start right Content here -->            
                <!-- Start content -->
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-primary">
                                    <div class="panel-heading  col-sm-15 m-b-10">
                                        
                                        <a href="#" type="button" class="btn btn-sm btn-dark " data-toggle="modal" data-target="#myModal">Tambah Karyawan</a> 
                                        
                                    </div>

                                    @include('karyawan.addModal')

                                        <div class="panel-body">
                                                <table id="datatable" class="table table-striped table-bordered">                                                

                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>NIK</th>
                                                            <th>Nama</th>
                                                            <th>Email</th>
                                                            <th>Jenis Kelamin</th>
                                                            <th>Alamat</th>
                                                            <th>Tanggal Masuk</th>
                                                            <th>Tanggal Keluar</th>
                                                            <th>Action</th>

                                                            <?php $no=1 ?>
                                                        </tr>
                                                    </thead>


                                                    <tbody>
                                                    @foreach ($karyawan as $k)
                                                        <tr>
                                                            <td>{{$no++}}</td>
                                                            <td>{{$k->nik}}</td>
                                                            <td>{{$k->nama}}</td>
                                                            <td>{{$k->email}}</td>
                                                            <td>{{$k->jenis_kelamin}}</td>
                                                            <td>{{$k->alamat}}</td>
                                                            <td>{{$k->tglmasuk}}</td>
                                                            <td>{{$k->tglkeluar}}</td>
                                                            <td>

                                                            

                                                <div class="d-grid gap-2 " role="group" aria-label="Basic example" >
                                                                <form action="karyawan/destroy/{{$k->id}}" method="POST">

                                                                <a class="btn btn-success btn-sm" href="#" type="button"  data-toggle="modal" data-target="#myModal2{{ $k->id }}">
                                                                        <i class="fa fa-pencil"></i>
                                                                </a>

                                                                    @csrf
                                                                    @method ('delete')   

                                                                    <button onclick="return confirm('Anda yakin mau menghapus item ini ?')" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button> 
                                                                </form>
                                                                </td>
                                                                        <!-- MODAL BEGIN -->
                                                    
                                        
                                                    @include('karyawan.editModal')
                                                </div>
                                        </div>
                                                        </tr>
                                                    @endforeach  
                                                    
                                                    </tbody>
                                                </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>





        <!-- Sweet-Alert  -->
        <script src="assets/plugins/bootstrap-sweetalert/sweet-alert.min.js"></script>
        <script src="assets/pages/sweet-alert.init.js"></script>                                 

@endsection