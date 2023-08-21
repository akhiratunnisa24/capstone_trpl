@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title ">Informasi Gaji</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Informasi Gaji</li>
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
                                <form action="/storeupload" method="POST" enctype="multipart/form-data"
                                    onsubmit="myFunction()">
                                    @csrf
                                    @method('post')
                                    <div class="control-group after-add-more">

                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div>
                                                            <div
                                                                class="modal-header bg-info panel-heading  col-sm-15 m-b-5">

                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-6 m-t-10">
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <label class="form-label col-sm-5 text-end">Nama</label>
                                                                <div class="col-sm-7">
                                                                    : {{ $karyawan->nama }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 m-t-10">
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <label
                                                                    class="form-label col-sm-5 text-end">Departemen</label>
                                                                <div class="col-sm-7">
                                                                    : {{ $karyawan->departemen->nama_departemen }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 m-t-10">
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <label class="form-label col-sm-5 text-end">Tanggal
                                                                    Masuk</label>
                                                                <div class="col-sm-7">
                                                                    :  {{ \Carbon\carbon::parse($karyawan->tglmasuk)->format('d/m/Y') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 m-t-10">
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <label class="form-label col-sm-5 text-end">Jabatan</label>
                                                                <div class="col-sm-7">
                                                                    : {{ $karyawan->jabatan }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 m-t-10">
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <label class="form-label col-sm-5 text-end">Tanggal
                                                                    Keluar</label>
                                                                <div class="col-sm-7">
                                                                    @if ($karyawan->tglkeluar)
                                                                        :
                                                                        {{ \Carbon\carbon::parse($karyawan->tglkeluar)->format('d/m/Y') }}
                                                                    @else
                                                                        : -
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 m-t-10">
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <label class="form-label col-sm-5 text-end">Tipe
                                                                    Kontrak</label>
                                                                <div class="col-sm-7">
                                                                    : Kontrak / Pekerja Tetap
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6 m-t-10">
                                                        <div class="mb-3">
                                                            <div class="row">
                                                                <label class="form-label col-sm-5 text-end">Struktur
                                                                    Gaji</label>
                                                                <div class="col-sm-7">
                                                                    : Bulanan/Mingguan/Harian
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            {{-- <a href="editfile{{ $karyawan->id }}" class="btn btn-sm btn-primary" type="button">Edit Data <i class="fa fa-edit"></i></a> --}}
                                            {{-- @if (!isset($file))
                                                <a href="/karyawanupload{{ $karyawan->id }}" class="btn btn-sm btn-success">
                                                    Upload Data <i class="fa fa-upload"></i> </a>
                                            @elseif (isset($file))
                                                <a href="editfile{{ $karyawan->id }}" class="btn btn-sm btn-primary"
                                                    type="button">Edit Data <i class="fa fa-edit"></i></a>
                                            @endif --}}
                                            {{-- @if (!empty($file->surat_pengangkatan_kartap)) --}}
                                            {{-- <a href="editfile{{ $karyawan->id }}" class="btn btn-sm btn-primary" type="button" <?php echo $file === null ? 'disabled' : ''; ?>>Edit Data <i class="fa fa-edit"></i></a> --}}
                                            <a href="karyawan" class="btn btn-sm btn-danger" type="button">Kembali <i
                                                    class="fa fa-home"></i></a>
                                        </div>

                                        </table>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
