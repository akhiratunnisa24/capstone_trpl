@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Setting Organisasi</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Setting Organisasi</li>
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
                        {{-- <div class="panel-heading  clearfix">
                            <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                data-target="#AddModal"> Edit Organisasi</a>
                        </div> --}}
                        {{-- @include('admin.datamaster.organisasi.addOrganisasi') --}}
                        <div class="panel-body">
                            <table id="datatable-responsive13" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Departemen</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($departemen as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            {{-- <td>{{ $data->id }}</td> --}}
                                            <td>{{ $data->nama_departemen }}</td>
                                            <td class="text-center">
                                                <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                    {{-- <a class="btn btn-info btn-sm" data-toggle="modal" 
                                                        data-target="#showDepartmen{{$data->id}}"><i class="fa fa-eye"></i></a> --}}

                                                    <a class="btn btn-success btn-sm editDepartmen" data-toggle="modal" 
                                                       data-target="#editDepartmen{{$data->id}}"><i class="fa fa-edit"></i>
                                                    </a>

                                                    <button class="btn btn-danger btn-sm" onclick="hapus({{ $data->id }})"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('admin.datamaster.departemen.showDepartemen')
                                        @include('admin.datamaster.departemen.editDepartemen')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function hapus(id) {
            swal.fire({
                title: "Apakah anda yakin ?",
                text: "Data yang sudah terhapus tidak dapat dikembalikan kembali.",
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
                    location.href = '<?= 'http://localhost:8000/departemen/delete' ?>' + id;
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
