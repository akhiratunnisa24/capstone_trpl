@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Ajukan Resign</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Ajukan Resign</li>
                </ol>
                <div class="clearfix"></div>               
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
                                        <div class="panel-heading clearfix">
                                            {{-- <strong>List Permohonan Cuti</strong> --}}
                                            <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                                data-target="#Modal"> Form Ajukan Resign</a>
                                        </div>
                                        <!-- modals tambah data cuti -->
                                        @include('karyawan.resign.addresign')

                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <table id="datatable-responsive"
                                                        class="table dt-responsive nowrap table-striped table-bordered"
                                                        cellspacing="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Karyawan</th>
                                                                <th>Departemen</th>
                                                                <th>Tanggal Bergabung</th>
                                                                <th>Tanggal Resign</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End Row -->
                        </div> <!-- container -->
                    </div> <!-- content -->
                </div>

             

            </div>
        </div>
    </div>
</div>



    {{-- <script type="text/javascript">
    let tp = '{{$tipe}}';
    
        if(tp == 1) {
            $('#tab1').click();
        } else {
            $('#tab2').click();
        }
</script> --}}
@endsection