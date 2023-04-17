    <head>
        <!-- Datapicker -->
        <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">


        <meta charset="utf-8" />
        <title>HRMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="shortcut icon" href="{{ asset('') }}assets/images/favicon2.png">

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    </head>

     <div class="container">
        <!-- Page-Title -->
        <div class="row" style="margin-top: 30px">
            <div class="col-sm-12">
                <div class="page-header-title">
                    <h4 class="pull-left page-title">Detail Pelamar</h4>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

    <div class="panel panel-primary">
        <form action="/store_Data" method="POST" enctype="multipart/form-data">
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
                                        <p style="text-transform: uppercase;">{{ $pelamar->nik ?? '-' }}</p>
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
                                        <p style="text-transform: uppercase;">{{ $pelamar->nama ?? '-' }}</p>
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
                                        <p style="text-transform: uppercase;">{{ $pelamar->tgllahir ?? '-' }}</p>
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
                                        <p style="text-transform: uppercase;">{{ $pelamar->tempatlahir ?? '-' }}</p>
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
                                        <p style="text-transform: uppercase;">{{ $pelamar->nik ?? '-' }}</p>
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
                                        @if ($pelamar->jenis_kelamin == 'Perempuan')
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
                                        <label class="font-size-14 fw-bold">E-Mail *</label>
                                        <p>{{ $pelamar->email ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Baris tengah  --}}

                <div class="col-md-4">
                    <label class="">
                        <h4 class="text-white">#</h4>
                    </label>
                    <div class="my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Agama *</label>
                                        <p>{{ $pelamar->agama ?? '-' }}</p>
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
                                        <p>{{ $pelamar->gol_darah ?? '-' }} </p>
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
                                        <p>{{ $pelamar->alamat ?? '-' }}</p>
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
                                        <p>{{ $pelamar->no_hp ?? '-' }}</p>
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
                                        <label class="font-size-14 fw-bold">Gaji yang diharapkan *</label>
                                        <p> Rp.{{ $pelamar->gaji ?? '-' }},-</p>
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
                                        <p style="text-transform: uppercase;">{{ $pelamar->no_npwp ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">Nomor Asuransi AKDHK</label>
                                        <p style="text-transform: uppercase;">{{ $pelamar->no_akdhk ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                {{-- Baris paling kanan  --}}
                <div class="col-md-4">
                    
                    <label class="">
                        <h4 class="text-white">#</h4>
                    </label>
                    <div class="row my-5">
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">No. BPJS Ketenagakerjaan *</label>
                                        <p>{{ $pelamar->no_bpjs_ket ?? '-' }}</p>
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
                                        <label class="font-size-14 fw-bold">No. Program Pensiun *</label>
                                        <p>{{ $pelamar->no_bpjs_ket ?? '-' }}</p>
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
                                        <p>{{ $pelamar->no_kk ?? '-' }}</p>
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
                                        <p>{{ $pelamar->no_bpjs_kes ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">No. Program ASKES *</label>
                                        <p>{{ $pelamar->no_bpjs_kes ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="col-12 pl-0">
                        <div class="form-group mb-3">
                            <div class="row align-items-end">
                                <div class="col-md mb-md-0 m-l-15">
                                    <label class="font-size-14 fw-bold">Nama Bank *</label>
                                    <p>{{ $pelamar->nama_bank ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="col-12 pl-0">
                            <div class="form-group mb-3">
                                <div class="row align-items-end">
                                    <div class="col-md mb-md-0 m-l-15">
                                        <label class="font-size-14 fw-bold">No. Rekening *</label>
                                        <p>{{ $pelamar->no_rek ?? '-' }}</p>
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
                                <th>Hubungan</th>
                                <th>Nama</th>
                                                    <th>Jenis Kelamin</th>
                                <th>Tanggal Lahir</th>
                                                    <th>Kota Kelahiran</th>
                                <th>Pendidikan Terakhir</th>
                                <th>Pekerjaan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datakeluarga as $keluarga)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $keluarga['hubungan'] }}</td>
                                    <td>{{ $keluarga['nama'] }}</td>
                                    <td>{{ $keluarga['jenis_kelamin'] }}</td>
                                    <td>{{ $keluarga['tgllahir'] }}</td>
                                    <td>{{ $keluarga['tempatlahir'] }}</td>
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
                                            <th>Nomor Ijazah</th>
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
                                        <td>{{ $p['ijazah_formal'] }}</td>
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
                                            <th>Lembaga Pendidikan</th>
                                <th>Alamat</th>
                                <th>Tahun Lulus</th>
                                            <th>Nomor Ijazah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendidikan as $nf)
                                @if ($nf['jenis_pendidikan'] != null)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $nf['jenis_pendidikan'] }}</td>
                                        <td>{{ $nf['nama_lembaga'] }}</td>
                                        <td>{{ $nf['kota_pnonformal'] }}</td>
                                        <td>{{ $nf['tahun_lulus_nonformal'] }}</td>
                                        <td>{{ $nf['ijazah_nonformal'] }}</td>
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
                                <th>Nama Perusahaan</th>
                                <th>Alamat</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
                                <th>Jabatan</th>
                                <th>Level</th>
                                <th>Gaji</th>
                                            <th>Alasan Berhenti</th>
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
                                    <td>{{ $pek['alasan_berhenti'] }}</td>
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
                                <th>Nama Organisasi</th>
                                <th>Alamat</th>
                                <th>Tanggal Masuk</th>
                                <th>Tanggal Keluar</th>
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
                                <th>Nomor Surat / Sertifikat</th>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="modal-footer">
                <a href="/show_rekrutmen{{ $pelamar->id_lowongan }}" class="btn btn-sm btn-danger"><i class="fa fa-backward"></i> Kembali</a>
                {{-- <button onclick="history.back()" class="btn btn-sm btn-danger"><i class="fa fa-backward"></i> Kembali rtes  </button> --}}
                {{-- <button type="submit" name="submit" class="btn btn-sm btn-success"><strong><i
                            class="fa fa-paper-plane"></i></strong> Kirim Data</button> --}}
            </div>
        </form>

    </div>