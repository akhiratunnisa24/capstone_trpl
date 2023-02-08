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
    <div class="row">
        <div class="col-lg-12">
            <ul class="nav nav-tabs navtab-bg">
                <li class="active">
                    <a id="tabs_a" href="#mcuti" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Permintaan Cuti</span>
                    </a>
                </li>
                <li class="">
                    <a id="tabs_b" href="#mizin" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Permintaan Izin</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="mcuti">
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" style="height:35px">
                                        </div>
                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <table id="datatable-responsive3" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                {{-- <th>id</th> --}}
                                                                <th>Karyawan</th>
                                                                <th>Kategori</th>
                                                                {{-- <th>ID Kategori</th> --}}
                                                                <th>Tgl. Mulai</th>
                                                                <th>Tgl.Selesai</th>
                                                                <th>Jml. Cuti</th>
                                                                {{-- <th>Departemen</th> --}}
                                                                @if(Auth::user()->role == 3)
                                                                    <th>Approval</th>
                                                                @endif
                                                                <th>Status</th>
                                                                <th>Action</th>        
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                             @foreach($cutistaff as $data)
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                    {{-- <td>{{$data->id}}</td> --}}
                                                                    <td>{{$data->nama}}</td>
                                                                    <td>{{$data->jenis_cuti}}</td>
                                                                    {{-- <td>{{$data->id_jeniscuti}}</td> --}}
                                                                    <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}}</td>
                                                                    <td>{{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td>
                                                                    <td>{{$data->jml_cuti}} Hari</td>
                                                                    @if(Auth::user()->role == 3)
                                                                        <td>{{$data->tipe_approval}}</td>
                                                                    @endif
                                                                    {{-- <td>{{$data->departemen}}</td> --}}
                                                                    @if($data->status == 'Pending')
                                                                        <td>
                                                                            <span class="badge badge-warning">Pending</span>
                                                                        </td>
                                                                    @elseif($data->status == 'Disetujui Manager')
                                                                        <td>
                                                                            <span class="badge badge-info">Disetujui Manager</span>
                                                                        </td>
                                                                    @elseif($data->status == 'Disetujui Supervisor')
                                                                        <td>
                                                                            <span class="badge badge-secondary">Disetujui Supervisor</span>
                                                                        </td>
                                                                    @elseif($data->status == 'Disetujui')
                                                                        <td>
                                                                            <span class="badge badge-success">Disetujui</span>
                                                                        </td>
                                                                    @elseif($data->status == 3)
                                                                        <td>
                                                                            <span class="badge badge-success">Disetujui</span>
                                                                        </td>
                                                                    @else
                                                                        <td>
                                                                            <span class="badge badge-danger">Ditolak</span>
                                                                        </td>
                                                                    @endif
                                                                    <td id="b" class="text-center" > 
                                                                        <div class="row">
                                                                            @if($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 'Pending')
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('cuti.approved',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui Manager" class="form-control" hidden> 
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button> 
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:8px">
                                                                                    <form action="" method="POST"> 
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cutiTolak{{$data->id}}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                {{-- <div class="col-sm-3" style="margin-left:8px">
                                                                                    <form action="{{ route('cuti.reject',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        @method('POST')
                                                                                        <input type="hidden" name="status" value="Ditolak" class="form-control" hidden> 
                                                                                        <button  type="submit" class="fa fa-times btn-danger btn-sm"></button> 
                                                                                    </form>
                                                                                </div> --}}
                                                                            @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 'Disetujui Supervisor')
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('cuti.approved',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui Manager" class="form-control" hidden> 
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button> 
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:8px">
                                                                                    <form action="" method="POST"> 
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cutiTolak{{$data->id}}">
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
                                                                @include('manager.staff.showCuti')
                                                                @include('manager.staff.cutiReject')
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
                </div>
                <div class="tab-pane" id="mizin">
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-13">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading" style="height:35px">
                                            {{-- <strong>Data Permintaan Izin</strong> --}}
                                        </div>
                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <table  id="datatable-responsive12" class="table dt-responsive table-striped table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Karyawan</th>
                                                                <th>Kategori Izin</th>
                                                                <th>Keperluan</th>
                                                                <th>Tanggal</th>
                                                                <th>Jml</th>
                                                                <th>Mulai s/d Selesai</th>
                                                                <th>Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($izinstaff as $data)
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                    <td>{{$data->nama}}</td>
                                                                    <td>{{$data->jenis_izin}}</td>
                                                                    <td>{{$data->keperluan}}</td>

                                                                    {{-- tanggal mulai & tanggal selesai --}}
                                                                    @if($data->tgl_mulai != $data->tgl_selesai)
                                                                        <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}} s/d {{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td>
                                                                    @else
                                                                        <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/M/Y")}}</td>
                                                                    @endif

                                                                    {{-- Jumlah hari izin --}}
                                                                    @if($data->jml_hari != null)
                                                                        <td>{{$data->jml_hari}} Hari</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif

                                                                    {{-- jam mulai & jam selesai --}}
                                                                    @if($data->jam_mulai != null && $data->jam_mulai !=null)
                                                                        <td>{{\Carbon\Carbon::parse($data->jam_mulai)->format("H:i")}} s/d {{\Carbon\Carbon::parse($data->jam_selesai)->format("H:i")}}</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif

                                                                    {{-- status --}}
                                                                    @if($data->status == 'Pending')
                                                                        <td>
                                                                            <span class="badge badge-warning">Pending</span>
                                                                        </td>
                                                                    @elseif($data->status == 'Disetujui Manager')
                                                                        <td>
                                                                            <span class="badge badge-info">Disetujui Manager</span>
                                                                        </td>
                                                                    @elseif($data->status == 'Disetujui')
                                                                        <td>
                                                                            <span class="badge badge-success">Disetujui</span>
                                                                        </td>
                                                                    @else
                                                                        <td>
                                                                            <span class="badge badge-danger">Ditolak</span>
                                                                        </td>
                                                                    @endif

                                                                    <td> 
                                                                        <div class="row">
                                                                            @if($data->status == 'Pending')
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('izin.approved',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden> 
                                                                                        <button  type="submit" class="fa fa-check btn-success btn-sm"></button> 
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST"> 
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#Reject{{$data->id}}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                {{-- <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('izin.reject',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        @method('POST')
                                                                                        <input type="hidden" name="status" value="Ditolak" class="form-control" hidden> 
                                                                                        <button type="submit" class="fa fa-times btn-danger btn-sm"></button> 
                                                                                    </form>
                                                                                </div> --}}
                                                                            @endif
                
                                                                            <div class="col-sm-3" style="margin-left:5px">
                                                                                <form action="" method="POST"> 
                                                                                    <a class="btn btn-info btn-sm" style="height:26px" data-toggle="modal" data-target=" #Showizinm{{$data->id}}">
                                                                                        <i class="fa fa-eye fa-md"></i>
                                                                                    </a>
                                                                                </form> 
                                                                            </div>
                                                                            {{-- modal show izin --}}
                                                                            @include('manager.staff.showIzin')
                                                                            @include('manager.staff.izinReject')
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/pages/datatables.init.js"></script>

    <script type="text/javascript">
        let t = `{{$tp}}`;

        if(t == 1) 
        {
            $('#tabs_a').click();
        }else{
            $('#tabs_b').click();
        }
    </script>    
@endsection