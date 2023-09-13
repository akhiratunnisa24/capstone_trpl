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
            font-size: 12px;
        }

        #absensi td,
        #absensi th {
            border: none;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        #absensi tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #absensi tr:hover {
            background-color: #ddd;
            border-bottom: 1px solid #ddd;
        }

        #absensi th {
            padding-top: 8px;
            padding-bottom: 8px;
            text-align: center;
            background-color: #3eb1d4;
            color: white;
            border-bottom: 1px solid #ddd;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        h1 {
            font-size: 2.0rem;
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            margin: 2rem auto;
            border-collapse: collapse;
            border : 1px solid #878686;
        }

        #photo {
            width: 100%;
            margin: 0.5rem auto;
            border-collapse: collapse;
            border: 2px solid #fffefe;
        }

        td {
            padding: 0.5rem;
            font-size: 12px; 
            border : 1px solid #878686;
        }

        tr:last-child td {
            border-bottom: none;
        }

        th {
            background-color: #8047d67a;
            color: white;
            padding: 0.5rem;
            text-align: left;
            font-size: 12px; 
            border : 1px solid #878686;
        }
        #foto {
            background-color: #fdfdfd;
            color: white;
            padding: 10px;
            text-align: left;
        }

        .page-break {
            page-break-after: always;
        } 
        
    </style>
</head>

