<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Cuti Pegawai</title>
    <style>
        .garis {
            margin-top: 10px;
            height: 3px;
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            margin-bottom: 5px;
        }

        .align-tanggal {
            text-align: center;
            white-space: nowrap;
        }

        .align-nama {
            text-align: center;
            white-space: nowrap;
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

        .n {
            text-align: left;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <h1 align="center">{{$setorganisasi->nama_perusahaan}}</h1>
    <p id="address">{{$setorganisasi->alamat}}, {{$setorganisasi->kode_pos}}</p>
    <div class="garis"></div>
    <h3 align="center">Report Cuti Pegawai</h3>
    <table id="absensi">
        <tr>
            <th>No. </th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Kategori Cuti</th>
            <th>Tanggal Pelaksanaan</th>
            <th>Keperluan</th>
            <th>Status</th>
        </tr>

        @forelse($data as $key => $d)
            <tr align="center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->nik }}</td>
                <td class="n">{{ ucwords(strtolower($d->karyawans->nama)) }}</td>
                <td>{{ $d->jeniscutis->jenis_cuti }}</td>
                <td class="align-tanggal">{{\Carbon\Carbon::parse($d->tgl_mulai)->format('d/m/Y')}} @if($d->tgl_selesai != NULL) s.d {{\Carbon\Carbon::parse($d->tgl_selesai)->format('d/m/Y')}} @endif</td>
                <td>{{ $d->keperluan }}</td>
                <td>
                    <span
                        class="badge badge-{{ $d->status == 1 ? 'warning' : ($d->status == 5 ? 'danger' : ($d->status == 6 ? 'info' : ($d->status == 7 ? 'success' : ($d->status == 9 ? 'secondary' : ($d->status == 10 ? 'success' : ''))))) }}">
                        {{ $d->status == 1 ? 'Pending' : ($d->status == 5 ? 'Ditolak' : ($d->status == 6 ? 'Disetujui Atasan' : ($d->status == 7 ? 'Disetujui' : ($d->status == 9 ? 'Pending Atasan' : ($d->status == 10 ? 'Pending Pimpinan' : ''))))) }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12" class="text-center">Data Tidak Ditemukan</td>
            </tr>
        @endforelse
    </table>
    <br>
    @php
        use Carbon\Carbon;

        $now = Carbon::now();
        $bulan = $now->locale('id')->monthName;
        $formatted_date = $now->day . ' ' . $bulan . ' ' . $now->year;
    @endphp
    <div class="row-sm-3">
        @if(Auth::user()->partner == 1)
            <p id="ttd">Jakarta Selatan, {{  $formatted_date }}</p>
        @else
            <p id="ttd">Jakarta Selatan, {{  $formatted_date }}</p>
        @endif
        {{-- <p id="t">Hormat Kami,</p> --}}
        <p id="tt">(HR Development)</p>
    </div>
</body>

</html>
