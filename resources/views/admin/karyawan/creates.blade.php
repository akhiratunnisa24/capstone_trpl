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
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs navtab-bg">
                <li class="">
                    <a id="tabs1" href="#identitas" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">A. IDENTITAS DIRI</span>
                    </a>
                </li>
                <li class="">
                    <a id="tabs2" href="#datakeluarga" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="mdi mdi-account-multiple"></i></span>
                        <span class="hidden-xs">B. DATA KELUARGA</span>
                    </a>
                </li>
                <li class="">
                    <a id="tabs3" href="#kontakdarurat" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-phone"></i></span>
                        <span class="hidden-xs">C. KONTAK DARURAT</span>
                    </a>
                </li>
                <li class="">
                    <a id="tabs4" href="#riwayatpendidikan" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-mortar-board (alias)"></i></span>
                        <span class="hidden-xs">D. RIWAYAT PENDIDIKAN</span>
                    </a>
                </li>
                <li class="">
                    <a id="tabs5" href="#riwayatpekerjaan" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-suitcase"></i></span>
                        <span class="hidden-xs">E. RIWAYAT PEKERJAAN</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- A> IDENTITAS DIRI -->

                <div class="tab-pane active" id="identitas">
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20 col-sm-20 col-xs-20">
                                    <form action="storepage" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        <div class="control-group after-add-more">
                                           
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div>
                                                                <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                    <label class="text-white m-b-10">A. IDENTITAS DIRI</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 m-t-10">
                            
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                                                        <input type="text" name="namaKaryawan" class="form-control" placeholder="Masukkan Nama" autocomplete="off" required>
                                                                        <div id="emailHelp" class="form-text"></div>
                                                                    </div>
                                                                </div>
                            
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose15" type="text" class="form-control" placeholder="yyyy/mm/dd" id="4"
                                                                                name="tgllahirKaryawan" autocomplete="off" rows="10" required></input><br>
                                                                            <span class="input-group-addon bg-custom b-0"><i  class="mdi mdi-calendar text-white"></i></span>
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
                                                                        <textarea class="form-control" autocomplete="off" name="alamatKaryawan" rows="3"></textarea><br>
                                                                    </div>
                                                                </div>
                            
                                                            </div>
                            
                                                            <!-- baris sebelah kanan  -->
                            
                                                            <div class="col-md-6 m-t-10">
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
                                                        <a href="#datakeluarga" class="btn btn-sm btn-danger" data-toggle="tab">Selanjutnya</a>
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
                <!-- END IDENTITAS CUTI -->

                <!-- B. DATA KELUARGA -->
                <div class="tab-pane" id="datakeluarga">
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20 col-sm-20 col-xs-20">
                                    <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Hubungan Keluarga</th>
                                                <th>Alamat</th>
                                                <th>Pekerjaan</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($datakeluarga as $dk)
                                                <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $dk->nama}}</td>
                                                <td>{{ $dk->tgllahir}}</td>
                                                <td>{{ $dk->hubungan}}</td>
                                                <td>{{ $dk->alamat}}</td>
                                                <td>{{ $dk->pekerjaan}}</td>
                                                {{-- <td></td> --}}
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table><br>
                                    <form action="/storedatakeluarga" method="POST" enctype="multipart/form-data">
                                        <div class="control-group after-add-more">
                                            @csrf
                                            @method('post')
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <div class="col-md-12">
                                                        <div class="row">

                                                            <!-- FORM -->
                                                            <div class="col-md-6">
                                                                <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5 ">
                                                                    <label class="text-white">Status Pernikahan*)</label>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1" class="form-label">Status Pernikahan</label>
                                                                    <select class="form-control selectpicker" name="status_pernikahan">
                                                                        <option value="">Pilih Status Pernikahan</option>
                                                                        <option value="Sudah">Sudah Menikah</option>
                                                                        <option value="Belum">Belum Menikah</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <!-- SEBELAH KANAN -->
                                                            <div class="col-md-6">
                                                                <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5 ">
                                                                    <label class="text-white">Data Keluarga *) </label>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Nama
                                                                            Lengkap</label>
                                                                        <input type="text" name="namaPasangan"
                                                                            class="form-control" autocomplete="off" placeholder="Masukkan Nama">
                                                                        <div id="emailHelp" class="form-text"></div>
                                                                    </div>
                                                                </div>
        
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Tanggal
                                                                            Lahir</label>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="yyyy/mm/dd"
                                                                                id="datepicker-autoclose8" autocomplete="off" name="tgllahirPasangan"
                                                                                rows="10"></input><br>
                                                                            <span class="input-group-addon bg-custom b-0"><i
                                                                                    class="mdi mdi-calendar text-white"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Hubungan</label>
                                                                        <select class="form-control selectpicker" name="hubungankeluarga" required>
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
        
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Alamat</label>
                                                                        <input class="form-control" name="alamatPasangan" autocomplete="off"
                                                                            rows="9" placeholder="Masukkan Alamat"></input>
                                                                    </div>
                                                                </div>
        
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1" class="form-label">Pendidikan
                                                                        Terakhir</label>
                                                                    <select class="form-control selectpicker"
                                                                        name="pendidikan_terakhirPasangan">
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
                                                                            placeholder="Masukkan Pekerjaan">
                                                                        <div id="emailHelp" class="form-text"></div>
                                                                    </div>
                                                                </div>
        
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pull-right">
                                                        <button type="submit" name="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                        <a href="#kontakdarurat" class="btn btn-sm btn-danger" data-toggle="tab">Selanjutnya</a>
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
                {{-- END DATA KELUARGA --}}

                <!-- C. KONTAK DARURAT -->
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
                                            @foreach($kontakdarurat as $kd)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{ $kd->nama}}</td>
                                                    <td>{{ $kd->no_hp}}</td>
                                                    <td>{{ $kd->alamat}}</td>
                                                    <td>{{ $kd->hubungan}}</td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                            @endforeach
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
                <!-- END IDENTITAS CUTI -->

                <!-- B. RIWAYAT PENDIDIKAN -->
                <div class="tab-pane" id="riwayatpendidikan">
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20 col-sm-20 col-xs-20">
                                    <table id="datatable-responsive8" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                       <span class="badge badge-info"><strong>A. PENDIDIKAN FORMAL</strong></span>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Tingkat Pendidikan</th>
                                                <th>Nama Sekolah</th>
                                                <th>Kota</th>
                                                <th>Jurusan</th>
                                                <th>Tahun Lulus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pformal as $p)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$p->tingkat }}</td>
                                                    <td>{{$p->nama_sekolah }}</td>
                                                    <td>{{$p->kota_pformal }}</td>
                                                    <td>{{$p->jurusan }}</td>
                                                    <td>{{$p->tahun_lulus_formal }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table><br>

                                    <span class="badge badge-info"><strong>B. PENDIDIKAN NON FORMAL</strong></span>
                                    <table id="datatable-responsive9" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Bidang/Jenis</th>
                                                <th>Kota</th>
                                                <th>Tahun Lulus</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($nonformal as $nf)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{ $nf->jenis_pendidikan }}</td>
                                                    <td>{{ $nf->kota_pnonformal }}</td>
                                                    <td>{{ $nf->tahun_lulus_nonformal }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table><br>
                                    <form action="/storepformal" method="POST" enctype="multipart/form-data">
                                        <div class="control-group after-add-more">
                                            @csrf
                                            @method('post')
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            {{-- KIRI --}}
                                                            <div class="col-md-6">
                                                                <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5 ">
                                                                    <label class="text-white">Pendidikan Formal</label>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1" class="form-label">Tingkat</label>
                                                                    <select class="form-control selectpicker" name="tingkat_pendidikan">
                                                                        <option value="">Pilih TingkatPendidikan</option>
                                                                        <option value="SD">SD</option>
                                                                        <option value="SMP">SMP</option>
                                                                        <option value="SMA/K">SMA/K</option>
                                                                        <option value="Universitas">Universitas</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Nama Sekolah</label>
                                                                        <input type="text" name="nama_sekolah" class="form-control" placeholder="Masukkan Sekolah" autocomplete="off">
                                                                        <div id="emailHelp" class="form-text">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label"> Kota</label>
                                                                        <input type="text" name="kotaPendidikanFormal"  class="form-control"
                                                                            id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Kota">
                                                                        <div id="emailHelp" class="form-text">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label"> Jurusan</label>
                                                                        <input type="text" name="jurusan" no_kk class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                            placeholder="Masukkan Jurusan" autocomplete="off">
                                                                        <div id="emailHelp" class="form-text">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Lulus Tahun</label>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose20" type="text"  class="form-control" placeholder="yyyy" id="4"
                                                                                    name="tahun_lulusFormal" rows="10" autocomplete="off"></input><br>
                                                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <button type="submit" name="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                                   
                                                                </div>
                                                            </div>

                                                            {{-- KANAN --}}
                                                            <div class="col-md-6">
                                                                <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                    <label class="text-white">Pendidikan NonFormal</label>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Bidang / Jenis</label>
                                                                        <input type="text" name="jenis_pendidikan" class="form-control" placeholder="Masukkan Nama" autocomplete="off"> 
                                                                        <div id="emailHelp" class="form-text">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label"> Kota</label>
                                                                        <input type="text" name="kotaPendidikanNonFormal"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"   placeholder="Masukkan Kota" autocomplete="off">
                                                                        <div id="emailHelp" class="form-text">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Lulus Tahun</label>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose21" type="text" class="form-control" placeholder="yyyy" id="4"
                                                                                    name="tahunLulusNonFormal" autocomplete="off" rows="10" ><br>
                                                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div></div><br><br><br><br><br><br><br><br>
                                                                <div class="pull-right">
                                                                    <button type="submit" name="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                                    <a href="#riwayatpekerjaan" data-toggle="tab" class="btn btn-sm btn-danger">Selanjutnya</a>
                                                                </div>
                                                            </div>
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
                {{-- END RIWAYAT PENDIDIKAN --}}

                <!-- B. RIWAYAT PEKERJAAN -->
                <div class="tab-pane" id="riwayatpekerjaan">
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20 col-sm-20 col-xs-20">
                                    <table id="datatable-responsive10" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Perusahaan</th>
                                                <th>Jabatan</th>
                                                <th>Lama Kerja</th>
                                                <th>Gaji</th>
                                                <th>Atasan Langsung</th>
                                                <th>Direktur</th>
                
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pekerjaan as $pek)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $pek->nama_perusahaan }}</td>
                                                    <td>{{ $pek->jabatan }}</td>
                                                    <td>{{ $pek->lama_kerja }}</td>
                                                    <td>{{ $pek->gaji }}</td>
                                                    <td>{{ $pek->nama_atasan }}</td>
                                                    <td>{{ $pek->nama_direktur }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table><br>
                                    <form action="/storepekerjaan" method="POST" enctype="multipart/form-data">
                                        <div class="control-group after-add-more">
                                            @csrf
                                            @method('post')
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div>
                                                                <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                    <label class="text-white m-b-10">E. Riwayat Pekerjaan</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 m-t-10">
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Nama  Perusahaan</label>
                                                                        <input type="text" name="namaPerusahaan"  class="form-control"  placeholder="Masukkan Nama Perusahaan" autocomplete="off">
                                                                        <div id="emailHelp" class="form-text">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">  Alamat </label>
                                                                        <input type="text"  name="alamatPerusahaan" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                            placeholder="Masukkan Alamat"autocomplete="off">
                                                                        <div id="emailHelp"class="form-text">
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
                                                                            placeholder="Masukkan Jenis Usaha" autocomplete="off">
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
                                                                            placeholder="Masukkan Jabatan" autocomplete="off">
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
                                                                            placeholder="Masukkan Nama Atasan" autocomplete="off">
                                                                        <div id="emailHelp"
                                                                            class="form-text">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                {{-- <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <button class="btn btn-success btn-sm"><i class="fa fa-user-plus"></i>
                                                                        </button>
                                                                        <div id="emailHelp"
                                                                            class="form-text">
                                                                        </div>
                                                                    </div>
                                                                </div> --}}
                                                            </div>

                                                            {{-- KANAN --}}
                                                            <div class="col-md-6 m-t-10">
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label
                                                                            for="exampleInputEmail1"
                                                                            class="form-label">
                                                                            Nama
                                                                            Direktur</label>
                                                                        <input
                                                                            type="text"
                                                                            name="namaDirektur"
                                                                            no_kk
                                                                            class="form-control"
                                                                            id="exampleInputEmail1"
                                                                            aria-describedby="emailHelp"
                                                                            placeholder="Masukkan Nama Direktur" autocomplete="off">
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
                                                                        <input
                                                                            type="text"
                                                                            name="lamaKerja"
                                                                            no_kk
                                                                            class="form-control"
                                                                            id="exampleInputEmail1"
                                                                            aria-describedby="emailHelp"
                                                                            placeholder="Masukkan Lama Kerja" autocomplete="off">
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
                                                                        <input
                                                                            type="text"
                                                                            name="alasanBerhenti"
                                                                            no_kk
                                                                            class="form-control"
                                                                            id="exampleInputEmail1"
                                                                            aria-describedby="emailHelp"
                                                                            placeholder="Masukkan Alasan Berhenti" autocomplete="off">
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
                                                                        <input
                                                                            type="text"
                                                                            name="gajiRpekerjaan"
                                                                            no_kk
                                                                            class="form-control"
                                                                            id="gaji"
                                                                            aria-describedby="emailHelp"
                                                                            placeholder="Masukkan Gaji" autocomplete="off">
                                                                        <div id="emailHelp"
                                                                            class="form-text">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="pull-right">
                                                        <button type="submit" name="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                        <a href="/karyawan" class="btn btn-sm btn-danger">Kembali</a>
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
                {{-- END DATA KELUARGA --}}

            </div>
        </div>
    </div> 
    
        {{-- <script src="assets/js/jquery.min.js"></script> --}}
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Plugins js -->
        <script src="assets/plugins/timepicker/bootstrap-timepicker.js"></script>
        <script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
        <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
        <script src="assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
    
        <!-- Plugins Init js -->
        <script src="assets/pages/form-advanced.js"></script>

        <script type="text/javascript">
            $(document).ready(function() {
                $(".add-more").click(function() {
                    var html = $(".copy").html();
                    $(".after-add-more").after(html);
                });

                // saat tombol remove dklik control group akan dihapus 
                $("body").on("click", ".remove", function() {
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
        <!-- Pre-load all tab content using jQuery -->
        <script>
            $(document).ready(function() {
            $('.tab-content').find('.tab-pane').each(function(index, tab) {
                var href = $(tab).attr('id');
                var url = '/' + href + '/form'; // Replace with the URL of the tab content
                $(tab).load(url);
            });
            });
        </script>
    
@endsection
