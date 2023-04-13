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
    <h3 align="center">Report Cuti Pegawai</h3>
    <table id="absensi">
        <tr>
            <th>ID </th>
            <th>Nama</th>
            <th>Kategori Cuti</th>
            <th>Tanggal Mulai</th>
            <th>Tanggal Selesai</th>
            <th>Keperluan</th>
            <th>Status</th>
        </tr>

        @forelse($data as $key => $d)
            <tr align="center">
                <td>{{ $d->id }}</td>
                <td id="n">{{ $d->karyawans->nama }}</td>
                <td>{{ $d->jeniscutis->jenis_cuti }}</td>
                <td>{{ $d->tgl_mulai }}</td>
                <td>{{ $d->tgl_selesai }}</td>
                <td>{{ $d->keperluan }}</td>
                <td>
                    <span
                        class="badge badge-{{ $d->status == 1 ? 'warning' : ($d->status == 2 ? 'info' : ($d->status == 5 ? 'danger' : ($d->status == 6 ? 'secondary' : ($d->status == 7 ? 'success' : '')))) }}">
                        {{ $d->status == 1 ? 'Pending' : ($d->status == 2 ? 'Disetujui Manager' : ($d->status == 5 ? 'Ditolak' : ($d->status == 6 ? 'Disetujui Asisten Manajer' : ($d->status == 7 ? 'Disetujui' : '')))) }}
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
    <div class="row-sm-3">
        <p id="ttd">Depok, {{ date('d F Y') }}</p>
        {{-- <p id="t">Hormat Kami,</p> --}}
        <p id="tt">(HR Development)</p>
    </div>
</body>

</html>
