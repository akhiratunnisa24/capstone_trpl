@extends('layouts.default')
@section('content')

    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
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
            <div class="panel panel-secondary" id="showDataKeluarga">
                <div class="panel-heading"></div>
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20">
                                <div class="control-group after-add-more">

                                    <div class="modal-body">
                                        <table class="table table-bordered table-striped">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div>
                                                        <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                            <label class="text-white m-b-10">C. RIWAYAT PEKERJAAN</label>
                                                        </div>
                                                    </div>

                                                    {{-- RIWAYAT PEKERJAAN --}}
                                                    <a class="btn btn-sm btn-success pull-right" data-toggle="modal"
                                                        data-target="#addPekerjaan"
                                                        style="margin-right:10px;margin-bottom:10px">
                                                        <i class="fa fa-plus"> <strong> Tambah Data Pekerjaan</strong></i>
                                                    </a>
                                                    @include('admin.karyawan.addPekerjaan')
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Perusahaan</th>
                                                                <th>Alamat</th>
                                                                <th>Tanggal Masuk</th>
                                                                <th>Tanggal Keluar</th>
                                                                <th>Jabatan</th>
                                                                <th>Level</th>
                                                                <th>Gaji</th>
                                                                <th>Alasan Berhenti</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($pekerjaan as $rpekerjaan)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $rpekerjaan->nama_perusahaan }}</td>
                                                                    <td>{{ $rpekerjaan->alamat }}</td>
                                                                    {{-- <td>{{ $rpekerjaan->tgl_mulai }}</td>
                                                                    <td>{{ $rpekerjaan->tgl_selesai }}</td> --}}
                                                                    <td>{{ $rpekerjaan->tgl_mulai ? \Carbon\Carbon::createFromFormat('Y-m-d', $rpekerjaan->tgl_mulai)->format('d/m/Y') : '' }}
                                                                    </td>
                                                                    <td>{{ $rpekerjaan->tgl_selesai ? \Carbon\Carbon::createFromFormat('Y-m-d', $rpekerjaan->tgl_selesai)->format('d/m/Y') : '' }}
                                                                    </td>
                                                                    <td>{{ $rpekerjaan->jabatan }}</td>
                                                                    <td>{{ $rpekerjaan->level }}</td>
                                                                    <td>Rp. {{ $rpekerjaan->gaji }},-</td>
                                                                    <td>{{ $rpekerjaan->alasan_berhenti }}</td>
                                                                    <td class="">
                                                                        <a class="btn btn-sm btn-primary"
                                                                            data-toggle="modal"
                                                                            data-target="#editPekerjaan{{ $rpekerjaan->id }}"
                                                                            style="margin-right:10px">
                                                                            <i class="fa fa-edit" title="Edit"></i>
                                                                        </a>
                                                                        <button
                                                                            onclick="hapus_karyawan({{ $rpekerjaan->id }})"
                                                                            class="btn btn-danger btn-sm"><i
                                                                                class="fa fa-trash"
                                                                                title="Hapus"></i></button>
                                                                    </td>
                                                                </tr>
                                                                @include('admin.karyawan.editPekerjaan')
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    {{-- </div> --}}
                                                </div>

                                                {{-- <table id="datatable-responsive6"
                                                        class="table dt-responsive nowrap table-striped table-bordered"
                                                        cellpadding="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Perusahaan</th>
                                                                <th>Alamat</th>
                                                                <th>Tahun Mulai</th>
                                                                <th>Tahun Selesai</th>
                                                                <th>Jabatan</th>
                                                                <th>Level</th>
                                                                <th>Gaji</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($pekerjaan as $key => $pek)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $pek->nama_perusahaan ?? '-' }}</td>
                                                                    <td>{{ $pek->alamat ?? '-' }}</td>
                                                                    <td>{{ $pek->tgl_mulai ?? '-' }}</td>
                                                                    <td>{{ $pek->tgl_selesai ?? '-' }}</td>
                                                                    <td>{{ $pek->jabatan ?? '-' }}</td>
                                                                    <td>{{ $pek->level ?? '-' }}</td>
                                                                    <td>{{ $pek->gaji ?? '-' }}</td>
                                                                    <td>{{ $pek->asda ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table> --}}


                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="showpendidikan{{ $karyawan->id }}" class="btn btn-sm btn-info"
                                            type="button">Sebelumnya <i class="fa fa-backward"></i></a>
                                        <a href="showorganisasi{{ $karyawan->id }}" class="btn btn-sm btn-success"
                                            type="button">Selanjutnya <i class="fa fa-forward"></i></a>
                                    </div>
                                </div>
                            </div>
                            {{-- </form> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

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
                    location.href = '<?= '/destroyPekerjaan' ?>' + id;
                }
            })
        }
    </script>
@endsection
