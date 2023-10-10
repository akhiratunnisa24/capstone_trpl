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
                    <li>Rynest Employee Management System</li>
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
                                <form action="/storepage" method="POST" enctype="multipart/form-data">
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
                                                                        <label  class="form-label">NIP Karyawan <span style="color: red;">*</span></label>
                                                                        <input type="text" name="nipKaryawan" value="{{ $karyawan->nip ?? '' }}" class="form-control"
                                                                            placeholder="Masukkan NIP Karyawan" required>
                                                                    </div>
                                                                </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nama Lengkap <span style="color: red;">*</span></label>
                                                                    <input type="text" name="namaKaryawan" class="form-control" value="{{ $karyawan->nama ?? '' }}" placeholder="Masukkan Nama Lengkap" autocomplete="off" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label  class="form-label">Tanggal Lahir <span style="color: red;">*</span></label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose-format" type="text" class="form-control" placeholder="dd/mm/yyyy" id="4"
                                                                            name="tgllahirKaryawan" value="{{ $karyawan->tgllahir ? \Carbon\Carbon::parse($karyawan->tgllahir)->format('d/m/Y') : '' }}" autocomplete="off" rows="10" required readonly><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i  class="mdi mdi-calendar text-white"></i></span>
                                                                    </div><!-- input-group -->
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tempat Lahir <span style="color: red;">*</span></label>
                                                                    <input type="text" name="tempatlahirKaryawan" class="form-control" value="{{ $karyawan->tempatlahir ?? '' }}" placeholder="Masukkan Tempat Lahir" autocomplete="off" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="form-label">Jenis Kelamin <span style="color: red;">*</span></label>
                                                                <select class="form-control selectpicker" name="jenis_kelaminKaryawan" required>
                                                                    <option value="">Pilih Jenis Kelamin</option>
                                                                    <option value="Laki-Laki" {{ $karyawan->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                                                    <option value="Perempuan" {{ $karyawan->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alamat E-mail <span style="color: red;">*</span></label>
                                                                    <input type="email" name="emailKaryawan" value="{{ $karyawan->email ?? '' }}"
                                                                        class="form-control" id="exampleInputEmail1"
                                                                        aria-describedby="emailHelp" placeholder="Masukkan Email" autocomplete="off" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="form-label">Divisi <span style="color: red;">*</span></label>
                                                                <select class="form-control selectpicker" name="divisi" data-live-search="true" required>
                                                                    <option value="">Pilih Departemen</option>
                                                                    @foreach ($departemen as $d)
                                                                    <option value="{{ $d->id }}" {{ $karyawan->divisi == $d->id ? 'selected' : '' }}>{{ $d->nama_departemen ?? '' }}
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="form-label">Atasan Langsung (Asistant Manager/Manager/Direksi)</label>
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
                                                                <label class="form-label">Atasan/Pimpinan (Manager/Direksi)</label>
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
                                                                <label class="form-label">Nama Jabatan <span style="color: red;">*</span></label>
                                                                <select class="form-control selectpicker" name="namaJabatan" data-live-search="true" required>
                                                                    <option value="">Pilih Nama Jabatan</option>
                                                                    @foreach ($namajabatan as $nama)
                                                                        <option value="{{ $nama->nama_jabatan }}" {{ $karyawan->nama_jabatan == $nama->nama_jabatan ? 'selected' : '' }} > {{ $nama->nama_jabatan ?? '' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="form-label">Level Jabatan <span style="color: red;">*</span></label>
                                                                <select class="form-control selectpicker" name="jabatanKaryawan" data-live-search="true" required>
                                                                    <option value="">Pilih Level Jabatan</option>
                                                                    @foreach ($leveljabatan as $level)
                                                                        <option value="{{ $level->nama_level }}" {{ $karyawan->jabatan == $level->nama_level ? 'selected' : '' }} > {{ $level->nama_level ?? '' }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="form-label">Status Karyawan <span style="color: red;">*</span></label>
                                                                <select class="form-control selectpicker" name="statusKaryawan" required>
                                                                    <option value="">Pilih Status   </option>
                                                                    <option value="Pengurus"  {{ $karyawan->status_karyawan == 'Pengurus' ? 'selected' : '' }}>Pengurus</option>
                                                                    <option value="Tetap"  {{ $karyawan->status_karyawan == 'Tetap' ? 'selected' : '' }}>Tetap</option>
                                                                    <option value="Kontrak" {{ $karyawan->status_karyawan == 'Kontrak' ? 'selected' : '' }}>Kontrak</option>
                                                                    <option value="Probation" {{ $karyawan->status_karyawan == 'Percobaan' ? 'selected' : '' }}>Percobaan</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                    <label class="form-label">Golongan Darah <span style="color: red;">*</span></label>
                                                                    <select class="form-control selectpicker" name="gol_darahKaryawan" required>
                                                                        <option value="">Pilih Golongan Darah</option>
                                                                        <option value="A" {{ $karyawan->gol_darah == 'A' ? 'selected' : '' }}>A</option>
                                                                        <option value="B" {{ $karyawan->gol_darah == 'B' ? 'selected' : '' }}>B</option>
                                                                        <option value="AB" {{ $karyawan->gol_darah == 'AB' ? 'selected' : '' }}>AB</option>
                                                                        <option value="O" {{ $karyawan->gol_darah == 'O' ? 'selected' : '' }}>O</option>
                                                                        <option value="Nihil" {{ $karyawan->gol_darah == 'Nihil' ? 'selected' : '' }}>Nihil</option>
                                                                    </select>
                                                                </div>


                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alamat <span style="color: red;">*</span></label>
                                                                    <textarea class="form-control" autocomplete="off" name="alamatKaryawan" rows="5" required>{{ $karyawan->alamat ?? '' }}</textarea><br>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-4">Pilih Foto Karyawan <span style="color: red;">*</span></label>
                                                                    @if($karyawan->foto != null)
                                                                        <img class="img-preview img-fluid mb-3 col-sm-4" src="{{ asset('Foto_Profile/'.$karyawan->foto) }}">
                                                                        <input type="file" name="foto" class="form-control" id="foto" onchange="previewImage()">
                                                                    @else
                                                                        <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                        <input type="file" name="foto" class="form-control" id="foto" onchange="previewImage()" required>
                                                                    @endif

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- baris sebelah kanan  -->

                                                        <div class="col-md-6 m-t-10">
                                                            <div class="form-group">
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Status Pernikahan <span style="color: red;">*</span></label>
                                                                    <select class="form-control selectpicker" name="status_pernikahan" required>
                                                                        <option value="">Pilih Status Pernikahan</option>
                                                                        <option value="Sudah Menikah" {{ $karyawan->status_pernikahan == 'Sudah Menikah' ? 'selected' : '' }} >Sudah Menikah</option>
                                                                        <option value="Belum Menikah" {{ $karyawan->status_pernikahan == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                                                        <option value="Duda" {{ $karyawan->status_pernikahan == 'Duda' ? 'selected' : '' }}>Duda</option>
                                                                        <option value="Janda" {{ $karyawan->status_pernikahan == 'Janda' ? 'selected' : '' }}>Janda</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Jumlah Anak</label>
                                                                    <input type="number" name="jumlahAnak" value="{{ $karyawan->jumlah_anak ?? '' }}"    class="form-control" autocomplete="off" placeholder="Masukkan Jumlah Anak">
                                                                </div>
                                                            </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">No. Handphone <span style="color: red;">*</span></label>
                                                                        <input type="number" name="no_hpKaryawan" value="{{ $karyawan->no_hp ?? '' }}" class="form-control"
                                                                            placeholder="Masukkan Nomor Handphone" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Agama <span style="color: red;">*</span></label>
                                                                        <select class="form-control selectpicker" name="agamaKaryawan" required>
                                                                            <option value="">Pilih Agama</option>
                                                                            <option value="Islam" {{ $karyawan->agama  == 'Islam' ? 'selected' : '' }}>Islam</option>
                                                                            <option value="Kristen" {{ $karyawan->agama  == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                                                            <option value="Katholik" {{ $karyawan->agama == 'Katholik' ? 'selected' : '' }}>Katholik</option>
                                                                            <option value="Hindu" {{ $karyawan->agama  == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                                                            <option value="Budha" {{ $karyawan->agama  == 'Budha' ? 'selected' : '' }}>Budha</option>
                                                                            {{-- <option value="Khong Hu Chu" {{ $karyawan->agama ?? '' == 'Khong Hu Chu' ? 'selected' : '' }}>Khong Hu Chu</option> --}}
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Tanggal Masuk <span style="color: red;">*</span></label>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose-format2" type="text" class="form-control" placeholder="dd/mm/yyyy"
                                                                                name="tglmasukKaryawan"  value="{{ $karyawan->tglmasuk ? \Carbon\Carbon::parse($karyawan->tglmasuk)->format('d/m/Y') : '' }}" autocomplete="off"  rows="10"  required readonly>
                                                                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">No. KTP <span style="color: red;">*</span></label>
                                                                        <input type="text" name="nikKaryawan" class="form-control" value="{{ $karyawan->nik ?? '' }}"
                                                                            placeholder="Masukkan No. KTP / NIK" required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">No. Kartu Keluarga</label>
                                                                        <input type="text" name="nokkKaryawan" class="form-control" value="{{ $karyawan->no_kk ?? '' }}"
                                                                            placeholder="Masukkan No. Kartu Keluarga" >
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">No. NPWP</label>
                                                                        <input type="text" name="nonpwpKaryawan" class="form-control" value="{{ $karyawan->no_npwp ?? '' }}"
                                                                            placeholder="Masukkan No. NPWP" >
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">No. BPJS Ketenagakerjaan</label>
                                                                        <input type="text" name="nobpjsketKaryawan" class="form-control" value="{{ $karyawan->no_bpjs_ket ?? '' }}"
                                                                            placeholder="Masukkan No. BPJS Ketenagakerjaan" >
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">No. BPJS Kesehatan</label>
                                                                        <input type="text" name="nobpjskesKaryawan" class="form-control" value="{{ $karyawan->no_bpjs_kes ?? '' }}"
                                                                            placeholder="Masukkan No. BPJS Kesehatan" >
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">No. Asuransi AKDHK</label>
                                                                        <input type="text" name="noAkdhk" class="form-control" value="{{ $karyawan->no_akdhk ?? '' }}"
                                                                            placeholder="Masukkan No. AKDHK" >
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">No. Program Pensiun</label>
                                                                        <input type="text" name="noprogramPensiun" class="form-control" value="{{ $karyawan->no_program_pensiun ?? '' }}"
                                                                            placeholder="Masukkan No. Program Pensiun" >
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">No. Program ASKES</label>
                                                                        <input type="text" name="noprogramAskes" class="form-control" value="{{ $karyawan->no_program_askes ?? '' }}"
                                                                            placeholder="Masukkan No. Program ASKES" >
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                    <label class="form-label">Nama Bank <span style="color: red;">*</span></label>
                                                                    <select class="form-control selectpicker" name="nama_bank" data-live-search="true" required>
                                                                        <option value="">Pilih Bank</option>
                                                                        @foreach ($bank as $bankItem)
                                                                            <option value="{{ $bankItem->nama_bank }}" {{ $karyawan->nama_bank == $bankItem->nama_bank ? 'selected' : '' }}>
                                                                                {{ $bankItem->nama_bank }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">No. Rekening <span style="color: red;">*</span></label>
                                                                        <input type="number" name="norekKaryawan" class="form-control" value="{{ $karyawan->no_rek ?? '' }}"
                                                                            placeholder="Masukkan No. Rekening" required>
                                                                    </div>
                                                                </div>
                                                                {{-- @if(Auth::check() && Auth::user()->role === 6) --}}
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Gaji Pokok <span style="color: red;">*</span></label>
                                                                        <input type="text" name="gaji" class="form-control input-formats" value="{{ number_format($karyawan->gaji, 0, ',', '.') ?? '' }}" placeholder="Masukkan Gaji Pokok" required>
                                                                    </div>
                                                                </div>
                                                                {{-- @endif --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    {{-- <button type="submit" id="btnsimpan" name="submit" class="btn btn-sm btn-primary">Simpan</button> --}}
                                                    <button type="submit"  name="submit" id="btnselanjutnya" class="btn btn-sm btn-success">Simpan & Selanjutnya <i class="fa fa-forward"></i></button>
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
