@extends('layouts.default')
@section('content')
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
        <form action="{{ route('store.data.karyawan') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')
            <div class=" col-sm-0 m-b-0"></div>
            <div class="modal-body">
                <div class="col-md-4">
                    <label class="">
                        <h4> A. DATA DIRI</h4>
                    </label>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">NIK Karyawan *</label>
                                        <p style="text-transform: uppercase;">{{ $karyawan->nik }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Nama lengkap *</label>
                                        <p style="text-transform: uppercase;">{{ $karyawan->nama }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Tanggal Lahir *</label>
                                        <p style="text-transform: uppercase;">{{ $karyawan->tgllahir }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Tempat Lahir *</label>
                                        <p style="text-transform: uppercase;">{{ $karyawan->tempatlahir }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Nomor Induk Kependudukan (NIK) *</label>
                                        <p style="text-transform: uppercase;">{{ $karyawan->nik }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Jenis Kelamin *</label>
                                        @if ($karyawan->jenis_kelamin == 'P')
                                            <p>Perempuan</p>
                                        @else
                                            <p>Laki-Laki</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Nomor NPWP *</label>
                                        <p style="text-transform: uppercase;">{{ $karyawan->no_npwp }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Nomor Asuransi AKDHK</label>
                                        <p style="text-transform: uppercase;">{{ $karyawan->no_akdhk }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 pl-0">
                        <div class="form-group mb-3">
                            <div class="row align-items-end">
                                <div class="col-md mb-md-0 m-l-15">
                                    <label class="font-size-14 fw-bold">Nama Bank *</label>
                                    <p>{{ $karyawan->nama_bank }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-4">
                    <label class="">
                        <h4 class="text-white">#</h4>
                    </label>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">E-Mail *</label>
                                        <p>{{ $karyawan->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Agama *</label>
                                        <p>{{ $karyawan->agama }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Golongan Darah *</label>
                                        <p>{{ $karyawan->gol_darah }} </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Alamat *</label>
                                        <p>{{ $karyawan->alamat }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">No. Handphone *</label>
                                        <p>{{ $karyawan->no_hp }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Tanggal Masuk *</label>
                                        <p>{{ $karyawan->tglmasuk }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">No. BPJS Ketenagakerjaan *</label>
                                        <p>{{ $karyawan->no_bpjs_ket }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">No. Program Pensiun *</label>
                                        <p>{{ $karyawan->no_bpjs_ket }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="">
                        <h4 class="text-white">#</h4>
                    </label>
                    <div class="row my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Departemen *</label>
                                        <p>{{ $karyawan->departemens->nama_departemen }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Jabatan *</label>
                                        <p>{{ $karyawan->nama_jabatan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Status Karyawan *</label>
                                        <p>{{ $karyawan->status_karyawan }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Atasan Langsung *</label>
                                        <p>{{ $atasan_pertama_nama }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Atasan (Asisten Manajer/Manajer/Direktur)</label>
                                        @if (!empty($atasan_kedua_nama))
                                            <p>{{ $atasan_kedua_nama }}</p>
                                        @else
                                            <p>-</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Nomor Kartu Keluarga *</label>
                                        <p>{{ $karyawan->no_kk }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">No. BPJS Kesehatan *</label>
                                        <p>{{ $karyawan->no_bpjs_kes }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">No. Program ASKES *</label>
                                        <p>{{ $karyawan->no_bpjs_kes }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">No. Rekening *</label>
                                        <p>{{ $karyawan->no_rek }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>


            </div>

            <div id="data-keluarga">
                <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                    <label>
                        <h4>B. DATA KELUARGA </h4>
                    </label>
                    <table class="table table-striped">
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Hubungan</th>
                                {{-- <th>Alamat</th> --}}
                                <th>Pendidikan Terakhir</th>
                                <th>Pekerjaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datakeluarga as $keluarga)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $keluarga['nama'] }}</td>
                                    <td>{{ $keluarga['tgllahir'] }}</td>
                                    <td>{{ $keluarga['hubungan'] }}</td>
                                    {{-- <td>{{$keluarga['alamat']}}</td> --}}
                                    <td>{{ $keluarga['pendidikan_terakhir'] }}</td>
                                    <td>{{ $keluarga['pekerjaan'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="kontak-darurat">
                <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                    <label>
                        <h4>C. KONTAK DARURAT </h4>
                    </label>
                    <table class="table table-striped">
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Hubungan Keluarga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kontakdarurat as $kd)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $kd['nama'] }}</td>
                                    <td>{{ $kd['no_hp'] }}</td>
                                    <td>{{ $kd['alamat'] }}</td>
                                    <td>{{ $kd['hubungan'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="riwayat-pendidikan">
                <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                    <label class="" width="100%">
                        <h4>D. RIWAYAT PENDIDIKAN</h4>
                    </label><br>
                    <table class="table table-striped">
                        <label class="text-white badge bg-info">Pendidikan Formal</label>
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                <th>Tingkat Pendidikan</th>
                                <th>Nama Sekolah</th>
                                <th>Alamat</th>
                                <th>Jurusan</th>
                                <th>Tahun Lulus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendidikan as $p)
                                @if ($p['tingkat'] != null)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $p['tingkat'] }}</td>
                                        <td>{{ $p['nama_sekolah'] }}</td>
                                        <td>{{ $p['kota_pformal'] }}</td>
                                        <td>{{ $p['jurusan'] }}</td>
                                        <td>{{ $p['tahun_lulus_formal'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                    <label class="text-white badge bg-info">Pendidikan Non Formal</label>
                    <table class="table table-striped">
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                <th>Jenis/Bidang Pendidikan</th>
                                <th>Alamat</th>
                                <th>Tahun Lulus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendidikan as $nf)
                                @if ($nf['jenis_pendidikan'] != null)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $nf['jenis_pendidikan'] }}</td>
                                        <td>{{ $nf['kota_pnonformal'] }}</td>
                                        <td>{{ $nf['tahun_lulus_nonformal'] }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="riwayat-pekerjaan">
                <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                    <label class="" width="100%">
                        <h4>E. RIWAYAT PEKERJAAN</h4>
                    </label>
                    <table class="table table-striped">
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                <th>Perusahaan</th>
                                <th>Alamat</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
                                <th>Jabatan</th>
                                <th>Level</th>
                                <th>Gaji</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pekerjaan as $pek)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pek['nama_perusahaan'] }}</td>
                                    <td>{{ $pek['alamat'] }}</td>
                                    <td>{{ $pek['tgl_mulai'] }}</td>
                                    <td>{{ $pek['tgl_selesai'] }}</td>
                                    <td>{{ $pek['jabatan'] }}</td>
                                    <td>{{ $pek['level'] }}</td>
                                    <td>{{ $pek['gaji'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="riwayat-organisasi">
                <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                    <label class="" width="100%">
                        <h4>F. RIWAYAT ORGANISASI</h4>
                    </label>
                    <table class="table table-striped">
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                <th>Lembaga</th>
                                <th>Alamat</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Jabatan</th>
                                <th>Nomor SK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($organisasi as $org)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $org['nama_organisasi'] }}</td>
                                    <td>{{ $org['alamat'] }}</td>
                                    <td>{{ $org['tgl_mulai'] }}</td>
                                    <td>{{ $org['tgl_selesai'] }}</td>
                                    <td>{{ $org['jabatan'] }}</td>
                                    <td>{{ $org['no_sk'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="riwayat-organisasi">
                <div class="modal-body" style="margin-left:15px;margin-right:15px;">
                    <label class="" width="100%">
                        <h4>H. RIWAYAT PRESTASI </h4>
                    </label>
                    <table class="table table-striped">
                        <thead class="alert alert-info">
                            <tr>
                                <th>No</th>
                                <th>Perihal / Keterangan</th>
                                <th>Instansi Pemberi</th>
                                <th>Alamat</th>
                                <th>Nomor Surat</th>
                                <th>Tanggal Surat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($prestasi as $pres)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pres['keterangan'] }}</td>
                                    <td>{{ $pres['nama_instansi'] }}</td>
                                    <td>{{ $pres['alamat'] }}</td>
                                    <td>{{ $pres['no_surat'] }}</td>
                                    <td>{{ $pres['tanggal_surat'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <a href="/create-data-pekerjaan" class="btn btn-sm btn-info"><i class="fa fa-backward"></i> Perbaiki</a>
                <button type="submit" name="submit" class="btn btn-sm btn-success"><strong><i
                            class="fa fa-paper-plane"></i></strong> Simpan Data</button>
            </div>
        </form>

    </div>
@endsection
