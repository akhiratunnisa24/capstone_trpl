@extends('layouts.default')
@section('content')
    <!-- Header -->
    <link rel="stylesheet" type="text/css" href="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css">
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Data Informasi</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Data Informasi</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Close Header -->

    <!-- Start content -->
    <?php session_start(); ?>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading  clearfix">
                            <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                data-target="#createInformasi"> Tambah Data Informasi</a>
                        </div>
                        @include('admin.datamaster.informasi.create')
                        
                        <div class="panel-body">
                            <table id="datatable-responsive39" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                                <thead>
                                    <tr>
                                        <th style="width: 20px;">No</th>
                                        <th style="width: 200px;">Judul</th>
                                        <th style="width: 400px;">Konten</th>
                                        <th style="width: 100px;">Masa Aktif</th>
                                        <th style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($informasi as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $data->judul }}</td>
                                            <td style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: normal;">{!! nl2br(html_entity_decode($data->konten)) !!}</td>
                                            <td>{{ \Carbon\Carbon::parse($data->tanggal_aktif)->format('d/m/Y') }} @if($data->tanggal_berakhir !== NULL) s.d {{ \Carbon\Carbon::parse($data->tanggal_berakhir)->format('d/m/Y') }} @endif</td>
                                            <td id="b" class="text-center" > 
                                                <div class="row">
                                                    <div class="col-sm-3" style="margin-left:6px">
                                                        <form action="" method="POST"> 
                                                            <a  class="btn btn-success btn-sm" style="height:26px" data-toggle="modal" data-target="#ShowInformasi{{$data->id}}">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        </form> 
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('admin.datamaster.informasi.edit')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>
    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script><!--Summernote js-->
    <script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>


    @if(Session::has('pesan'))
        <script>
            swal("Selamat","{{ Session::get('pesan')}}", 'success', {
                button:true,
                button:"OK",
            });
        </script>
    @endif

    @if(Session::has('pesa'))
    <script>
        swal("Mohon Maaf","{{ Session::get('pesa')}}", 'error', {
            button:true,
            button:"OK",
        });
    </script>
@endif
@endsection
