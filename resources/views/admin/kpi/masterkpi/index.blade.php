@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Data Master KPI</h4>
                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Data Master KPI</li>
                </ol>
                <div class="clearfix"></div>
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
                        <div class="panel-heading clearfix">
                            <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal" data-target="#addJob"> Tambah Master KPI</a>
                            <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal" data-target="#editMaster"> Edit Master</a>
                        </div>
                        @include('admin.kpi.masterkpi.addMaster')
                        {{-- @include('admin.kpi.masterkpi.editMaster') --}}
                        <div class="panel-body">
                            <table id="datatable-responsive13" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Departemen</th>
                                        <th>Nama Master</th>
                                        {{-- <th>Bobot ( % )</th>
                                        <th>Target</th> --}}
                                        <th>Tgl Aktif</th>
                                        <th>Tgl Berakhir</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($master as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->departemens->nama_departemen}}</td>
                                            <td>{{ $data->nama_master}}</td>
                                            {{-- <td>{{ $data->bobot}}</td>
                                            <td>{{ $data->target}}</td> --}}
                                            <td>{{ \Carbon\Carbon::parse($data->tglaktif)->format('d/m/Y')}}</td>
                                            <td>{{ \Carbon\Carbon::parse($data->tglberakhir)->format('d/m/Y')}}</td>
                                            <td class="text-center">
                                                <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                    <a class="btn btn-success btn-sm editJob" data-toggle="modal" data-target="#editMaster{{$data->id}}"><i class="fa fa-edit"></i></a>
                                                    <button class="btn btn-danger btn-sm" onclick="hapus({{ $data->id }})"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('admin.kpi.masterkpi.editMaster')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- sweet alert -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

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
                    });
                    location.href = '<?= '/job/delete' ?>' + id;
                }
            });
        }
    </script>

    <?php if(@$_SESSION['sukses']) { ?>
        <script>
            swal.fire("Good job!", "<?php echo $_SESSION['sukses']; ?>", "success");
        </script>
        <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->
        <?php unset($_SESSION['sukses']); } ?>
@endsection
