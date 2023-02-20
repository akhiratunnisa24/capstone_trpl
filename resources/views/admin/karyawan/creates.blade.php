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
                                                        <input type="text" name="namaKaryawan" class="form-control" value="{{ old('namaKaryawan') }}" placeholder="Masukkan Nama" autocomplete="off" required>
                                                        <div id="emailHelp" class="form-text"></div>
                                                    </div>
                                                </div>
            
                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                                                        <div class="input-group">
                                                            <input id="datepicker-autoclose15" type="text" class="form-control" placeholder="yyyy/mm/dd" id="4"
                                                                name="tgllahirKaryawan" value="{{ old('tgllahirKaryawan') }}" autocomplete="off" rows="10" required></input><br>
                                                            <span class="input-group-addon bg-custom b-0"><i  class="mdi mdi-calendar text-white"></i></span>
                                                        </div><!-- input-group -->
                                                    </div>
                                                </div>
            
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                                    <select class="form-control selectpicker"  value="{{ old('jenis_kelaminKaryawan') }}" name="jenis_kelaminKaryawan" required>
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option value="L">Laki-Laki</option>
                                                        <option value="P">Perempuan</option>
                                                    </select>
                                                </div>
            
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="form-label">Departemen</label>
                                                    <select class="form-control selectpicker" value="{{ old('divisi') }}" name="divisi" data-live-search="true" required>
                                                        <option value="">Pilih Departemen</option>
                                                        @foreach ($departemen as $d)
                                                            <option value="{{ $d->id }}">{{ $d->nama_departemen }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
            
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="form-label">Atasan Langsung (SPV/Manager/Direktur)</label>
                                                    <select class="form-control selectpicker" value="{{ old('atasan_pertama') }}" name="atasan_pertama" data-live-search="true">
                                                        <option value="">Pilih Atasan Langsung</option>
                                                        @foreach ($atasan_pertama as $atasan)
                                                            <option value="{{ $atasan->id }}">{{ $atasan->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
            
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="form-label">Atasan (Manager/Direktur)</label>
                                                    <select class="form-control selectpicker" value="{{ old('atasan_kedua') }}" name="atasan_kedua"  data-live-search="true">
                                                        <option value="">Pilih Atasan</option>
                                                        @foreach ($atasan_kedua as $atasan)
                                                            <option value="{{ $atasan->atasan }}">{{ $atasan->nama }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
            
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1" class="form-label">Jabatan</label>
                                                    <select class="form-control selectpicker" value="{{ old('jabatanKaryawan') }}" name="jabatanKaryawan" required>
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
                                                        <textarea class="form-control" autocomplete="off" value="{{ old('alamatKaryawan') }}" name="alamatKaryawan" rows="3"></textarea><br>
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
                                                            <input type="number" name="no_hpKaryawan" value="{{ old('no_hpKaryawan') }} "class="form-control"
                                                                placeholder="Masukkan Nomor Handphone" required>
                                                        </div>
                                                    </div>
            
                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">Alamat
                                                                E-mail</label>
                                                            <input type="email" name="emailKaryawan" value="{{ old('emailKaryawan') }}"
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
                                                            <select class="form-control selectpicker" name="agamaKaryawan" value="{{ old('agamaKaryawan') }}" required>
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
                                                                    name="tglmasukKaryawan" rows="10" autocomplete="off"value="{{ old('tglmasukKaryawan') }}"
                                                                    required></input><br>
                                                                <span class="input-group-addon bg-custom b-0"><i
                                                                        class="mdi mdi-calendar text-white"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
            
                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">NIK</label>
                                                            <input type="number" name="nikKaryawan" class="form-control" value="{{ old('nikKaryawan') }}"
                                                                placeholder="Masukkan NIK" required>
                                                        </div>
                                                    </div>
            
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="form-label">Golongan Darah</label>
                                                        <select class="form-control selectpicker" name="gol_darahKaryawan" value="{{ old('gol_darahKaryawan') }}" required>
                                                            <option value="">Pilih Golongan Darah</option>
                                                            <option value="A">A</option>
                                                            <option value="B">B</option>
                                                            <option value="AB">AB</option>
                                                            <option value="O">O</option>
                                                        </select>
                                                    </div>
            
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label col-sm-4">Pilih Foto Karyawan</label>
                                                        <img class="img-preview img-fluid mb-3 col-sm-4">
                                                        <input type="file" name="foto" class="form-control" id="foto" onchange="previewImage()" value="{{ old('foto') }}"> 
                                                    </div>
            
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        {{-- <a href="#datakeluarga" type="submit" name="submit" class="btn btn-sm btn-primary" >Selanjutnya</a> --}}
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
     {{-- <script src="assets/js/jquery.min.js"></script> --}}
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     <script src="assets/pages/form-advanced.js"></script>

     <script>
        function previewImage() 
        {
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

@endsection