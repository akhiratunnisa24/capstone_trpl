@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Master Shift</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Master Shift</li>
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
                                data-target="#AddShift"> Tambah Data Shift</a>
                        </div>
                        @include('admin.datamaster.shift.addShift')
                        <div class="panel-body">
                            <table id="datatable-responsive15" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Shift</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Pulang</th>
                                        @if($role == 5)
                                         <th>Partner</th>
                                        @endif
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($shift as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->nama_shift }}</td>
                                            <td>{{ $data->jam_masuk }}</td>
                                            <td>{{ $data->jam_pulang}}</td>
                                            @if($role == 5)
                                                <td>{{ $data->partner}}</td>
                                            @endif
                                            <td class="text-center">
                                                <div class="d-grid gap-2 " role="group" aria-label="Basic example">

                                                    <a class="btn btn-success btn-sm" data-toggle="modal" 
                                                       data-target="#editShift{{$data->id}}"><i class="fa fa-edit"></i>
                                                    </a>

                                                    <button class="btn btn-danger btn-sm" onclick="hapusshift({{ $data->id }})"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        @include('admin.datamaster.shift.editShift')
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
        function hapusshift(id) {
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
                    location.href = '<?= '/shift/delete/' ?>' + id;
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