<body>
    <h1 align="center">{{$setorganisasi->nama_perusahaan}}</h1>
    @if($setorganisasi->partner == 2)
        <p id="address">{{$setorganisasi->alamat}},{{$setorganisasi->daerah}},{{$setorganisasi->kode_pos}}</p>
    @else
        <p id="address">{{$setorganisasi->alamat}}</p>
        <p id="address">{{$setorganisasi->daerah}},{{$setorganisasi->kode_pos}}</p>
    @endif
    <div class="garis"></div>
    <h3 align="center">Data Karyawan</h3>

    <h4>A. Identitas Diri</h4>
    <table id="photo">
        <tr>
            <th id="foto" colspan="2" style="text-align: center;">
                @if($data->foto !== null)
                    <img src="{{ public_path('Foto_Profile/') . $data->foto }}" alt="" style="width: 180px; height: 220px; display: block; margin: 0 auto;">
                @else
                    <p style="color: red;">File foto tidak tersedia.</p>
                @endif
            </th>
        </tr>
    </table>
    <table>
        <tbody class="absensi">
            {{-- <tr>
                <th>Foto Profile</th>
                <td>
                    <img src="{{ public_path('Foto_Profile/') . $data->foto }}" alt="" style="width:30%; ">
                </td>
            </tr> --}}
            <tr>
                <th>NIK Karyawan</th>
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
            {{-- <tr>
                <th></th>
                <th></th>
            </tr> --}}
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
            {{-- <tr>
                <th></th>
                <th></th>
            </tr> --}}
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
            {{-- <tr>
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
            </tr> --}}
            {{-- <tr>
                <th></th>
                <th></th>
            </tr> --}}
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
            {{-- <tr>
                <th>No. Asuransi AKDHK</th>
                <td>{{ $data->no_akdhk ?? '-' }}</td>
            </tr> --}}
            {{-- <tr>
                <th>No. Program Pensiun</th>
                <td>{{ $data->no_program_pensiun ?? '-' }}</td>
            </tr> --}}
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
    @php 
        $n = 1;
    @endphp
    <h4 id="formal">B. Riwayat Pendidikan</h4>
    <label  id="formal" class="text-white badge bg-info">Pendidikan Formal</label>
    <table  id="formal"  class="table table-striped">
        <thead>
            <tr  class="table-bordered">
                <th>No</th>
                <th>Tingkat Pendidikan</th>
                <th>Nama Sekolah</th>
                <th>Alamat</th>
                <th>Jurusan</th>
                <th>Tahun Mulai</th>
                <th>Tahun Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendidikan as $p)
                @if ($p['tingkat'] != null)
                    <tr>
                        <td>{{ $n++ }}</td>
                        <td>{{ $p->tingkat }}</td>
                        <td>{{ $p->nama_sekolah }}</td>
                        <td>{{ $p->kota_pformal }}</td>
                        <td>{{ $p->jurusan }}</td>
                        <td>{{ $p->tahun_masuk_formal }}</td>
                        <td>{{ $p->tahun_lulus_formal }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <label id="noformal" class="text-white badge bg-info">Pendidikan Non Formal</label>
    <table id="noformal" class="table table-striped">
        <thead class="alert alert-info">
            <tr>
                <th>No</th>
                <th>Jenis/Bidang Pendidikan</th>
                <th>Nama Lembaga</th>
                <th>Alamat</th>
                <th>Tahun Mulai</th>
                <th>Tahun Akhir</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $no = 1;
            @endphp
            @foreach ($pendidikan as $nf)
                @if ($nf['jenis_pendidikan'] != null)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $nf->jenis_pendidikan }}</td>
                        <td>{{ $nf->nama_lembaga }}</td>
                        <td>{{ $nf->kota_pnonformal }}</td>
                        <td>{{ $nf->tahun_masuk_nonformal }}</td>
                        <td>{{ $nf->tahun_lulus_nonformal }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
   @if($pendidikan->count() >= 6 && $pendidikan->count() <= 10 && $data->foto !== null)
        <div class="page-break"></div>
    {{-- @elseif($pendidikan->count() >= 7 && $pendidikan->count() <= 10 && $data->foto !== null) --}}
    @endif

    <h4 id="pekerjaan">C. Riwayat Pengalaman Bekerja</h4>
    <table id="pekerjaan" class="table table-striped">
        <thead class="alert alert-info">
            <tr>
                <th>No</th>
                <th>Perusahaan</th>
                <th>Alamat</th>
                <th>Tahun Masuk</th>
                <th>Tahun Selesai</th>
                <th>Jabatan Terakhir</th>
                <th>Level Jabatan</th>
                <th>Gaji Terakhir</th>
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

    @php
        $a = $pendidikan->count();
        $b = $pekerjaan->count();
        $c = $a + $b;
        $d = $organisasi->count();
        $e = $c + $d;
        $f = $prestasi->count();
        $g = $e + $f;
        $h = $keluarga->count();
        $i = $g + $h;
        $j = $b + $d + $f;
        $k = $d + $f;
    @endphp

    @if($c >= 6 && $c <= 11 && $b !== 0)
        <div class="page-break"></div>
    @endif
    <h4 id="organisasi">D. Riwayat Organisasi & Komunitas</h4>
    <table id="organisasi" class="table table-striped">
        <thead class="alert alert-info">
            <tr>
                <th>No</th>
                <th>Lembaga</th>
                <th>Alamat</th>
                <th>Tahun Mulai</th>
                <th>Tahun Selesai</th>
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

    <h4 id="prestasi">E. Riwayat Penghargaan/Prestasi</h4>
    <table  id="prestasi" class="table table-striped">
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
                    <td>{{ \Carbon\Carbon::parse($pres->tanggal_surat)->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- {{$j;}} --}}
    @if($g >= 19 && $f == 0 && $d !== 0 || $j >= 7 || $k > 0)
        <div class="page-break"></div>
    @endif
    <h4 id="keluarga" >F. Data Keluarga & Tanggungan</h4>
    <table id="keluarga" class="table table-striped">
        <thead class="alert alert-info">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Kota Kelahiran</th>
                <th>Jenis Kelamin</th>
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
                    <td>{{ Carbon\Carbon::parse($keluarga->tgllahir)->format('d/m/Y') }}</td>
                    <td>{{ $keluarga->tempatlahir}}</td>
                    <td>{{ $keluarga->jenis_kelamin}}</td>
                    <td>{{ $keluarga->hubungan }}</td>
                    <td>{{ $keluarga->pendidikan_terakhir }}</td>
                    <td>{{ $keluarga->pekerjaan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h4 id="kontakdarurat">G. Data Kontak Darurat</h4>
    <table id="kontakdarurat" class="table table-striped" >
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

    
    {{-- <h4>B. Riwayat Jabatan</h4>
    <table  class="table table-striped">
        <thead>
            <tr  class="table-bordered">
                <th>No</th>
                <th>Jabatan Terakhir</th>
                <th>Level Jabatan</th>
                <th>Gaji Terakhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($historyjabatan as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->jabatans->nama_jabatan }}</td>
                    <td>{{ $p->leveljabatans->nama_level }}</td>
                    <td>{{ number_format(floatval($p->gaji_terakhir), 0, ',', '.')}}</td>
                </tr>
            @endforeach
        </tbody>
    </table> --}}
</body>

</html>
