@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <div class="col-sm-8">
                    <h4 class="pull-left page-title">Alokasi Cuti</h4>
                </div>
                <div align="right" class="col-sm-4">
                    <a href="/permintaan_cuti" class="btn btn-success btn-md">Kembali ke Cuti</a>
                    <a href="/settingalokasi" class="btn btn-success btn-md">Kembali ke Setting</a>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>    
    </div>
    <div class="btn-group" style="margin-left:15px;margin-bottom:10px" role="group" aria-label="Basic example">
        <a href="" class="btn btn-dark" data-toggle="modal" data-target="#Modal1">Import Excel</a>
        <a href="" class="btn btn-dark" data-toggle="modal" data-target="#smallModal">Import CSV</a>
         {{-- form import --}}
        @include('admin.alokasicuti.importexcel')
    </div>
    <!-- Start content -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <a href="" class="btn btn-dark" data-toggle="modal" data-target="#newalokasi">Tambah Alokasi</a>
                        </div>
                         {{-- form setting --}}
                         @include('admin.alokasicuti.addalokasi')

                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table  id="datatable-responsive7" class="table dt-responsive table-striped nowrap table-bordered" cellpadding="0" width="100%">
                                        <thead>
                                            <tr>
                                                {{-- <th>ID</th>
                                                <th>id settingalokasi</th>
                                                <th>id j.cuti</th>
                                                <th>kategori</th> --}}
                                                <th>#</th>
                                                <th>Karyawan</th>
                                                <th>Kategori Cuti</th>
                                                <th>Durasi (Hari)</th>
                                                {{-- <th>Tanggal Masuk</th> --}}
                                                <th>Mode Alokasi</th>
                                                <th>Aktif Dari</th>
                                                <th>Sampai</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
                                            @foreach($alokasicuti as $data)
                                                <tr>
                                                    {{-- <td>{{$data->id}}</td>
                                                    <td>{{$data->id_settingalokasi}}</td>
                                                    <td>{{$data->id_jeniscuti}}</td>
                                                    <td>{{$data->jeniscutis->jenis_cuti}}</td> --}}
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$data->karyawans->nama}}</td>
                                                    <td>{{$data->jeniscutis->jenis_cuti}}</td>
                                                    <td>{{$data->durasi}}</td>
                                                    {{-- @if($data->tgl_masuk != NULL)
                                                        <td>{{\Carbon\Carbon::parse($data->tgl_masuk)->format('d/m/Y')}}</td>
                                                    @else
                                                        <td></td>
                                                    @endif --}}
                                                    <td>{{$data->mode_alokasi}}</td>
                                                    <td>{{\Carbon\Carbon::parse($data->aktif_dari)->format('d/m/Y')}}</td>
                                                    <td>{{\Carbon\Carbon::parse($data->sampai)->format('d/m/Y')}}</td>
                                                    <td class="text-center"> 
                                                        <div class="row">
                                                            <a id="bs" class="btn btn-info btn-sm showalokasi" data-toggle="modal" data-target="#showalokasi{{$data->id}}">
                                                                <i class="fa fa-eye"></i>
                                                            </a> 
                                                            <a class="btn btn-sm btn-success btn-editalokasi" data-toggle="modal" data-alokasi="{{$data->id}}" data-target="#editalokasi">
                                                                <i class="fa fa-edit"></i>
                                                                {{-- {{$data->id}} --}}
                                                            </a> 
                                                            <button onclick="alokasicuti({{$data->id}})"  class="btn btn-danger btn-sm">
                                                                <i class="fa fa-trash"></i>
                                                            </button> 
                                                        </div> 
                                                   </td> 
                                                </tr>
                                                 <!-- modals show -->
                                                @include('admin.alokasicuti.showalokasi')
                                                @include('admin.alokasicuti.editalokasi')
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
    </div> <!-- content -->
    
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/app.js"></script>
@endsection