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
            <div class="panel-group " id="accordion-test-2">
                <div class="panel panel-default ">
                    {{-- <span class="badge badge-xs badge-danger text-right">{{ $cutijumlah }}</span> --}}
                    <div class="panel-heading ">
                        <h4 class="panel-title ">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#1" aria-expanded="false"
                                class="dropdown-toggle waves-effect waves-light collapsed">
                                Permintaan Cuti Karyawan
                                
                                @if ($cutijumlah)
                                    <span class="badge badge badge-danger" style="background-color:red">{{ $cutijumlah }}</span>
                                @endif
                            </a>
                        </h4>
                    </div>
                    <div id="1" class="panel-collapse collapse">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="info">
                                                <th>No</th>
                                                <th>Karyawan</th>
                                                <th>Cuti</th>
                                                <th>Mulai</th>
                                                <th>Cuti</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cuti as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->nama }}</td>
                                                    {{-- <td>{{$data->karyawans->nama}}</td> --}}
                                                    {{-- <td>{{$data->jeniscutis->jenis_cuti}}</td> --}}
                                                    <td>{{ $data->jenis_cuti }}</td>
                                                    {{-- <td>{{$data->keperluan}}</td> --}}
                                                    <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}</td>
                                                    {{-- <td>{{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td> --}}
                                                    <td>{{ $data->jml_cuti }} Hari</td>
                                                    <td>
                                                        {{-- {{ $data->status }} --}}
                                                        <span
                                                            class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : '')))) }}">
                                                            {{ $data->status == 1 ? 'Pending' : ($data->status == 2 ? 'Disetujui Manager' : ($data->status == 5 ? 'Ditolak' : ($data->status == 6 ? 'Disetujui Supervisor' : ($data->status == 7 ? 'Disetujui' : '')))) }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <div class="row">
                                                            @if ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1)
                                                                <div class="col-sm-3">
                                                                    <form action="/permintaan_cuti/{{ $data->id }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:8px">
                                                                    <form action="{{ route('cuti.tolak', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="status" value="Ditolak"
                                                                            class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                            @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2)
                                                                <div class="col-sm-3">
                                                                    <form action="/permintaan_cuti/{{ $data->id }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:8px">
                                                                    <form action="{{ route('cuti.tolak', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="status" value="Ditolak"
                                                                            class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                            @else
                                                            @endif

                                                            <div class="col-sm-3" style="margin-left:6px">
                                                                <form action="" method="POST">
                                                                    <a class="btn btn-info btn-sm" style="height:26px"
                                                                        data-toggle="modal"
                                                                        data-target="#Showcuti{{ $data->id }}">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                {{-- modal show cuti --}}
                                                @include('admin.cuti.showcuti')
                                            @endforeach

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
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#2" class="collapsed"
                                aria-expanded="false">
                                Permintaan Izin Karyawan
                                
                                @if ($izinjumlah)
                                    <span class="badge badge badge-danger" style="background-color:red">{{ $izinjumlah }}</span>
                                @endif
                            </a>

                        </h4>
                    </div>
                    <div id="2" class="panel-collapse collapse">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="info">
                                                <th>No</th>
                                                <th>Karyawan</th>
                                                <th>Izin</th>
                                                <th>Tanggal</th>
                                                <th>Hari</th>
                                                <th>Jam</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($izin as $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->nama }}</td>
                                                    <td>{{ $data->jenis_izin }} Orang</td>
                                                    @if ($data->tgl_mulai != null && $data->tgl_selesai != null)
                                                        <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                            s/d
                                                            {{ \Carbon\Carbon::parse($data->tgl_selesai)->format('d/m/Y') }}
                                                        </td>
                                                    @else
                                                        <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/M/Y') }}
                                                        </td>
                                                    @endif

                                                    @if ($data->jml_hari != null)
                                                        <td>{{ $data->jml_hari }} Hari</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    @if ($data->jam_mulai != null && $data->jam_mulai != null)
                                                        <td>{{ \Carbon\Carbon::parse($data->jam_mulai)->format('H:i') }}
                                                            s/d
                                                            {{ \Carbon\Carbon::parse($data->jam_selesai)->format('H:i') }}
                                                        </td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 5 ? 'danger' : ($data->status == 7 ? 'success' : '')) }}">
                                                            {{ $data->status == 1 ? 'Pending' : ($data->status == 5 ? 'Ditolak' : ($data->status == 7 ? 'Disetujui' : '')) }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <div class="row">
                                                            {{-- @if ($data->status == 'Pending' || $data->status == 'Disetujui Manager') --}}
                                                            @if ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1)
                                                                <div class="col-sm-3">
                                                                    <form action="{{ route('izinapproved', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                    <form action="" method="POST">
                                                                        <a class="btn btn-danger btn-sm"
                                                                            style="height:26px" data-toggle="modal"
                                                                            data-target="#izReject{{ $data->id }}">
                                                                            <i class="fa fa-times fa-md"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                                {{-- <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('izinreject',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        @method('POST')
                                                                                        <input type="hidden" name="status" value="Ditolak" class="form-control" hidden> 
                                                                                        <button type="submit" class="fa fa-times btn-danger btn-sm"></button> 
                                                                                    </form>
                                                                                </div> --}}
                                                            @else
                                                            @endif

                                                            <div class="col-sm-3" style="margin-left:5px">
                                                                <form action="" method="POST">
                                                                    <a class="btn btn-info btn-sm" style="height:26px"
                                                                        data-toggle="modal"
                                                                        data-target="#Showizinadmin{{ $data->id }}">
                                                                        <i class="fa fa-eye fa-md"></i>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                            {{-- modal show izin --}}
                                                            @include('admin.cuti.showizin')
                                                            @include('admin.cuti.izinReject')
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach

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
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#3" class="collapsed"
                                aria-expanded="false">
                                Permintaan Resign Karyawan
                                
                                @if ($resignjumlah)
                                    <span class="badge badge badge-danger" style="background-color:red">{{ $resignjumlah }}</span>

                                @endif
                            </a>
                        </h4>
                    </div>
                    <div id="3" class="panel-collapse collapse">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="info">
                                                <th>No</th>
                                                <th>Karyawan</th>
                                                <th>Departemen</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($resign as $r)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $r->karyawan->nama }}</td>
                                                    <td>{{ $r->departemens->nama_departemen ?? ' ' }}</td>
                                                    {{-- <td>{{ \Carbon\Carbon::parse($r->tgl_masuk)->format('d/m/Y') }}</td> --}}
                                                    <td>{{ \Carbon\Carbon::parse($r->tgl_resign)->format('d/m/Y') }}</td>
                                                    {{-- <td>{{ $r->tipe_resign }}</td> --}}
                                                    <!-- data for status -->
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $r->status == 8 ? 'warning' : ($r->status == 2 ? 'info' : ($r->status == 3 ? 'success' : ($r->status == 4 ? 'warning' : 'danger'))) }}">
                                                            {{ $r->status == 8 ? $r->statuses->name_status : ($r->status == 2 ? $r->statuses->name_status : ($r->status == 3 ? $r->statuses->name_status : ($r->status == 4 ? $r->statuses->name_status : 'Ditolak'))) }}
                                                        </span>
                                                    </td>
                                                    <td id="b" class="text-center">
                                                        <div class="btn-group" role="group">
                                                            @if ($r->status == 2 || $r->status == 4)
                                                                <form action="{{ route('resignapproved', $r->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value=1
                                                                        class="form-control" hidden>
                                                                    <button type="submit" class="btn btn-success btn-sm">
                                                                        <i class="fa fa-check"></i>
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('resignreject', $r->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <input type="hidden" name="status" value=5
                                                                        class="form-control" hidden>
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-times"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <a class="btn btn-info btn-sm" data-toggle="modal"
                                                                data-target="#Showresign{{ $r->id }}">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @include('karyawan.resign.showresign')
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                                            @foreach ($alokasicuti2 as $alokasi)
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
                                Data Rekruitmen
                            </a>
                        </h4>
                    </div>
                    <div id="5" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="info">
                                                <th>No</th>
                                                <th>Lowongan</th>
                                                {{-- <th>Pelamar</th> --}}
                                                <th>Dibutuhkan</th>
                                                <th>Aktif Dari</th>
                                                <th>Berakhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($posisi as $k)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $k->posisi }}</td>
                                                    {{-- <td>{{ $k->jeniscutis->jenis_cuti }}</td> --}}
                                                    <td>{{ $k->jumlah_dibutuhkan }} Orang</td>
                                                    <td>{{ \Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y') }}</td>
                                                </tr>
                                            @endforeach

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
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#6"
                                aria-expanded="false" class="collapsed">
                                Data lorem ipsum
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
