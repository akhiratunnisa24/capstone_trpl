@extends('layouts.default')
@section('content')
   <head>
        {{-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}
        <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
        <link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">

        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number] {
                -moz-appearance: textfield;
            }
        </style>
    </head>
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title ">Detail Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Detail Karyawan</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-secondary">
                <div class="panel-heading"></div>
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20">
                                <div class="control-group after-add-more">


                                    <div class="modal-body">
                                        {{-- <table class="table table-bordered table-striped"> --}}
                                        <div class="col-md-12">
                                            <div class="row">

                                                <div>
                                                    <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                        <label class="text-white m-b-10">B. RIWAYAT PENDIDIKAN</label>
                                                    </div>
                                                </div>

                                                <span class=""><strong> 1. PENDIDIKAN FORMAL</strong></span>

                                                <a class="btn btn-sm btn-success pull-right" data-toggle="modal"
                                                    data-target="#addPformal" style="margin-right:10px;margin-bottom:10px">
                                                    <i class="fa fa-plus"> <strong> Tambah Data</strong></i>
                                                </a>
                                                @include('admin.karyawan.addPformal')
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Tingkat Pendidikan</th>
                                                            <th>Nama Sekolah</th>
                                                            <th>Jurusan</th>
                                                            <th>Tahun Mulai</th>
                                                            <th>Tahun Selesai</th>
                                                            <th>Alamat</th>
                                                            {{-- <th>Tahun Lulus</th> --}}
                                                            <th>Nomor Ijazah</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        @php
                                                            $no = 1;
                                                        @endphp

                                                        @foreach ($pendidikan as $rpendidikan)
                                                            @if ($rpendidikan->tingkat !== null)
                                                                <tr>
                                                                    <td>{{ $no++ }}</td>
                                                                    <td>{{ $rpendidikan->tingkat }}</td>
                                                                    <td>{{ $rpendidikan->nama_sekolah }}</td>
                                                                    <td>{{ $rpendidikan->jurusan }}</td>
                                                                    @if ($rpendidikan->tahun_masuk_formal !== null)
                                                                        <td>{{ $rpendidikan->tahun_masuk_formal }}</td>
                                                                        {{-- <td>{{ \Carbon\Carbon::parse($rpendidikan->tahun_masuk_formal)->format('d/m/Y') }}</td> --}}
                                                                    @else
                                                                        <td></td>
                                                                    @endif
                                                                    @if ($rpendidikan->tahun_lulus_formal !== null)
                                                                        <td>{{ $rpendidikan->tahun_lulus_formal }}</td>
                                                                        {{-- <td>{{ \Carbon\Carbon::parse($rpendidikan->tahun_lulus_formal)->format('d/m/Y') }}</td> --}}
                                                                    @else
                                                                        <td></td>
                                                                    @endif

                                                                    <td>{{ $rpendidikan->kota_pformal }}</td>
                                                                    <td>{{ $rpendidikan->ijazah_formal }}</td>
                                                                    <td class="">
                                                                        <a class="btn btn-sm btn-primary editPformal"
                                                                            data-toggle="modal"
                                                                            data-target="#editPformal{{ $rpendidikan->id }}"
                                                                            style="margin-right:10px">
                                                                            <i class="fa fa-edit" title="Edit"></i>
                                                                        </a>
                                                                        <button
                                                                            onclick="hapus_karyawan({{ $rpendidikan->id }})"
                                                                            class="btn btn-danger btn-sm"><i
                                                                                class="fa fa-trash"
                                                                                title="Hapus"></i></button>
                                                                    </td>
                                                                </tr>
                                                                @include('admin.karyawan.editPformal')
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                <span class=""><strong> 2. PENDIDIKAN NON FORMAL</strong></span>

                                                <a class="btn btn-sm btn-success pull-right" data-toggle="modal"
                                                    data-target="#addPnformal" style="margin-right:10px;margin-bottom:10px">
                                                    <i class="fa fa-plus"> <strong> Tambah Data</strong></i>
                                                </a>

                                                @include('admin.karyawan.addPnformal')
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Bidang/Jenis</th>
                                                            <th>Lembaga Pendidikan</th>
                                                            <th>Tahun Mulai</th>
                                                            <th>Tahun Selesai</th>
                                                            <th>Alamat</th>
                                                            <th>Nomor Ijazah</th>
                                                            <th>Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $nom = 1;
                                                        @endphp
                                                        @foreach ($nonformal as $rpendidikan)
                                                            <tr>
                                                                <td>{{ $nom++ }}</td>
                                                                <td>{{ $rpendidikan->jenis_pendidikan }}</td>
                                                                <td>{{ $rpendidikan->nama_lembaga }}</td>
                                                                @if ($rpendidikan->tahun_masuk_nonformal !== null)
                                                                    <td>{{ $rpendidikan->tahun_masuk_nonformal }}
                                                                    </td>
                                                                @else
                                                                    <td></td>
                                                                @endif

                                                                @if ($rpendidikan->tahun_lulus_nonformal !== null)
                                                                {{-- <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $rpendidikan->tahun_lulus_nonformal)->format('d/m/Y') }}</td> --}}
                                                                   <td>{{$rpendidikan->tahun_lulus_nonformal }}</td>
                                                                @else
                                                                    <td></td>
                                                                @endif

                                                                <td>{{ $rpendidikan->kota_pnonformal }}</td>
                                                                <td>{{ $rpendidikan->ijazah_nonformal }}</td>
                                                                <td class="">
                                                                    <a class="btn btn-sm btn-primary editPnformal"
                                                                        data-toggle="modal"
                                                                        data-target="#editPnformal{{ $rpendidikan->id }}"
                                                                        style="margin-right:10px">
                                                                        <i class="fa fa-edit" title="Edit"></i>
                                                                    </a>
                                                                    <button
                                                                        onclick="hapus_karyawans({{ $rpendidikan->id }})"
                                                                        class="btn btn-danger btn-sm"><i class="fa fa-trash"
                                                                            title="Hapus"></i></button>
                                                                </td>
                                                            </tr>
                                                            @include('admin.karyawan.editPnformal')
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                                {{-- <table id="datatable-responsive6"
                                                        class="table dt-responsive nowrap table-striped table-bordered"
                                                        cellpadding="0" width="100%">
                                                        <span class=""><strong>2. PENDIDIKAN NON
                                                                FORMAL</strong></span>
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Bidang/Jenis</th>
                                                                <th>Alamat</th>
                                                                <th>Tahun Lulus</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($pendidikan as $key => $pen)
                                                                @if ($pen['jenis_pendidikan'] != null)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>

                                                                        <td>{{ $pen->jenis_pendidikan ?? '-' }}</td>
                                                                        <td>{{ $pen->kota_pnonformal ?? '-' }}</td>
                                                                        <td>{{ $pen->tahun_lulus_nonformal ?? '-' }}</td>
                                                                        <td>{{ $pen->tahun_lulus_nonformal ?? '-' }}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table> --}}


                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="showidentitas{{ $karyawan->id }}" class="btn btn-sm btn-info"
                                                type="button">Sebelumnya <i class="fa fa-backward"></i></a>
                                            <a href="showpekerjaan{{ $karyawan->id }}" class="btn btn-sm btn-success"
                                                type="button">Selanjutnya <i class="fa fa-forward"></i></a>
                                        </div>
                                        {{-- </div> --}}
                                    </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

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

        {{-- //delete pendidikan formal --}}
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
                        location.href = '<?= '/destroyPendidikan' ?>' + id;
                    }
                })
            }
        </script>

        {{-- delete pendidikan non formal --}}
        <script>
            function hapus_karyawans(id) {
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
                        location.href = '<?= '/deletePendidikan' ?>' + id;
                    }
                })
            }
        </script>
    @endsection
