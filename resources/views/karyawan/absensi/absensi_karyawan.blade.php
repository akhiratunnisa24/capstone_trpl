@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Absensi karyawan</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Human Resources Management System</a></li>
                    <li class="active">Absensi Karyawan</li>
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
                    <div class="panel panel-light">
                        <div class="panel-body">
                            {{-- TAMPILAN ABSENSI karyawan --}}
                            <h3 class="text-center m-t-0 m-b-30">
                                <span class=""><img src="assets/images/user.png" alt="logo" height="130" width="130"></span>
                                <h3 align="center"><strong>{{Auth::user()->name}}</strong></h3>
                                <div>
                                    @if(!isset($absensi->jam_masuk))
                                        <form action="{{route('absensi.action')}}" method="POST" align="center">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" class="btn btn-info btn-lg"> 
                                            ABSEN MASUK
                                            </button> 
                                        </form>
                                    @else
                                        <form action="{{route('absen_pulang',$absensi->id)}}" method="POST" align="center">
                                            @csrf
                                            <button type="submit" class="btn btn-warning btn-lg m-10">
                                            ABSEN PULANG
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </h3>
                            <h4 class="text-muted text-center m-t-0"><b></b></h4>
                        </div>
                    </div>
                </div>
            </div> <!-- End Row -->
        </div> <!-- container -->
    </div> <!-- content --> 

        {{-- <!-- jQuery  -->
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

        {{-- <!-- Datatables-->
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
        <script src="assets/plugins/datatables/dataTables.scroller.min.js"></script> --}} --}}

    {{-- <!-- Datatable init js -->
    <script src="assets/pages/datatables.init.js"></script>
    <script src="assets/js/app.js"></script> --}}

@endsection