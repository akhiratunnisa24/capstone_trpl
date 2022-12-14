@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <div class="col-sm-8">
                    <h4 class="pull-left page-title">Alokasi Cuti</h4>
                </div>
                <div align="right" class="col-sm-4">
                    <a href="/permintaan_cuti" class="btn btn-success btn-md">Kembali ke Cuti</a>
                    <a href="/settingalokasi" class="btn btn-success btn-md">Kembali ke Setting</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>    
    </div>
    <div class="btn-group" style="margin-left:15px;margin-bottom:10px" role="group" aria-label="Basic example">
        <a href="" class="btn btn-dark" data-toggle="modal" data-target="#Modal1">Import Excel</a>
        <a href="" class="btn btn-dark" data-toggle="modal" data-target="#smallModal">Import CSV</a>
         {{-- form import --}}
        @include('admin.alokasicuti.importexcel')
    </div>
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#newalokasi">Tambah Alokasi</a>
                            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#editalokasi">Edit Alokasi</a>
                            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#showalokasi">View Detail</a>
                        </div>
                         {{-- form setting --}}
                         @include('admin.alokasicuti.addalokasi')
                         @include('admin.alokasicuti.editalokasi')
                         @include('admin.alokasicuti.showalokasi')

                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table  id="datatable-responsive3" class="table dt-responsive table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Karyawan</th>
                                                <th scope="col">Kategori Cuti</th>
                                                <th scope="col">Durasi</th>
                                                <th scope="col">Tanggal Masuk</th>
                                                <th scope="col">Mode Alokasi</th>
                                                <th scope="col">Aktif Dari</th>
                                                <th scope="col">Sampai</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
                                            {{-- @foreach($alokasi as $data) --}}
                                            {{-- {{$loop->iteration}} --}}
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td class="text-center"> 
                                                       <form action="" method="POST" id="bs"> 
                                                           <a id="bs" class="btn btn-info btn-sm Modalshowdetail" data-toggle="modal" data-target="#showdetail">
                                                               <i class="fa fa-eye"></i>
                                                           </a> 
                                                           <a id="bs" class="btn btn-sm btn-success Modaleditalokasi" data-toggle="modal" data-target="#editalokasi">
                                                               <i class="fa fa-edit"></i>
                                                           </a> 
                                                           @csrf 
                                                           @method('DELETE') 
                                                           <button id="bs" type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                               <i class="fa fa-trash"></i>
                                                           </button> 
                                                       </form> 
                                                   </td> 
                                                </tr>
                                            {{-- @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div> <!-- content -->
    
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/modernizr.min.js"></script>
    <script src="assets/js/detect.js"></script>
    <script src="assets/js/fastclick.js"></script>
    <script src="assets/js/jquery.slimscroll.js"></script>
    <script src="assets/js/jquery.blockUI.js"></script>
    <script src="assets/js/waves.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
    <script src="assets/js/app.js"></script>
@endsection