@extends('layouts.default')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Tindak Lanjut Keterlambatan Karyawan</h4>
                    <ol class="breadcrumb pull-right">
                    <li>Rynest Employees Management System</li>
                    <li class="active">Tindak Lanjut Keterlambatan Karyawan</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <!-- Header -->
    @if(isset($terlambat))
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-15">
                            <h5>Sanksi Teguran Biasa</h5>
                            </div>
                            <div class="panel-body" >
                                <table id="datatable-responsive22" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Karyawan</th>
                                            <th>Jumlah Terlambat</th>
                                            <th>Sanksi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                        @foreach($terlambat as $t)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$t->nama}}</td>
                                                <td>{{$t->jumlah}} kali</td>
                                                <td>{{$t->sanksi}}</td>
                                                <td class="text-center">
                                                    <a href="/terlambat-detail{{$t->id_karyawan}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
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
        </div>
    @endif
    @if(isset($telat))
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-15">
                            <h5>Sanksi SP 1</h5>
                            </div>
                            <div class="panel-body" >
                                <table id="datatable-responsive18" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Karyawan</th>
                                            <th>Jumlah Terlambat</th>
                                            <th>Sanksi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                        @foreach($telat as $te)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$te->nama}}</td>
                                                <td>{{$te->jumlah}} kali</td>
                                                <td>{{$te->sanksi}}</td>
                                                <td class="text-center">
                                                    <a href="/terlambat-detail{{$te->id_karyawan}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
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
        </div>
    @endif
    @if(isset($datatelat))
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading  col-sm-15">
                            <h5>Sanksi SP 2</h5>
                            </div>
                            <div class="panel-body" >
                                <table id="datatable-responsive21" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Karyawan</th>
                                            <th>Jumlah Terlambat</th>
                                            <th>Sanksi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
                                        @foreach($datatelat as $tel)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$tel->nama}}</td>
                                                <td>{{$tel->jumlah}} kali</td>
                                                <td>{{$tel->sanksi}}</td>
                                                <td class="text-center">
                                                    <a href="/terlambat-detail{{$tel->id_karyawan}}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
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
        </div>
    @endif
    <a href="/" class="btn btn-sm btn-danger pull-right" style="margin-right:15px;">Kembali <i class="fa fa-home"></i></a>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
    
@endsection
