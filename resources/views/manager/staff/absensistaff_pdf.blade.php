<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report Absensi Staff</title>
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
    <h1 align="center">PT. Global Risk Management (GRM)</h1>
    <p id="address">Graha GRM Royal Spring Business Park 11, Jl. Ragunan Raya No. 29A, Jakarta Selatan, 12540</p>
    <div class="garis"></div>
    <h3 align="center">Report Absensi Staff Departemen</h3>

    <p>Unit Kerja: {{ ucwords(strtolower($departemen->nama_departemen))}}</p>
    @if(isset($nbulan))
        <p>Periode&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $nbulan}}</p>
    @else
        <p>Periode&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: - </p>
    @endif

    <table id="absensi">
        <tr>
            <th>No.</th>
            <th>Nama</th>
            {{-- <th>Departemen</th> --}}
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Terlambat</th>
            <th>Plg Cepat</th>
            <th>Jml Jam Kerja</th>
        </tr>
        {{-- @php use Carbon; @endphp --}}
        @forelse($data as $key => $d)
            <tr align="center">
                <td>{{$loop->iteration}}</td>
                <td class="n">{{ucwords(strtolower($d->karyawans->nama))}}</td>
                {{-- <td>{{$d->departemens->nama_departemen}}</td> --}}
                <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d/m/Y')}}</td>
                <td>{{$d->jam_masuk}}</td>
                <td>{{$d->jam_keluar}}</td>
                <td>{{$d->terlambat}}</td>
                <td>{{$d->plg_cepat}}</td>
                <td>{{$d->jam_kerja}}</td>
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
        <p id="ttd">Jakarta Selatan, {{  $formatted_date }}</p>
        <p id="tt">(Departemen Manager)</p>
    </div>
</body>
</html>
