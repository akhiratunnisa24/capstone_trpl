@extends('layouts.default')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Dashboard</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Dashboard</li>
                </ol>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="panel-group" id="accordion-test-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#1"
                                aria-expanded="false" class="dropdown-toggle waves-effect waves-light collapsed">
                                Permintaan Cuti Karyawan
                            <i class="fa fa-bell"></i> <span class="badge badge-xs badge-danger">3</span></a>
                        </h4>
                    </div>
                    <div id="1" class="panel-collapse collapse">
                        sdfsfsdf
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#2"
                                class="collapsed" aria-expanded="false">
                                Permintaan Resign Karyawan
                            </a>
                        </h4>
                    </div>
                    <div id="2" class="panel-collapse collapse">
                        <div class="panel-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                            3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                            laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                            coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                            anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                            occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard
                            of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#3"
                                class="collapsed" aria-expanded="false">
                                Permintaan Resign Karyawan
                            </a>
                        </h4>
                    </div>
                    <div id="3" class="panel-collapse collapse">
                        <div class="panel-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid.
                            3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt
                            laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin
                            coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes
                            anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings
                            occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard
                            of them accusamus labore sustainable VHS.
                        </div>
                    </div>
                </div>

            </div>
        </div>
         
        <div class="col-lg-6">
            <div class="panel-group" id="accordion-test-2">

                

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#4"
                                aria-expanded="false" class="collapsed">
                                Data Cuti Karyawan
                            </a>
                        </h4>
                    </div>
                    <div id="4" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="info">
                                                <th>No</th>
                                                {{-- <th>settingalokasi</th> --}}
                                                <th>Nama Karyawan</th>
                                                <th>Cuti Yang Didapat</th>
                                                <th>Durasi Cuti</th>
                                                <th>Aktif Dari</th>
                                                <th>Berakhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($alokasicuti as $alokasi)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    {{-- <td>{{ $alokasi->id}}</td>
                                            <td>{{ $alokasi->id_settingalokasi}}</td> --}}
                                                    <td>{{ $alokasi->karyawans->nama }}</td>
                                                    <td>{{ $alokasi->jeniscutis->jenis_cuti }}</td>
                                                    <td>{{ $alokasi->durasi }} hari</td>
                                                    <td>{{ \Carbon\Carbon::parse($alokasi->aktif_dari)->format('d/m/Y') }}
                                                    </td>
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
                                                <td class="thick-line text-right"><strong>Jumlah</strong></td>
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

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#5"
                                aria-expanded="false" class="collapsed">
                                Data Izin Karyawan
                            </a>
                        </h4>
                    </div>
                    <div id="5" class="panel-collapse collapse">
                        sdfsfsdf
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#6"
                                aria-expanded="false" class="collapsed">
                                Data Resign Karyawan
                            </a>
                        </h4>
                    </div>
                    <div id="6" class="panel-collapse collapse">
                        sdfsfsdf
                    </div>
                </div>

                
            </div>
        </div>
    </div> <!-- end row -->

    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-primary text-center">
                <div class="panel-heading btn-info">
                    <a href="{{ url('showkaryawancuti') }}" class="panel-title ">
                        <h4 class="panel-title ">Cuti dan Izin Hari Ini</h4>
                    </a>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $cutidanizin }}</b></h3>
                    <p class="text-muted"><b>Total Pengajuan Cuti dan Izin </b> </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-primary text-center">
                <div class="panel-heading btn-success">
                    <a href="{{ url('showkaryawanabsen') }}" class="panel-title ">
                        <h4 class="panel-title">Absen Masuk Hari Ini</h4>
                    </a>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenHariini }}</b></h3>
                    <p class="text-muted"><b>Total Absen Masuk </b> </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-primary text-center">
                <div class="panel-heading btn-warning">
                    <a href="{{ url('showkaryawanterlambat') }}" class="panel-title ">
                        <h4 class="panel-title">Terlambat Hari Ini</h4>
                    </a>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenTerlambatHariIni }}</b></h3>
                    <p class="text-muted"><b>Total Terlambat</b> </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-primary text-center">
                <div class="panel-heading btn-danger">
                    <a href="{{ url('showkaryawantidakmasuk') }}" class="panel-title ">
                        <h4 class="panel-title"> Belum / Tidak Masuk Hari Ini</h4>
                    </a>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $totalTidakAbsenHariIni }}</b></h3>
                    <p class="text-muted"><b>Total Tidak Masuk</b></p>
                </div>
            </div>
        </div>

    </div>

    {{-- <div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-info">
                <a href="{{ url('showkaryawancuti') }}" class="panel-title ">
                <h4 class="panel-title ">Cuti dan Izin Bulan Ini</h4>
                </a>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $cutidanizinPerbulan }}</b></h3>
                <p class="text-muted"><b>Total Pengajuan Cuti dan Izin </b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-success">
                <a href="{{ url('showkaryawanabsen') }}" class="panel-title ">
                <h4 class="panel-title">Absen Masuk Bulan Ini</h4>
                </a>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $absenBulanini }}</b></h3>
                <p class="text-muted"><b>Total Absen Masuk </b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-warning">
                <a href="{{ url('showkaryawanterlambat') }}" class="panel-title ">
                <h4 class="panel-title">Terlambat Bulan Ini</h4>
                </a>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $absenTerlambat }}</b></h3>
                <p class="text-muted"><b>Total Terlambat </b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-danger">
                <a href="{{ url('showkaryawantidakmasuk') }}" class="panel-title ">
                <h4 class="panel-title"> Tidak Masuk Bulan Ini</h4>
                </a>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $tidakMasukBulanIni }}</b></h3>
                <p class="text-muted"><b>Total Absen Tidak Masuk </b> </p>
            </div>
        </div>
    </div>

