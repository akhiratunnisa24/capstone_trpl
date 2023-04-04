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
            border: 1px solid #ddd;
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

    <h4>Identitas Diri</h4>
    <table>
        <tbody>
            <tr>
                <th>NIP Karyawan</th>
                <td>{{ $data->nip ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $data->nama ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Tanggal Lahir</th>
                <td>{{\Carbon\Carbon::parse($data->tgllahir)->format('d/m/Y') ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tempat Lahir</th>
                <td>{{ $data->tempatlahir ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $data->jenis_kelamin ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Departemen</th>
                <td>{{ $data->departemen->nama_departemen ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>{{ $data->jabatan ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Status Karyawan</th>
                <td>{{ $data->status_karyawan ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Golongan Darah</th>
                <td>{{ $data->gol_darah ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $data->alamat ?? '-'  }}</td>
            </tr>
            <tr>
            <tr>
                <th>Status Pernikahan</th>
                <td>{{ $data->status_pernikahan ?? '-'  }}</td>
            </tr>
             <tr>
                <th>Jumlah Anak</th>
                <td>{{ $data->jumlah_anak ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Nomor Handphone</th>
                <td>{{ $data->no_hp ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $data->email ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Agama</th>
                <td>{{ $data->agama ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td>{{\Carbon\Carbon::parse($data->tglmasuk)->format('d/m/Y') ?? '-' }}</td>
            </tr>
            <tr>
                <th>No. KTP</th>
                <td>{{ $data->nik ?? '-'  }}</td>
            </tr>
            <tr>
                <th>No. Kartu Keluarga</th>
                <td>{{ $data->no_kk ?? '-'  }}</td>
            </tr>
            <tr>
                <th>No. NPWP</th>
                <td>{{ $data->no_npwp ?? '-'  }}</td>
            </tr>
            <tr>
                <th>No. BPJS Ketenagakerjaan</th>
                <td>{{ $data->no_bpjs_ket ?? '-'  }}</td>
            </tr>
            <tr>
                <th>No. BPJS Kesehatan</th>
                <td>{{ $data->no_bpjs_kes ?? '-'  }}</td>
            </tr>
            <tr>
                <th>No. Asuransi AKDHK</th>
                <td>{{ $data->no_akdhk ?? '-'  }}</td>
            </tr>
            <tr>
                <th>No. Program Pensiun</th>
                <td>{{ $data->no_program_pensiun ?? '-'  }}</td>
            </tr>
            <tr>
                <th>No. Program ASKES</th>
                <td>{{ $data->no_program_askes ?? '-'  }}</td>
            </tr>
            <tr>
                <th>Nama Bank</th>
                <td>{{ $data->nama_bank ?? '-'  }}</td>
            </tr>
            <tr>
                <th>No. Rekening</th>
                <td>{{ $data->no_rek ?? '-'  }}</td>
            </tr>
            
        </tbody>
    </table>

    <br>
    <div class="row-sm-3">
        <p id="ttd">Depok, {{ date('d F Y') }}</p>
        {{-- <p id="t">Hormat Kami,</p> --}}
        <p id="tt">(HR Development)</p>
    </div>
</body>

</html>
