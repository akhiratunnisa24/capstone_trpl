@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title">Tindak Lanjut Ketidakhadiran Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Tindak Lanjut Ketidakhadiran Karyawan</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Header -->
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-15"><p class="text-primary">#</p>
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
                                                <td>{{$tm->tanggal}}</td>
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
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-15"><p class="text-primary">#</p>
                            </div>
                            <div class="panel-body" >
                                <table id="datatable-responsive21" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($absensi as $ab)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$ab->nama}}</td>
                                                <td>{{$ab->tanggal}}</td>
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
        <a href="/" class="btn btn-sm btn-danger pull-right" style="margin-right:15px">Kembali</a>

    {{-- @endif --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
@endsection
