@extends('layouts.default')
@section('content')
<!-- Header -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <h4 class="pull-left page-title">Setting Cuti tahunan</h4>

            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Setting Cuti Tahunan</li>
            </ol>
           
            <div class="clearfix"></div>
        </div>
    </div>
<!-- Start content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                        {{-- <form action="/reset-cuti-tahunan" method="POST" align="center">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-dark btn-sm fa fa-refresh pull-right"> Reset Cuti Tahunan</button>
                        </form> --}}
                        @if(date('m') == 4 && date('d') == 10)
                            <form action="/reset-cuti-tahun-ini" method="POST" align="center">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-dark btn-sm fa fa-refresh pull-right"> Kosongkan Data</button>
                            </form>
                        @else
                            <form action="/reset-cuti-tahunan" method="POST" align="center">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-dark btn-sm fa fa-refresh pull-right"> Reset Cuti Tahunan</button>
                            </form>
                        @endif

                    </div>
                    
                    <div class="panel-body m-b-5">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="datatable-responsive11" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Karyawan</th>
                                            <th>kategori Cuti</th>
                                            <th>Jumlah Cuti Tahun Ini</th>
                                            <th>Sisa Cuti Tahun Lalu</th>
                                            <th>Periode</th>
                                            {{-- <th>Aksi</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($settingcuti as $item)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item->karyawans->nama}}</td>
                                                <td>{{$item->jeniscutis->jenis_cuti}}</td>
                                                <td>{{$item->jumlah_cuti}}</td>
                                                <td>{{$item->sisa_cuti}}</td>
                                                <td>{{$item->periode}}</td>
                                                {{--<td class="text-center">
                                                    <a id="bs" class="btn btn-info btn-sm Modalshowsetting"
                                                        data-toggle="modal" data-target="#Modalshowsetting{{$data->id}}">
                                                        <i class="fa fa-eye"></i>
                                                    </a> --}}
                                                    {{-- <a id="bs" class="btn btn-sm btn-success editsetting"
                                                        data-toggle="modal" data-target="#editsetting{{$data->id}}">
                                                        <i class="fa fa-edit"></i>
                                                    </a> --}}
                                                    {{-- <button onclick="settingalokasi({{$data->id}})"
                                                        class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr> --}}
                                        {{-- modals show setting --}}
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- content -->
</div>

    <script src="assets/js/jquery.min.js"></script>
@endsection