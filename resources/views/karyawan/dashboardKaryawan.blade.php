@extends('layouts.default')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Dashboard </h4>
                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Dashboard</li>
                </ol>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    {{-- <php
        use App\Models\Karyawan;
        $row = Karyawan::where('id', Auth::user()->id_pegawai)->select('jabatan')->first();
            
    ?> --}}

    @if (Auth::check() && Auth::user()->role == 1 || Auth::check() && Auth::user()->role == 3)
        {{-- @php dd($row->jabatan, Auth::user()->role) @endphp --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="panel-group " id="accordion-test-2">
                    <div class="panel panel-default ">
                        <div class="panel-heading ">
                            <h4 class="panel-title ">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#1" aria-expanded="false"
                                    class="dropdown-toggle waves-effect waves-light collapsed">
                                    Permintaan Cuti Karyawan
                                    
                                    @if($cutijumlah)
                                        <span class="badge badge badge-danger" style="background-color:red">{{$cutijumlah}}</span>
                                    @endif

                                </a>
                            </h4>
                        </div>
                        <div id="1" class="panel-collapse collapse">

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="info">
                                                    <th>No</th>
                                                    <th>Karyawan</th>
                                                    <th>Cuti</th>
                                                    <th>Mulai</th>
                                                    {{-- <th>Cuti</th> --}}
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cuti as $data)
                                                    @if($data->catatan == NULL)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->nama }}</td>
                                                            <td>{{ $data->jenis_cuti }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}</td>
                                                            {{-- <td>{{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td> --}}
                                                            {{-- <td>{{ $data->jml_cuti }} Hari</td> --}}
                                                            <td>
                                                                {{-- {{ $data->status }} --}}
                                                                <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : ($data->status == 14 ? 'warning' :($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' :  'secondary' )))))))))))) }}">
                                                                    {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status :  ($data->status == 14 ?  $data->name_status :  ($data->status == 15 ?  $data->name_status :  ($data->status == 16 ?  $data->name_status : '')))))))))))) }}
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <div class="row">
                                                                    
                                                                    @if ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Manajer")
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
                                                                    
                                                                    @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Asisten Manajer")
                                                                    
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
                                                                    
                                                                    @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Direksi")
                                                                
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

                                                
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == "Asisten Manajer")
                                                                    
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
                                                                    
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == "Manajer")
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
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2  && $row->jabatan == "Direksi")
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

                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6  && $row->jabatan == "Manajer")
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
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6  && $row->jabatan == "Direksi")
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
                                                                            <a class="btn btn-info btn-sm" style="height:26px"
                                                                                data-toggle="modal"
                                                                                data-target="#Showcuti{{ $data->id }}">
                                                                                <i class="fa fa-eye"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    {{-- modal show cuti --}}
                                                    @endif
                                                    @include('admin.cuti.showcuti')
                                                    @include('manager.staff.cutiReject')
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="panel panel-default ">
                        <div class="panel-heading ">
                            <h4 class="panel-title ">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#7" aria-expanded="false"
                                    class="dropdown-toggle waves-effect waves-light collapsed">
                                    Pembatalan dan Perubahan Cuti Karyawan
                                    
                                    @if($jumct)
                                        <span class="badge badge badge-danger" style="background-color:red">{{$jumct}}</span>
                                    @endif
                                </a>
                            </h4>
                        </div>
                        <div id="7" class="panel-collapse collapse">

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="info">
                                                    <th>No</th>
                                                    <th>Karyawan</th>
                                                    <th>Cuti</th>
                                                    <th>Tanggal</th>
                                                    <th>Catatan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($cutis as $data)
                                                   
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->nama }}</td>
                                                            <td>{{ $data->jenis_cuti }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}</td>
                                            
                                                            <td> {{$data->catatan}}</td>

                                                            <td>
                                                                <div class="row">
                                                                    
                                                                    @if ($data->atasan_kedua == Auth::user()->id_pegawai && $data->catatan == "Pembatalan Disetujui Atasan" && $row->jabatan == "Manajer")
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
                                                                   
                                                                    @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Pembatalan" && $row->jabatan == "Direksi")
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
                                                                    @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Perubahan" && $row->jabatan == "Direksi")
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
                                                                    @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->catatan == "Pembatalan Disetujui Atasan" && $row->jabatan == "Direksi")
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
                                                                    @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->catatan == "Perubahan Disetujui Atasan" && $row->jabatan == "Direksi")
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
                                                                    @else
                                                                    @endif
                                                                    <div class="col-sm-3" style="margin-left:6px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-info btn-sm" style="height:26px"
                                                                                data-toggle="modal"
                                                                                data-target="#Showcuti{{ $data->id }}">
                                                                                <i class="fa fa-eye"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    
                                                    {{-- modal show cuti --}}
                                                    @include('admin.cuti.showcuti')
                                                    @include('manager.staff.cutiReject')
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#3" class="collapsed"
                                    aria-expanded="false">
                                    Permintaan Resign Karyawan
                                    
                                    @if ($resignjumlah)
                                        <span class="badge badge badge-danger" style="background-color:red">{{ $resignjumlah }}</span>

                                    @endif
                                </a>
                            </h4>
                        </div>
                        <div id="3" class="panel-collapse collapse">

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="info">
                                                    <th>No</th>
                                                    <th>Karyawan</th>
                                                    <th>Departemen</th>
                                                    <th>Tanggal</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($resign as $r)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $r->karyawan->nama }}</td>
                                                        <td>{{ $r->departemens->nama_departemen ?? ' ' }}</td>
                                                        {{-- <td>{{ \Carbon\Carbon::parse($r->tgl_masuk)->format('d/m/Y') }}</td> --}}
                                                        <td>{{ \Carbon\Carbon::parse($r->tgl_resign)->format('d/m/Y') }}</td>
                                                        {{-- <td>{{ $r->tipe_resign }}</td> --}}
                                                        <!-- data for status -->
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ $r->status == 8 ? 'warning' : ($r->status == 2 ? 'info' : ($r->status == 3 ? 'success' : ($r->status == 4 ? 'warning' : 'danger'))) }}">
                                                                {{ $r->status == 8 ? $r->statuses->name_status : ($r->status == 2 ? $r->statuses->name_status : ($r->status == 3 ? $r->statuses->name_status : ($r->status == 4 ? $r->statuses->name_status : 'Ditolak'))) }}
                                                            </span>
                                                        </td>
                                                        <td id="b" class="text-center">
                                                            <div class="btn-group" role="group">
                                                                @if ($r->status == 2 || $r->status == 4)
                                                                    <form action="{{ route('resignapproved', $r->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status" value=1
                                                                            class="form-control" hidden>
                                                                        <button type="submit" class="btn btn-success btn-sm">
                                                                            <i class="fa fa-check"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ route('resignreject', $r->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="status" value=5
                                                                            class="form-control" hidden>
                                                                        <button type="submit" class="btn btn-danger btn-sm">
                                                                            <i class="fa fa-times"></i>
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                                <a class="btn btn-info btn-sm" data-toggle="modal"
                                                                    data-target="#Showresign{{ $r->id }}">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @include('karyawan.resign.showresign')
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

            <div class="col-lg-6">
                <div class="panel-group" id="accordion-test-2">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#2" class="collapsed"
                                    aria-expanded="false">
                                    Permintaan Izin Karyawan
                                    
                                    @if ($izinjumlah)
                                        <span class="badge badge badge-danger" style="background-color:red">{{ $izinjumlah }}</span>
                                    @elseif(!$izinjumlah)
                                    @endif
                                </a>

                            </h4>
                        </div>
                        <div id="2" class="panel-collapse collapse">

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="info">
                                                    <th>No</th>
                                                    <th>Karyawan</th>
                                                    <th>Izin</th>
                                                    <th>Tanggal</th>
                                                    {{-- <th>Hari</th> --}}
                                                    {{-- <th>Jam</th> --}}
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($izin as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data->nama }}</td>
                                                        <td>{{ $data->jenis_izin }}</td>
                                                        @if ($data->tgl_mulai != null && $data->tgl_selesai != null)
                                                            <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                                s/d
                                                                {{ \Carbon\Carbon::parse($data->tgl_selesai)->format('d/m/Y') }}
                                                            </td>
                                                        @else
                                                            <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/M/Y') }}
                                                            </td>
                                                        @endif

                                                    
                                                        <td>
                                                           
                                                            <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : 'secondary' ))))))))) }}">
                                                                {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ?  $data->name_status : ($data->status == 5 ?  $data->name_status : ($data->status == 6 ?  $data->name_status : ($data->status == 7 ?  $data->name_status : ($data->status == 9 ?  $data->name_status : ($data->status == 10 ?  $data->name_status : ($data->status == 11 ?  $data->name_status : ($data->status == 12 ?  $data->name_status : ($data->status == 13 ?  $data->name_status : ''))))))))) }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <div class="row">
                                                                @if ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Manajer")
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
                                                                    @include('admin.cuti.izinReject')
                                                                @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Asisten Manajer")
                                                            
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
                                                                @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == "Direksi")
                                                            
                                                                    <div class="col-sm-3">
                                                                        <form action="{{ route('izin.approv', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                            <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"  style="height:26px" data-toggle="modal" data-target="#izinTolak{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('direktur.cuti.izinReject')    
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == "Asisten Manajer")
                                                                
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
                                                            
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == "Manajer")
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
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2  && $row->jabatan == "Direksi")
                                                                <div class="col-sm-3">
                                                                    <form action="{{ route('izin.approv', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                    <form action="" method="POST">
                                                                        <a class="btn btn-danger btn-sm"  style="height:26px" data-toggle="modal" data-target="#izinTolak{{ $data->id }}">
                                                                            <i class="fa fa-times fa-md"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                                @include('direktur.cuti.izinReject')    
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6  && $row->jabatan == "Direksi")
                                                                    <div class="col-sm-3">
                                                                        <form action="{{ route('izin.approv', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status" value="Disetujui" class="form-control" hidden>
                                                                            <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"  style="height:26px" data-toggle="modal" data-target="#izinTolak{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('direktur.cuti.izinReject')    
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $row->jabatan == "Manajer")
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
                                                                @else
                                                                @endif

                                                                <div class="col-sm-3" style="margin-left:5px">
                                                                    <form action="" method="POST">
                                                                        <a class="btn btn-info btn-sm" style="height:26px"
                                                                            data-toggle="modal"
                                                                            data-target="#Showizinadmin{{ $data->id }}">
                                                                            <i class="fa fa-eye fa-md"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                                {{-- modal show izin --}}
                                                                @include('admin.cuti.showizin')
                                                                {{-- @include('admin.cuti.izinReject') --}}
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

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#8" class="collapsed"
                                    aria-expanded="false">
                                    Pembatalan/Perubahan Sakit/Ijin 
                                    
                                    @if ($jumizin)
                                        <span class="badge badge badge-danger" style="background-color:red">{{ $jumizin }}</span>
                                    @endif
                                </a>

                            </h4>
                        </div>
                        <div id="8" class="panel-collapse collapse">

                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="info">
                                                    <th>No</th>
                                                    <th>Karyawan</th>
                                                    <th>Izin</th>
                                                    <th>Tanggal</th>
                                                    <th>Catatan</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($ijin as $data)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data->nama }}</td>
                                                        <td>{{ $data->jenis_izin }}</td>
                                                        @if ($data->tgl_mulai != null && $data->tgl_selesai != null)
                                                            <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                                s/d
                                                                {{ \Carbon\Carbon::parse($data->tgl_selesai)->format('d/m/Y') }}
                                                            </td>
                                                        @else
                                                            <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/M/Y') }}
                                                            </td>
                                                        @endif
                                                        
                                                        <td>{{$data->catatan}}</td>

                                                        <td>
                                                            <div class="row">
                                                                {{-- @if ($data->status == 'Pending' || $data->status == 'Disetujui Manajer') --}}
                                                                <div class="row">
                                                                    
                                                                    @if ($data->atasan_kedua == Auth::user()->id_pegawai && $data->catatan == "Pembatalan Disetujui Atasan" && $row->jabatan == "Manajer")
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
                                                                    @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->catatan == "Pembatalan Disetujui Atasan" && $row->jabatan == "Direksi")
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
                                                                    @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->catatan == "Perubahan Disetujui Atasan" && $row->jabatan == "Direksi")
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
                                                                    @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Pembatalan" && $row->jabatan == "Direksi")
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
                                                                    @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->catatan == "Mengajukan Perubahan" && $row->jabatan == "Direksi")
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
                                                                    @endif
                                                                    
                                    
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:5px">
                                                                    <form action="" method="POST">
                                                                        <a class="btn btn-info btn-sm" style="height:26px"
                                                                            data-toggle="modal"
                                                                            data-target="#Showizinadmin{{ $data->id }}">
                                                                            <i class="fa fa-eye fa-md"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                                {{-- modal show izin --}}
                                                                @include('admin.cuti.showizin')
                                                                @include('admin.cuti.izinReject')
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

                @if (Auth::check() && Auth::user()->role == 1 || Auth::check() && Auth::user()->role == 2)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#5"
                                    aria-expanded="false" class="collapsed">
                                    Data Rekruitmen
                                </a>
                            </h4>
                        </div>
                        <div id="5" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr class="info">
                                                    <th>No</th>
                                                    <th>Lowongan</th>
                                                    {{-- <th>Pelamar</th> --}}
                                                    <th>Dibutuhkan</th>
                                                    <th>Aktif Dari</th>
                                                    <th>Berakhir</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($posisi as $k)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $k->posisi }}</td>
                                                        {{-- <td>{{ $k->jeniscutis->jenis_cuti }}</td> --}}
                                                        <td>{{ $k->jumlah_dibutuhkan }} Orang</td>
                                                        <td>{{ \Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y') }}
                                                        </td>
                                                        <td>{{ \Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y') }}</td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                    
                </div>
            </div>
        </div> <!-- end row -->
    @endif

    

    <!-- baris kedua -->
    <div class="row">
        <div id="a" class="col-md-9">
            <div id="a" class="panel panel-secondary">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12">
                            @if(count($sisacutis)> 0)
                                <table class="table table-striped">
                                    <label><b>Sisa Cuti Tahun Lalu</b></label>
                                    <thead>
                                        <tr class="info">
                                            <th>No</th>
                                            <th>Nama Karyawan</th>
                                            <th>Kategori Cuti</th>
                                            <th>Sisa Cuti Tahun Lalu</th>
                                            <th>Periode</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($sisacutis as $key => $sisa)
                                            @if($sisa->id_pegawai == Auth::user()->id_pegawai)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $sisa->karyawans->nama }}</td>
                                                    <td>{{ $sisa->jenis_cuti }}</td>
                                                    <td>{{ $sisa->sisa_cuti }} hari</td>
                                                    <td>{{ $sisa->periode}}</td>
                                                    <td>
                                                       <a href="" class="btn btn-sm btn-danger fa fa-plus pull-right" data-toggle="modal" data-target="#mModal"> Ambil Cuti</a>
                                                    </td>
                                                </tr>
                                            @endif
                                            @include('karyawan.addcuti')
                                        @empty
                                            @if($sisa->id_pegawai != Auth::user()->id_pegawai)
                                                <tr>
                                                    <td colspan="12" class="text-center">No data available in table.</td>
                                                </tr>
                                            @endif
                                        @endforelse
                                    </tbody>
                                </table>
                            @endif

                            <table class="table table-striped">
                                <label><b>Alokasi Cuti Tahun Ini</b></label>
                                <thead>
                                    <tr class="info">
                                        <th>No</th>
                                        <th>Nama Karyawan</th>
                                        <th>Kategori Cuti</th>
                                        <th>Durasi Cuti</th>
                                        <th>Durasi Aktif</th>
                                        {{-- <th>Berakhir</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($alokasicuti as $alokasi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $alokasi->karyawans->nama }}</td>
                                            <td>{{ $alokasi->jeniscutis->jenis_cuti }}</td>
                                            <td>{{ $alokasi->durasi }} hari</td>
                                            <td>{{ \Carbon\Carbon::parse($alokasi->aktif_dari)->format('d/m/Y') }}  s.d {{ \Carbon\Carbon::parse($alokasi->sampai)->format('d/m/Y') }}</td>
                                            {{-- <td>{{ \Carbon\Carbon::parse($alokasi->sampai)->format('d/m/Y') }}</td> --}}
                                        </tr>
                                    @endforeach
    
                                    <!-- mencari jumlah cuti -->
                                    @php
                                        $jml = 0;
                                    @endphp
                                    @foreach ($alokasicuti as $key => $alokasi)
                                        @php
                                            $jml += $alokasi->durasi;
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line text-right"><strong>Jumlah Cuti</strong></td>
                                        <td class="thick-line text-left">{{ $jml }} hari</td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                        <td class="thick-line"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-primary text-center">
                <div class="panel-heading btn-success">
                    <h4 class="panel-title">Absen Hari Ini</h4>
                </div>
                <?php
                    use Illuminate\Support\Facades\Auth;
                    use App\Models\Absensi;
                    if ($absenKaryawan == 1 ) { 
                ?>
                <div class="panel-body">
                    <h3 class=""><b class="text text-success">Sukses</b></h3>
                    <p class="text-muted"><b>Anda Sudah Berhasil Absen</b></p>
                </div>
                <?php
                    } else { 
                ?>
                <div class="panel-body">
                    <h3 class=""><a href="{{url("absensi-karyawan")}}"><b class="text text-danger">Belum Absen</b></a></h3>
                    <p class="text-muted"><b>Anda Belum Absen</b></p>
                </div>
                <?php } ?>
            </div>
        </div>
        
    </div> <!-- End Row -->

    <!-- baris kedua -->
    <div class="row">

       
         <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-teal text-center">
                <div class="panel-heading btn-success">
                    <h4 class="panel-title">Data Absen Bulan Ini</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenBulanini }}</b></h3>
                    <p class="text-muted"><b>Kali absensi</b></p>
                </div>
            </div>
        </div>


        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-teal text-center">
                <div class="panel-heading btn-success">
                    <h4 class="panel-title">Data Absen Bulan Lalu</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenBulanlalu }}</b></h3>
                    <p class="text-muted"><b>Kali absensi</b></p>
                </div>
            </div>
        </div>

        
        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-primary text-center">
                <div class="panel-heading btn-warning">
                    <h4 class="panel-title">Terlambat Bulan Ini</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenTerlambatkaryawan }}</b></h3>
                    <p class="text-muted"><b>Kali absensi</b> </p>
                </div>
            </div>
        </div>
        
        <div class="col-sm-6 col-lg-3">
            <div id="a" class="panel panel-teal text-center">
                <div class="panel-heading btn-warning">
                    <h4 class="panel-title">Terlambat Bulan Lalu</h4>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenTerlambatbulanlalu }}</b></h3>
                    <p class="text-muted"><b>Kali absensi</b></p>
                </div>
            </div>
        </div>
        
       

    </div>

    <style>
        #a {
            border-radius: 10px;
        }
    </style>
@endsection
