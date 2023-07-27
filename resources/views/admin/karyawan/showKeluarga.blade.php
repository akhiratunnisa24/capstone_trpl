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
                    <li>Human Resources Management System</li>
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
                                                            <label class="text-white m-b-10">F. DATA KELUARGA</label>
                                                        </div>
                                                    </div>
                                                    
                                                    <a class="btn btn-sm btn-success pull-right" data-toggle="modal"
                                                        data-target="#addKeluarga"
                                                        style="margin-right:10px;margin-bottom:10px">
                                                        <i class="fa fa-plus"> <strong> Add Data Keluarga</strong></i>
                                                    </a>
                                                    @include('admin.karyawan.addKeluarga')
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Hubungan</th>
                                                                <th>Nama</th>
                                                                <th>Jenis Kelamin</th>
                                                                <th>Tanggal Lahir</th>
                                                                <th>Kota Kelahiran</th>
                                                                <th>Pendidikan Terakhir</th>
                                                                <th>Pekerjaan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($keluarga as $kel)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $kel->hubungan }}</td>
                                                                    <td>{{ $kel->nama }}</td>
                                                                    <td>{{ $kel->jenis_kelamin }}</td>
                                                                    {{-- <td>{{ \Carbon\carbon::parse($kel->tgllahir)->format('d/m/Y') }}</td> --}}
                                                                    <td>{{ $kel->tgllahir ? \Carbon\Carbon::createFromFormat('Y-m-d', $kel->tgllahir)->format('d/m/Y') : '' }}</td>
                                                                    <td>{{ $kel->tempatlahir }}</td>
                                                                    <td>{{ $kel->pendidikan_terakhir }}</td>
                                                                    <td>{{ $kel->pekerjaan }}</td>
                                                                    <td class="">
                                                                        <a class="btn btn-sm btn-primary"
                                                                            data-toggle="modal"
                                                                            data-target="#editKeluarga{{ $kel->id }}"
                                                                            style="margin-right:10px">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                        <button onclick="hapus_karyawan({{ $kel->id }})"  class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                                    </td>
                                                                </tr>
                                                                @include('admin.karyawan.editKeluarga')
                                                            @endforeach
                                                        </tbody>
                                                    </table>


                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                 <a href="showprestasi{{ $karyawan->id }}" class="btn btn-sm btn-info"
                                                    type="button">Sebelumnya <i class="fa fa-backward"></i></a>
                                                <a href="showkontakdarurat{{ $karyawan->id }}" class="btn btn-sm btn-success"
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
                    location.href = '<?= '/destroyKeluarga' ?>' + id;
                }
            })
        }
    </script>
@endsection
