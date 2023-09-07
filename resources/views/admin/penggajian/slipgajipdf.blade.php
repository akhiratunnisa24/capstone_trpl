<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slip Gaji Karyawan</title>
    <style>
        .garis{
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

        #absensi {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        #address {
            text-align: center;
            margin-left: 30px;
            margin-right:30px;
        }

        #absensi td, #absensi th {
        border: 1px solid #ddd;
        padding: 8px;
        }

        #absensi tr:nth-child(even){background-color: #f2f2f2;}

        #absensi tr:hover {background-color: #ddd;}

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
            padding-top:40px;
        }
        .n {
            text-align: left;
        }
    </style>
</head>
<body>
    {{-- <h1 align="center">{{$setorganisasi->nama_perusahaan}}</h1> --}}
    <h1 align="center">Nama Perusahaan</h1>
    {{-- <p id="address">{{$setorganisasi->alamat}}, {{$setorganisasi->kode_pos}}</p> --}}
    <p id="address">Alamat dan kode pos</p>
   <!-- Slip Gaji -->
<div class="garis"></div>
<h3 align="center">Slip Gaji Karyawan</h3>
<p>Nama: Jullyandre Fazri</p>
<p>NIK: RTI002</p>
<p>Jabatan: Staff</p>
<p>Status: Karyawan Tetap</p>

<!-- Bagian Penghasilan -->
<h3>PENGHASILAN:</h3>
<table id="absensi">
    <tr>
        <th>Deskripsi</th>
        <th>Jumlah</th>
    </tr>
    <tr>
        <td>Gaji Pokok</td>
        <td>Rp. 1,000,000</td>
    </tr>
    <tr>
        <td>Tunjangan Makan</td>
        <td>Rp. 400,000</td>
    </tr>
    <tr>
        <td>Tunjangan Transport</td>
        <td>Rp. 300,000</td>
    </tr>
    <tr>
        <td>Bonus</td>
        <td>Rp. 1,000,000</td>
    </tr>
    <tr>
        <th>Total</th>
        <td>Rp. -</td>
    </tr>
</table>

<!-- Bagian Potongan -->
<h3>POTONGAN:</h3>
<table id="absensi">
    <tr>
        <th>Deskripsi</th>
        <th>Jumlah</th>
    </tr>
    <tr>
        <td>Pajak</td>
        <td>Rp. 120,000</td>
    </tr>
    <tr>
        <td>Asuransi</td>
        <td>Rp. 300,000</td>
    </tr>
    <tr>
        <th>Total</th>
        <td>Rp. -</td>
    </tr>
</table>

<!-- Total Penerimaan Bersih -->
<p class="n">Total Penerimaan Bersih Rp. -</p>

    @php
        use Carbon\Carbon;
        $now = Carbon::now();
        $bulan = $now->locale('id')->monthName;
        $formatted_date = $now->day . ' ' . $bulan . ' ' . $now->year;
    @endphp
    <div class="row-sm-3">
        @if(Auth::user()->partner == 1)
            <p id="ttd">Jakarta Selatan, {{  $formatted_date }}</p>
        @elseif(Auth::user()->partner == 2)
            <p id="ttd">Depok, {{  $formatted_date }}</p>
        @endif
        {{-- <p id="t">Hormat Kami,</p> --}}
        <p id="tt">(HR Development)</p>
    </div>
</body>
</html>
