@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Master Jabatan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Master Jabatan</li>
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
                                data-target="#AddModal"> Tambah Data Jabatan</a>
                        </div>
                        @include('admin.datamaster.jabatan.addJabatan')
                        <div class="panel-body">
                            <table id="datatable-responsive13" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Level</th>
                                        <th>Nama Jabatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($jabatan as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->level_jabatan }}</td>
                                            <td>{{ $data->nama_jabatan }}</td>
                                            <td class="text-center">
                                                <div class="d-grid gap-2 " role="group" aria-label="Basic example">

                                                    <a class="btn btn-success btn-sm editJabatan" data-toggle="modal" 
                                                       data-target="#editJabatan{{$data->id}}"><i class="fa fa-edit"></i>
                                                    </a>

                                                    <button class="btn btn-danger btn-sm" onclick="hapus({{ $data->id }})"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('admin.datamaster.jabatan.editJabatan')
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

    @if(Session::has('pesan'))
        <script>
            swal("Selamat","{{ Session::get('pesan')}}", 'success', {
                button:true,
                button:"OK",
            });
        </script>
    @endif

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
                    location.href = '<?= 'http://localhost:8000/jabatan/delete' ?>' + id;
                }
            })
        }
    </script>
@endsection
