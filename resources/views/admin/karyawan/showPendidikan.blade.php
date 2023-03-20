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
                                                            <label class="text-white m-b-10">B. RIWAYAT PENDIDIKAN</label>
                                                        </div>
                                                    </div>

                                                    <table id="datatable-responsive6"
                                                        class="table dt-responsive nowrap table-striped table-bordered"
                                                        cellpadding="0" width="100%">
                                                        <span class=""><strong>1. PENDIDIKAN FORMAL</strong></span>
                                                         <a class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#addPformal" style="margin-right:10px;margin-bottom:10px">
                                                            <i class="fa fa-plus"> <strong> Add Pendidikan Formal</strong></i>
                                                        </a>
                                                        @include('admin.karyawan.addPformal')
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Tingkat Pendidikan</th>
                                                                <th>Nama Sekolah</th>
                                                                <th>Alamat</th>
                                                                <th>Jurusan</th>
                                                                <th>Tahun Lulus</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($pendidikan as $key => $pend)
                                                            @if($pend['tingkat'] != null)
                                                                <tr>
                                                                    <td>{{ $no++ }}</td>
                                                                    <td>{{ $pend->tingkat ?? '-' }}</td>
                                                                    <td>{{ $pend->nama_sekolah ?? '-' }}</td>
                                                                    <td>{{ $pend->kota_pformal ?? '-' }}</td>
                                                                    <td>{{ $pend->jurusan ?? '-' }}</td>
                                                                    <td>{{ $pend->tahun_lulus_formal ?? '-' }}</td>
                                                                    <td>{{ $pend->tahun_lulus_formal ?? '-' }}</td>
                                                                </tr>
                                                            @endif
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    <table id="datatable-responsive6"
                                                        class="table dt-responsive nowrap table-striped table-bordered"
                                                        cellpadding="0" width="100%">
                                                        <span class=""><strong>2. PENDIDIKAN NON FORMAL</strong></span>
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
                                                            @if($pen['jenis_pendidikan'] != null)
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
                                                    </table>


                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                 <a href="showidentitas{{ $karyawan->id }}" class="btn btn-sm btn-info"
                                                    type="button">Sebelumnya <i class="fa fa-backward"></i></a>
                                                <a href="showpekerjaan{{ $karyawan->id }}" class="btn btn-sm btn-success"
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
