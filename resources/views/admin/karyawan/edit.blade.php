@extends('layouts.default')
@section('content')

<!-- Header -->
<div class="row">
    <div class="col-sm-12">

        <div class="page-header-title">
            <h4 class="pull-left page-title ">Edit Karyawan</h4>

            <ol class="breadcrumb pull-right">
                <li>Rynest Employee Management System</li>
                <li class="active">Edit Karyawan</li>
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


    <form action="karyawanupdate{{$karyawan->id}}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('put')

        <div class="modal-body">
            <div class="modal-header bg-info panel-heading  col-sm-15 m-b-2 ">
                <label class=""><h4>A. IDENTITAS </h4></label>
            </div>
            <br>
            <div  class="row">
                <div class="col-md-6">

                    <div class="form-group">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input name="namaKaryawan" type="text" class="form-control" value="{{$karyawan->nama}}">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="mb-3">
                           <label>NIK</label> 
                           <input name="nikKaryawan" type="text" class="form-control" autocomplete="off" value="{{$karyawan->nik}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                           <label>Tanggal Lahir</label> 
                            <input name="tgllahirKaryawan" type="text" autocomplete="off"
                                class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose17" autocomplete="off"
                                value="{{\Carbon\Carbon::parse($karyawan->tgllahir)->format('Y/m/d')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                           <label>Jenis Kelamin</label> 
                           <select class="form-control selectpicker" name="jenis_kelaminKaryawan" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" @if($karyawan->jenis_kelamin == "L") selected @endif >Laki-Laki</option>
                            <option value="P" @if($karyawan->jenis_kelamin == "P") selected @endif >Perempuan</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                           <label>Email</label> 
                           <input type="text" name="emailKaryawan" class="form-control" autocomplete="off" value="{{$karyawan->email}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                           <label>Agama</label> 
                           <select class="form-control selectpicker" name="agamaKaryawan">
                                <option value="">Pilih Agama</option>
                                <option value="Islam" @if($karyawan->agama == "Islam") selected @endif>Islam</option>
                                <option value="Kristen" @if($karyawan->agama == "Kristen") selected @endif>Kristen</option>
                                <option value="Katholik" @if($karyawan->agama == "Katholik") selected @endif>Katholik</option>
                                <option value="Hindu" @if($karyawan->agama == "Hindu") selected @endif>Hindu</option>
                                <option value="Budha" @if($karyawan->agama == "Budha") selected @endif>Budha</option>
                                <option value="Khong Hu Chu" @if($karyawan->agama == "Khong Hu Chu") selected @endif>Khong Hu Chu</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                           <label>Golongan Darah</label> 
                           <select class="form-control selectpicker" name="gol_darahKaryawan" required>
                            <option value="">Pilih Golongan Darah</option>
                            <option value="A" @if($karyawan->gol_darah == "A") selected @endif >A</option>
                            <option value="B" @if($karyawan->gol_darah == "B") selected @endif >B</option>
                            <option value="AB" @if($karyawan->gol_darah == "AB") selected @endif >AB</option>
                            <option value="O" @if($karyawan->gol_darah == "O") selected @endif >O</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                           <label>Alamat</label> 
                           <input name="alamatKaryawan" type="text" class="form-control" autocomplete="off" value="{{$karyawan->alamat}}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Pilih Foto Karyawan</label><br>
                            <img class="img-preview img-fluid mb-6 col-sm-5"
                            src="{{ asset('Foto_Profile/' . $karyawan->foto)}}" alt="Tidak ada foto profil." style="width:205px;" >
                        <br><input type="file" name="foto" class="form-control" id="foto" onchange="previewImage()">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                           <label>Nomor Handphone</label> 
                           <input name="no_hpKaryawan" type="text" autocomplete="off" class="form-control" value="{{$karyawan->no_hp}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Departemen</label>
                        <select class="form-control selectpicker" name="divisi" data-live-search="true" required>
                            <option value="">Pilih Departemen</option>
                            @foreach ($departemen as $d)
                                <option value="{{ $d->id }}"
                                    @if($karyawan->divisi == $d->id)
                                        selected
                                    @endif>{{ $d->nama_departemen }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Atasan Langsung (Asistant Manager/Manager/Direksi)</label>
                        <select class="form-control selectpicker" name="atasan_pertama" data-live-search="true">
                            <option value="">Pilih Atasan Langsung</option>
                            @foreach ($atasan_pertama as $atasan)
                                <option value="{{ $atasan->id }}"
                                    @if($karyawan->atasan_pertama == $atasan->id)
                                        selected
                                    @endif>{{ $atasan->nama }}
                                </option>
                                   
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Atasan/Pimpinan (Manager/Direksi)</label>
                        <select class="form-control selectpicker" name="atasan_kedua"  data-live-search="true">
                            <option value="">Pilih Atasan</option>
                            @foreach ($atasan_kedua as $atasan)
                                <option value="{{ $atasan->id}}"
                                    @if($karyawan->atasan_kedua == $atasan->id)
                                        selected
                                    @endif>{{ $atasan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="mb-3">
                           <label>Jabatan</label> 
                           <select type="text" class="form-control selectpicker" name="jabatanKaryawan" required>
                            <option value="">Pilih Jabatan</option>
                            <option value="Direksi" @if($karyawan->jabatan == "Direksi") selected @endif >Direksi</option>
                            <option value="Manager" @if($karyawan->jabatan == "Manager") selected @endif >Manager</option>
                            <option value="Asistant Manager" @if($karyawan->jabatan == "Asistant Manager") selected @endif >Asistant Manager</option>
                            <option value="HRD" @if($karyawan->jabatan == "HRD") selected @endif >HRD</option>
                            <option value="Staff" @if($karyawan->jabatan == "Staff") selected @endif >Staff</option>
                        </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 modal-header bg-info panel-heading">
                    <label><h4>B. KELUARGA </h4></label><br>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-6">
                    <div class="m-b-5 modal-header bg-info">
                        <label class="text-white">Data Istri / Suami *)</label>
                    </div><br>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Status Pernikahan</label>
                            <select type="text" class="form-control selectpicker" name="status_pernikahan" required>
                                <option value="">Pilih Status Pernikahan</option>
                                <option value="Belum" @if($keluarga->status_pernikahan == "Belum") selected @endif >Belum Menikah</option>
                                <option value="Sudah" @if($keluarga->status_pernikahan == "Sudah") selected @endif >Sudah Menikah</option>
                            </select>
                        </div>
                    </div>
            
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Nama Pasangan</label>
                            <input type="text" name="namaPasangan" class="form-control" autocomplete="off" value="{{$keluarga->nama}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Tanggal Lahir </label>
                            <input type="text" name="tgllahirPasangan" autocomplete="off" class="form-control" placeholder="yyyy/mm/dd" id="datepicker-autoclose16" value="{{\Carbon\Carbon::parse($keluarga->tgllahir)->format('Y/m/d')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhirPasangan" autocomplete="off" class="form-control" value="{{$keluarga->pendidikan_terakhir}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Alamat</label>
                            <input type="text" name="alamatPasangan" class="form-control" autocomplete="off" value="{{$keluarga->alamat}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Pekerjaan</label>
                            <input type="text" name="pekerjaanPasangan" autocomplete="off" class="form-control" value="{{$keluarga->pekerjaan}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="modal-header bg-info">
                        <label class="text-white">Kontak Darurat</label>
                    </div><br>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Nama Lengkap</label>
                            <input type="text" name="namaKdarurat" class="form-control" autocomplete="off" value="{{$kdarurat->nama}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Alamat </label>
                            <input type="text" name="alamatKdarurat" class="form-control" autocomplete="off" value="{{$kdarurat->alamat}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Nomor Handphone</label>
                            <input type="text" name="no_hpKdarurat" autocomplete="off" class="form-control" value="{{$kdarurat->no_hp}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Hubungan</label>
                            <select type="text" class="form-control selectpicker" name="hubunganKdarurat" required>
                                <option value="">Pilih Hubungan</option>
                                <option value="Ayah" @if($kdarurat->hubungan == "Ayah") selected @endif >Ayah</option>
                                <option value="Ibu"  @if($kdarurat->hubungan == "Ibu") selected @endif >Ibu</option>
                                <option value="Suami" @if($kdarurat->hubungan == "Suami") selected @endif>Suami</option>
                                <option value="Istri" @if($kdarurat->hubungan == "Istri") selected @endif>Istri</option>
                                <option value="Kakak" @if($kdarurat->hubungan == "Kakak") selected @endif>Kakak</option>
                                <option value="Adik" @if($kdarurat->hubungan == "Adik") selected @endif>Adik</option>
                                <option value="Anak" @if($kdarurat->hubungan == "Anak") selected @endif>Anak</option>
                            </select>
                        
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 modal-header bg-info panel-heading">
                    <label><h4>C. RIWAYAT PENDIDIKAN </h4></label><br>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6">
                    <div class="m-b-5 modal-header bg-info">
                        <label class="text-white">Pendidikan Formal</label>
                    </div><br>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Tingkat Pendidikan</label>
                            <input type="text" name="tingkat_pendidikan" autocomplete="off"
                                class="form-control" value="{{$rpendidikan->tingkat}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Nama Sekolah</label>
                            <input type="text" name="nama_sekolah" class="form-control" autocomplete="off"
                            value="{{$rpendidikan->nama_sekolah}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Kota</label>
                            <input type="text" name="kotaPendidikanFormal" class="form-control" autocomplete="off"
                            value="{{$rpendidikan->kota_pformal}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Jurusan</label>
                            <input type="text" name="jurusan" class="form-control" autocomplete="off"
                                value="{{$rpendidikan->jurusan}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Lulus Tahun</label>
                            <div class="input-group">
                                <input id="datepicker-autoclose3" type="text"
                                        class="form-control" value="{{$rpendidikan->tahun_lulus_formal}}" placeholder="yyyy" id="4"
                                        name="tahun_lulusFormal" rows="10" autocomplete="off"><br>
                                <span class="input-group-addon bg-custom b-0"><i
                                            class="mdi mdi-calendar text-white"></i></span>
                            </div>
                            {{-- <input type="text" name="tahun_lulus_formal" autocomplete="off"
                            class="form-control" placeholder="yyyy"
                            value="{{$rpendidikan->tahun_lulus_formal}}"> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="m-b-5 modal-header bg-info">
                        <label class="text-white">Pendidikan Non Formal</label>
                    </div><br>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Bidang/ Jenis Pendidikan</label>
                            <input type="text" name="jenis_pendidikan" autocomplete="off"
                            class="form-control" value="{{$rpendidikan->jenis_pendidikan}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Kota</label>
                            <input type="text" name="kotaPendidikanNonFormal" autocomplete="off"
                            class="form-control" value="{{$rpendidikan->kota_pnonformal}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Lulus Tahun</label>
                            <div class="input-group">
                                <input id="datepicker-autoclose4" type="text"
                                        class="form-control" placeholder="yyyy" id="4"  value="{{$rpendidikan->tahun_lulus_nonformal}}"
                                        name="tahunLulusNonFormal" autocomplete="off" rows="10"><br>
                                <span class="input-group-addon bg-custom b-0"><i
                                            class="mdi mdi-calendar text-white"></i></span>
                            </div>
                            {{-- <input type="text" name="tahunLulusNonFormal" autocomplete="off"
                                class="form-control" placeholder="yyyy"
                                value="{{$rpendidikan->tahun_lulus_nonformal}}"> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 modal-header bg-info panel-heading">
                    <label><h4>D. RIWAYAT PEKERJAAN</h4></label><br> 
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Nama Perusahaan</label>
                            <input type="text" name="namaPerusahaan" autocomplete="off"
                            class="form-control" value="{{$rpekerjaan->nama_perusahaan}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Alamat Perusahaan</label>
                            <input type="text" name="alamatPerusahaan" autocomplete="off"
                            class="form-control" value="{{$rpekerjaan->alamat}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Jenis Usaha</label>
                            <input type="text" name="jenisUsaha" class="form-control" autocomplete="off"
                            value="{{$rpekerjaan->jenis_usaha}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Nama Direksi</label>
                            <input type="text" name="namaDirektur" class="form-control" autocomplete="off"
                            value="{{$rpekerjaan->nama_direktur}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Nama Atasan Langsung</label>
                            <input type="text" name="namaAtasan" autocomplete="off"
                            class="form-control" value="{{$rpekerjaan->nama_atasan}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" autocomplete="off"
                            value="{{$rpekerjaan->jabatan}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Lama Kerja</label>
                            <input type="text" name="lamaKerja" class="form-control" autocomplete="off"
                            value="{{$rpekerjaan->lama_kerja}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Alasan Berhenti</label>
                            <input type="text" name="alasanBerhenti" autocomplete="off"
                            class="form-control" value="{{$rpekerjaan->alasan_berhenti}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label>Gaji</label>
                            <input type="text" name="gajiRpekerjaan" id="gaji" autocomplete="off"
                            class="form-control" value="{{$rpekerjaan->gaji}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <input type="hidden" name="id_karyawan" value="{{$karyawan->id}}">
            <input type="hidden" name="id_pendidikan" value="{{$rpendidikan->id}}">
            <input type="hidden" name="id_keluarga" value="{{$keluarga->id}}">
            <input type="hidden" name="id_pekerjaan" value="{{$rpekerjaan->id}}">
            <input type="hidden" name="id_kdarurat" value="{{$kdarurat->id}}">
            <button type="submit" name="submit" class="btn btn-sm btn-primary">Simpan</button>
            <a href="karyawanshow{{$karyawan->id}}" class="btn btn-sm btn-danger">Kembali</a>
    </form>
</div>


<!-- <tbody> -->


<!-- <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">NIK</label>
                            <input type="text" class="form-control" name="nik" id="nik" value="">
                        </div>         -->

<!-- <tr>
                            <td><label for="exampleInputEmail1" class="form-label">NIP</label>
                            <input type="text" class="form-control" name="nip" id="nip" value="{{$karyawan->nip}}"></td>
                            <td><span  class="text-bold" ></span></td>
                            <td></td>
                            <td><label for="name" class="text-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="{{$karyawan->nama}}"></td>
                        </tr>
                       
                        <tr>

                            <td><label for="dob">Tanggal Lahir </label>
                            <div>
                            <input id="datepicker-autoclose5" class="form-control" name="tgllahir" value="{{$karyawan->tgllahir}}"></td>
                            <td><span id="dob"></span></td>

                            <td rowspan="13"></td>
                            <td rowspan="4" colspan="2" class="text-center">
                                <img  class="img-preview img-fluid mb-3 col-sm-5" src="{{ asset('Foto_Profile/' . $karyawan->foto)}}" alt="Tidak ada foto profil." style="width:185px; ">
                                <label >Pilih Foto Karyawan</label>
                                <input type="file" name="foto" class="form-control" id="foto" onchange="previewImage()" >
                            </td>

                        </tr>

                        <tr>
                            <td><label for="phone_number">Nomor Handphone </label>
                            <input type="number" class="form-control" name="no_hp" id="no_hp" value="{{$karyawan->no_hp}}"></td>
                            <td><span id="phone_number"></span></td>
                        </tr>

                        <tr>
                            <td><label for="ktp_number">No. KTP</label>
                            <input type="number" class="form-control" name="nik" id="nik" value="{{$karyawan->nik}}"></td>
                            <td><span id="ktp_number"></span></td>
                        </tr>

                        <tr>
                            <td><label for="kk_number">No. KK</label>
                            <input type="number" class="form-control" name="no_kk" id="no_kk" value="{{$karyawan->no_kk}}"></td>
                            <td><span id="kk_number"></span></td>
                        </tr>

                        <tr>
                            <td><label for="gender">Jenis Kelamin </label>
                            <select class="form-control" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" @if($karyawan->jenis_kelamin == "L") selected @endif >Laki-Laki</option>
                                <option value="P" @if($karyawan->jenis_kelamin == "P") selected @endif >Perempuan</option>
                            </select></td>
                            <td><span id="gender"></span></td>
                            
                            
                            <td><label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{$karyawan->email}}"></td>
                            <td><span id="email"></span></td>
                        </tr>

                        <tr>
                            <td><label for="employee_status">Status Karyawan</label>
                            <select class="form-control" name="status_karyawan" required>
                                <option value="">Pilih Status Karyawan</option>
                                <option value="Tetap" @if($karyawan->status_karyawan == "Tetap") selected @endif>Tetap</option>
                                <option value="Kontrak" @if($karyawan->status_karyawan == "Kontrak") selected @endif>Kontrak</option>
                                <option value="Probation" @if($karyawan->status_karyawan == "Probation") selected @endif>Probation</option>
                            </select></td>
                            <td><span id="employee_status"></span></td>
                            
                            <td><label for="contract_duration">Durasi Kontrak </label>
                            <input type="text" class="form-control" name="kontrak" id="kontrak" value="{{$karyawan->kontrak}}"></td>
                            <td><span id="contract_duration"></span></td>
                        </tr>

                        <tr>
                            <td><label for="status">Status Kerja</label>
                            <select class="form-control" name="status_kerja" required>
                                <option value="">Pilih Status Karyawan</option>
                                <option value="Aktif" @if($karyawan->status_kerja == "Aktif") selected @endif >Aktif</option>
                                <option value="Non-Aktif" @if($karyawan->status_kerja == "Non-Aktif") selected @endif>Non-Aktif</option>
                            </select></td>
                            <td><span id="status"></span></td>

                            <td><label for="employee_type">Tipe Karyawan</label>
                            <select class="form-control" name="tipe_karyawan" required>
                                <option value="">Pilih Tipe Karyawan</option>
                                <option value="Fulltime" @if($karyawan->tipe_karyawan == "Fulltime") selected @endif>Fulltime</option>
                                <option value="Freelance" @if($karyawan->tipe_karyawan == "Freelance") selected @endif>Freelance</option>
                                <option value="Magang" @if($karyawan->tipe_karyawan == "Magang") selected @endif>Magang</option>
                            </select></td>
                            <td><span id="employee_type"></span></td>
                        </tr>

                        <tr>
                            <td><label for="start_work_date">Tanggal Mulai Bekerja</label>
                            <input type="text" class="form-control" id="datepicker-autoclose6" name="tglmasuk" value="{{$karyawan->tglmasuk}}" ></input></td>
                            <td><span id="start_work_date"></span></td>

                            <td><label for="end_work_date">Tanggal Akhir Bekerja</label>
                            <input type="text" class="form-control" id="datepicker-autoclose7" name="tglkeluar" value="{{$karyawan->tglkeluar}}" ></input></td>
                            <td><span id="end_work_date"></span></td>
                        </tr>

                        <tr>
                            <td><label for="npwp_number">No. NPWP</label>
                            <input type="number" class="form-control" name="no_npwp" id="no_npwp" value="{{$karyawan->no_npwp}}"></td>
                            <td><span id="npwp_number"></span></td>
                            
                            <td><label for="role_name">Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat" value="{{$karyawan->alamat}}"></td>
                            <td><span id="role_name"></span></td>
                        </tr>
                        <tr>
                            <td><label for="division_name">Divisi</label>
                            <input type="text" class="form-control" name="divisi" id="divisi" value="{{$karyawan->divisi}}"></td>
                            <td><span id="division_name"></span></td>

                            <td><label for="position_name">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{$karyawan->jabatan}}"></td>
                            <td><span id="position_name"></span></td>
                        </tr>

                        <tr>
                            <td><label for="cc_number">No. Rekening</label>
                            <input type="number" class="form-control" name="no_rek" id="no_rek" value="{{$karyawan->no_rek}}"></td>
                            <td><span id="cc_number"></span></td>

                            <td><label for="salary">Gaji Pokok</label>
                            <input type="text" class="form-control" name="gaji" id="gaji" value="{{$karyawan->gaji}}"></td>
                            <td><span id="salary"></span></td>
                        </tr>
                        <tr>
                            <td><label for="bpjskes_number">No. BPJS Kesehatan</label>
                            <input type="number" class="form-control" name="no_bpjs_kes" id="no_bpjs_kes" value="{{$karyawan->no_bpjs_kes}}"></td>
                            <td><span ></span></td>

                            <td><label >No. BPJS Ketenagakerjaan</label>
                            <input type="number" class="form-control" name="no_bpjs_ket" id="no_bpjs_ket" value="{{$karyawan->no_bpjs_ket}}"></td>
                            <td><span ></span></td>
                        </tr>
                      
                        
                    </tbody> -->



<script>
    var rupiah = document.getElementById('gaji');
rupiah.addEventListener('keyup', function(e){
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah(this.value);
});
/* Fungsi formatRupiah */
function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
}

function previewImage(){

const image = document.querySelector('#foto');
const imgPreview =document.querySelector('.img-preview');

    imgPreview.style.display = 'block';

const oFReader = new FileReader();
oFReader.readAsDataURL(image.files[0]);

oFReader.onload = function(oFREvent){
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