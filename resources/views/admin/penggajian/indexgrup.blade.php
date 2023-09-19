@extends('layouts.default')
@section('content')
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css">
<link rel="stylesheet" src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.css">
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th, td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    th:nth-child(1),
    td:nth-child(1) {
        width: 5%;
    }

    th:nth-child(2),
    td:nth-child(2) {
        width: 20%;
    }

    th:nth-child(3),
    td:nth-child(3) {
        width: 20%;
    }

    th:nth-child(4),
    td:nth-child(4) {
        width: 20%;
    }

    th:nth-child(5),
    td:nth-child(5) {
        width: 10%;
    }

    th:nth-child(6),
    td:nth-child(6) {
        width: 10%;
    }

    th:nth-child(7),
    td:nth-child(7) {
        width: 15%;
    }
</style>

    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Slip Gaji Grup</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Rynest Employee Management System</a></li>
                    <li class="active">Slip Gaji</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading  col-sm-15 clearfix" >
                            <div class="pull-right">
                                <a href="" class="btn btn-dark btn-sm fa fa-plus" data-toggle="modal" data-target="#addslip-grup"> Tambah Slip Baru</a>
                            </div>
                        </div>
                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable-responsive49" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Grup</th>
                                                <th>Tgl. Gajian</th>
                                                <th>Periode</th>
                                                <th>Jumlah Slip</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($slipgrupindex as $data)
                                               
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>{{$data->nama_grup}}</td>
                                                        <td>{{\Carbon\Carbon::parse($data->tglgajian)->format('d/m/Y')}}</td>
                                                        <td>{{\Carbon\Carbon::parse($data->tglawal)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($data->tglakhir)->format('d/m/Y')}}</td>
                                                        <td>
                                                            @php
                                                                $jumlahData = $slip->where('tglawal', $data->tglawal)
                                                                    ->where('tglakhir', $data->tglakhir)
                                                                    ->where('partner',$data->partner)
                                                                    ->count();
                                                            @endphp
                                                            {{$jumlahData}} slip
                                                        </td>
                                                        <td>
                                                            <div  class="d-grid gap-2" role="group" aria-label="Basic example">
                                                                {{-- <a href="/slipgaji-karyawan-grup/{{$data->id}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> 
                                                                 --}}
                                                                 <a href="/slipgaji-grup{{ $data->id }}" class="btn btn-info btn-sm" title="Lihat Identitas" target="_blank"><i class="fa fa-eye" style="font-size: 15px;"></i></a>
                                                                 {{-- <a href="{{ route('showslipgroup', ['id' => $data->id]) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a> --}}

                                                          </div>
                                                        </td>
                                                    </tr>
                                                
                                                {{-- @include('admin.penggajian.editgrup') --}}
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
    @include('admin.penggajian.addgrup')

    <script src="assets/pages/form-advanced.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

    @if(Session::has('pesan'))
        <script>
            swal("Selamat","{{ Session::get('pesan')}}", 'success', {
                button:true,
                button:"OK",
            });
        </script>
    @endif

    @if(Session::has('pesa'))
        <script>
            swal("Mohon Maaf","{{ Session::get('pesa')}}", 'error', {
                button:true,
                button:"OK",
            });
        </script>
    @endif

    @if (Session::has('message'))
        <script>
            swal("Mohon Maaf",<?php echo json_encode( Session::get('message') ) ?>, 'info', {
                button: false,
                button: "OK",
            });
        </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@endsection
