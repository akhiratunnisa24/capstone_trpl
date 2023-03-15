@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Setting Absensi</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Human Resources Management System</a></li>
                    <li class="active">Setting Absensi</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- Close Header -->
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading  col-sm-15 m-b-10" style="height:45px">
                            <a href="" class="pull-right btn btn-dark btn-sm fa fa-plus" data-toggle="modal" data-target="#add"> Tambah Setting</a>
                            @include('admin.settingabsensi.addSetting')
                        </div>
                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable-responsive22" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Toleransi Terlambat (menit)</th>
                                                <th>Terlambat</th>
                                                <th>Sanksi Terlambat</th>
                                                <th>Tidak Masuk</th>
                                                <th>Status</th>
                                                <th>Sanksi Tidak Masuk</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($settingabsensi as $data)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    @if($data->toleransi_terlambat !=NULL)
                                                        <td>{{\Carbon\Carbon::parse($data->toleransi_terlambat)->format('i')}} menit</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    @if($data->jumlah_terlambat !=NULL)
                                                        <td>{{$data->jumlah_terlambat}} kali</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                   
                                                    <td>{{$data->sanksi_terlambat}}</td>

                                                    @if($data->jumlah_tidakmasuk !=NULL)
                                                        <td>{{$data->jumlah_tidakmasuk}} kali</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    @if($data->status_tidakmasuk != NULL)
                                                        <td>{{$data->status_tidakmasuk}}</td>
                                                    @else
                                                        <td></td>
                                                    @endif
                                                    <td>{{$data->sanksi_tidak_masuk}}</td>
                                                    <td class="text-center">
                                                        <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                            <a id="bs" class="btn btn-sm btn-success"  data-toggle="modal"  data-target="#edit{{$data->id}}">
                                                                <i class="fa fa-edit"></i></a>
                                                            @csrf
                                                            @method('DELETE')
                                                            {{-- <button onclick="izin({{$data->id}})" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></button> --}}
                                                            {{-- <button id="bs" type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                                <i class="fa fa-trash"></i> </button> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                @include('admin.settingabsensi.editSetting')
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End Row -->
        </div> <!-- container -->
    </div> <!-- content -->   
@endsection