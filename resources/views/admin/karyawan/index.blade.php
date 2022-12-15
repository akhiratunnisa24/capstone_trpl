@extends('layouts.default')

@section('content')
<!-- Header -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <h4 class="pull-left page-title">Data karyawan</h4>
            <ol class="breadcrumb pull-right">
                <li><a href="#">Human Resources Management System</a></li>
                <li class="active">Data Karyawan</li>
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
                        <h3 class="panel-title">Data Karyawan</h3>
                    </div>
                    <div class="panel-body m-b-5">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="datatable-responsive" class="table table-striped dt-responsive table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>NIK</th>
                                            <th>Departemen</th>
                                            <th>Alamat</th>
                                            <th>Tgl. Masuk</th>
                                            <th>Tgl. Keluar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($karyawan as $data)
                                            <tr>
                                                <td>{{$data->nama}}</td>
                                                <td>{{$data->nik}}</td>
                                                <td>{{$data->departemens->departemen}}</td>
                                                <td>{{$data->alamat}}</td>
                                                <td>{{$data->tglmasuk}}</td>
                                                <td>{{$data->tglkeluar}}</td>
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