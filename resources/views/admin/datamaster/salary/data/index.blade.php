@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Salary</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Salary</li>
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
                                data-target="#Modal"> Tambah Data Salary</a>
                        </div>

                        <div class="panel-body">
                            <table id="datatable-responsive44"
                                class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0"
                                width="100%">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Kode</th>
                                        <th>Kategori</th>
                                        @if ($role == 5)
                                            <th>Partner</th>
                                        @endif
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($benefit as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->nama_benefit }}</td>
                                            <td>{{ $data->kode }}</td>
                                            <td>{{ $data->kategoribenefits->nama_kategori }}</td>
                                            @if ($role == 5)
                                                <td>{{ $data->partner }}</td>
                                            @endif
                                            <td class="text-center">
                                                <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                    @if ($data->partner !== 0)
                                                        <a class="btn btn-success btn-sm editDepartmen" data-toggle="modal"
                                                            data-target="#edit{{ $data->id }}"><i
                                                                class="fa fa-edit"></i>
                                                        </a>
                                                    @endif

                                                    @if ($role == 5)
                                                        <button class="btn btn-danger btn-sm"
                                                            onclick="hapus({{ $data->id }})"><i
                                                                class="fa fa-trash"></i></button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @include('admin.datamaster.salary.data.edit')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @include('admin.datamaster.salary.data.add')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <!-- jangan lupa menambahkan script js sweet alert di bawah ini  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

    @if (Session::has('pesan'))
        <script>
            swal("Selamat", "{{ Session::get('pesan') }}", 'success', {
                button: true,
                button: "OK",
            });
        </script>
    @endif

    @if (Session::has('pesa'))
        <script>
            swal("Mohon Maaf", "{{ Session::get('pesa') }}", 'error', {
                button: true,
                button: "OK",
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
                        title: "Mohon Menunggu",
                        text: "Data Benefit sedang diperiksa.",
                        icon: "info",
                        confirmButtonColor: '#3085d6',
                    })
                    location.href = '<?= '/benefit/delete' ?>' + id;
                }
            })
        }
    </script>
@endsection