</div> --}}

    {{-- <div class="row">
    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-info">
                <a href="{{ url('showkaryawancuti') }}" class="panel-title ">
                <h4 class="panel-title">Cuti dan Izin Bulan Lalu</h4>
                </a>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $cutidanizibulanlalu }}</b></h3>
                <p class="text-muted"><b>Total Cuti dan Izin</b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-success">
                <a href="{{ url('showkaryawanabsen') }}" class="panel-title ">
                <h4 class="panel-title">Absen Masuk Bulan Lalu</h4>
                </a>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $absenBulanlalu }}</b></h3>
                <p class="text-muted"><b>Total Absen Masuk</b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-warning">
                <a href="{{ url('showkaryawanterlambat') }}" class="panel-title ">
                <h4 class="panel-title">Terlambat Bulan Lalu</h4>
                </a>
            </div>
            <div class="panel-body">
                <h3 class=""><b>{{ $absenTerlambatbulanlalu }}</b></h3>
                <p class="text-muted"><b>Lorem Ipsum </b> </p>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="panel panel-primary text-center">
            <div class="panel-heading btn-danger">
                <a href="{{ url('showkaryawantidakmasuk') }}" class="panel-title ">
                <h4 class="panel-title">Tidak Masuk Bulan Lalu </h4>
                </a>
            </div>
            <div class="panel-body">
                <h3 class=""><b>0</b></h3>
                {{$absenTidakMasukBulanLalu}}
                <p class="text-muted"><b>Total Absen Tidak Masuk</b> </p>
            </div>
        </div>
    </div>

</div> --}}


    <div class="row">

        <!-- Chart JS -->
        {{-- <div class="col-lg-12">
        <div class="panel panel-border panel-info">
            <div class="panel-heading">
                <h3 class="panel-title text-white">Cuti {{ $tahun }} </h3>
            </div>
            <div class="panel-body">
                <div>
                    <canvas id="myChart" style="height: 300px"></canvas>
                </div>
            </div>
        </div>
    </div> <!-- col --> --}}

    </div> <!-- End Row -->



    </div> <!-- container -->

    </div> <!-- content -->

    </div>
    <!-- End Right content here -->

    </div>
    <!-- END wrapper -->


    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>

    <!--Morris Chart-->
    <script src="assets/plugins/morris/morris.min.js"></script>
    <script src="assets/plugins/raphael/raphael-min.js"></script>
    <script src="assets/pages/morris.init.js"></script>



    <!--Chart JS-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        var users2 = {{ Js::from($data) }};
        var labelBulan = {{ Js::from($labelBulan) }}

        const data = {
            labels: labelBulan,
            datasets: [{
                label: 'Cuti',
                backgroundColor: '#18bae2',
                borderColor: '#18bae2',
                data: users2,
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                ticks: {
                    precision: 0
                },

            }
        };

        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    </script>
@endsection
