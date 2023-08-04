@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Master User Mesin</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Master User Mesin</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Close Header -->
    @if ($errorMessage)
        <div class="alert alert-danger">
            {{ $errorMessage }}
        </div>
    @endif
    <!-- Start content -->
    <?php session_start(); ?>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading  clearfix">
                            <a href="" class="btn btn-sm btn-dark fa fa-plus pull-right" data-toggle="modal"
                                data-target="#AddModal"> Tambah Data User Mesin</a>
                        </div>
                        @include('admin.datamaster.user_mesin.addUserMesin')
                        <div class="panel-body">
                            <table id="datatable-responsive13" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama User Mesin</th>
                                        <th>NIK</th>
                                        <th>Departemen</th>
                                        <th>Nomor ID</th>
                                        <th>Nomor ID 2</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($userMesins as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->karyawan->nama }}</td>
                                            <td>{{ $data->nik }}</td>
                                            <td>{{ $data->karyawan->departemen->nama_departemen }}</td>
                                            <td>{{ $data->noid }}</td>
                                            <td>{{ $data->noid2 }}</td>
                                            <td class="text-center">
                                                <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                @if (in_array(auth()->user()->role, [1, 5]))
                                                    <a class="btn btn-success btn-sm editUserMesin" data-toggle="modal" 
                                                           data-target="#editUserMesin{{$data->id}}"><i class="fa fa-edit"></i></a>
                                                        <button class="btn btn-danger btn-sm" onclick="hapus('{{ $data->id}}')"><i class="fa fa-trash"></i></button>
                                                    @else
                                                    <a class="btn btn-success btn-sm editUserMesin" data-toggle="modal" 
                                                           data-target="#editUserMesin{{$data->id}}"><i class="fa fa-edit"></i></a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @include('admin.datamaster.user_mesin.editUserMesin')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rest of the JavaScript code remains the same -->

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
                        title: "Mohon Menunggu",
                        text: "Data Jabatan sedang diperiksa",
                        icon: "info",
                        confirmButtonColor: '#3085d6',
                    })
                    location.href = '<?= '/user_mesin/delete/' ?>' + id;
                }
            })
        }
    </script>
   <script>
        $(document).ready(function () {
            // Ketika dropdown "Nama Karyawan" dipilih, isi field "NIK", "Departemen", dan "Partner" sesuai data karyawan terpilih
            $('#id_pegawai').change(function () {
                var selectedKaryawanId = $(this).val();
                if (selectedKaryawanId) {
                    $.ajax({
                        url: '/get_karyawan_info/' + selectedKaryawanId, // Ganti URL ini sesuai dengan route yang digunakan untuk mengambil informasi karyawan
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            if (data) {
                                $('#nik').val(data.nik);
                                $('#departemen').val(data.departemen);
                                $('#partner').val(data.partner);
                            }
                        }
                    });
                } else {
                    $('#nik').val('');
                    $('#departemen').val('');
                    $('#partner').val('');
                }
            });
        });
    </script>

   <script>
        $(document).ready(function() {
            $('.select2').select2({
                // Opsi tambahan jika diperlukan
                placeholder: 'Cari karyawan...',
                allowClear: true, // Mengaktifkan tombol "clear" untuk menghapus pilihan
                minimumInputLength: 3 // Minimal jumlah karakter yang harus diinput untuk memulai pencarian
            });
        });
    </script>
@endsection
