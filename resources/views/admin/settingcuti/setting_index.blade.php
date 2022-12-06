@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <div class="col-sm-8">
                    <h4 class="pull-left page-title">Setting Alokasi</h4>
                </div>
                <div class="col-sm-4" align="right">
                    <a href="/permintaan_cuti" class="btn btn-success btn-md">Kembali ke Cuti</a>
                    <a href="/alokasicuti" class="btn btn-success btn-md">Kembali ke Alokasi</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>    
    </div>
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#newsetting">Form Setting</a>
                            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#editsetting">Edit Setting</a>
                            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#showsetting">View Detail</a>
                        </div>
                        {{-- form setting --}}
                        @include('admin.settingcuti.formsetting')
                        @include('admin.settingcuti.editsetting')
                        @include('admin.settingcuti.showsetting')
                        
                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable" class="table table-responsive table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">Kategori Cuti</th>
                                                <th scope="col">Tipe Alokasi</th>
                                                <th scope="col">Durasi</th>
                                                <th scope="col">Mode</th>
                                                <th scope="col">Nama Mode</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- @foreach($absensi as $data) --}}
                                                <tr>
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

    <!-- Datatables-->
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>
    <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
    <script src="assets/plugins/datatables/buttons.bootstrap.min.js"></script>
    <script src="assets/plugins/datatables/jszip.min.js"></script>
    <script src="assets/plugins/datatables/pdfmake.min.js"></script>
    <script src="assets/plugins/datatables/vfs_fonts.js"></script>
    <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
    <script src="assets/plugins/datatables/buttons.print.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.keyTable.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables/responsive.bootstrap.min.js"></script>
    <script src="assets/plugins/datatables/dataTables.scroller.min.js"></script> 

    <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>

    <script src="assets/js/app.js"></script>
@endsection