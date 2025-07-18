@extends('layouts.default')
@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Dashboard</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
                    <li class="active">Dashboard</li>
                </ol>

                <div class="clearfix"></div>
            </div>
        </div>
    </div>

    {{-- @if (Auth::check() && $role == 1) --}}
    {{-- <div class="row">
        <div class="col-lg-6"> --}}
            {{-- <div class="panel-group " id="accordion-test-2"> --}}
                {{-- <div class="panel panel-default "> --}}
                    {{-- <span class="badge badge-xs badge-danger text-right">{{ $cutijumlah }}</span> --}}
                    {{-- <div class="panel-heading ">
                        <h4 class="panel-title ">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#1" aria-expanded="false"
                                class="dropdown-toggle waves-effect waves-light collapsed">
                                Permintaan Cuti Karyawan

                                @if ($cutijumlah)
                                    <span class="badge badge badge-danger"
                                        style="background-color:red">{{ $cutijumlah }}</span>
                                @endif
                            </a>
                        </h4>
                    </div> --}}
                    {{-- <div id="1" class="panel-collapse collapse">
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
                                                <th>Cuti</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($cuti as $key => $data)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $data->nama }}</td>
                                                    <td>{{ $data->jenis_cuti }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}</td>
                                                    <td>{{ $data->jml_cuti }} Hari</td>
                                                    <td>

                                                        <span
                                                            class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'danger' : ($data->status == 14 ? 'warning' : ($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' : 'secondary')))))))))))) }}">
                                                            {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ? $data->name_status : ($data->status == 5 ? $data->name_status : ($data->status == 6 ? $data->name_status : ($data->status == 7 ? $data->name_status : ($data->status == 9 ? $data->name_status : ($data->status == 10 ? $data->name_status : ($data->status == 11 ? $data->name_status : ($data->status == 12 ? $data->name_status : ($data->status == 13 ? $data->name_status : ($data->status == 14 ? $data->name_status : ($data->status == 15 ? $data->name_status : ($data->status == 16 ? $data->name_status : '')))))))))))) }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <div class="row">
                                                            @if ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1)
                                                                <div class="col-sm-3">
                                                                    <form action="/permintaan_cuti/{{ $data->id }}"
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
                                                                        <a class="btn btn-danger btn-sm" style="height:26px"
                                                                            data-toggle="modal"
                                                                            data-target="#cuReject{{ $data->id }}">
                                                                            <i class="fa fa-times fa-md" title="Tolak"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                            @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2)
                                                                <div class="col-sm-3">
                                                                    <form action="/permintaan_cuti/{{ $data->id }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden"
                                                                            name="status"value="Disetujui"
                                                                            class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                    <form action="" method="POST">
                                                                        <a class="btn btn-danger btn-sm" style="height:26px"
                                                                            data-toggle="modal"
                                                                            data-target="#cuReject{{ $data->id }}">
                                                                            <i class="fa fa-times fa-md" title="Tolak"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                            @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6)
                                                                <div class="col-sm-3">
                                                                    <form action="/permintaan_cuti/{{ $data->id }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden"
                                                                            name="status"value="Disetujui"
                                                                            class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                    <form action="" method="POST">
                                                                        <a class="btn btn-danger btn-sm" style="height:26px"
                                                                            data-toggle="modal"
                                                                            data-target="#cuReject{{ $data->id }}">
                                                                            <i class="fa fa-times fa-md" title="Tolak"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                            @else
                                                            @endif

                                                            <div class="col-sm-3" style="margin-left:6px">
                                                                <form action="" method="POST">
                                                                    <a class="btn btn-info btn-sm" style="height:26px"
                                                                        data-toggle="modal"
                                                                        data-target="#Showcuti{{ $data->id }}">
                                                                        <i class="fa fa-eye" title="Lihat Detail"></i>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @include('admin.cuti.showcuti')
                                                @include('admin.cuti.cutiReject')
                                            @empty
                                                <tr>
                                                    <td>No data available in table</td>
                                                </tr>
                                            @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div> --}}
                {{-- <div class="panel panel-default ">
                    <div class="panel-heading ">
                        <h4 class="panel-title ">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#8"
                                aria-expanded="false" class="dropdown-toggle waves-effect waves-light collapsed">
                                Pembatalan dan Perubahan Cuti Karyawan

                                @if ($jumct)
                                    <span class="badge badge badge-danger"
                                        style="background-color:red">{{ $jumct }}</span>
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
                                                    <td> {{ $data->catatan }}</td>

                                                    <td>
                                                        <div class="row">

                                                            @if (
                                                                $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                    $data->catatan == 'Pembatalan Disetujui Atasan' &&
                                                                    $row->jabatan == 'Manager')
                                                                <div class="col-sm-3">
                                                                    <form
                                                                        action="{{ route('batal.approved', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                    <form
                                                                        action="{{ route('batal.rejected', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-times btn-danger  btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                            @elseif (
                                                                $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                    $data->catatan == 'Perubahan Disetujui Atasan' &&
                                                                    $row->jabatan == 'Manager')
                                                                <div class="col-sm-3">
                                                                    <form action="{{ route('ubah.approved', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                    <form action="{{ route('ubah.rejected', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-times btn-danger  btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                            @elseif (
                                                                $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                    $data->catatan == 'Mengajukan Pembatalan' &&
                                                                    $row->jabatan == 'Manager')
                                                                <div class="col-sm-3">
                                                                    <form
                                                                        action="{{ route('batal.approved', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                    <form
                                                                        action="{{ route('batal.rejected', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-times btn-danger  btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                            @elseif (
                                                                $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                    $data->catatan == 'Mengajukan Perubahan' &&
                                                                    $row->jabatan == 'Manager')
                                                                <div class="col-sm-3">
                                                                    <form action="{{ route('ubah.approved', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                    <form action="{{ route('ubah.rejected', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-times btn-danger  btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                            @elseif (
                                                                $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                    $data->catatan == 'Mengajukan Pembatalan' &&
                                                                    $row->jabatan == 'Asistant Manager')
                                                                <div class="col-sm-3">
                                                                    <form
                                                                        action="{{ route('batal.approved', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                    <form
                                                                        action="{{ route('batal.rejected', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-times btn-danger  btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                            @elseif (
                                                                $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                    $data->catatan == 'Mengajukan Perubahan' &&
                                                                    $row->jabatan == 'Asistant Manager')
                                                                <div class="col-sm-3">
                                                                    <form action="{{ route('ubah.approved', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:7px">
                                                                    <form action="{{ route('ubah.rejected', $data->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="Disetujui" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="fa fa-times btn-danger  btn-sm"></button>
                                                                    </form>
                                                                </div>
                                                            @endif

                                                            <div class="col-sm-3" style="margin-left:6px">
                                                                <form action="" method="POST">
                                                                    <a class="btn btn-info btn-sm" style="height:26px"
                                                                        data-toggle="modal"
                                                                        data-target="#Showcuti{{ $data->id }}">
                                                                        <i class="fa fa-eye" title="Lihat Detail"></i>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                @include('admin.cuti.showcuti')
                                                @include('manager.staff.cutiReject')
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                </div> --}}

                {{-- <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#2" class="collapsed"
                                aria-expanded="false">
                                Permintaan Sakit/Izin/Dinas/lain-lain

                                @if ($izinjumlah)
                                    <span class="badge badge badge-danger"
                                        style="background-color:red">{{ $izinjumlah }}</span>
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
                                                        <span
                                                            class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'danger' : 'secondary'))))))))) }}">
                                                            {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ? $data->name_status : ($data->status == 5 ? $data->name_status : ($data->status == 6 ? $data->name_status : ($data->status == 7 ? $data->name_status : ($data->status == 9 ? $data->name_status : ($data->status == 10 ? $data->name_status : ($data->status == 11 ? $data->name_status : ($data->status == 12 ? $data->name_status : ($data->status == 13 ? $data->name_status : ''))))))))) }}
                                                        </span>
                                                    </td>

                                                    <td>
                                                        <div class="row">

                                                            @if ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1)
                                                                <div class="col-sm-3">
                                                                    <form action="{{ route('izinapproved', $data->id) }}"
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
                                                                        <a class="btn btn-danger btn-sm"
                                                                            style="height:26px" data-toggle="modal"
                                                                            data-target="#izReject{{ $data->id }}">
                                                                            <i class="fa fa-times fa-md"
                                                                                title="Tolak"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                            @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6)
                                                                <div class="col-sm-3">
                                                                    <form action="{{ route('izinapproved', $data->id) }}"
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
                                                                        <a class="btn btn-danger btn-sm"
                                                                            style="height:26px" data-toggle="modal"
                                                                            data-target="#izReject{{ $data->id }}">
                                                                            <i class="fa fa-times fa-md"
                                                                                title="Tolak"></i>
                                                                        </a>
                                                                    </form>
                                                                </div>
                                                            @else
                                                            @endif

                                                            <div class="col-sm-3" style="margin-left:5px">
                                                                <form action="" method="POST">
                                                                    <a class="btn btn-info btn-sm" style="height:26px"
                                                                        data-toggle="modal"
                                                                        data-target="#Showizinadmin{{ $data->id }}">
                                                                        <i class="fa fa-eye fa-md"
                                                                            title="Lihat Detail"></i>
                                                                    </a>
                                                                </form>
                                                            </div>

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
                </div> --}}
{{--
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#9" class="collapsed"
                                aria-expanded="false">
                                Pembatalan/Perubahan Sakit/Izin

                                @if ($jumizin)
                                    <span class="badge badge badge-danger"
                                        style="background-color:red">{{ $jumizin }}</span>
                                @endif
                            </a>

                        </h4>
                    </div>
                    <div id="9" class="panel-collapse collapse">

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
                                                        <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                        </td>
                                                    @endif

                                                    <td>{{ $data->catatan }}</td>

                                                    <td>
                                                        <div class="row">

                                                            <div class="row">

                                                                @if (
                                                                    $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Pembatalan Disetujui Atasan' &&
                                                                        $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('batal.setuju', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.tolak', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Perubahan Disetujui Atasan' &&
                                                                        $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.setuju', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.tolak', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Pembatalan' &&
                                                                        $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('batal.setuju', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.tolak', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Perubahan' &&
                                                                        $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.setuju', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.tolak', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Pembatalan' &&
                                                                        $row->jabatan == 'Asistant Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('batal.setuju', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.tolak', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Perubahan' &&
                                                                        $row->jabatan == 'Asistant Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.setuju', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.tolak', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"></button>
                                                                        </form>
                                                                    </div>
                                                                @endif

                                                            </div>
                                                            <div class="col-sm-3" style="margin-left:5px">
                                                                <form action="" method="POST">
                                                                    <a class="btn btn-info btn-sm" style="height:26px"
                                                                        data-toggle="modal"
                                                                        data-target="#Showizinm{{ $data->id }}">
                                                                        <i class="fa fa-eye fa-md"
                                                                            title="Lihat Detail"></i>
                                                                    </a>
                                                                </form>
                                                            </div>
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

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#12"
                                aria-expanded="false" class="dropdown-toggle waves-effect waves-light collapsed">
                                Susunan Pengurus dan Manajemen
                            </a>
                        </h4>
                    </div>
                    <div id="12" class="panel-collapse collapse">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped">
                                        <thead style="text-align: center;">
                                            <tr class="info">
                                                <th>No</th>
                                                <th>Management</th>
                                                <th>Head Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($jumlahKaryawanPerJabatan as $k)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $k->nama_jabatan }}</td>
                                                    <td>{{ $k->total }}</td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <td class="thick-line"></td>
                                                <td class="thick-line text-right"><strong>Total</strong></td>
                                                <td class="thick-line text-left">{{ $jumlahKaryawanPerJabatan2 }}</td>
                                            </tr>

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
                            <a data-toggle="collapse" data-parent="#accordion-test-8" href="#14"
                                aria-expanded="false" class="dropdown-toggle waves-effect waves-light collapsed">
                                Jumlah Karyawan
                            </a>
                        </h4>
                    </div>
                    <div id="14" class="panel-collapse collapse">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped">
                                        <thead style="text-align: center;">
                                            <tr class="info">
                                                <th>No</th>
                                                <th>Divisi</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($karyawan as $k)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $k->nama_jabatan }}</td>
                                                    <td>{{ $k->total }}</td>
                                                </tr>
                                            @endforeach

                                            <tr>
                                                <td class="thick-line"></td>
                                                <td class="thick-line text-right"><strong>Total</strong></td>
                                                <td class="thick-line text-left">{{ $jumlahkaryawan }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> --}}

        {{-- <div class="col-lg-6">

            <div class="panel-group" id="accordion-test-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#3" class="collapsed"
                                aria-expanded="false">
                                Permintaan Resign Karyawan

                                @if ($resignjumlah)
                                    <span class="badge badge badge-danger"
                                        style="background-color:red">{{ $resignjumlah }}</span>
                                @else
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
                                                    <td>{{ \Carbon\Carbon::parse($r->tgl_resign)->format('d/m/Y') }}</td>
                                                    <td>
                                                        <span
                                                            class="badge badge-{{ $r->status == 1 ? 'warning' : ($r->status == 6 ? 'info' : ($r->status == 7 ? 'success' : ($r->status == 5 ? 'warning' : 'danger'))) }}">
                                                            {{ $r->status == 1 ? $r->statuses->name_status : ($r->status == 6 ? $r->statuses->name_status : ($r->status == 7 ? $r->statuses->name_status : ($r->status == 5 ? $r->statuses->name_status : 'Ditolak'))) }}
                                                        </span>
                                                    </td>
                                                    <td id="b" class="text-center">
                                                        <div class="btn-group" role="group">
                                                            @if ($r->karyawan->atasan_pertama == Auth::user()->id_pegawai && $r->status == 1)
                                                                <form action="{{ route('resignapproved', $r->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value=1
                                                                        class="form-control" hidden>
                                                                    <button type="submit" class="btn btn-success btn-sm">
                                                                        <i class="fa fa-check" title="Setuju"></i>
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('resignreject', $r->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <input type="hidden" name="status" value=5
                                                                        class="form-control" hidden>
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-times" title="Tolak"></i>
                                                                    </button>
                                                                </form>
                                                            @elseif($r->karyawan->atasan_kedua == Auth::user()->id_pegawai && $r->status == 6)
                                                                <form
                                                                    action="{{ route('resign_approved_manager', $r->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="status" value=1
                                                                        class="form-control" hidden>
                                                                    <button type="submit" class="btn btn-success btn-sm">
                                                                        <i class="fa fa-check" title="Setuju"></i>
                                                                    </button>
                                                                </form>
                                                                <form action="{{ route('resignreject', $r->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('POST')
                                                                    <input type="hidden" name="status" value=5
                                                                        class="form-control" hidden>
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fa fa-times" title="Tolak"></i>
                                                                    </button>
                                                                </form>
                                                            @endif
                                                            <a class="btn btn-info btn-sm" data-toggle="modal"
                                                                data-target="#Showresign{{ $r->id }}">
                                                                <i class="fa fa-eye" title="Lihat Detail"></i>
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
                @if (isset($potongtransport) || isset($potonguangmakan) || isset($terlambat) || isset($telat) || isset($datatelat))
                    @php
                        $jumlah = $jpc + $jpg;
                    @endphp
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#4"
                                    aria-expanded="false" class="collapsed">
                                    Data Tidak Masuk
                                    @if ($jumlah)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">@php  echo $jumlah; @endphp</span>
                                    @else
                                    @endif
                                </a>
                            </h4>
                        </div>
                        <div id="4" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <ul class="">
                                            <li class="text-center notifi-title" style="background-color: #d9edf7; color: #666666; font-weight:bold; list-style-type:none">Notifikasi Tidak Masuk
                                                @if ($jumlah)
                                                    <span class="badge badge-xs badge-danger">@php  echo $jumlah; @endphp</span>
                                                @else
                                                @endif
                                            </li>
                                            <li class="list-group">
                                                @if (isset($potonguangmakan) && $jpc > 0)
                                                    <a href="/tindakan-tidak-masuk" class="list-group-item">
                                                        <div class="media">
                                                            <div class="media-heading">Sanksi Pemotongan Uang Makan
                                                                <span
                                                                    class="badge badge-xs badge-danger">{{ $jpc }}</span>
                                                            </div>
                                                            <p class="m-0">
                                                                <small>Karyawan yang tidak masuk kerja tanpa keterangan yang
                                                                    dapat dipertanggungjawabkan akan mendapatkan sanksi dari
                                                                    Perusahaan</small>
                                                            </p>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if (isset($potongtransport) && $jpg > 0)
                                                    <a href="/tindakan-tidak-masuk" class="list-group-item">
                                                        <div class="media">
                                                            <div class="media-body clearfix">
                                                                <div class="media-heading">Sanksi Pemotongan Uang
                                                                    Transportasi<span
                                                                        class="badge badge-xs badge-danger">{{ $jpg }}</span>
                                                                </div>
                                                                <p class="m-0">
                                                                    <small>Karyawan yang tidak masuk kerja tanpa keterangan
                                                                        yang dapat dipertanggungjawabkan akan mendapatkan
                                                                        sanksi dari Perusahaan</small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            </li>
                                        </ul>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        @php
                            $jum = $jumter + $jumtel + $jumdat;
                        @endphp

                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#7"
                                    aria-expanded="false" class="collapsed">
                                    Notifikasi Terlambat

                                    @if ($jum)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">@php  echo $jum; @endphp</span>
                                    @endif
                                </a>
                            </h4>
                        </div>
                        <div id="7" class="panel-collapse collapse">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <ul class="">

                                            <li class="text-center notifi-title" style="background-color: #d9edf7; color: #666666; font-weight:bold; list-style-type:none">Notifikasi Terlambat <span
                                                    class="badge badge-xs badge-danger">@php  echo $jum; @endphp</span></li>
                                            <li class="list-group">
                                                @if ($terlambat && $jumter > 0)
                                                    <a href="/tindakan-terlambat" class="list-group-item">
                                                        <div class="media">
                                                            <div class="media-body clearfix">
                                                                <div class="media-heading">Sanksi Teguran Biasa <span
                                                                        class="badge badge-xs badge-danger">{{ $jumter }}</span>
                                                                </div>
                                                                <p class="m-0">
                                                                    <small>Karyawan yang datang terlambat yang melebihi dari
                                                                        ketentuan yang ditetapkan akan mendapatkan sanksi
                                                                        sesuai ketentuan dari Perusahaan</small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if (isset($telat) && $jumtel > 0)
                                                    <a href="/tindakan-terlambat" class="list-group-item">
                                                        <div class="media">
                                                            <div class="media-body clearfix">
                                                                <div class="media-heading">Sanksi SP 1<span
                                                                        class="badge badge-xs badge-danger">{{ $jumtel }}</span>
                                                                </div>
                                                                <p class="m-0">
                                                                    <small>Karyawan yang datang terlambat yang melebihi dari
                                                                        ketentuan yang ditetapkan akan mendapatkan sanksi
                                                                        sesuai ketentuan dari Perusahaan</small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                                @if (isset($datatelat) && $jumdat > 0)
                                                    <a href="/tindakan-terlambat" class="list-group-item">
                                                        <div class="media">
                                                            <div class="media-body clearfix">
                                                                <div class="media-heading">Sanksi SP 1<span
                                                                        class="badge badge-xs badge-danger">{{ $jumdat }}</span>
                                                                </div>
                                                                <p class="m-0">
                                                                    <small>Karyawan yang datang terlambat yang melebihi dari
                                                                        ketentuan yang ditetapkan akan mendapatkan sanksi
                                                                        sesuai ketentuan dari Perusahaan</small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                @endif
                                            </li>
                                        </ul>
                                        </li>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#5"
                                aria-expanded="false" class="collapsed">
                                Data Rekruitmen
                                @if ($rekruitmenjumlah)
                                    <span class="badge badge badge-danger"
                                        style="background-color:red">{{ $rekruitmenjumlah }}</span>
                                @endif
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
                                                <th>Lowongan</th> --}}
                                                {{-- <th>Pelamar</th> --}}
                                                {{-- <th>Dibutuhkan</th>
                                                <th>Durasi Aktif</th> --}}
                                                {{-- <th>Berakhir</th> --}}
                                                {{-- <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($posisi as $k)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $k->posisi }}</td> --}}
                                                    {{-- <td>{{ $k->jeniscutis->jenis_cuti }}</td> --}}
                                                    {{-- <td>{{ $k->jumlah_dibutuhkan }} Orang</td>
                                                    <td>{{ \Carbon\Carbon::parse($k->tgl_mulai)->format('d/m/Y') }} s.d
                                                        {{ \Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y') }}</td>

                                                    <td>
                                                        <div class="row">
                                                            <div class="col-sm-3">
                                                                <form action="/show_rekrutmen{{ $k->id }}">
                                                                    <button type="submit"
                                                                        class="fa fa-eye btn-info btn-sm"></button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr> --}}
                                            {{-- @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="panel panel-default">

                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-8" href="#15"
                                aria-expanded="false" class="dropdown-toggle waves-effect waves-light collapsed">
                                Data Kehadiran Kerja Karyawan
                                @if ($jumAbsen != 0)
                                    <span class="badge badge badge-danger"
                                        style="background-color:red">{{ $jumAbsen }}</span>
                                @endif
                            </a>
                        </h4>
                    </div>
                    <div id="15" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="col-xs-12 m-b-10">
                                        <button id="tarikAbsenBtn" class="btn btn-success btn-sm">Tarik Absen</button>
                                        <div id="resultContainer"></div>
                                    </div>

                                    <table class="table table-striped m-t-20">
                                        <thead style="text-align: center;">
                                            <tr class="info">
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Tanggal</th>
                                                <th>Jam Masuk</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($absenHarini as $k)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $k->karyawans->nama }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($k->total)->format('d/m/Y') }}</td>
                                                    <td>{{ $k->jam_masuk }}</td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                {{-- <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#11"
                                aria-expanded="false" class="dropdown-toggle waves-effect waves-light collapsed">
                                Status Hak Cuti Tahunan
                            </a>
                        </h4>
                    </div>
                    <div id="11" class="panel-collapse collapse">

                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            @foreach ($alokasi as $key => $k)
                                                @php
                                                    $jmlcuti = $k->jmlhakcuti;
                                                    $durasi = $k->durasi;
                                                    $sisa = $jmlcuti - $durasi;
                                                    $tahun  = \Carbon\Carbon::now()->year;
                                                @endphp
                                                <tr>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Jumlah Hak Cuti Tahun {{$tahun}}</td>
                                                    <td>{{ $k->jmlhakcuti }}</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Hak Cuti Yang Sudah Diambil</td>
                                                    <td>{{ $sisa }}</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Sisa Hak Cuti</td>
                                                    <td>{{ $k->durasi }}</td>
                                                </tr>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    @if (count($sisacutis) > 0)
                                        <table class="table table-striped">
                                            <label><b>Sisa Cuti Tahun Lalu</b></label>
                                            <thead>
                                                <tr class="info">
                                                    <th>No</th>
                                                    <th>Kategori</th>
                                                    <th>Sisa Cuti Tahun Lalu</th>
                                                    <th>Periode</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($sisacutis as $key => $sisa)
                                                    @if ($sisa->id_pegawai == Auth::user()->id_pegawai)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $sisa->karyawans->nama }}</td>
                                                            <td>{{ $sisa->jenis_cuti }}</td>
                                                            <td>{{ $sisa->sisa_cuti }} hari</td>
                                                            <td>{{ $sisa->periode }}</td>
                                                            <td>
                                                                <a href=""
                                                                    class="btn btn-sm btn-danger fa fa-plus pull-right"
                                                                    data-toggle="modal" data-target="#mModal"> Ambil Cuti</a>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                    @include('karyawan.addcuti')
                                                @empty
                                                    @if ($sisa->id_pegawai != Auth::user()->id_pegawai)
                                                        <tr>
                                                            <td colspan="12" class="text-center">No data available in table.
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforelse
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            {{-- </div>
        </div>
    </div> <!-- end row --> --}}

    {{-- <div class="row">
        <div class="col-lg-12">
            <div class="panel-group" id="accordion-test-7">
                <div class="panel panel-default ">
                    <div class="panel-heading ">
                        <h4 class="panel-title ">
                            <a data-toggle="collapse" data-parent="#accordion-test-2" href="#13"
                                aria-expanded="false" class="dropdown-toggle waves-effect waves-light collapsed">
                                Informasi HRD
                                @if ($jmlinfo != 0)
                                    <span class="badge badge badge-danger"
                                        style="background-color:red">{{ $jmlinfo }}</span>
                                @endif
                            </a>
                        </h4>
                    </div>
                    <div id="13" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        </thead>
                                        <tbody>
                                            @foreach ($informasi as $key => $k)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <b>{{ $k->judul }}</b> <br><br>
                                                        <p>{!! nl2br(html_entity_decode($k->konten)) !!}</p>
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
    </div> --}}

    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-warning text-center">
                <div class="panel-heading btn-warning">
                    <a href="{{ url('showkaryawancuti') }}" class="panel-title ">
                        <h4 class="panel-title ">Cuti dan Izin Hari Ini</h4>
                    </a>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $cutidanizin }}</b></h3>
                    <p class="text-muted"><b>Total Cuti dan Izin </b> </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-warning text-center">
                <div class="panel-heading btn-warning">
                    <a href="{{ url('showkaryawanabsen') }}" class="panel-title ">
                        <h4 class="panel-title">Absen Masuk Hari Ini</h4>
                    </a>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenHariinihrd }}</b></h3>
                    <p class="text-muted"><b>Total Absen Masuk </b> </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-warning text-center">
                <div class="panel-heading btn-warning">
                    <a href="{{ url('showkaryawanterlambat') }}" class="panel-title ">
                        <h4 class="panel-title">Terlambat Hari Ini</h4>
                    </a>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $absenTerlambatHariInihrd }}</b></h3>
                    <p class="text-muted"><b>Total Terlambat</b> </p>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-3">
            <div class="panel panel-warning text-center">
                <div class="panel-heading btn-warning">
                    <a href="{{ url('showkaryawantidakmasuk') }}" class="panel-title ">
                        <h4 class="panel-title"> Belum / Tidak Masuk Hari Ini</h4>
                    </a>
                </div>
                <div class="panel-body">
                    <h3 class=""><b>{{ $totalTidakAbsenHariInihrd }}</b></h3>
                    <p class="text-muted"><b>Total Tidak Masuk</b></p>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Absensi Hari Ini</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="absensiChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Cuti Hari Ini</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="cutiChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Izin Hari Ini</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="ijinChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>  --}}
    {{-- <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Absensi Kemarin</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="absenKemarinChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Cuti Hari Ini</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="cutiKemarinChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Izin Hari Ini</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="ijinKemarinChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Row --> --}}
    {{-- <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Absensi Bulan Ini</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="absenBulanIniChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Cuti Bulan Ini</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="cutiBulanIniChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Izin Bulan Ini</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="ijinBulanIniChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Row --> --}}
    {{-- <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Absensi Bulan Lalu</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="absenBulanLaluChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Cuti Bulan Lalu</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="cutiBulanLaluChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="panel panel-border panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title text-white text-center">Izin Bulan Lalu</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <canvas id="ijinBulanlaluChart" style="height: 300px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Row --> --}}

    <div class="row">
    </div> <!-- End Row -->
    </div> <!-- container -->
    </div> <!-- content -->
    </div>
    <!-- End Right content here -->
    </div>
    <!-- END wrapper -->
    <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>

    <!--Morris Chart-->
    <script src="assets/plugins/raphael/raphael-min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.all.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.js"></script>

    <!--Chart JS-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if (Session::has('success'))
        <script>
            swal("Selamat", "{{ Session::get('success') }}", 'success', {
                button: true,
                button: "OK",
            });
        </script>
    @endif

    @if (Session::has('error'))
        <script>
            swal("Mohon Maaf", "{{ Session::get('error') }}", 'error', {
                button: true,
                button: "OK",
            });
        </script>
    @endif

    @if (Session::has('message'))
        <div class="alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

     {{-- var tidakMasukBulanIni = {{ $tidakMasukBulanInihrd }}; --}}
    {{-- var tidakMasukkemarin = {{ $tidakMasukKemarinhrd }} --}}
     {{-- var tidakMasukBulanLalu = {{ $tidakMasukBulanLaluhrd }}; --}}
    <script>
        // Data absensi
        var masuk = {{ $absenHariinihrd }};
        var terlambat = {{ $absenTerlambatHariInihrd }};
        var tidakMasuk = {{ $totalTidakAbsenHariInihrd }};
        var cuti = {{ $cutiHariinihrd }};
        var ijin = {{ $dataIzinHariinihrd }};
        var absenKemarin = {{ $jumAbsenKemarin }};
        var terlambatKemarin = {{ $absenTerlambatKemarinhrd }};

        var cutiKemarin = {{ $cutiKemarinhrd }};
        var ijinKemarin = {{ $dataIzinKemarinhrd }};
        var masukBulanini = {{ $absenBulaninihrd }};
        var terlambatBulanIni =  {{$absenTerlambatBulanInihrd }};

        var cutiBulanIni = {{ $jumCutiBulanIni }};
        var IjinBulanIni = {{ $jumIzinBulanIni }};
        var masukBulanLalu = {{ $absenBulanLaluhrd }};
        var terlambatBulanLalu = {{ $absenTerlambatbulanlaluhrd }};

        var cutiBulanLalu = {{ $jumCutiBulanLalu }};
        var ijinBulanlalu = {{$jumIzinBulanLalu }};

        const data = {
            labels: ['Masuk', 'Terlambat', 'Tidak Masuk'],
            datasets: [{
                label: '',
                backgroundColor: ['#18bae2', '#FF8C00', '#f44336'],
                borderColor: ['#18bae2', '#FF8C00', '#f44336'],
                borderWidth: 1,
                data: [masuk, terlambat, tidakMasuk],
            }]
        };
        const data1 = {
            labels: ['Cuti'],
            datasets: [{
                label: '',
                backgroundColor: ['#18bae2'],
                borderColor: ['#18bae2'],
                borderWidth: 1,
                data: [cuti],
            }]
        };
        const data2 = {
            labels: ['Ijin'],
            datasets: [{
                label: '',
                backgroundColor: ['#FFFF00'],
                borderColor: ['#FFFF00'],
                borderWidth: 1,
                data: [ijin],
            }]
        };
        const data3 = {
            labels: ['Masuk', 'Terlambat', 'Tidak Masuk'],
            datasets: [{
                label: '',
                backgroundColor: ['#18bae2', '#FF8C00', '#f44336'],
                borderColor: ['#18bae2', '#FF8C00', '#f44336'],
                borderWidth: 1,
                data: [absenKemarin, terlambatKemarin, tidakMasukkemarin],
            }]
        };
        const data4 = {
            labels: ['Cuti'],
            datasets: [{
                label: '',
                backgroundColor: ['#18bae2'],
                borderColor: ['#18bae2'],
                borderWidth: 1,
                data: [cutiKemarin],
            }]
        };
        const data5 = {
            labels: ['Ijin'],
            datasets: [{
                label: '',
                backgroundColor: ['#18bae2'],
                borderColor: ['#18bae2'],
                borderWidth: 1,
                data: [ijinKemarin],
            }]
        };
        const data6 = {
            labels: ['Masuk', 'Terlambat', 'Tidak Masuk'],
            datasets: [{
                label: '',
                backgroundColor: ['#18bae2', '#FF8C00', '#f44336'],
                borderColor: ['#18bae2', '#FF8C00', '#f44336'],
                borderWidth: 1,
                data: [masukBulanini, terlambatBulanIni, tidakMasukBulanIni],
            }]
        };
        const data7 = {
            labels: ['Cuti'],
            datasets: [{
                label: '',
                backgroundColor: ['#18bae2'],
                borderColor: ['#18bae2'],
                borderWidth: 1,
                data: [cutiBulanIni],
            }]
        };
        const data8 = {
            labels: ['Ijin'],
            datasets: [{
                label: '',
                backgroundColor: ['#18bae2'],
                borderColor: ['#18bae2'],
                borderWidth: 1,
                data: [IjinBulanIni],
            }]
        };
        const data9 = {
            labels: ['Masuk', 'Terlambat', 'Tidak Masuk'],
            datasets: [{
                label: '',
                backgroundColor: ['#18bae2', '#FF8C00', '#f44336'],
                borderColor: ['#18bae2', '#FF8C00', '#f44336'],
                borderWidth: 1,
                data: [masukBulanLalu, terlambatBulanLalu, tidakMasukBulanLalu],
            }]
        };
        const data10 = {
            labels: ['Cuti'],
            datasets: [{
                label: '',
                backgroundColor: ['#18bae2'],
                borderColor: ['#18bae2'],
                borderWidth: 1,
                data: [cutiBulanLalu],
            }]
        };
        const data11 = {
            labels: ['Ijin'],
            datasets: [{
                label: '',
                backgroundColor: ['#18bae2'],
                borderColor: ['#18bae2'],
                borderWidth: 1,
                data: [ijinBulanlalu],
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };


        const config1 = {
            type: 'bar',
            data: data1,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };

        const config2 = {
            type: 'bar',
            data: data2,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };
        const config3 = {
            type: 'bar',
            data: data3,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };
        const config4 = {
            type: 'bar',
            data: data4,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };
        const config5 = {
            type: 'bar',
            data: data5,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };
        const config6 = {
            type: 'bar',
            data: data6,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };
        const config7 = {
            type: 'bar',
            data: data7,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };
        const config8 = {
            type: 'bar',
            data: data8,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };
        const config9 = {
            type: 'bar',
            data: data9,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };
        const config10 = {
            type: 'bar',
            data: data10,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };
        const config11 = {
            type: 'bar',
            data: data11,
            options: {
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                    },
                },
            },
        };

        const absensiChart = new Chart(
            document.getElementById('absensiChart'),
            config
        );
        const cutiChart = new Chart(
            document.getElementById('cutiChart'),
            config1
        );
        const ijinChart = new Chart(
            document.getElementById('ijinChart'),
            config2
        );
        const absenKemarinChart = new Chart(
            document.getElementById('absenKemarinChart'),
            config3
        );
        const cutiKemarinChart = new Chart(
            document.getElementById('cutiKemarinChart'),
            config4
        );
        const ijinKemarinChart = new Chart(
            document.getElementById('ijinKemarinChart'),
            config5
        );
        const absenBulaniniChart = new Chart(
            document.getElementById('absenBulanIniChart'),
            config6
        );
        const cutiBulanIniChart = new Chart(
            document.getElementById('cutiBulanIniChart'),
            config7
        );
        const ijinBulanIniChart = new Chart(
            document.getElementById('ijinBulanIniChart'),
            config8
        );
        const absenBulanLaluChart = new Chart(
            document.getElementById('absenBulanLaluChart'),
            config9
        );
        const cutiBulanLaluChart = new Chart(
            document.getElementById('cutiBulanLaluChart'),
            config10
        );
        const ijinBulanlaluChart = new Chart(
            document.getElementById('ijinBulanlaluChart'),
            config11
        );
    </script>

    <!-- Script AJAX untuk pemrosesan data -->
    <script>
        $(document).ready(function() {
            // Tangkap event klik tombol "Tarik Absen"
            $('#tarikAbsenBtn').click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ url('/tarik-absen') }}", // Rute untuk pemrosesan data
                    data: {
                        _token: "{{ csrf_token() }}", // CSRF token
                    },
                    success: function(response) {
                        // Tampilkan respons dari server pada elemen dengan id "resultContainer"
                        $('#resultContainer').html(response);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>

@endsection
