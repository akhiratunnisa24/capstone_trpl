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
        <div class="col-md-12">
            <div class="panel panel-secondary" id="riwayatpekerjaan">
                <div class="panel-heading"></div>
                <div class="content">
                    {{-- alert danger --}}
                    <div class="alert alert-danger" id="error-message" style="display: none;">
                        <button type="button" class="close" onclick="$('#error-message').hide()">&times;</button>
                    </div>
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
                                                                    <input type="text" name="namaKaryawan" class="form-control" value="{{ $karyawan->nama ?? '' }}" placeholder="Masukkan Nama" autocomplete="off" required>
                                                                    <div id="emailHelp" class="form-text"></div>
                                                                </div>
                                                            </div>
                        
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose15" type="text" class="form-control" placeholder="yyyy/mm/dd" id="4"
                                                                            name="tgllahirKaryawan" value="{{ $karyawan->tgllahir ?? '' }}" autocomplete="off" rows="10" required></input><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i  class="mdi mdi-calendar text-white"></i></span>
                                                                    </div><!-- input-group -->
                                                                </div>
                                                            </div>
                        
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                                                <select class="form-control selectpicker" name="jenis_kelaminKaryawan" required>
                                                                    <option value="">Pilih Jenis Kelamin</option>
                                                                    <option value="L" {{ $karyawan->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                                                    <option value="P" {{ $karyawan->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                                </select>
                                                            </div>
                        
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Departemen</label>
                                                                <select class="form-control selectpicker" name="divisi" data-live-search="true" required>
                                                                    <option value="">Pilih Departemen</option>
                                                                    @foreach ($departemen as $d)
                                                                    <option value="{{ $d->id }}" 
                                                                        {{ $karyawan->divisi == $d->id ? 'selected' : '' }}>
                                                                        {{ $d->nama_departemen ?? '' }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                        
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Atasan Langsung (SPV/Manager/Direktur)</label>
                                                                <select class="form-control selectpicker" name="atasan_pertama" data-live-search="true">
                                                                    <option value="">Pilih Atasan Langsung</option>
                                                                    @foreach ($atasan_pertama as $atasan)
                                                                        <option value="{{ $atasan->id }}" 
                                                                            {{ $karyawan->atasan_pertama == $atasan->id ? 'selected' : '' }}>
                                                                            {{ $atasan->nama ?? '' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Atasan (Manager/Direktur)</label>
                                                                <select class="form-control selectpicker" name="atasan_kedua"  data-live-search="true">
                                                                    <option value="">Pilih Atasan</option>
                                                                    @foreach ($atasan_kedua as $atasan)
                                                                        <option value="{{ $atasan->id }}"
                                                                             {{ $karyawan->atasan_kedua == $atasan->id ? 'selected' : '' }}>
                                                                             {{ $atasan->nama ?? '' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Jabatan</label>
                                                                <select class="form-control selectpicker" name="jabatanKaryawan" required>
                                                                    <option value="">Pilih Jabatan</option>
                                                                    <option value="Management"  {{ $karyawan->jabatan ?? '' == 'Management' ? 'selected' : '' }}>Management</option>
                                                                    <option value="Manager" {{ $karyawan->jabatan ?? '' == 'Manager' ? 'selected' : '' }}>Manager</option>
                                                                    <option value="Supervisor" {{ $karyawan->jabatan ?? '' == 'Supervisor' ? 'selected' : '' }}>Supervisor</option>
                                                                    <option value="Staff" {{ $karyawan->jabatan ?? '' == 'Staff' ? 'selected' : '' }}>Staff</option>
                                                                </select>
                                                            </div>
                        
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                                                    <textarea class="form-control" autocomplete="off" value="{{ $karyawan->alamat ?? '' }}" name="alamatKaryawan" rows="3" required></textarea><br>
                                                                </div>
                                                            </div>
                                                        </div>
                        
                                                        <!-- baris sebelah kanan  -->
                        
                                                        <div class="col-md-6 m-t-10">
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">No. Handphone</label>
                                                                        <input type="number" name="no_hpKaryawan" value="{{ $karyawan->no_hp ?? '' }}" class="form-control"
                                                                            placeholder="Masukkan Nomor Handphone" required>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Alamat E-mail</label>
                                                                        <input type="email" name="emailKaryawan" value="{{ $karyawan->email ?? '' }}"
                                                                            class="form-control" id="exampleInputEmail1" 
                                                                            aria-describedby="emailHelp" placeholder="Masukkan Email" autocomplete="off" required>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Agama</label>
                                                                        <select class="form-control selectpicker" name="agamaKaryawan" required>
                                                                            <option value="">Pilih Agama</option>
                                                                            <option value="Islam" {{ $karyawan->agama ?? '' == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                                            <option value="Kristen" {{ $karyawan->agama ?? '' == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                                            <option value="Katholik" {{ $karyawan->agama ?? '' == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                                                            <option value="Hindu" {{ $karyawan->agama ?? '' == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                                            <option value="Budha" {{ $karyawan->agama ?? '' == 'Budha' ? 'selected' : '' }}>Budha</option>
                                                                            <option value="Khong Hu Chu" {{ $karyawan->agama ?? '' == 'Khong Hu Chu' ? 'selected' : '' }}>Khong Hu Chu</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Tanggal Masuk</label>
                                                                        <div class="input-group">
                                                                            <input type="text" class="form-control"
                                                                                placeholder="yyyy/mm/dd" id="datepicker-autoclose2"
                                                                                name="tglmasukKaryawan" rows="10" autocomplete="off" value="{{ $karyawan->tglmasuk ?? '' }}"
                                                                                required></input><br>
                                                                            <span class="input-group-addon bg-custom b-0"><i
                                                                                    class="mdi mdi-calendar text-white"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">NIK</label>
                                                                        <input type="number" name="nikKaryawan" class="form-control" value="{{ $karyawan->nik ?? '' }}"
                                                                            placeholder="Masukkan NIK" required>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="form-group">
                                                                    <label for="exampleInputEmail1" class="form-label">Golongan Darah</label>
                                                                    <select class="form-control selectpicker" name="gol_darahKaryawan" required>
                                                                        <option value="">Pilih Golongan Darah</option>
                                                                        <option value="A" {{ $karyawan->gol_darah ?? '' == 'A' ? 'selected' : '' }}>A</option>
                                                                        <option value="B" {{ $karyawan->gol_darah ?? '' == 'B' ? 'selected' : '' }}>B</option>
                                                                        <option value="AB" {{ $karyawan->gol_darah ?? '' == 'AB' ? 'selected' : '' }}>AB</option>
                                                                        <option value="O" {{ $karyawan->gol_darah ?? '' == 'O' ? 'selected' : '' }}>O</option>
                                                                    </select>
                                                                </div>
                        
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label col-sm-4">Pilih Foto Karyawan</label>
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="foto" class="form-control" id="foto" onchange="previewImage()"> 
                                                                </div>
                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    {{-- <button type="submit" id="btnsimpan" name="submit" class="btn btn-sm btn-primary">Simpan</button> --}}
                                                    <a href="/create-data-keluarga" type="submit"  name="submit" id="btnselanjutnya" class="btn btn-sm btn-danger">Simpan & Selanjutnya <i class="fa fa-forward"></i></a>
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

    {{-- <script>
        $(document).ready(function() {
            $("#btnselanjutnya").attr('disabled', true);
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#btnsimpan").click(function() {
                $("#btnselanjutnya").attr('disabled', false);
            });
            
            $("#btnselanjutnya").click(function() {
                if ($("#btnsimpan").attr('disabled')) {
                    alert("Silakan klik tombol 'Simpan' terlebih dahulu!");
                    return false;
                }
            });
        });
    </script> --}}
@endsection