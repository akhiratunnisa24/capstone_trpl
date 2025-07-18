@extends('layouts.default')
@section('content')
    <!-- Header -->
    <style>
        .btn-custom {
            width: 35px; /* Sesuaikan ukuran sesuai kebutuhan */
            height: 30px; /* Sesuaikan ukuran sesuai kebutuhan */
        }
    </style>
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Data Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
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
                            {{-- <a href="karyawancreate" type="button" class="btn btn-sm btn-dark fa fa-user-plus "> Tambah
                                Data Karyawan</a> --}}
                            @if(Auth::user()->role !== 6 )
                                <a type="button" class="btn btn-sm btn-dark fa fa-at " data-toggle="modal"
                                    data-target="#myModal"> Buat Akun Karyawan</a>

                                {{-- <a href="/karyawanupload" class="btn btn-sm btn-dark fa fa-upload"> Upload File Digital</a> --}}

                                {{-- <a href="" class="btn btn-sm btn-dark fa fa-cloud-download" data-toggle="modal"
                                    data-target="#Modal2"> Impor Excel</a> --}}
                                {{-- <a href="/exportexcelkaryawan" class="btn btn-sm btn-dark fa fa-cloud-upload "> Export Excel
                                </a> --}}

                                <a href="karyawancreates" type="button" class="btn btn-sm btn-dark fa fa-user-plus pull-right">
                                    Tambah Data Karyawan
                                </a>
                            @else
                                <h2></h2>
                            @endif
                        </div>
                        @include('admin.karyawan.addAkunModal')
                        <div class="panel-body">
                            <form action="{{ route('search') }}" method="GET">
                                <div class="row col-md-12">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-7">
                                        <div>
                                            <label>Nama Karyawan</label>
                                            <input type="text" name="query" class="form-control"
                                                placeholder="Cari karyawan...">
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div style="margin-top:5px">
                                            <label></label>
                                            <div>
                                                <button type="submit" id="search"
                                                    class="btn btn-md btn-success fa fa-search" style="height: 37px;"> Cari
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                            </form>

                            {{-- <div class="container"> --}}
                            @if ($query)
                                <h4 class="text-center" style="margin-top:10px;">Hasil Pencarian untuk "{{ $query }}"
                                </h4>
                                @if ($results->isEmpty())
                                    <p>Tidak ada hasil yang ditemukan.</p>
                                @else
                                    <div class="panel-body" style="padding:1%">
                                        <div class="row" style="margin-top:40px ">
                                            <div class="col-md-12">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr class="info">
                                                            <th>No</th>
                                                            <th>Nama</th>
                                                            <th>Departemen</th>
                                                            <th>Tanggal Lahir</th>
                                                            <th>L / P</th>
                                                            <th>Alamat</th>
                                                            <th>Email</th>
                                                            <th>Agama</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($results as $k)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $k->nama }}</td>
                                                                <td>{{ $k->departemen->nama_departemen ?? '' }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}
                                                                </td>
                                                                <td>{{ $k->jenis_kelamin }}</td>
                                                                <td>{{ $k->alamat }}</td>
                                                                <td>{{ $k->email }}</td>
                                                                <td>{{ $k->agama }}</td>
                                                                <td>
                                                                    <div class="d-grid gap-2 " role="group"
                                                                        aria-label="Basic example">
                                                                        {{-- <a href="karyawanshow{{ $k->id }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a> --}}

                                                                        <a href="showidentitas{{ $k->id }}" class="btn btn-info btn-custom btn-sm" title="Lihat Identitas" target="_blank"><i class="fa fa-eye" style="font-size: 13px;"></i></a>
                                                                        {{-- <a href="showfile{{ $k->id }}" class="btn btn-success btn-custom btn-sm " title="Open Digital File"><i class="fa fa fa-file-photo-o (alias)" style="font-size: 13px;"></i></a>
                                                                        <a href="downloadpdf{{ $k->id }}" class="btn btn-dark btn-custom btn-sm "  title="Download PDF" target="_blank"><i class="fa fa fa-download" style="font-size: 13px;"></i></a>
                                                                        <a href="showinformasigaji{{ $k->id }}" class="btn btn-warning btn-custom btn-sm " title="Informasi Gaji" target="_blank"><i class="mdi mdi-cash-multiple" style="font-size: 15px;"></i></a> --}}
                                                                        {{-- <button  onclick="hapus_karyawan({{ $k->id }})"  class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                                                                    </div>
                                                                    <!-- <button class="btn btn-default waves-effect waves-light" id="sa-success">Click me</button> -->
                                                                </td>

                                                            </tr>
                                                        @endforeach

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @else
                            @endif
                            {{-- </div> --}}


                            {{-- <table id="datatable-responsive6"
                                class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0"
                                width="100%">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Departemen</th>
                                        <th>Tanggal Lahir</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th>Agama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($karyawan as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ $k->departemen->nama_departemen }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->agama }}</td>
                                            <td>
                                                <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                    <a href="karyawanshow{{ $k->id }}"
                                                        class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                    <button onclick="hapus_karyawan({{ $k->id }})"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                                <!-- <button class="btn btn-default waves-effect waves-light" id="sa-success">Click me</button> -->
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Import Data Excel --}}
    <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title text-center" id="myModalLabel">Impor Excel</h4>
                </div>
                <form action="/import_excel" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-lg-5">
                                <input type="file" name="file" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-primary">Import Data</button>
                    </div>
                </form>
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
    <script>
        // Ambil elemen input
        const searchInput = document.querySelector('input[name="query"]');

        // Tambahkan event listener onchange
        searchInput.addEventListener('change', () => {
            // Submit form
            searchInput.closest('form').submit();
        });
    </script>

    <script>
        function hapus_karyawan(id) {
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
                    location.href = '<?= '/karyawan/destroy/' ?>' + id;
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

    @if (Session::has('message'))
        <script>
            swal("Mohon Maaf",<?php echo json_encode( Session::get('message') ) ?>, 'info', {
                button: false,
                button: "OK",
            });
        </script>
    @endif


@endsection
