@extends('layouts.default')
@section('content')
<head>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <h4 class="pull-left page-title ">Slip Gaji Karyawan</h4>

            <ol class="breadcrumb pull-right">
                <li>Rynest Employee Management System</li>
                <li class="active">Slip Gaji</li>
            </ol>

            <div class="clearfix">
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary">
                    <div class="panel-heading  col-sm-15 clearfix" >
                        <div class="pull-right" style="height:20px;">
                            {{-- <a href="" class="btn btn-dark btn-sm fa fa-plus" data-toggle="modal" data-target="#addslip"> Tambah Slip Baru</a> --}}
                        </div>
                    </div>
                    <div class="panel-body m-b-5">
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <table id="datatable-responsive49" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tgl.Gajian</th>
                                            <th>Periode</th>
                                            <th>Karyawan</th>
                                            {{-- <th>Jabatan</th> --}}
                                            <th>Tgl Masuk</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($slipgaji as $data)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{\Carbon\Carbon::parse($data->tgl_gajian)->format('d/m/Y')}}</td>
                                                <td>{{\Carbon\Carbon::parse($data->tglawal)->format('d/m/Y')}} - {{\Carbon\Carbon::parse($data->tglakhir)->format('d/m/Y')}}</td>
                                                <td>{{$data->karyawans->nama}}</td>
                                                {{-- <td>{{$data->karyawans->nama_jabatan}}</td> --}}
                                                <td>{{\Carbon\Carbon::parse($data->karyawans->tglmasuk)->format('d/m/Y')}}</td>
                                                
                                                    @if($data->karyawans->divisi !== null && $data->karyawans->jabatan !== null && $data->karyawans->nama_jabatan !== null  && $data->nama_bank !== null && $data->no_rekening !== null && $data->gaji_pokok !== null)
                                                        <td>Data Lengkap</td>
                                                    @elseif($data->karyawans->divisi === null  || $data->karyawans->jabatan === null || $data->karyawans->nama_jabatan === null || $data->nama_bank === null || $data->no_rekening === null || $data->nama_bank === null && $data->no_rekening === null || $data->gaji_pokok === null)  
                                                        <td style="color: rgb(240, 20, 20)">Lengkapi Data</td>
                                                    @endif
                                                
                                                <td>
                                                    <div  class="d-grid gap-2" role="group" aria-label="Basic example">
                                                        <a href="" class="col-md-6 btn btn-info btn-sm" data-toggle="modal" data-target="#editslip{{$data->id_karyawan}}" style="width:35px;"><i class="fa fa-edit"></i></a>
                                                        @if($data->karyawans->divisi !== null  && $data->karyawans->jabatan !== null && $data->karyawans->nama_jabatan !== null && $data->nama_bank !== null && $data->no_rekening !== null && $data->nama_bank !== null && $data->no_rekening !== null && $data->gaji_pokok !== null)  
                                                            <form method="POST" action="/slipgaji{{$data->id}}" class="col-md-1">
                                                            @csrf
                                                            @method('PUT')
                                                                <input type="hidden" name="id_karyawan" value="{{ $data->karyawans->id }}">
                                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                                                <button type="submit" class="btn btn-success btn-sm" title="Lihat Slip Gaji"><i class="fa fa-eye"></i></button>
                                                            </form>
                                                        @endif
                                                     
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
        </div> <!-- End Row -->
    </div> <!-- container -->
</div> 
@foreach($slipgaji as $data)
       @include('admin.penggajian.editrekening')
    @endforeach
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
@endsection

