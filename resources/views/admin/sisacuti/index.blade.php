@extends('layouts.default')
@section('content')
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
<!-- Header -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <h4 class="pull-left page-title">Sisa Cuti Tahun Sebelumnya</h4>
            
            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Sisa Cuti Tahunan</li>
            </ol>
           
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- Start content -->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading clearfix">
                       <p></p>
                    </div>
                    <div class="panel-body m-b-5">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="datatable-responsive23" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Karyawan</th>
                                            <th>Kategori Cuti</th>
                                            {{-- <th>Jumlah Cuti Tahun Ini </th> --}}
                                            <th>Sisa Cuti Tahun Lalu</th>
                                            <th>Periode</th>
                                            <th>Masa Aktif</th>
                                            <th>Status</th>
                                            {{-- <th>Aksi</th> --}}
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($sisacuti as $data)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$data->karyawans->nama}}</td>
                                                <td>{{$data->jenis_cuti}}</td>
                                                {{-- <td>{{$data->jumlah_cuti}}</td> --}}
                                                <td>{{$data->sisa_cuti}}</td>
                                                <td>{{$data->periode}}</td>
                                                <td>{{\Carbon\Carbon::parse($data->dari)->format('d/m')}} - {{\Carbon\Carbon::parse($data->sampai)->format('d/m Y') }}</td>
                                                <td>
                                                    @if($data->status == 1)
                                                        <span class="badge badge-info">Aktif</span>
                                                    @else
                                                        <span class="badge badge-danger">Kadaluarsa</span>
                                                    @endif
                                                </td>
                                                {{-- <td>
                                                    <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                        <form action="/sisa-cuti/{{$data->id_pegawai}}" method="POST">
                                                            @csrf
                                                            @method('POST')
                                                            <button type="submit" class="btn btn-warning btn-sm fa fa-paper-plane">  Kirim Notifikasi</button>
                                                        </form>
                                                    </div>

                                                </td> --}}
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
    </div>
</div> <!-- content -->

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/pages/datatables.init.js"></script>

{{-- <script src="assets/js/app.js"></script> --}}
@endsection