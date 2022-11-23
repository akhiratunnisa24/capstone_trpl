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
<?php session_start(); ?>
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
                        <table id="datatable" class="table table-striped table-bordered ">

                            <thead >
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>L / P</th>
                                    <th>Alamat</th>
                                    <th>Status Karyawan</th>
                                    <th>Tipe Karyawan</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Action</th>

                                    <?php $no = 1 ?>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($karyawan as $k)
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$k->nama}}</td>
                                    <td>{{$k->tgllahir}}</td>
                                    <td>{{$k->jenis_kelamin}}</td>
                                    <td>{{$k->alamat}}</td>
                                    <td>{{$k->status_karyawan}}</td>
                                    <td>{{$k->tipe_karyawan}}</td>
                                    <td>{{$k->tglmasuk}}</td>
                                    <td>
                                        <div class="d-grid gap-2 " role="group" aria-label="Basic example">

                                            <a href="karyawanshow{{$k->id}}" class="btn btn-info btn-sm">
                                            <i class="fa fa-eye"></i></a>
                                             
                                            <button onclick="hapus_karyawan({{$k->id}})"  class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>  
                                    </td>               
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



<script>

function hapus_karyawan(id){
    swal.fire({
            title: "Apakah anda yakin ?",
            text: "Data yang sudah terhapus tidak dapat dikembalikan kembali",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Ya, hapus!",
            CancelButtonText: "Ya!",
            closeOnConfirm: false
        }).then((result) => {
            if (result.isConfirmed) {
                swal.fire({
                    title : "Deleted!",
                    text: "Your imaginary file has been deleted.",
                    type: "success",
                    confirmButtonColor: '#3085d6',
                })
                location.href = '<?= "http://localhost:8000/karyawan/destroy/" ?>' + id;
            }
            })
        }

</script>

@endsection