@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Data Cuti Staff</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Human Resources Management System</a></li>
                    <li class="active">Data Cuti</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- Close Header -->

    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Data Cuti Staff</h3>
                        </div>
                        <div class="panel-body m-b-5">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <table id="datatable-responsive12" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Karyawan</th>
                                                <th>Kategori</th>
                                                <th>Tgl. Mulai</th>
                                                <th>Tgl.Selesai</th>
                                                <th>Jml. Cuti</th>
                                                <th>Status</th>
                                                <th>Aksi</th>        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cuti as $data)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$data->nama}}</td>
                                                    <td>{{$data->jenis_cuti}}</td>
                                                    <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}}</td>
                                                    <td>{{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td>
                                                    <td>{{$data->jml_cuti}} Hari</td>
                                                    <td>
                                                        <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : '')))) }}">
                                                            {{ $data->status == 1 ? 'Pending' : ($data->status == 2 ? 'Disetujui Manager' : ($data->status == 5 ? 'Ditolak' : ($data->status == 6 ? 'Disetujui Supervisor' : ($data->status == 7 ? 'Disetujui' : '')))) }}
                                                        </span>
                                                    </td>
                                                    <td id="b" class="text-center" > 
                                                        <div class="row">
                                                            @if(($data->jabatan == 'Supervisor' && $data->status == 2))
                                                                <div class="col-sm-3">
                                                                    <form action="{{ route('leave.approved',$data->id)}}" method="POST"> 
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="Disetujui Manager" class="form-control" hidden> 
                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button> 
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:8px">
                                                                    <form action="" method="POST"> 
                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cutisTolak{{$data->id}}">
                                                                            <i class="fa fa-times fa-md"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                                 {{-- {{ route('leave.rejected',$data->id)}} --}}
                                                                    {{-- <form action="" method="POST"> 
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="status" value="Ditolak" class="form-control" hidden> 
                                                                        <button  type="submit" class="fa fa-times btn-danger btn-sm"></button> 
                                                                    </form> --}}
                                                            @elseif(($data->jabatan == 'Manager' && $data->status == 1))
                                                                <div class="col-sm-3">
                                                                    <form action="{{ route('leave.approved',$data->id)}}" method="POST"> 
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="Disetujui Manager" class="form-control" hidden> 
                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button> 
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:8px">
                                                                    <form action="" method="POST"> 
                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cutisTolak{{$data->id}}">
                                                                            <i class="fa fa-times fa-md"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                            @else

                                                            @endif

                                                            <div class="col-sm-3" style="margin-left:6px">
                                                                <form action="" method="POST"> 
                                                                    <a  class="btn btn-info btn-sm" style="height:26px" data-toggle="modal" data-target="#shoCutiStaff{{$data->id}}">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </form> 
                                                            </div>
                                                        </div>
                                                    </td> 
                                                </tr>
                                                @include('direktur.cuti.show')
                                                @include('direktur.cuti.cutiReject')
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