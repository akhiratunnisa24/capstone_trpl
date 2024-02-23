@extends('layouts.default')
@section('content')
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
    <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
    <style>
        .card {
          border-radius: 20px;
          /* box-shadow: 0 8px 10px rgba(0, 0, 0, 0.1); */
        }

        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #d1d1d1;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1;
            border-radius: 10px;
        }

        .popup-content {
            text-align: left;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }
        .image-container {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .popover.tour {
            max-width: 500px;
            background-color: rgb(96, 96, 211);
        }

        .popover-body {
            /* Gaya lainnya sesuai kebutuhan Anda */
        }

      </style>

    <!-- Header -->
    @if($status == 0)
    <div class="overlay" id="overlay"></div>
    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePopup()">&times;</span>
            <div class="image-container text-center mb-3">
            </div>
            <h4 class="text-center text-danger">
                IMPORTANT!
            </h4>
            <h6 class="mt-5 text-center" style="margin-left: 70px; margin-right: 70px;">Pastikan  Anda sudah <b style="color:#4D96FF">UPDATED</b>
                @if($status == 0) Jabatan Karyawan,@endif
                Sebelum Menyeting Alokasi Cuti untuk Karyawan</h6>

            <p class="mt-5 text-center">
                @if($status == 0)
                    <a href="{{url('karyawan')}}" class="btn btn-primary btn-md mr-3">UPDATE JABATAN</a>
                @endif
            </p>
        </div>
    </div>

    @endif
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Setting Alokasi Cuti Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
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
                                <a href="" class="btn btn-dark fa fa-plus pull-right" data-toggle="modal"
                                    data-target="#newsetting"> Tambah
                                    Setting</a>
                            </div>
                            <div class="panel-body m-b-5">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <table id="datatable-responsive11"
                                            class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kategori Cuti</th>
                                                    <th>Durasi (Hari)</th>
                                                    <th>Tipe Alokasi Cuti</th>
                                                    <th>Periode</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($settingalokasi as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data->jeniscutis->jenis_cuti }}</td>
                                                        <td>{{ $data->durasi }}</td>
                                                        <td>{{ $data->mode_karyawan }}</td>
                                                        <td>{{ $data->periode }}</td>
                                                        <td>
                                                            @if ($data->status = 1)
                                                                <span class="badge badge-success">Aktif</span>
                                                            @else
                                                                <span class="badge badge-danger">Tidak Aktif</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <a id="bs" class="btn btn-info btn-sm Modalshowsetting"
                                                                data-toggle="modal"
                                                                data-target="#Modalshowsetting{{ $data->id }}">
                                                                <i class="fa fa-eye" title="Lihat Detail"></i>
                                                            </a>
                                                            <a id="bs" class="btn btn-sm btn-success editsetting"
                                                                data-toggle="modal" data-target="#editsetting{{$data->id}}">
                                                                <i class="fa fa-user-plus" title="Tambah Karyawan"></i>
                                                            </a>
                                                            <button onclick="settingalokasi({{ $data->id }})"
                                                                class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash" title="Hapus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    {{-- modals show setting --}}
                                                    @include('admin.settingalokasi.showsetting')
                                                    @include('admin.settingalokasi.editsetting')
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
        </div>
        {{-- form setting --}}
        @include('admin.settingalokasi.formsetting')

        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        {{-- <script src="assets/js/app.js"></script> --}}

        <!-- sweet alert -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

        <script>
            function openPopup() {
                var popup = document.getElementById("popup");
                if (popup) {
                    popup.style.display = "block";
                } else {
                    console.error("Element with ID 'popup' not found.");
                }
            }

            function closePopup() {
                var popup = document.getElementById("popup");
                if (popup) {
                    popup.style.display = "none";
                } else {
                    console.error("Element with ID 'popup' not found.");
                }
            }

            document.addEventListener("DOMContentLoaded", function () {
                openPopup();
            });
        </script>
        @if (Session::has('success'))
            <script>
                swal("Selamat", "{{ Session::get('success') }}", 'success', {
                    button: true,
                    button: "OK",
                });
            </script>
        @endif
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
                        location.href = '<?= '/deletesetting/' ?>' + id;
                        //location.href = '<?= 'http://localhost:8000/deletesetting/' ?>' + id;
                        // location.href = '<?= 'http://dev.rynest-technology.com/deletesetting/' ?>' + id;
                    }
                })
            }
        </script>


        @if (Session::has('success'))
            <script>
                swal("Selamat", "{{ Session::get('success') }}", 'success', {
                    button: true,
                    button: "OK",
                });
            </script>
        @endif

        @if (Session::has('error'))
            <script>
                swal("Mohon Maaf", "{{ Session::get('error') }}", 'error', {
                    button: true,
                    button: "OK",
                });
            </script>
        @endif

        <?php if(@$_SESSION['sukses']){ ?>
        <script>
            swal.fire("Good job!", "<?php echo $_SESSION['sukses']; ?>", "success");
        </script>
        <!-- jangan lupa untuk menambahkan unset agar sweet alert tidak muncul lagi saat di refresh -->

        <?php unset($_SESSION['sukses']); } ?>
    @endsection
