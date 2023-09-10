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
            padding-top: 8px;
            padding-bottom: 8px;
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

        /* Style untuk mengatur tampilan teks */
        .text-center {
            text-align: center;
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
    <h3 align="center">Slip Gaji Karyawan</h3>
    <table id="slipdetail">
        <tr>
            <td>Nama</td>
            <td>: {{$slipgaji->karyawans->nama}}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{$slipgaji->karyawans->nip}}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>: {{$slipgaji->karyawans->nama_jabatan}}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>: {{$slipgaji->karyawans->jabatan}}</td>
        </tr>
    </table>
    <div class="row row-table">
        <div class="col-md-6 row-table">
            <table id="absensi">
                <h3>PENGHASILAN:</h3>
                @if ($detailgaji !== null)
                    @foreach($detailgaji as $detail)
                        @if($detail->id_benefit === 1 )
                            <tr>
                                <td>{{ $detail->benefit->nama_benefit}}</td>
                                <td class="text-right">{{ number_format($detail->total, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    @endforeach
                    @foreach($detailgaji as $detail)
                        @if($detail->benefit->partner !== 0)
                            <tr>
                                <td>{{ $detail->benefit->nama_benefit}}</td>
                                <td class="text-right">{{ number_format($detail->total, 0, ',', '.')}}</td>
                            </tr>
                        @endif
                    @endforeach
                    @foreach($detailgaji as $detail)
                        @if($detail->id_benefit === 2)
                            <tr>
                                <td class="text-right" style="font-weight: bold;">Total</td>
                                <td class="text-right" style="font-weight: bold;">{{ number_format($detail->total, 0, ',', '.') }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </table>
        </div> 
        <div class="col-md-6 row-table">
            <table id="absensi">
               <h3>POTONGAN:</h3>
                @if($detailgaji !== null && $detail->id_kategori === 5 || $detail->id_kategori === 6)
                    @foreach($detailgaji as $detail)
                        <tr>
                            <td>{{ $detail->benefit->nama_benefit}}</td>
                            <td class="text-right">{{ number_format($detail->total, 0, ',', '.')}}</td>
                        </tr>
                    @endforeach
                    @if($slipgaji !== null)
                        <tr class="total-row">
                            <td class="text-right" style="font-weight: bold;">Total</td>
                            <td class="text-right" style="font-weight: bold;">{{ number_format($slipgaji->potongan, 0, ',', '.') }}</td>
                        </tr>
                    @endif
                @else
                    <tr>
                        <td>Asuransi</td>
                        <td class="text-right">{{ number_format($slipgaji->asuransi, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td>Pph21</td>
                        <td class="text-right">{{ number_format($slipgaji->pajak, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="total-row">
                        <td class="text-right" style="font-weight: bold;">Total</td>
                        <td class="text-right" style="font-weight: bold;">{{ number_format($slipgaji->potongan, 0, ',', '.') }}</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
    <hr>
    <table id="absensi">
        @foreach($detailgaji as $detail)
            @if($detail->id_benefit === 3)
                <tr class="total-row">
                    <td class="text-right" style="font-weight: bold;">Total Penerimaan Bersih</td>
                    <td class="text-right" style="font-weight: bold;">Rp. {{ number_format($detail->total, 0, ',', '.') }}</td>
                </tr> 
               @endif
        @endforeach
    </table>
    <hr>
    
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
