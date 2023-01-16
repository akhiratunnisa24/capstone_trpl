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
<!-- Close Header -->





<div class="panel panel-primary">
    <div class=" col-sm-0 m-b-0">

    </div>

    <form action="/karyawan/store_page" method="POST" enctype="multipart/form-data">
        <div class="control-group after-add-more">

            @csrf
            @method('post')

            <div class="modal-body">
                <table class="table table-bordered table-striped">
                        <div class="row">
                            <div class="col-md-12">

                            <!-- judul 1 -->
                            <div class="modal-header bg-info panel-heading  col-sm-15 m-b-2 ">
                                <label class="  "><h4>A. IDENTITAS </h4></label>
                            </div>
                            <table class="table table-bordered table-striped">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">


                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label for="exampleInputEmail1" class="form-label">Nama
                                                        Lengkap</label>
                                                    <input type="text" name="namaKaryawan" class="form-control"
                                                        placeholder="Masukkan Nama" required>
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
                                                            name="tgllahirKaryawan" rows="10" required></input><br>
                                                        <span class="input-group-addon bg-custom b-0"><i
                                                                class="mdi mdi-calendar text-white"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                                <select class="form-control" name="jenis_kelaminKaryawan" required>
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="L">Laki-Laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Departemen</label>
                                                <select class="form-control" name="divisi" required>
                                                    <option value="">Pilih Departemen</option>
                                                    @foreach ($departemen as $d)
                                                    <option value="{{ $d->id }}">{{ $d->nama_departemen }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Nama Manager</label>
                                                <select class="form-control" name="manager" >
                                                    <option value="">Pilih Manager</option>
                                                    <option value="Manager1">manager1</option>
                                                    <option value="manager2">manager2</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Jabatan</label>
                                                <select class="form-control" name="jabatanKaryawan" required>
                                                    <option value="">Pilih Jabatan</option>
                                                    <option value="Manager">Manager</option>
                                                    <option value="Staff">Staff</option>
                                                </select>
                                            </div>
                                            

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                                    <textarea class="form-control" name="alamatKaryawan"
                                                        rows="5"></textarea><br>
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
                                                            class="form-control" id="exampleInputEmail1"
                                                            aria-describedby="emailHelp" placeholder="Masukkan Email"
                                                            required>
                                                        <div id="emailHelp" class="form-text"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">Agama</label>
                                                        <input type="text" name="agamaKaryawan" class="form-control"
                                                            placeholder="Masukkan Agama" required>
                                                        <div class="form-text"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">Tanggal
                                                            Masuk</label>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control"
                                                                placeholder="yyyy/mm/dd" id="datepicker-autoclose2"
                                                                name="tglmasukKaryawan" rows="10" required></input><br>
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
                                                    <select class="form-control" name="gol_darahKaryawan" required>
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
                                                    <input type="file" name="foto" class="form-control" id="foto"
                                                        onchange="previewImage()">
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- judul 2  -->
                                    <div class="modal-header bg-info panel-heading  col-sm-15 m-b-2 ">
                                        <label class="  "><h4>B. KELUARGA </h4></label>
                                    </div>
                                    <table class="table table-bordered table-striped">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">

                                                    <!-- sub judul 2 -->
                                                    <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5 ">
                                                        <label class="  ">Data Keluarga</label>
                                                    </div>


                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="form-label">Status
                                                            Pernikahan</label>
                                                        <select class="form-control" name="status_pernikahan" required>
                                                            <option value="">Pilih Status Pernikahan</option>
                                                            <option value="Sudah">Sudah Menikah</option>
                                                            <option value="Belum">Belum Menikah</option>
                                                        </select>
                                                    </div>

                                                    <!-- <div class="form-group">
                                                <label for="exampleInputEmail1" class="form-label">Hubungan Keluarga</label>
                                                <select class="form-control" name="status_pernikahan" required>
                                                    <option value="">Pilih Hubungan Keluarga</option>
                                                    <option value="Sudah">Orang Tua</option>
                                                    <option value="Belum">Istri</option>
                                                    <option value="Belum">Saudara Kandung</option>
                                                    <option value="Belum">Anak</option>
                                                </select>
                                            </div> -->

                                                    <!-- sub judul 2 -->
                                                    <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5 ">
                                                        <label class="  ">Data Istri / Suami *) </label>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">Nama
                                                                Lengkap</label>
                                                            <input type="text" name="namaPasangan" class="form-control"
                                                                placeholder="Masukkan Nama">
                                                            <div id="emailHelp" class="form-text"></div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">Tanggal
                                                                Lahir</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control"
                                                                    placeholder="yyyy/mm/dd" id="datepicker-autoclose8"
                                                                    name="tgllahirPasangan" rows="10"
                                                                    ></input><br>
                                                                <span class="input-group-addon bg-custom b-0"><i
                                                                        class="mdi mdi-calendar text-white"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1"
                                                                class="form-label">Alamat</label>
                                                            <input class="form-control" name="alamatPasangan" rows="9"
                                                                placeholder="Masukkan Alamat"></input>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="form-label">Pendidikan
                                                            Terakhir</label>
                                                        <select class="form-control" name="pendidikan_terakhirPasangan"
                                                            >
                                                            <option value="">Pilih Pendidikan Terakhir</option>
                                                            <option value="SD">SD</option>
                                                            <option value="SMP">SMP</option>
                                                            <option value="SMA/K">SMA/K</option>
                                                            <option value="D-3">D-3</option>
                                                            <option value="S-1">S-1</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1"
                                                                class="form-label">Pekerjaan</label>
                                                            <input type="text" name="pekerjaanPasangan" no_kk
                                                                class="form-control" id="exampleInputEmail1"
                                                                aria-describedby="emailHelp"
                                                                placeholder="Masukkan Pekerjaan" >
                                                            <div id="emailHelp" class="form-text"></div>
                                                        </div>
                                                    </div>


                                                    <div class="form-group">
                                                        <div class="mb-3">

                                                            <!-- <button class="btn btn-success btn-sm add-more" type="button">
                                                            <i class="fa fa-user-plus"></i>
                                                        </button> -->

                                                            <!-- <button class="btn btn-success add-more" type="button">
                                                        <i class="glyphicon glyphicon-plus"></i> Add
                                                    </button> -->


                                                        </div>
                                                    </div>


                                                </div>

                                                <!-- baris sebelah kanan  -->

                                                <div class="col-md-6">
                                                    <div class="form-group ">




                                                        <!-- sub judul 5 -->
                                                        <div
                                                            class="modal-header bg-info panel-heading  col-sm-15 m-b-5  ">
                                                            <label class="  ">Kontak Darurat</label>
                                                        </div>


                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label for="exampleInputEmail1" class="form-label">Nama
                                                                    Lengkap</label>
                                                                <input type="text" name="namaKdarurat"
                                                                    class="form-control" placeholder="Masukkan Nama"
                                                                    required>
                                                                <div id="emailHelp" class="form-text"></div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group ">
                                                            <div class="mb-3 ">
                                                                <label for="exampleInputEmail1"
                                                                    class="form-label">Alamat</label>
                                                                <input class="form-control" name="alamatKdarurat"
                                                                    rows="9" placeholder="Masukkan Alamat"></input>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label for="exampleInputEmail1" class="form-label">No.
                                                                    Handphone</label>
                                                                <input type="number" name="no_hpKdarurat"
                                                                    class="form-control" id="no_hp"
                                                                    placeholder="Masukkan Nomor Handphone" required>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label for="exampleInputEmail1"
                                                                    class="form-label">Hubungan</label>
                                                                <input type="text" name="hubunganKdarurat"
                                                                    class="form-control" id="no_hp"
                                                                    placeholder="Masukkan Hubungan" required>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <!-- Judul 1 -->
                                                    <div class="modal-header bg-info panel-heading  col-sm-15 m-b-2 ">
                                                        <label class="  "><h4> C. Riwayat Pendidikan </h4></label>
                                                    </div>

                                                    <table class="table table-bordered table-striped">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-6">


                                                                    <!-- sub judul 2 -->
                                                                    <div
                                                                        class="modal-header bg-info panel-heading  col-sm-15 m-b-5 ">
                                                                        <label class="  ">Pendidikan Formal</label>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Tingkat</label>
                                                                        <select class="form-control"
                                                                            name="tingkat_pendidikan" required>
                                                                            <option value="">Pilih Tingkat Pendidikan
                                                                            </option>
                                                                            <option value="SD">SD</option>
                                                                            <option value="SMP">SMP</option>
                                                                            <option value="SMA/K">SMA/K</option>
                                                                            <option value="Universitas">Universitas
                                                                            </option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="mb-3">
                                                                            <label for="exampleInputEmail1"
                                                                                class="form-label">Nama Sekolah</label>
                                                                            <input type="text" name="nama_sekolah"
                                                                                class="form-control"
                                                                                placeholder="Masukkan Nama" required>
                                                                            <div id="emailHelp" class="form-text"></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="mb-3">
                                                                            <label for="exampleInputEmail1"
                                                                                class="form-label"> Kota</label>
                                                                            <input type="text"
                                                                                name="kotaPendidikanFormal" no_kk
                                                                                class="form-control"
                                                                                id="exampleInputEmail1"
                                                                                aria-describedby="emailHelp"
                                                                                placeholder="Masukkan Kota" required>
                                                                            <div id="emailHelp" class="form-text"></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="mb-3">
                                                                            <label for="exampleInputEmail1"
                                                                                class="form-label"> Jurusan</label>
                                                                            <input type="text" name="jurusan" no_kk
                                                                                class="form-control"
                                                                                id="exampleInputEmail1"
                                                                                aria-describedby="emailHelp"
                                                                                placeholder="Masukkan Jurusan" required>
                                                                            <div id="emailHelp" class="form-text"></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <div class="mb-3">
                                                                            <label for="exampleInputEmail1"
                                                                                class="form-label">Lulus Tahun</label>
                                                                            <div class="input-group">
                                                                                <input type="text" class="form-control"
                                                                                    placeholder="yyyy/mm/dd"
                                                                                    id="datepicker-autoclose12"
                                                                                    name="tahun_lulusFormal" rows="10"
                                                                                    required></input><br>
                                                                                <span
                                                                                    class="input-group-addon bg-custom b-0"><i
                                                                                        class="mdi mdi-calendar text-white"></i></span>
                                                                            </div><!-- input-group -->
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group ">

                                                                        <!-- baris sebelah kanan  -->
                                                                        <!-- sub judul 3 -->
                                                                        <div
                                                                            class="modal-header bg-info panel-heading  col-sm-15 m-b-5  ">
                                                                            <label class="  ">Pendidikan Non
                                                                                Formal</label>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="mb-3">
                                                                                <label for="exampleInputEmail1"
                                                                                    class="form-label">Bidang /
                                                                                    Jenis</label>
                                                                                <input type="text"
                                                                                    name="jenis_pendidikan"
                                                                                    class="form-control"
                                                                                    placeholder="Masukkan Nama"
                                                                                    >
                                                                                <div id="emailHelp" class="form-text">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="mb-3">
                                                                                <label for="exampleInputEmail1"
                                                                                    class="form-label"> Kota</label>
                                                                                <input type="text"
                                                                                    name="kotaPendidikanNonFormal" no_kk
                                                                                    class="form-control"
                                                                                    id="exampleInputEmail1"
                                                                                    aria-describedby="emailHelp"
                                                                                    placeholder="Masukkan Kota"
                                                                                    >
                                                                                <div id="emailHelp" class="form-text">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <div class="mb-3">
                                                                                <label for="exampleInputEmail1"
                                                                                    class="form-label">Lulus
                                                                                    Tahun</label>
                                                                                <div class="input-group">
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        placeholder="yyyy/mm/dd"
                                                                                        id="datepicker-autoclose14"
                                                                                        name="tahunLulusNonFormal"
                                                                                        rows="10" ></input><br>
                                                                                    <span
                                                                                        class="input-group-addon bg-custom b-0"><i
                                                                                            class="mdi mdi-calendar text-white"></i></span>
                                                                                </div><!-- input-group -->
                                                                            </div>
                                                                        </div>


                                                                    </div>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <!-- Judul 1 -->
                                                                    <div
                                                                        class="modal-header bg-info panel-heading  col-sm-15 m-b-2 ">
                                                                        <label class="  "><h4>D. Riwayat Pekerjaan </h4></label>
                                                                    </div>

                                                                    <table class="table table-bordered table-striped">
                                                                        <form role="form" method="post"
                                                                            action="tambah_alumni.php">
                                                                            <div class="card-body">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">


                                                                                        <!-- sub judul 2 -->

                                                                                        <div class="form-group">
                                                                                            <div class="mb-3">
                                                                                                <label
                                                                                                    for="exampleInputEmail1"
                                                                                                    class="form-label">Nama
                                                                                                    Perusahaan</label>
                                                                                                <input type="text"
                                                                                                    name="namaPerusahaan"
                                                                                                    class="form-control"
                                                                                                    placeholder="Masukkan Nama Perusahaan"
                                                                                                    >
                                                                                                <div id="emailHelp"
                                                                                                    class="form-text">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <div class="mb-3">
                                                                                                <label
                                                                                                    for="exampleInputEmail1"
                                                                                                    class="form-label">
                                                                                                    Alamat </label>
                                                                                                <input type="text"
                                                                                                    name="alamatPerusahaan"
                                                                                                    no_kk
                                                                                                    class="form-control"
                                                                                                    id="exampleInputEmail1"
                                                                                                    aria-describedby="emailHelp"
                                                                                                    placeholder="Masukkan Alamat"
                                                                                                    >
                                                                                                <div id="emailHelp"
                                                                                                    class="form-text">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <div class="mb-3">
                                                                                                <label
                                                                                                    for="exampleInputEmail1"
                                                                                                    class="form-label">
                                                                                                    Jenis Usaha</label>
                                                                                                <input type="text"
                                                                                                    name="jenisUsaha"
                                                                                                    no_kk
                                                                                                    class="form-control"
                                                                                                    id="exampleInputEmail1"
                                                                                                    aria-describedby="emailHelp"
                                                                                                    placeholder="Masukkan Jenis Usaha"
                                                                                                    >
                                                                                                <div id="emailHelp"
                                                                                                    class="form-text">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <div class="mb-3">
                                                                                                <label
                                                                                                    for="exampleInputEmail1"
                                                                                                    class="form-label">
                                                                                                    Jabatan</label>
                                                                                                <input type="text"
                                                                                                    name="jabatanRpkerejaan"
                                                                                                    no_kk
                                                                                                    class="form-control"
                                                                                                    id="exampleInputEmail1"
                                                                                                    aria-describedby="emailHelp"
                                                                                                    placeholder="Masukkan Jabatan"
                                                                                                    >
                                                                                                <div id="emailHelp"
                                                                                                    class="form-text">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <div class="mb-3">
                                                                                                <label
                                                                                                    for="exampleInputEmail1"
                                                                                                    class="form-label">
                                                                                                    Nama Atasan
                                                                                                    Langsung</label>
                                                                                                <input type="text"
                                                                                                    name="namaAtasan"
                                                                                                    no_kk
                                                                                                    class="form-control"
                                                                                                    id="exampleInputEmail1"
                                                                                                    aria-describedby="emailHelp"
                                                                                                    placeholder="Masukkan Nama Atasan"
                                                                                                    >
                                                                                                <div id="emailHelp"
                                                                                                    class="form-text">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="form-group">
                                                                                            <div class="mb-3">
                                                                                                <button
                                                                                                    class="btn btn-success btn-sm">
                                                                                                    <i
                                                                                                        class="fa fa-user-plus"></i>
                                                                                                </button>
                                                                                                <div id="emailHelp"
                                                                                                    class="form-text">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>


                                                                                    </div>

                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group ">

                                                                                            <!-- baris sebelah kanan  -->
                                                                                            <!-- sub judul 3 -->

                                                                                            <div class="form-group">
                                                                                                <div class="mb-3">
                                                                                                    <label
                                                                                                        for="exampleInputEmail1"
                                                                                                        class="form-label">
                                                                                                        Nama
                                                                                                        Direktur</label>
                                                                                                    <input type="text"
                                                                                                        name="namaDirektur"
                                                                                                        no_kk
                                                                                                        class="form-control"
                                                                                                        id="exampleInputEmail1"
                                                                                                        aria-describedby="emailHelp"
                                                                                                        placeholder="Masukkan Nama Direktur"
                                                                                                        >
                                                                                                    <div id="emailHelp"
                                                                                                        class="form-text">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="form-group">
                                                                                                <div class="mb-3">
                                                                                                    <label
                                                                                                        for="exampleInputEmail1"
                                                                                                        class="form-label">
                                                                                                        Lama
                                                                                                        Kerja</label>
                                                                                                    <input type="text"
                                                                                                        name="lamaKerja"
                                                                                                        no_kk
                                                                                                        class="form-control"
                                                                                                        id="exampleInputEmail1"
                                                                                                        aria-describedby="emailHelp"
                                                                                                        placeholder="Masukkan Lama Kerja"
                                                                                                        >
                                                                                                    <div id="emailHelp"
                                                                                                        class="form-text">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="form-group">
                                                                                                <div class="mb-3">
                                                                                                    <label
                                                                                                        for="exampleInputEmail1"
                                                                                                        class="form-label">
                                                                                                        Alasan
                                                                                                        Berhenti</label>
                                                                                                    <input type="text"
                                                                                                        name="alasanBerhenti"
                                                                                                        no_kk
                                                                                                        class="form-control"
                                                                                                        id="exampleInputEmail1"
                                                                                                        aria-describedby="emailHelp"
                                                                                                        placeholder="Masukkan Alasan Berhenti"
                                                                                                        >
                                                                                                    <div id="emailHelp"
                                                                                                        class="form-text">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>

                                                                                            <div class="form-group">
                                                                                                <div class="mb-3">
                                                                                                    <label
                                                                                                        for="exampleInputEmail1"
                                                                                                        class="form-label">
                                                                                                        Gaji</label>
                                                                                                    <input type="text"
                                                                                                        name="gajiRpekerjaan"
                                                                                                        no_kk
                                                                                                        class="form-control"
                                                                                                        id="gaji"
                                                                                                        aria-describedby="emailHelp"
                                                                                                        placeholder="Masukkan Gaji"
                                                                                                        >
                                                                                                    <div id="emailHelp"
                                                                                                        class="form-text">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>


                                                                                        </div>
                                                                                    </div>

                                                                        </form>
                                                                    </table>
                                                                </div>

                                                                <div class="modal-footer">

                                                                    <button type="submit" name="submit"
                                                                        class="btn btn-sm btn-primary">Simpan</button>
                                                                    <a href="karyawan"
                                                                        class="btn btn-sm btn-danger">Kembali</a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                </div>
                                    </table>
                                </div>
                        </div>
                    </div>
            </div>
            </table>
        </div>
</div>
</table>
</div>
</div>
</form>
</div>


<script type="text/javascript">
    $(document).ready(function() {
      $(".add-more").click(function(){ 
          var html = $(".copy").html();
          $(".after-add-more").after(html);
      });

      // saat tombol remove dklik control group akan dihapus 
      $("body").on("click",".remove",function(){ 
          $(this).parents(".control-group").remove();
      });
    });
</script>

<script>
    var rupiah = document.getElementById('gaji');
        rupiah.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value);
        });
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }

        function previewImage() {

            const image = document.querySelector('#foto');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
</script>


<script src="assets/js/jquery.min.js"></script>



<!-- Plugins js -->
<script src="assets/plugins/timepicker/bootstrap-timepicker.js"></script>
<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="assets/pages/form-advanced.js"></script>
@endsection