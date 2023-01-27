@extends('layouts.default')
@section('content')

<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">


<!-- Header -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <h4 class="pull-left page-title">Setting Alokasi Cuti Karyawan</h4>

            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Setting Alokasi</li>
            </ol>
           
            <div class="clearfix"></div>
        </div>
    </div>
<!-- Start content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        <a href="" class="btn btn-dark fa fa-plus pull-right" data-toggle="modal" data-target="#newsetting"> Tambah
                            Setting</a>
                    </div>
                    <div class="panel-body m-b-5">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="datatable-responsive11" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Kategori Cuti</th>
                                            <th>Durasi (Hari)</th>
                                            <th>Mode Alokasi</th>
                                            <th>Departemen</th>
                                            <th>JK/Status</th>
                                            <th>T. Aprproval</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($settingalokasi as $data)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$data->jeniscutis->jenis_cuti}}</td>
                                            <td>{{$data->durasi}}</td>
                                            <td>{{$data->mode_alokasi}}</td>
                                            @if($data->departemen !=null)
                                            <td>{{$data->departemens->nama_departemen}}</td>
                                            @else
                                            <td>{{$data->departemen}}</td>
                                            @endif
                                            <td>{{$data->mode_karyawan}}</td>
                                            <td>{{$data->tipe_approval}}</td>
                                            <td class="text-center">
                                                <a id="bs" class="btn btn-info btn-sm Modalshowsetting"
                                                    data-toggle="modal" data-target="#Modalshowsetting{{$data->id}}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a id="bs" class="btn btn-sm btn-success editsetting"
                                                    data-toggle="modal" data-target="#editsetting{{$data->id}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <button onclick="settingalokasi({{$data->id}})"
                                                    class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        {{-- modals show setting --}}
                                        @include('admin.settingcuti.showsetting')
                                        @include('admin.settingcuti.editsetting')
                                        {{-- @include('admin.settingcuti.editsetting',explode(",", $data->kode_karyawan)) --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- content -->
    {{-- form setting --}}
    @include('admin.settingcuti.formsetting')

    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    {{-- <script src="assets/js/app.js"></script> --}}
    
    <!-- sweet alert -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"></script>

    {{-- Direct halaman tambah data --}}
    <script type="text/javascript">
        function settingalokasi(id) {
            swal.fire({
                title: "Apakah anda yakin?",
                text: "Data yang sudah terhapus tidak dapat dikembalikan kembali",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "Ya, hapus!",
                closeOnConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    swal.fire({
                        title: "Terhapus!",
                        text: "Data berhasil di hapus..",
                        icon: "success",
                        confirmButtonColor: '#3085d6',
                    })
                    location.href = '<?= 'http://localhost:8000/deletesetting/' ?>' + id;
                }
            })
        }
    </script>

    <?php if(@$_SESSION['sukses']){ ?>
    <script>
        swal.fire("Good job!", "<?php echo $_SESSION['sukses']; ?>", "success");
    </script>
    <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->

    <?php unset($_SESSION['sukses']); } ?>
    @endsection