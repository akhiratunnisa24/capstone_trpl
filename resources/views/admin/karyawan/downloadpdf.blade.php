<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Karyawan</title>
    <style>
        .garis {
            margin-top: 10px;
            height: 3px;
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            margin-bottom: 5px;
        }

        #absensi {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #address {
            text-align: center;
            margin-left: 30px;
            margin-right: 30px;
        }

        #absensi td,
        #absensi th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #absensi tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #absensi tr:hover {
            background-color: #ddd;
        }

        #absensi th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            background-color: #3eb1d4;
            color: white;
        }

        #ttd {
            text-align: right;
            padding-right: 10px;
        }

        #t {
            text-align: right;
            padding-right: 93px;
        }

        #tt {
            text-align: right;
            padding-right: 33px;
            padding-top: 40px;
        }

        #n {
            text-align: left;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        h1 {
            font-size: 2.5rem;
            text-align: center;
            margin-top: 2rem;
        }

        table {
            width: 100%;
            margin: 2rem auto;
            border-collapse: collapse;
            border: 2px solid #ddd;
        }

        td {
            padding: 0.5rem;
            border-bottom: 1px solid #ddd;
        }

        tr:last-child td {
            border-bottom: none;
        }

        th {
            background-color: #8047d67a;
            color: white;
            padding: 0.5rem;
            text-align: left;
        }
    </style>
</head>

<body>
    <h1 align="center">PT. Global Risk Management (GRM)</h1>
    <p id="address">Graha GRM Royal Spring Business Park 11, Jl. Ragunan Raya No. 29A, Jakarta Selatan, 12540</p>
    <div class="garis"></div>
    <h3 align="center">Data Karyawan</h3>

    <h4>A. Identitas Diri</h4>
    <table>
        <tbody>
            <tr>
                <th>Foto Profile</th>
                <td>
                    <img src="{{ public_path('Foto_Profile/') . $data->foto }}" alt="" style="width:30%; ">
                </td>
            </tr>
            <tr>
                <th>NIP Karyawan</th>
                <td>{{ $data->nip ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $data->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $data->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <th>Unit Kerja</th>
                <td>{{ $data->departemen->nama_departemen ?? '-' }}</td>
            </tr>
            <tr>
                <th>Level Jabatan</th>
                <td>{{ $data->jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status Karyawan</th>
                <td>{{ $data->status_karyawan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td>{{ \Carbon\Carbon::parse($data->tglmasuk)->format('d/m/Y') ?? '-' }}</td>
            </tr>
            <tr>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th>Status Pernikahan</th>
                <td>{{ $data->status_pernikahan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jumlah Anak</th>
                <td>{{ $data->jumlah_anak ?? '-' }}</td>
            </tr>
            <tr>
                <th>Agama</th>
                <td>{{ $data->agama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Golongan Darah</th>
                <td>{{ $data->gol_darah ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{ \Carbon\Carbon::parse($data->tgllahir)->format('d/m/Y') ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tempat Lahir</th>
                <td>{{ $data->tempatlahir ?? '-' }}</td>
            </tr>
            <tr>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $data->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nomor Handphone</th>
                <td>{{ $data->no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $data->email ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nama Kontak Person</th>
                <td>{{ $data->kdarurat->nama ?? '-' }}</td>
            </tr>
            <tr>
                <th>Status Hubungan</th>
                <td>{{ $data->kdarurat->hubungan ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. Kontak Telp/HP</th>
                <td>{{ $data->kdarurat->no_hp ?? '-' }}</td>
            </tr>
            <tr>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th>No. KTP</th>
                <td>{{ $data->nik ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. Kartu Keluarga</th>
                <td>{{ $data->no_kk ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. NPWP</th>
                <td>{{ $data->no_npwp ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. BPJS Ketenagakerjaan</th>
                <td>{{ $data->no_bpjs_ket ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. BPJS Kesehatan</th>
                <td>{{ $data->no_bpjs_kes ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. Asuransi AKDHK</th>
                <td>{{ $data->no_akdhk ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. Program Pensiun</th>
                <td>{{ $data->no_program_pensiun ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. Program ASKES</th>
                <td>{{ $data->no_program_askes ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nama Bank</th>
                <td>{{ $data->nama_bank ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. Rekening</th>
                <td>{{ $data->no_rek ?? '-' }}</td>
            </tr>

        </tbody>
    </table>

    <h4>B. Riwayat Pendidikan</h4>
    <label class="text-white badge bg-info">Pendidikan Formal</label>
    <table>
        <thead>
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
                        <td>{{ $p->tingkat }}</td>
                        <td>{{ $p->nama_sekolah }}</td>
                        <td>{{ $p->kota_pformal }}</td>
                        <td>{{ $p->jurusan }}</td>
                        <td>{{ $p->tahun_lulus_formal }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

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
                        <td>{{ $nf->jenis_pendidikan }}</td>
                        <td>{{ $nf->kota_pnonformal }}</td>
                        <td>{{ $nf->tahun_lulus_nonformal }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <h4>C. Riwayat Pekerjaan</h4>
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
                    <td>{{ $pek->nama_perusahaan }}</td>
                    <td>{{ $pek->alamat }}</td>
                    <td>{{ $pek->tgl_mulai }}</td>
                    <td>{{ $pek->tgl_selesai }}</td>
                    <td>{{ $pek->jabatan }}</td>
                    <td>{{ $pek->level }}</td>
                    <td>{{ $pek->gaji }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>D. Riwayat Organisasi</h4>
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
                    <td>{{ $org->nama_organisasi }}</td>
                    <td>{{ $org->alamat }}</td>
                    <td>{{ $org->tgl_mulai }}</td>
                    <td>{{ $org->tgl_selesai }}</td>
                    <td>{{ $org->jabatan }}</td>
                    <td>{{ $org->no_sk }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>E. Riwayat Prestasi</h4>
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
                    <td>{{ $pres->keterangan }}</td>
                    <td>{{ $pres->nama_instansi }}</td>
                    <td>{{ $pres->alamat }}</td>
                    <td>{{ $pres->no_surat }}</td>
                    <td>{{ $pres->tanggal_surat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>F. Data Keluarga</h4>
    <table class="table table-striped">
        <thead class="alert alert-info">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Hubungan</th>
                <th>Pendidikan Terakhir</th>
                <th>Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keluarga as $keluarga)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $keluarga->nama }}</td>
                    <td>{{ $keluarga->tgllahir }}</td>
                    <td>{{ $keluarga->hubungan }}</td>
                    <td>{{ $keluarga->pendidikan_terakhir }}</td>
                    <td>{{ $keluarga->pekerjaan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4>G. Data Kontak Darurat</h4>
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
                    <td>{{ $kd->nama }}</td>
                    <td>{{ $kd->no_hp }}</td>
                    <td>{{ $kd->alamat }}</td>
                    <td>{{ $kd->hubungan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    {{-- <br>
    <div class="row-sm-3">
        <p id="ttd">Depok, {{ date('d F Y') }}</p>
        <br>
        <br>
        <p id="tt">(HR Development)</p>
    </div> --}}
</body>

</html>
