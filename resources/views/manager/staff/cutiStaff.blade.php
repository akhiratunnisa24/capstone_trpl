@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Transaksi Cuti dan Izin Karyawan</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Human Resources Management System</a></li>
                    <li class="active">Transaksi Cuti & Izin</li>
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
                        <span class="hidden-xs">Transaksi Cuti</span>
                    </a>
                </li>
                <li class="">
                    <a id="tabs_b" href="#mizin" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Transaksi Izin</span>
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
                                                    <table id="datatable-responsive22" class="table table-responsive dt-responsive table-striped table-bordered" width="100%">
                                                        <thead>
                                                            <tr>
                                                                @php
                                                                    use \Carbon\Carbon;
                                                                    $year = Carbon::now()->year;
                                                                @endphp
                                                                <th>No</th>
                                                                <th>Tgl Permohonan</th>
                                                                <th>NIK</th>
                                                                <th>Nama</th>
                                                                <th>Jabatan</th>
                                                                <th>Tanggal Cuti</th>
                                                                <th>Kategori Cuti</th>
                                                                <th>Jumlah Hari Kerja</th>
                                                                <th>Saldo Hak Cuti {{$year}}</th>
                                                                <th>Jumlah Cuti {{$year}}</th>
                                                                <th>Sisa Cuti {{$year}}</th>
                                                                <th>Persetujuan</th>
                                                                <th>Catatan</th>
                                                                <th>Aksi</th>        
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                             @foreach($cutistaff as $data)
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                    <td>{{\Carbon\Carbon::parse($data->tgl_permohonan)->format("d/m/Y")}}</td>
                                                                    <td>{{$data->nik}}</td>
                                                                    <td>{{$data->nama}}</td>
                                                                    <td>{{$data->jabatan}}</td>
                                                                    <td>{{\Carbon\Carbon::parse($data->tgl_mulai)->format("d/m/Y")}} s.d {{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td>
                                                                    <td>{{$data->jenis_cuti}}</td>
                                                                    <td>{{$data->jmlharikerja}}</td>
                                                                    <td>{{$data->saldohakcuti}}</td>
                                                                    <td>{{$data->jml_cuti}}</td>
                                                                    <td>{{$data->sisacuti}}</td>
                                                    
                                                                    <td>
                                                                        {{-- <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' :'')))))) }}">
                                                                            {{ $data->status == 1 ? 'Pending' : ($data->status == 2 ? 'Disetujui Manajer' : ($data->status == 5 ? 'Ditolak' : ($data->status == 6 ? 'Disetujui Asisten Manajer' : ($data->status == 7 ? 'Disetujui' : ($data->status == 9 ? 'Pending Atasan' : ($data->status == 10 ? 'Pending Pimpinan' :'')))))) }}
                                                                        </span> --}}
                                                                        <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                                            {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>{{$data->catatan}}</td>
                                                                    <td id="b" class="text-center" > 
                                                                        <div class="row">
                                                                            @if($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Manajer" && $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('cuti.approved',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui Manajer" class="form-control" hidden> 
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
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Asisten Manajer" && $data->catatan == null)
                                                                    
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('cuti.approved', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cutiTolak{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                             
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('cuti.approved',$data->id)}}" method="POST"> 
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui Manajer" class="form-control" hidden> 
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
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->catatan == "Pembatalan Disetujui Atasan" && $row->jabatan == "Manajer")
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('batal.approved', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('batal.rejected', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->catatan == "Perubahan Disetujui Atasan" && $row->jabatan == "Manajer")
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('ubah.approved', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('ubah.rejected', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Pembatalan" && $row->jabatan == "Manajer")
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('batal.approved', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('batal.rejected', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Perubahan" && $row->jabatan == "Manajer")
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('ubah.approved', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('ubah.rejected', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Pembatalan" && $row->jabatan == "Asisten Manajer")
                                                                            
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('batal.approved', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('batal.rejected', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Perubahan" && $row->jabatan == "Asisten Manajer")
                                                                            
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('ubah.approved', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('ubah.rejected', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                        
                                                                        
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Management" && $data->catatan == null)
                                                                        
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('leave.approved', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cutisTolak{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                @include('direktur.cuti.cutiReject')
                                                                        
                                                                    
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == "Asisten Manajer" && $data->catatan == null)
                                                                            
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('cuti.approved', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cutiTolak{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                        
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == "Manajer" && $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('cuti.approved', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cutiTolak{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2  && $row->jabatan == "Management" && $data->catatan == null)
                                                                                
                                                                                        <div class="col-sm-3">
                                                                                            <form action="{{ route('leave.approved', $data->id) }}" method="POST">
                                                                                                @csrf
                                                                                                <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                                <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                            </form>
                                                                                        </div>
                                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                                            <form action="" method="POST">
                                                                                                <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cutisTolak{{ $data->id }}">
                                                                                                    <i class="fa fa-times fa-md"></i>
                                                                                                </a>
                                                                                            </form>
                                                                                        </div>
                                                                                        @include('direktur.cuti.cutiReject')
    
                                                                
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
                                                                <th>No</th>
                                                                <th>Karyawan</th>
                                                                <th>Kategori Izin</th>
                                                                <th>Keperluan</th>
                                                                <th>Tanggal</th>
                                                                <th>Jml</th>
                                                                <th>Mulai s/d Selesai</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
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
                                                                    <td>
                                                                        {{-- <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : '')))) }}">
                                                                            {{ $data->status == 1 ? 'Pending' : ($data->status == 2 ? 'Disetujui Manajer' : ($data->status == 5 ? 'Ditolak' : ($data->status == 6 ? 'Disetujui Asisten Manajer' : ($data->status == 7 ? 'Disetujui' : '')))) }}
                                                                        </span> --}}
                                                                        <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                                            {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                                                                        </span>
                                                                    </td>

                                                                    <td> 
                                                                        <div class="row">
                                                                            @if ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Manajer" && $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('izin.approved', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#cutiTolak{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Asisten Manajer"  && $data->catatan == null)
                                                                        
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#Reject{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                @include('manager.staff.izinReject')
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Management"  && $data->catatan == null)
                                                                        
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status"
                                                                                            value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal" data-target="#Reject{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                        
                                                                                @include('manager.staff.izinReject')
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == "Asisten Manajer"  && $data->catatan == null)
                                                                            
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm"  style="height:26px" data-toggle="modal" data-target="#Reject{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                @include('manager.staff.izinReject')
                                                                        
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == "Manajer"  && $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm"  style="height:26px" data-toggle="modal" data-target="#Reject{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                @include('manager.staff.izinReject')
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2  && $row->jabatan == "Management"  && $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm"  style="height:26px" data-toggle="modal" data-target="#Reject{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>

                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $row->jabatan == "Manajer"  && $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status"  value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit"  class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm" style="height:26px" data-toggle="modal"  data-target="#Reject{{ $data->id }}">
                                                                                            <i class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                @include('manager.staff.izinReject')    
                                                                            
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->catatan == "Pembatalan Disetujui Atasan" && $row->jabatan == "Manajer")
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('batal.setuju', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('batal.tolak', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->catatan == "Perubahan Disetujui Atasan" && $row->jabatan == "Manajer")
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('ubah.setuju', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('ubah.tolak', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Pembatalan" && $row->jabatan == "Manajer")
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('batal.setuju', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('batal.tolak', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Perubahan" && $row->jabatan == "Manajer")
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('ubah.setuju', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('ubah.tolak', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Pembatalan" && $row->jabatan == "Asisten Manajer")
                                                                            
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('batal.setuju', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('batal.tolak', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Perubahan" && $row->jabatan == "Asisten Manajer")
                                                                            
                                                                                <div class="col-sm-3">
                                                                                    <form action="{{ route('ubah.setuju', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                                    <form action="{{ route('ubah.tolak', $data->id) }}" method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                                        <button type="submit" class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @else
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