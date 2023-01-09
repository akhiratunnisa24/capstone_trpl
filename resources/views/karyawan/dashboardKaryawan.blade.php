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

    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-teal text-center">
                <div class="panel-heading btn-info">
                    <h4 class="panel-title">Sisa Cuti Anda</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>Cuti tahunan if nul</b></h3>
                    <p class="text-muted"><b>Total Sisa Cuti Anda</b> </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-primary text-center">
                <div class="panel-heading btn-info">
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
                    <h3 class=""><b class="text text-success">Belum Absen</b></h3>
                    <p class="text-muted"><b>Anda Belum Absen</b></p>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-primary text-center">
                <div class="panel-heading btn-warning">
                    <h4 class="panel-title">Jumlah Terlambat Anda</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenTerlambatkaryawan }}</b></h3>
                    <p class="text-muted"><b>Total Jumlah Terlambat Anda</b> </p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-primary text-center">
                <div class="panel-heading btn-danger">
                    <h4 class="panel-title">Tidak Hadir Anda Bulan Ini</h4>
                </div>
                <div class="panel-body">
                    <?php
                    if($absenTidakmasuk == 2 ) { 
                  ?>
                    <h3 class=""><b class="text text-success">Masuk</b></h3>
                    <?php
                    } else { 
                  ?>
                    <h4 class=""><b class="text text-success">Total cuti + Total izin</b></h4>
                    {{-- + tidak ada keterangan --}}
                    <?php } ?>
                    <p class="text-muted"><b>Total Jumlah Tidak Hadir Anda</b> </p>
                </div>
            </div>
        </div>
    </div>

    <!-- baris kedua -->
    <div class="row">
        <div id="a" class="col-md-12">
            <div id="a" class="panel panel-secondary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="info">
                                        <th>#</th>
                                        <th>Nama Karyawan</th>
                                        <th>Cuti Yang Didapat</th>
                                        <th>Durasi Cuti</th>
                                        <th>Cuti Dipakai</th>
                                        <th>Sisa Cuti</th>
                                        <th>Aktif Dari</th>
                                        <th>Berakhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alokasicuti as $alokasi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $alokasi->karyawans->nama }}</td>
                                            <td>{{ $alokasi->jeniscutis->jenis_cuti }}</td>
                                            <td>{{ $alokasi->durasi }} hari</td>
                                            <td>
                                                @foreach($sisacuti as $sisa)
                                                    @if($alokasi->id_jeniscuti == $sisa->id_jeniscuti)
                                                        {{ $sisa->jml_cuti }} Hari
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($sisacuti as $sisa)
                                                    @if($alokasi->id_jeniscuti == $sisa->id_jeniscuti)
                                                        {{ $sisa->sisa }} hari
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($alokasi->aktif_dari)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($alokasi->sampai)->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
    
                                    <!-- mencari jumlah cuti -->
                                    @php
                                        $jml = 0;
                                        $terpakai = 0;
                                        $sis = 0;
                                    @endphp
                                    @foreach ($alokasicuti as $key => $alokasi)
                                        @php
                                            $jml += $alokasi->durasi;
                                        @endphp
                                    @endforeach
    
                                    @foreach ($sisacuti as $key => $sisa)
                                        @php
                                            $terpakai += $sisa->jml_cuti;
                                        @endphp
                                    @endforeach
                                     @php
                                        $sis = $jml-$terpakai;
                                    @endphp
                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-right"><strong>Jumlah Cuti</strong></td>
                                        <td class="thick-line text-left">{{ $jml }}</td>
                                        <td class="thick-line text-left">{{ $terpakai }} hari</td>
                                        <td class="thick-line text-left">{{ $sis }} hari</td>
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
    </div> <!-- End Row -->

    <!-- baris pertama -->
    <div class="row">
        <div class="col-sm-6 col-lg-3">
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
        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-teal text-center">
                <div class="panel-heading btn-info">
                    <h4 class="panel-title">Terlambat Bulan Lalu</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenTerlambatbulanlalu }}</b></h3>
                    <p class="text-muted"><b>Kali absensi</b></p>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-primary text-center">
                <div class="panel-heading btn-info">
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
                    <h3 class=""><b class="text text-success">Belum Absen</b></h3>
                    <p class="text-muted"><b>Anda Sudah Berhasil Absen</b></p>
                </div>
                <?php } ?>
            </div>
        </div>
       
        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-primary text-center">
                <div class="panel-heading btn-info">
                    <h4 class="panel-title">Terlambat Bulan Ini</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenTerlambatkaryawan }}</b></h3>
                    <p class="text-muted"><b>Kali absensi</b> </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-primary text-center">
                <div class="panel-heading btn-danger">
                    <h4 class="panel-title">Tidak Hadir Anda Bulan Ini</h4>
                </div>
                <div class="panel-body">
                    <?php
                    if($absenTidakmasuk == 2 ) { 
                  ?>
                    <h3 class=""><b class="text text-success">Masuk</b></h3>
                    <?php
                    } else { 
                  ?>
                    <h4 class=""><b class="text text-success">Total cuti + Total izin</b></h4>
                    {{-- + tidak ada keterangan --}}
                    <?php } ?>
                    <p class="text-muted"><b>Total Jumlah Tidak Hadir Anda</b> </p>
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
