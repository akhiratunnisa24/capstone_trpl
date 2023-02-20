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
                <h4 class="pull-left page-title ">Tambah Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Tambah Karyawan</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane" id="kontakdarurat">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-20 col-sm-20 col-xs-20">
                        <table id="datatable-responsive7" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Alamat</th>
                                    <th>Hubungan Keluarga</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach($kontakdarurat as $kd)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ $kd->nama}}</td>
                                        <td>{{ $kd->no_hp}}</td>
                                        <td>{{ $kd->alamat}}</td>
                                        <td>{{ $kd->hubungan}}</td>
                                        {{-- <td></td> --}}
                                    {{-- </tr>
                                @endforeach --}} 
                            </tbody>
                        </table><br>
                        <form action="/storekontakdarurat" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('post')
                            <div class="control-group after-add-more">
                                <div class="modal-body">
                                    <table class="table table-bordered table-striped">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-3"></div>
                                                <div class="col-md-6">
                                                    <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5  ">
                                                        <label class="text-white">Kontak Darurat</label>
                                                    </div>
                                                    <div class="form-group m-t-10">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                                            <input type="text" name="namaKdarurat" class="form-control" placeholder="Masukkan Nama" autocomplete="off" required>
                                                            <div id="emailHelp" class="form-text"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group ">
                                                        <div class="mb-3 ">
                                                            <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                                            <input class="form-control" name="alamatKdarurat" rows="9" placeholder="Masukkan Alamat"></input>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">No. Handphone</label>
                                                            <input type="number" name="no_hpKdarurat" class="form-control" id="no_hp" placeholder="Masukkan Nomor Handphone" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">Hubungan</label>
                                                            <select class="form-control selectpicker" name="hubunganKdarurat" required>
                                                                <option value="">Pilih Hubungan</option>
                                                                <option value="Ayah">Ayah</option>
                                                                <option value="Ibu">Ibu</option>
                                                                <option value="Suami">Suami</option>
                                                                <option value="Istri">Istri</option>
                                                                <option value="Kakak">Kakak</option>
                                                                <option value="Adik">Adik</option>
                                                                <option value="Anak">Anak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="pull-right">
                                                        <button type="submit" name="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                        <a href="#riwayatpendidikan" data-toggle="tab" class="btn btn-sm btn-danger">Selanjutnya</a>
                                                    </div>
                                                </div>
                                                <div class="col-md3"></div>
                                            </div>
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
     {{-- <script src="assets/js/jquery.min.js"></script> --}}
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     <script src="assets/pages/form-advanced.js"></script>


@endsection