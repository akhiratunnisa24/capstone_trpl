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
                    <li>Rynest Employees Management System</li>
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
                                                            <label class="text-white m-b-10">G. DATA KONTAK DARURAT</label>
                                                        </div>
                                                    </div>

                                                    <a class="btn btn-sm btn-success pull-right" data-toggle="modal"
                                                        data-target="#addKontak"
                                                        style="margin-right:10px;margin-bottom:10px">
                                                        <i class="fa fa-plus"> <strong> Add Data Kontak Darurat</strong></i>
                                                    </a>
                                                    @include('admin.karyawan.addKontak')
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama </th>
                                                                <th>Hubungan</th>
                                                                <th>No HP</th>
                                                                <th>Alamat</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($kontakdarurat as $kondar)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $kondar->nama }}</td>
                                                                    <td>{{ $kondar->hubungan }}</td>
                                                                    <td>{{ $kondar->no_hp }}</td>
                                                                    <td>{{ $kondar->alamat }}</td>
                                                                    <td class="">
                                                                        <a class="btn btn-sm btn-primary"
                                                                            data-toggle="modal"
                                                                            data-target="#editDarurat{{ $kondar->id }}"
                                                                            style="margin-right:10px">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                        <button onclick="hapus_karyawan({{ $kondar->id }})"  class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                                    </td>
                                                                </tr>
                                                                @include('admin.karyawan.editKontakdarurat')
                                                            @endforeach
                                                        </tbody>
                                                    </table>


                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                 <a href="showkeluarga{{ $karyawan->id }}" class="btn btn-sm btn-info"
                                                    type="button">Sebelumnya <i class="fa fa-backward"></i></a>
                                                <a href="karyawan" class="btn btn-sm btn-danger"
                                                    type="button">Kembali <i class="fa fa-home"></i></a>
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
                    location.href = '<?= '/destroyKonrat' ?>' + id;
                }
            })
        }
    </script>
@endsection
