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
    <div class="panel panel-primary">
        <div class=" col-sm-0 m-b-0">
        </div>
        <form action="/karyawan/store_page" method="POST" enctype="multipart/form-data">
            <div class="control-group after-add-more">
                @csrf
                @method('post')
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <div class="modal-header bg-info panel-heading  col-sm-15 m-b-2 ">
                            <label class="  ">
                                <h4>A. IDENTITAS </h4>
                            </label>
                        </div><br>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">


                                    <div class="form-group">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Nama
                                                Lengkap</label>
                                            <input type="text" name="namaKaryawan" class="form-control"
                                                placeholder="Masukkan Nama" autocomplete="off" required>
                                            <div id="emailHelp" class="form-text"></div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Tanggal
                                                Lahir</label>
                                            <div class="input-group">
                                                <input id="datepicker-autoclose15" type="text"
                                                    class="form-control" placeholder="yyyy/mm/dd" id="4"
                                                    name="tgllahirKaryawan" autocomplete="off" rows="10" required></input><br>
                                                <span class="input-group-addon bg-custom b-0"><i
                                                        class="mdi mdi-calendar text-white"></i></span>
                                            </div><!-- input-group -->
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                        <select class="form-control selectpicker" name="jenis_kelaminKaryawan" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L">Laki-Laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="form-label">Departemen</label>
                                        <select class="form-control selectpicker" name="divisi" data-live-search="true" required>
                                            <option value="">Pilih Departemen</option>
                                            @foreach ($departemen as $d)
                                                <option value="{{ $d->id }}">{{ $d->nama_departemen }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="form-label">Atasan Langsung (SPV/Manager/Direktur)</label>
                                        <select class="form-control selectpicker" name="atasan_pertama" data-live-search="true">
                                            <option value="">Pilih Atasan Langsung</option>
                                            @foreach ($atasan_pertama as $atasan)
                                                <option value="{{ $atasan->id }}">{{ $atasan->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="form-label">Atasan (Manager/Direktur)</label>
                                        <select class="form-control selectpicker" name="atasan_kedua"  data-live-search="true">
                                            <option value="">Pilih Atasan</option>
                                            @foreach ($atasan_kedua as $atasan)
                                                <option value="{{ $atasan->atasan }}">{{ $atasan->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1" class="form-label">Jabatan</label>
                                        <select class="form-control selectpicker" name="jabatanKaryawan" required>
                                            <option value="">Pilih Jabatan</option>
                                            <option value="Management">Management</option>
                                            <option value="Manager">Manager</option>
                                            <option value="Supervisor">Supervisor</option>
                                            <option value="Staff">Staff</option>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                            <textarea class="form-control" autocomplete="off" name="alamatKaryawan" rows="5"></textarea><br>
                                        </div>
                                    </div>


                                </div>

                                <!-- baris sebelah kanan  -->

                                <div class="col-md-6">
                                    <div class="form-group">


                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">No.
                                                    Handphone</label>
                                                <input type="number" name="no_hpKaryawan" class="form-control"
                                                    placeholder="Masukkan Nomor Handphone" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Alamat
                                                    E-mail</label>
                                                <input type="email" name="emailKaryawan" no_kk
                                                    class="form-control" id="exampleInputEmail1" autocomplete="off"
                                                    aria-describedby="emailHelp" placeholder="Masukkan Email" autocomplete="off"
                                                    required>
                                                <div id="emailHelp" class="form-text"></div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1"
                                                    class="form-label">Agama</label>
                                                <select class="form-control selectpicker" name="agamaKaryawan" required>
                                                    <option value="">Pilih Agama</option>
                                                    <option value="Islam">Islam</option>
                                                    <option value="Kristen">Kristen</option>
                                                    <option value="Katholik">Katholik</option>
                                                    <option value="Hindu">Hindu</option>
                                                    <option value="Budha">Budha</option>
                                                    <option value="Khong Hu Chu">Khong Hu Chu</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">Tanggal
                                                    Masuk</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control"
                                                        placeholder="yyyy/mm/dd" id="datepicker-autoclose2"
                                                        name="tglmasukKaryawan" rows="10" autocomplete="off"
                                                        required></input><br>
                                                    <span class="input-group-addon bg-custom b-0"><i
                                                            class="mdi mdi-calendar text-white"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="mb-3">
                                                <label for="exampleInputEmail1" class="form-label">NIK</label>
                                                <input type="number" name="nikKaryawan" class="form-control"
                                                    placeholder="Masukkan NIK" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="form-label">Golongan
                                                Darah</label>
                                            <select class="form-control selectpicker" name="gol_darahKaryawan" required>
                                                <option value="">Pilih Golongan Darah</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="AB">AB</option>
                                                <option value="O">O</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="exampleInputEmail1" class="form-label col-sm-4">Pilih
                                                Foto Karyawan</label>
                                            <img class="img-preview img-fluid mb-3 col-sm-4">
                                            <input type="file" name="foto" class="form-control"
                                                id="foto" onchange="previewImage()">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">

                        <button type="submit" name="submit" class="btn btn-sm btn-primary">Simpan</button>
                         <a href="karyawan" class="btn btn-sm btn-danger">Selanjutnya</a>
                        </div>

                    </table>
                </div>
            </div>
        </form>
    </div>
@endsection
