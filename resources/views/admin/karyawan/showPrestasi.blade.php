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
                                                            <label class="text-white m-b-10">E. RIWAYAT PRESTASI</label>
                                                        </div>
                                                    </div>

                                                    {{-- RIWAYAT PEKERJAAN --}}
                                                    <a class="btn btn-sm btn-success pull-right" data-toggle="modal"
                                                        data-target="#addPrestasi"
                                                        style="margin-right:10px;margin-bottom:10px">
                                                        <i class="fa fa-plus"> <strong> Add Data Prestasi</strong></i>
                                                    </a>
                                                    @include('admin.karyawan.addPrestasi')
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Perihal / Keterangan</th>
                                                                <th>Instansi Pemberi</th>
                                                                <th>Alamat</th>
                                                                <th>No. Surat</th>
                                                                <th>Tanggal Surat</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($prestasi as $pres)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $pres->keterangan }}</td>
                                                                    <td>{{ $pres->nama_instansi }}</td>
                                                                    <td>{{ $pres->alamat }}</td>
                                                                    <td>{{ $pres->no_surat }}</td>
                                                                    <td>{{ $pres->tanggal_surat }}</td>
                                                                    <td class="">
                                                                        <a class="btn btn-sm btn-primary pull-right"
                                                                            data-toggle="modal"
                                                                            data-target="#editPrestasi{{ $pres->id }}"
                                                                            style="margin-right:10px">
                                                                            <i class="fa fa-edit"></i>
                                                                        </a>
                                                                        {{-- <button onclick="pekerjaan({{$$rpekerjaan->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                                                                    </td>
                                                                </tr>
                                                                @include('admin.karyawan.editPrestasi')
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                 <a href="showorganisasi{{ $karyawan->id }}" class="btn btn-sm btn-info"
                                                    type="button">Sebelumnya <i class="fa fa-backward"></i></a>
                                                <a href="showkeluarga{{ $karyawan->id }}" class="btn btn-sm btn-success"
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
@endsection
