@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Tindak Lanjut Ketidakhadiran Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Tindak Lanjut Ketidakhadiran Karyawan</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Header -->
    @if(isset($tidakmasuk))
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-12">
                                <h5 class="text-white">Detail Data Pemotongan Uang Transportasi</h5>
                            </div>
                            <div class="panel-body" >
                                <table id="datatable-responsive20" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tidakmasuk as $tm)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$tm->nama}}</td>
                                                <td>{{\Carbon\Carbon::parse($tm->tanggal)->format('d/m/Y')}}</td>
                                                <td>{{$tm->status}}</td>
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
    @elseif(isset($absensi))
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-12">
                                <h5 class="text-white">Detail Data Pemotongan Uang Makan</h5>
                            </div>
                            <div class="panel-body" >
                                <table id="datatable-responsive21" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Jumlah Terlambat (Jam)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($absensi as $ab)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$ab->nama}}</td>
                                                <td>{{\Carbon\Carbon::parse($ab->tanggal)->format('d/m/Y')}}</td>
                                                <td>{{$ab->terlambat}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
    @endif
    <a href="/" class="btn btn-sm btn-danger pull-right" style="margin-right:15px">Kembali <i class="fa fa-home"></i></a>

    {{-- @endif --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
@endsection
