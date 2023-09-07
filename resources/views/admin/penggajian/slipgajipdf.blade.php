<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slip Gaji Karyawan</title>
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

        #absensi {
            /* font-family: Arial, Helvetica, sans-serif;    */
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }
        #slipdetail {
            /* font-family: Arial, Helvetica, sans-serif; */
            /* border-collapse: collapse;
            width: 100%; */
        }

        #address {
            text-align: center;
            margin-left: 30px;
            margin-right: 30px;
        }

        #absensi td,
        #absensi th {
            border: none;
            padding: 2px;
            padding-left: 8px;
            background-color: transparent;
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

        .text-right {
            text-align: right;
            /* Align text to the right */
        }

        .total-row {
            background-color: #e0e0e0;
            /* Background color for the total row */
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
        }
    </style>
</head>

<body>
    <h1 align="center">Nama Perusahaan</h1>
    <p id="address">Alamat dan kode pos</p>
    <div class="garis"></div>
    <h3 align="center">Slip Gaji Karyawan</h3>
    <table id="slipdetail">
        <tr>
            <td>Nama</td>
            <td>: Jullyandre Fazri</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: RTI002</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>: Staff</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>: Karyawan Tetap</td>
        </tr>
    </table>

    <table id="absensi">

        <h3>PENGHASILAN:</h3>
        <tr>
            <td>Gaji Pokok</td>
            <td class="text-right"> 1,000,000</td>
        </tr>
        <tr>
            <td>Tunjangan Makan</td>
            <td class="text-right"> 400,000</td>
        </tr>
        <tr>
            <td>Tunjangan Transport</td>
            <td class="text-right"> 300,000</td>
        </tr>
        <tr>
            <td>Bonus</td>
            <td class="text-right"> 1,000,000</td>
        </tr>
        <tr class="total-row">
            <td class="text-right" style="font-weight: bold;">Total</td>
            <td class="text-right" style="font-weight: bold;">Rp. -</td>
        </tr>
    </table>
    <table id="absensi">
    <h3>POTONGAN:</h3>

        <tr>
            <td>Pajak</td>
            <td class="text-right"> 120,000</td>
        </tr>
        <tr>
            <td>Asuransi</td>
            <td class="text-right"> 300,000</td>
        </tr>
        <tr class="total-row">
            <td class="text-right" style="font-weight: bold;">Total</td>
            <td class="text-right" style="font-weight: bold;">Rp. -</td>
        </tr>
    </table>
    <hr>
    <table id="absensi">
        <tr class="total-row">
            <td class="text-right" style="font-weight: bold;">Total Penerimaan Bersih</td>
            <td class="text-right" style="font-weight: bold;">Rp. -</td>
        </tr>
    </table>
    @php
        use Carbon\Carbon;
        $now = Carbon::now();
        $bulan = $now->locale('id')->monthName;
        $formatted_date = $now->day . ' ' . $bulan . ' ' . $now->year;
    @endphp
    <div class="row-sm-3">
        @if (Auth::user()->partner == 1)
            <p id="ttd">Jakarta Selatan, {{ $formatted_date }}</p>
        @elseif(Auth::user()->partner == 2)
            <p id="ttd">Depok, {{ $formatted_date }}</p>
        @endif
        <p id="tt">(HR Development)</p>
    </div>
</body>

</html>
