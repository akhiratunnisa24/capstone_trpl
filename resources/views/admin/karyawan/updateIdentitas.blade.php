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
                <h4 class="pull-left page-title ">Edit Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Edit Karyawan</li>
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
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-20 col-sm-20 col-xs-20">
                            <form action="updateidentitas{{ $karyawan->id }}" method="POST" enctype="multipart/form-data">

                                @csrf
                                @method('PUT')

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
                                                                <label class="form-label col-sm-4">Pilih Foto
                                                                    Karyawan</label>
                                                                <img class="img-preview img-fluid mb-6 col-sm-5"
                                                                    src="{{ asset('Foto_Profile/' . $karyawan->foto) }}"
                                                                    alt="Tidak ada foto profil." style="width:299px;">
                                                                <input type="file" name="foto" class="form-control"
                                                                    id="foto" onchange="previewImage()">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">NIK Karyawan</label>
                                                                <input name="nipKaryawan" type="text"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $karyawan->nip ?? '-' }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Lengkap</label>
                                                                <input name="namaKaryawan" type="text"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $karyawan->nama ?? '-' }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Tanggal Lahir</label>

                                                                <div class="input-group">
                                                                    {{-- <input id="datepicker-autoclose36" type="text" class="form-control"
                                                                            name="tgllahirKaryawan" value="{{\Carbon\Carbon::parse($karyawan->tgllahir)->format('Y/m/d') ?? '-' }}" autocomplete="off" > --}}
                                                                    <input id="datepicker-autoclose36" type="text"
                                                                        class="form-control" name="tgllahirKaryawan"
                                                                        value="{{ $karyawan->tgllahir ?? '-' }}"
                                                                        autocomplete="off">
                                                                    <span class="input-group-addon bg-custom b-0"><i
                                                                            class="mdi mdi-calendar"></i></span>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Kota Kelahiran</label>
                                                                <input name="tempatlahirKaryawan" type="text"
                                                                    class="form-control" autocomplete="off"
                                                                    value="{{ $karyawan->tempatlahir ?? '-' }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label">Jenis Kelamin</label>
                                                            <select class="form-control" name="jenis_kelaminKaryawan">
                                                                <option value="">Pilih Jenis Kelamin</option>
                                                                <option value="Laki-Laki"
                                                                    @if ($karyawan->jenis_kelamin == 'Laki-Laki') selected @endif>
                                                                    Laki-Laki</option>
                                                                <option value="Perempuan"
                                                                    @if ($karyawan->jenis_kelamin == 'Perempuan') selected @endif>
                                                                    Perempuan</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label">Departemen</label>
                                                            <select class="form-control" name="divisi">
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
                                                            <label class="form-label">Atasan Langsung
                                                                (SPV/Manajer/Direktur)</label>
                                                            <select class="form-control" name="atasan_pertama"
                                                                data-live-search="true">
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
                                                            <label class="form-label">Atasan (Manajer/Direktur)</label>
                                                            <select class="form-control" name="atasan_kedua"
                                                                data-live-search="true">
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
                                                            <label class="form-label">Nama Jabatan</label>
                                                            <select class="form-control" name="namaJabatan">
                                                                <option value="">Pilih Nama Jabatan</option>
                                                                @foreach ($namajabatan as $nama)
                                                                    <option value="{{ $nama->nama_jabatan }}"
                                                                        {{ $karyawan->nama_jabatan == $nama->nama_jabatan ? 'selected' : '' }}>
                                                                        {{ $nama->nama_jabatan ?? '' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label">Level Jabatan</label>
                                                            <select class="form-control" name="jabatanKaryawan">
                                                                <option value="">Pilih Level Jabatan</option>
                                                                @foreach ($leveljabatan as $level)
                                                                    <option value="{{ $level->nama_level }}"
                                                                        {{ $karyawan->jabatan == $level->nama_level ? 'selected' : '' }}>
                                                                        {{ $level->nama_level ?? '' }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label">Status Karyawan</label>
                                                            <select class="form-control" name="statusKaryawan">
                                                                <option value="">Pilih Status Karyawan</option>
                                                                <option value="Tetap"
                                                                    @if ($karyawan->status_karyawan == 'Tetap') selected @endif>Tetap
                                                                </option>
                                                                <option value="Kontrak"
                                                                    @if ($karyawan->status_karyawan == 'Kontrak') selected @endif>
                                                                    Kontrak</option>
                                                                <option value="Probation"
                                                                    @if ($karyawan->status_karyawan == 'Probation') selected @endif>
                                                                    Probation</option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="form-label">Golongan Darah</label>
                                                            <select class="form-control" name="gol_darahKaryawan">
                                                                <option value="">Pilih Golongan Darah</option>
                                                                <option value="A"
                                                                    @if ($karyawan->gol_darah == 'A') selected @endif>A
                                                                </option>
                                                                <option value="B"
                                                                    @if ($karyawan->gol_darah == 'B') selected @endif>B
                                                                </option>
                                                                <option
                                                                    value="AB"@if ($karyawan->gol_darah == 'AB') selected @endif>
                                                                    AB</option>
                                                                <option value="O"
                                                                    @if ($karyawan->gol_darah == 'O') selected @endif>O
                                                                </option>
                                                            </select>
                                                        </div>



                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Alamat</label>
                                                                <textarea name="alamatKaryawan" class="form-control" rows="5">{{ $karyawan->alamat ?? '' }}</textarea>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-- baris sebelah kanan  -->

                                                    <div class="col-md-6 m-t-10">
                                                        <div class="form-group">



                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Status Pernikahan</label>
                                                                    <select class="form-control" name="status_pernikahan">
                                                                        <option value="">Pilih Status Pernikahan
                                                                        </option>
                                                                        <option value="Sudah Menikah"
                                                                            @if ($karyawan->status_pernikahan == 'Sudah Menikah') selected @endif>
                                                                            Sudah Menikah</option>
                                                                        <option value="Belum Menikah"
                                                                            @if ($karyawan->status_pernikahan == 'Belum Menikah') selected @endif>
                                                                            Belum Menikah</option>
                                                                        <option value="Duda"
                                                                            @if ($karyawan->status_pernikahan == 'Duda') selected @endif>
                                                                            Duda</option>
                                                                        <option value="Janda"
                                                                            @if ($karyawan->status_pernikahan == 'Janda') selected @endif>
                                                                            Janda</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Jumlah Anak</label>
                                                                    <input type="number" name="jumlahAnak"
                                                                        value="{{ $karyawan->jumlah_anak ?? '' }}"
                                                                        class="form-control" autocomplete="off"
                                                                        placeholder="Masukkan Jumlah Anak">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Handphone</label>
                                                                    <input type="number" name="no_hpKaryawan"
                                                                        value="{{ $karyawan->no_hp ?? '' }}"
                                                                        class="form-control"
                                                                        placeholder="Masukkan Nomor Handphone">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alamat E-mail</label>
                                                                    <input type="email" name="emailKaryawan"
                                                                        value="{{ $karyawan->email ?? '' }}"
                                                                        class="form-control" placeholder="Masukkan Email"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Agama</label>
                                                                    <select class="form-control" name="agamaKaryawan">
                                                                        <option value="">Pilih Agama</option>
                                                                        <option value="Islam"
                                                                            @if ($karyawan->agama == 'Islam') selected @endif>
                                                                            Islam</option>
                                                                        <option value="Kristen"
                                                                            @if ($karyawan->agama == 'Kristen') selected @endif>
                                                                            Kristen</option>
                                                                        <option value="Katholik"
                                                                            @if ($karyawan->agama == 'Katholik') selected @endif>
                                                                            Katholik</option>
                                                                        <option value="Hindu"
                                                                            @if ($karyawan->agama == 'Hindu') selected @endif>
                                                                            Hindu</option>
                                                                        <option value="Budha"
                                                                            @if ($karyawan->agama == 'Budha') selected @endif>
                                                                            Budha</option>
                                                                        <option value="Khong Hu Chu"
                                                                            @if ($karyawan->agama == 'Khong Hu Chu') selected @endif>
                                                                            Khong Hu Chu</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tanggal Masuk</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control"
                                                                            placeholder="yyyy/mm/dd"
                                                                            id="datepicker-autoclose2"
                                                                            name="tglmasukKaryawan" rows="10"
                                                                            autocomplete="off"
                                                                            value="{{ $karyawan->tglmasuk ?? '' }}">
                                                                        <span class="input-group-addon bg-custom b-0"><i
                                                                                class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. KTP</label>
                                                                    <input type="number" name="nikKaryawan"
                                                                        class="form-control"
                                                                        value="{{ $karyawan->nik ?? '' }}"
                                                                        placeholder="Masukkan NIK">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Kartu Keluarga</label>
                                                                    <input type="number" name="nokkKaryawan"
                                                                        class="form-control"
                                                                        value="{{ $karyawan->no_kk ?? '' }}"
                                                                        placeholder="Masukkan No. Kartu Keluarga">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. NPWP</label>
                                                                    <input type="number" name="nonpwpKaryawan"
                                                                        class="form-control"
                                                                        value="{{ $karyawan->no_npwp ?? '' }}"
                                                                        placeholder="Masukkan No. NPWP">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. BPJS
                                                                        Ketenagakerjaan</label>
                                                                    <input type="number" name="nobpjsketKaryawan"
                                                                        class="form-control"
                                                                        value="{{ $karyawan->no_bpjs_ket ?? '' }}"
                                                                        placeholder="Masukkan No. BPJS Ketenagakerjaan">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. BPJS Kesehatan</label>
                                                                    <input type="number" name="nobpjskesKaryawan"
                                                                        class="form-control"
                                                                        value="{{ $karyawan->no_bpjs_kes ?? '' }}"
                                                                        placeholder="Masukkan No. BPJS Kesehatan">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Asuransi AKDHK</label>
                                                                    <input type="number" name="noAkdhk"
                                                                        class="form-control"
                                                                        value="{{ $karyawan->no_akdhk ?? '' }}"
                                                                        placeholder="Masukkan No. AKDHK">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Program Pensiun</label>
                                                                    <input type="number" name="noprogramPensiun"
                                                                        class="form-control"
                                                                        value="{{ $karyawan->no_program_pensiun ?? '' }}"
                                                                        placeholder="Masukkan No. Program Pensiun">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Program ASKES</label>
                                                                    <input type="number" name="noprogramAskes"
                                                                        class="form-control"
                                                                        value="{{ $karyawan->no_program_askes ?? '' }}"
                                                                        placeholder="Masukkan No. Program ASKES">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nama Bank</label>
                                                                    <select class="form-control" name="nama_bank"
                                                                        required>
                                                                        <option value="">Pilih Bank</option>
                                                                        <option value="Bank ANZ Indonesia" {{ $karyawan->nama_bank ?? '' == 'Bank ANZ Indonesia' ? 'selected' : '' }}>Bank ANZ Indonesia</option>
                                                                        <option value="Bank Bukopin" {{ $karyawan->nama_bank ?? '' == 'Bank Bukopin' ? 'selected' : '' }}>Bank Bukopin</option>
                                                                        <option value="Bank Central Asia (BCA)" {{ $karyawan->nama_bank ?? '' == 'Bank Central Asia (BCA)' ? 'selected' : '' }}>Bank Central Asia (BCA)</option>
                                                                        <option value="Bank Danamon" {{ $karyawan->nama_bank ?? '' == 'Bank Danamon' ? 'selected' : '' }} >Bank Danamon</option>
                                                                        <option value="Bank DBS Indonesia" {{ $karyawan->nama_bank ?? '' == 'Bank DBS Indonesia' ? 'selected' : '' }} >Bank DBS Indonesia</option>
                                                                        <option value="Bank HSBC Indonesia" {{ $karyawan->nama_bank ?? '' == 'Bank HSBC Indonesia' ? 'selected' : '' }} >Bank HSBC Indonesia</option>
                                                                        <option value="Bank Jabar Banten (BJB)" {{ $karyawan->nama_bank ?? '' == 'Bank Jabar Banten (BJB)' ? 'selected' : '' }} >Bank Jabar Banten (BJB)</option>
                                                                        <option value="Bank Mandiri" {{ $karyawan->nama_bank ?? '' == 'Bank Mandiri' ? 'selected' : '' }} >Bank Mandiri</option>
                                                                        <option value="Bank Maybank" {{ $karyawan->nama_bank ?? '' == 'Bank Maybank' ? 'selected' : '' }} >Bank Maybank</option>
                                                                        <option value="Bank Mega" {{ $karyawan->nama_bank ?? '' == 'Bank Mega' ? 'selected' : '' }} >Bank Mega</option>
                                                                        <option value="Bank Muamalat" {{ $karyawan->nama_bank ?? '' == 'Bank Muamalat' ? 'selected' : '' }} >Bank Muamalat</option>
                                                                        <option value="Bank Negara Indonesia (BNI)" {{ $karyawan->nama_bank ?? '' == 'Bank Negara Indonesia (BNI)' ? 'selected' : '' }} >Bank Negara Indonesia (BNI)</option>
                                                                        <option value="Bank OCBC NISP" {{ $karyawan->nama_bank ?? '' == 'Bank OCBC NISP' ? 'selected' : '' }} >Bank OCBC NISP</option>
                                                                        <option value="Bank Panin" {{ $karyawan->nama_bank ?? '' == 'Bank Panin' ? 'selected' : '' }} >Bank Panin</option>
                                                                        <option value="Bank Permata" {{ $karyawan->nama_bank ?? '' == 'Bank Permata' ? 'selected' : '' }} >Bank Permata</option>
                                                                        <option value="Bank Rakyat Indonesia (BRI)" {{ $karyawan->nama_bank ?? '' == 'Bank Rakyat Indonesia (BRI)' ? 'selected' : '' }} >Bank Rakyat Indonesia (BRI)</option>
                                                                        <option value="Bank Syariah Mandiri" {{ $karyawan->nama_bank ?? '' == 'Bank Syariah Mandiri' ? 'selected' : '' }} >Bank Syariah Mandiri</option>
                                                                        <option value="Bank Tabungan Negara (BTN)" {{ $karyawan->nama_bank ?? '' == 'Bank Tabungan Negara (BTN)' ? 'selected' : '' }} >Bank Tabungan Negara (BTN)</option>
                                                                        <option value="Bank UOB Indonesia" {{ $karyawan->nama_bank ?? '' == 'Bank UOB Indonesia' ? 'selected' : '' }} >Bank UOB Indonesia</option>
                                                                        <option value="Bank CIMB Niaga" {{ $karyawan->nama_bank ?? '' == 'Bank CIMB Niaga' ? 'selected' : '' }} >Bank CIMB Niaga</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Rekening</label>
                                                                    <input type="number" name="norekKaryawan"
                                                                        class="form-control"
                                                                        value="{{ $karyawan->no_rek ?? '' }}"
                                                                        placeholder="Masukkan No. Rekening">
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button class="btn btn-sm btn-success" type="submit">Simpan Data <i
                                                        class="fa fa-save (alias)"></i></button>
                                                <a href="showidentitas{{ $karyawan->id }}" class="btn btn-sm btn-danger"
                                                    type="button">Kembali <i class="fa fa-home"></i></a>
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

    <script>
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
@endsection
