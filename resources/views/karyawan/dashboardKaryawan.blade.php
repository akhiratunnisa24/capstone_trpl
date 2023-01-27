@extends('layouts.default')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Dashboard {{ $row->nama }}</h4>
                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Dashboard {{ $row->nama }}</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <!-- baris kedua -->
    <div class="row">
        <div id="a" class="col-md-9">
            <div id="a" class="panel panel-secondary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="info">
                                        <th>#</th>
                                        {{-- <th>settingalokasi</th> --}}
                                        <th>Nama Karyawan</th>
                                        <th>Cuti Yang Didapat</th>
                                        <th>Durasi Cuti</th>
                                        <th>Aktif Dari</th>
                                        <th>Berakhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alokasicuti as $alokasi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            {{-- <td>{{ $alokasi->id}}</td>
                                            <td>{{ $alokasi->id_settingalokasi}}</td> --}}
                                            <td>{{ $alokasi->karyawans->nama }}</td>
                                            <td>{{ $alokasi->jeniscutis->jenis_cuti }}</td>
                                            <td>{{ $alokasi->durasi }} hari</td>
                                            <td>{{ \Carbon\Carbon::parse($alokasi->aktif_dari)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($alokasi->sampai)->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
    
                                    <!-- mencari jumlah cuti -->
                                    @php
                                        $jml = 0;
                                    @endphp
                                    @foreach ($alokasicuti as $key => $alokasi)
                                        @php
                                            $jml += $alokasi->durasi;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-right"><strong>Jumlah Cuti</strong></td>
                                        <td class="thick-line text-left">{{ $jml }} hari</td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3 col-lg-3">
            <div id="a" class="panel panel-teal text-center">
                <div class="panel-heading btn-info">
                    <h4 class="panel-title">Data Absen Bulan Lalu</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenBulanlalu }}</b></h3>
                    <p class="text-muted"><b>Kali absensi</b></p>
                </div>
            </div>
        </div>
    </div> <!-- End Row -->

    <!-- baris kedua -->
    <div class="row">

        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-primary text-center">
                <div class="panel-heading btn-success">
                    <h4 class="panel-title">Absen Hari Ini</h4>
                </div>
                <?php
                    use Illuminate\Support\Facades\Auth;
                    use App\Models\Absensi;
                    if ($absenKaryawan == 1 ) { 
                ?>
                <div class="panel-body">
                    <h3 class=""><b class="text text-success">Sukses</b></h3>
                    <p class="text-muted"><b>Anda Sudah Berhasil Absen</b></p>
                </div>
                <?php
                    } else { 
                ?>
                <div class="panel-body">
                    <h3 class=""><a href="{{url("absensi-karyawan")}}"><b class="text text-danger">Belum Absen</b></a></h3>
                    <p class="text-muted"><b>Anda Belum Absen</b></p>
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-teal text-center">
                <div class="panel-heading btn-success">
                    <h4 class="panel-title">Data Absen Bulan Lalu</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenBulanlalu }}</b></h3>
                    <p class="text-muted"><b>Kali absensi</b></p>
                </div>
            </div>
        </div>

        
        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-primary text-center">
                <div class="panel-heading btn-warning">
                    <h4 class="panel-title">Terlambat Bulan Ini</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenTerlambatkaryawan }}</b></h3>
                    <p class="text-muted"><b>Kali absensi</b> </p>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-teal text-center">
                <div class="panel-heading btn-warning">
                    <h4 class="panel-title">Terlambat Bulan Lalu</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenTerlambatbulanlalu }}</b></h3>
                    <p class="text-muted"><b>Kali absensi</b></p>
                </div>
            </div>
        </div>
        
       

    </div>

    <style>
        #a {
            border-radius: 10px;
        }
    </style>
@endsection
