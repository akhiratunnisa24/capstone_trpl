@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Tindak Lanjut Keterlembatan Karyawan</h4>
                    <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Tindak Lanjut Keterlambatan Karyawan</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Header -->
    @if($teguranbiasa)
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-12">
                                <h5 class="text-white">Detail Data Teguran Biasa</h5>
                            </div>
                            <div class="panel-body" >
                                <table id="datatable-responsive20" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Jam Masuk</th>
                                            <th>Jumlah Terlambat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($teguranbiasa as $tm)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$tm->karyawans->nama}}</td>
                                                <td>{{\Carbon\Carbon::parse($tm->tanggal)->format('d/m/Y')}}</td>
                                                <td>{{$tm->jam_masuk}}</td>
                                                <td>{{$tm->terlambat}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{-- <div class="modal-footer">
                                <a href="/" class="btn btn-sm btn-danger">Kembali</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(isset($jumtel))
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-12">
                                <h5 class="text-white">Detail Data SP1</h5>
                            </div>
                            <div class="panel-body" >
                                <table id="datatable-responsive21" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Jam Masuk</th>
                                            <th>Jumlah Terlambat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($p1))
                                            @foreach($sp1 as $m)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$m->karyawans->nama}}</td>
                                                    <td>{{\Carbon\Carbon::parse($m->tanggal)->format('d/m/Y')}}</td>
                                                    <td>{{$m->jam_masuk}}</td>
                                                    <td>{{$m->terlambat}}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-12">
                                <h5 class="text-white">Detail Data SP2</h5>
                            </div>
                            <div class="panel-body" >
                                <table id="datatable-responsive21" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Jam Masuk</th>
                                            <th>Jumlah Terlambat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($p2))
                                            @foreach($sp2 as $t)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$t->karyawans->nama}}</td>
                                                    <td>{{\Carbon\Carbon::parse($t->tanggal)->format('d/m/Y')}}</td>
                                                    <td>{{$t->jam_masuk}}</td>
                                                    <td>{{$t->terlambat}}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
        
    <a href="/" class="btn btn-sm btn-danger pull-right" style="margin-right:15px">Kembali <i class="fa fa-home"></i></a>

    {{-- @endif --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>         
@endsection
