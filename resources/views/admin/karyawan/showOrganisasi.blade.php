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
                                                            <label class="text-white m-b-10">D. RIWAYAT ORGANISASI</label>
                                                        </div>
                                                    </div>

                                                    <table id="datatable-responsive6"
                                                        class="table dt-responsive nowrap table-striped table-bordered"
                                                        cellpadding="0" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama Organisasi</th>
                                                                <th>Alamat</th>
                                                                <th>Tahun Mulai</th>
                                                                <th>Tahun Selesai</th>
                                                                <th>Jabatan</th>
                                                                <th>Nomor SK</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            @foreach ($organisasi as $key => $org)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $org->nama_organisasi ?? '-' }}</td>
                                                                    <td>{{ $org->alamat ?? '-' }}</td>
                                                                    <td>{{ $org->tgl_mulai ?? '-' }}</td>
                                                                    <td>{{ $org->tgl_selesai ?? '-' }}</td>
                                                                    <td>{{ $org->jabatan ?? '-' }}</td>
                                                                    <td>{{ $org->no_sk ?? '-' }}</td>
                                                                    <td>{{ $org->asda ?? '-' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>

                                                    
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                 <a href="showpekerjaan{{ $karyawan->id }}" class="btn btn-sm btn-info"
                                                    type="button">Sebelumnya <i class="fa fa-backward"></i></a>
                                                <a href="showprestasi{{ $karyawan->id }}" class="btn btn-sm btn-success"
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
