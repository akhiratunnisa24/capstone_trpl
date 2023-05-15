<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Izin Pegawai</title>
    <style>
        .garis {
            margin-top: 10px;
            height: 3px;
            border-top: 3px solid black;
            border-bottom: 1px solid black;
            margin-bottom: 5px;
        }

        .align-tanggal {
            text-align: left;
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

        #n {
            text-align: left;
        }
    </style>
</head>

<body>
    <h1 align="center">PT. Global Risk Management (GRM)</h1>
    <p id="address">Graha GRM Royal Spring Business Park 11, Jl. Ragunan Raya No. 29A, Jakarta Selatan, 12540</p>
    <div class="garis"></div>
    <h3 align="center">Report Izin Pegawai</h3>
    <table id="absensi">
        <tr>
            <th>No.</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Tanggal Pelaksanaan</th>
            <th>Keperluan</th>
            <th>Jam Pelaksanaan</th>
            <th>Jumlah Jam</th>
        </tr>

        @forelse($data as $key => $d)
            <tr align="center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->nik }}</td>
                <td class="align-nama">{{  ucwords(strtolower($d->karyawans->nama)) }}</td>
                <td>{{ $d->jenisizins->jenis_izin }}</td>
                <td class="align-tanggal">{{\Carbon\Carbon::parse($d->tgl_mulai)->format('d/m/Y')}} @if($d->tgl_selesai != NULL) s.d {{\Carbon\Carbon::parse($d->tgl_selesai)->format('d/m/Y')}} @endif</td>
                <td>{{ $d->keperluan }}</td>
                @if($d->jam_mulai != NULL)
                    <td class="align-tanggal">{{\Carbon\Carbon::parse($d->jam_mulai)->format('H:i')}} @if($d->jam_selesai != NULL) s.d {{\Carbon\Carbon::parse($d->jam_selesai)->format('H:i')}} @endif</td>
                    <td>{{ $d->jml_jam }}</td>
                @else
                    <td>-</td>
                    <td>-</td>
                @endif
            </tr>
        @empty
            <tr>
                <td colspan="12" class="text-center">Data Tidak Ditemukan</td>
            </tr>
        @endforelse
    </table>
    <br>
    <div class="row-sm-3">
        <p id="ttd">Jakarta Selatan, {{ date('d F Y') }}</p>
        {{-- <p id="t">Hormat Kami,</p> --}}
        <p id="tt">(HR Development)</p>
    </div>
</body>

</html>