@extends('layouts.default')

@section('content')
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Dashboard </h4>
                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
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

    @if (Auth::check() && (Auth::user()->role == 1 || Auth::check() && Auth::user()->role == 3 || Auth::check() && Auth::user()->role == 7))
        {{-- @php dd($row->jabatan, Auth::user()->role) @endphp --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="panel-group " id="accordion-test-2">
                    <div class="panel panel-default ">
                        <div class="panel-heading ">
                            <h4 class="panel-title ">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#1"
                                    aria-expanded="false" class="dropdown-toggle waves-effect waves-light collapsed">
                                    Permintaan Cuti Karyawan

                                    @if ($cutijumlah)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">{{ $cutijumlah }}</span>
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
                                                    @if ($data->catatan == null)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->nama }}</td>
                                                            <td>{{ $data->jenis_cuti }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                            </td>
                                                            {{-- <td>{{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td> --}}
                                                            {{-- <td>{{ $data->jml_cuti }} Hari</td> --}}
                                                            <td>
                                                                {{-- {{ $data->status }} --}}
                                                                <span
                                                                    class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : ($data->status == 14 ? 'warning' : ($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' : 'secondary')))))))))))) }}">
                                                                    {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ? $data->name_status : ($data->status == 5 ? $data->name_status : ($data->status == 6 ? $data->name_status : ($data->status == 7 ? $data->name_status : ($data->status == 9 ? $data->name_status : ($data->status == 10 ? $data->name_status : ($data->status == 11 ? $data->name_status : ($data->status == 12 ? $data->name_status : ($data->status == 13 ? $data->name_status : ($data->status == 14 ? $data->name_status : ($data->status == 15 ? $data->name_status : ($data->status == 16 ? $data->name_status : '')))))))))))) }}
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <div class="row">

                                                                    @if ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Manager')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('cuti.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px" data-toggle="modal"
                                                                                    data-target="#cutiTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Asistant Manager')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('cuti.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px" data-toggle="modal"
                                                                                    data-target="#cutiTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('leave.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px" data-toggle="modal"
                                                                                    data-target="#cutisTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                        @include('direktur.cuti.cutiReject')
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Asistant Manager')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('cuti.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutiTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Manager')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('cuti.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutiTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('leave.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutisTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                        @include('direktur.cuti.cutiReject')
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $row->jabatan == 'Manager')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('cuti.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutiTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('leave.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutisTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                        @include('direktur.cuti.cutiReject')
                                                                    @else
                                                                    @endif

                                                                    <div class="col-sm-3" style="margin-left:6px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-info btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#Showcuti{{ $data->id }}">
                                                                                <i class="fa fa-eye"
                                                                                    title="Lihat Detail"></i>
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
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#7"
                                    aria-expanded="false" class="dropdown-toggle waves-effect waves-light collapsed">
                                    Pembatalan dan Perubahan Cuti Karyawan

                                    @if ($jumct)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">{{ $jumct }}</span>
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
                                                        <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                        </td>

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
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Perubahan Disetujui Atasan' &&
                                                                        $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
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
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Perubahan' &&
                                                                        $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
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
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Perubahan' &&
                                                                        $row->jabatan == 'Asistant Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Pembatalan' &&
                                                                        $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('batal.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Perubahan' &&
                                                                        $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Pembatalan Disetujui Atasan' &&
                                                                        $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('batal.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Perubahan Disetujui Atasan' &&
                                                                        $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
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
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#3"
                                    class="collapsed" aria-expanded="false">
                                    Permintaan Resign Karyawan

                                    @if ($resignjumlah)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">{{ $resignjumlah }}</span>
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
                                                        <td>{{ \Carbon\Carbon::parse($r->tgl_resign)->format('d/m/Y') }}
                                                        </td>
                                                        {{-- <td>{{ $r->tipe_resign }}</td> --}}
                                                        <!-- data for status -->
                                                        <td>
                                                            <span
                                                                class="badge badge-{{ $r->status == 1 ? 'warning' : ($r->status == 6 ? 'info' : ($r->status == 7 ? 'success' : ($r->status == 5 ? 'warning' : 'danger'))) }}">
                                                                {{ $r->status == 1 ? $r->statuses->name_status : ($r->status == 6 ? $r->statuses->name_status : ($r->status == 7 ? $r->statuses->name_status : ($r->status == 5 ? $r->statuses->name_status : 'Ditolak'))) }}
                                                            </span>
                                                        </td>
                                                        <td id="b" class="text-center">
                                                            <div class="btn-group" role="group">
                                                                @if ($r->karyawan->atasan_pertama == Auth::user()->id_pegawai && $r->status == 1)
                                                                    <form
                                                                        action="{{ route('resign_approved_manager', $r->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="1" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="btn btn-success btn-sm"><i
                                                                                class="fa fa-check"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ route('resignreject', $r->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="status"
                                                                            value="5" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm"><i
                                                                                class="fa fa-times"></i>
                                                                        </button>
                                                                    </form>
                                                                @elseif($r->karyawan->atasan_kedua == Auth::user()->id_pegawai && $r->status == 6)
                                                                    <form action="{{ route('resignapproved', $r->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="1" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="btn btn-success btn-sm"><i
                                                                                class="fa fa-check"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ route('resignreject', $r->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="status"
                                                                            value="5" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm"><i
                                                                                class="fa fa-times"></i>
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


                    <div class="panel panel-default">

                    </div>

                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel-group" id="accordion-test-2">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#2"
                                    class="collapsed" aria-expanded="false">
                                    Permintaan Sakit/Ijin/Dinas/lain-lain

                                    @if ($izinjumlah)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">{{ $izinjumlah }}</span>
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
                                                    <th>Ijin</th>
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

                                                            <span
                                                                class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : 'secondary'))))))))) }}">
                                                                {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ? $data->name_status : ($data->status == 5 ? $data->name_status : ($data->status == 6 ? $data->name_status : ($data->status == 7 ? $data->name_status : ($data->status == 9 ? $data->name_status : ($data->status == 10 ? $data->name_status : ($data->status == 11 ? $data->name_status : ($data->status == 12 ? $data->name_status : ($data->status == 13 ? $data->name_status : ''))))))))) }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <div class="row">
                                                                @if ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#cutiTolak{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('admin.cuti.izinReject')
                                                                @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Asistant Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#Reject{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('manager.staff.izinReject')
                                                                @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approv', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#izinTolak{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('direktur.cuti.izinReject')
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Asistant Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#Reject{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('manager.staff.izinReject')
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#Reject{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('manager.staff.izinReject')
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approv', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#izinTolak{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('direktur.cuti.izinReject')
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approv', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#izinTolak{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('direktur.cuti.izinReject')
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#Reject{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
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
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#8"
                                    class="collapsed" aria-expanded="false">
                                    Pembatalan/Perubahan Sakit/Ijin

                                    @if ($jumizin)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">{{ $jumizin }}</span>
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
                                                    <th>Ijin</th>
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

                                                        <td>{{ $data->catatan }}</td>

                                                        <td>
                                                            <div class="row">
                                                                {{-- @if ($data->status == 'Pending' || $data->status == 'Disetujui Manager') --}}
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
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
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
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
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
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
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
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
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
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
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
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
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
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
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
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
                                                                            </form>
                                                                        </div>
                                                                    @elseif (
                                                                        $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                            $data->catatan == 'Pembatalan Disetujui Atasan' &&
                                                                            $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('batal.setuju', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
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
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
                                                                            </form>
                                                                        </div>
                                                                    @elseif (
                                                                        $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                            $data->catatan == 'Perubahan Disetujui Atasan' &&
                                                                            $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('ubah.setuju', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
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
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
                                                                            </form>
                                                                        </div>
                                                                    @elseif (
                                                                        $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                            $data->catatan == 'Mengajukan Pembatalan' &&
                                                                            $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('batal.setuju', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
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
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
                                                                            </form>
                                                                        </div>
                                                                    @elseif (
                                                                        $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                            $data->catatan == 'Mengajukan Perubahan' &&
                                                                            $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('ubah.setuju', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
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
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
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
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
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
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
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
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
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
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
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
                    {{-- <div class="col-lg-6">
                        <div class="panel-group" id="accordion-test-7">
                            <div class="panel panel-default ">
                                <div class="panel-heading ">
                                    <h4 class="panel-title ">
                                        <a data-toggle="collapse" data-parent="#accordion-test-2" href="#13" aria-expanded="false"
                                            class="dropdown-toggle waves-effect waves-light collapsed">
                                            Informasi HRD
                                            @if (isset($jmlinfo))
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
                                                                <td>{{$loop->iteration}}</td>
                                                                <td>
                                                                    <b>{{$k->judul}}</b> <br><br>
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
                    </div> --}}

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
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


                    @if ((Auth::check() && Auth::user()->role == 1) || (Auth::check() && Auth::user()->role == 2))
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
                                                            <td>{{ \Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y') }}
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
                    @endif

                </div>
            </div>
        </div> <!-- end row -->
    @endif

    @if (Auth::check() && Auth::user()->role == 2)
        {{-- @php dd($row->jabatan, Auth::user()->role) @endphp --}}
        <div class="row">
            <div class="col-lg-6">
                <div class="panel-group " id="accordion-test-2">
                    <div class="panel panel-default ">
                        <div class="panel-heading ">
                            <h4 class="panel-title ">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#1"
                                    aria-expanded="false" class="dropdown-toggle waves-effect waves-light collapsed">
                                    Permintaan Cuti Karyawan

                                    @if ($cutijumlah)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">{{ $cutijumlah }}</span>
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
                                                    @if ($data->catatan == null)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $data->nama }}</td>
                                                            <td>{{ $data->jenis_cuti }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                            </td>
                                                            {{-- <td>{{\Carbon\Carbon::parse($data->tgl_selesai)->format("d/m/Y")}}</td> --}}
                                                            {{-- <td>{{ $data->jml_cuti }} Hari</td> --}}
                                                            <td>
                                                                {{-- {{ $data->status }} --}}
                                                                <span
                                                                    class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : ($data->status == 14 ? 'warning' : ($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' : 'secondary')))))))))))) }}">
                                                                    {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ? $data->name_status : ($data->status == 5 ? $data->name_status : ($data->status == 6 ? $data->name_status : ($data->status == 7 ? $data->name_status : ($data->status == 9 ? $data->name_status : ($data->status == 10 ? $data->name_status : ($data->status == 11 ? $data->name_status : ($data->status == 12 ? $data->name_status : ($data->status == 13 ? $data->name_status : ($data->status == 14 ? $data->name_status : ($data->status == 15 ? $data->name_status : ($data->status == 16 ? $data->name_status : '')))))))))))) }}
                                                                </span>
                                                            </td>

                                                            <td>
                                                                <div class="row">

                                                                    @if ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Manager')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('cuti.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui" class="form-control"
                                                                                    hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutiTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Asistant Manager')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('cuti.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutiTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('leave.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutisTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                        @include('direktur.cuti.cutiReject')
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Asistant Manager')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('cuti.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutiTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Manager')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('cuti.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutiTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('leave.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutisTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                        @include('direktur.cuti.cutiReject')
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $row->jabatan == 'Manager')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('cuti.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutiTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                    @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('leave.approved', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form action="" method="POST">
                                                                                <a class="btn btn-danger btn-sm"
                                                                                    style="height:26px"
                                                                                    data-toggle="modal"
                                                                                    data-target="#cutisTolak{{ $data->id }}">
                                                                                    <i class="fa fa-times fa-md"
                                                                                        title="Tolak"></i>
                                                                                </a>
                                                                            </form>
                                                                        </div>
                                                                        @include('direktur.cuti.cutiReject')
                                                                    @else
                                                                    @endif

                                                                    <div class="col-sm-3" style="margin-left:6px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-info btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#Showcuti{{ $data->id }}">
                                                                                <i class="fa fa-eye"
                                                                                    title="Lihat Detail"></i>
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
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#7"
                                    aria-expanded="false" class="dropdown-toggle waves-effect waves-light collapsed">
                                    Pembatalan dan Perubahan Cuti Karyawan

                                    @if ($jumct)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">{{ $jumct }}</span>
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
                                                        <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                        </td>

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
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Perubahan Disetujui Atasan' &&
                                                                        $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
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
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Perubahan' &&
                                                                        $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
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
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Perubahan' &&
                                                                        $row->jabatan == 'Asistant Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Pembatalan' &&
                                                                        $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('batal.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Mengajukan Perubahan' &&
                                                                        $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Pembatalan Disetujui Atasan' &&
                                                                        $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('batal.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('batal.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @elseif (
                                                                    $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                        $data->catatan == 'Perubahan Disetujui Atasan' &&
                                                                        $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('ubah.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form
                                                                            action="{{ route('ubah.rejected', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-times btn-danger  btn-sm"
                                                                                title="Tolak"></button>
                                                                        </form>
                                                                    </div>
                                                                @else
                                                                @endif
                                                                <div class="col-sm-3" style="margin-left:6px">
                                                                    <form action="" method="POST">
                                                                        <a class="btn btn-info btn-sm"
                                                                            style="height:26px" data-toggle="modal"
                                                                            data-target="#Showcuti{{ $data->id }}">
                                                                            <i class="fa fa-eye"
                                                                                title="Lihat Detail"></i>
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
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#2"
                                    class="collapsed" aria-expanded="false">
                                    Permintaan Sakit/Ijin/Dinas/lain-lain

                                    @if ($izinjumlah)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">{{ $izinjumlah }}</span>
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
                                                    <th>Ijin</th>
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

                                                            <span
                                                                class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'success' : 'secondary'))))))))) }}">
                                                                {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ? $data->name_status : ($data->status == 5 ? $data->name_status : ($data->status == 6 ? $data->name_status : ($data->status == 7 ? $data->name_status : ($data->status == 9 ? $data->name_status : ($data->status == 10 ? $data->name_status : ($data->status == 11 ? $data->name_status : ($data->status == 12 ? $data->name_status : ($data->status == 13 ? $data->name_status : ''))))))))) }}
                                                            </span>
                                                        </td>

                                                        <td>
                                                            <div class="row">
                                                                @if ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#cutiTolak{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('admin.cuti.izinReject')
                                                                @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Asistant Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#Reject{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('manager.staff.izinReject')
                                                                @elseif ($data->atasan_pertama == Auth::user()->id_pegawai && $data->status == 1 && $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approv', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#izinTolak{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('direktur.cuti.izinReject')
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Asistant Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#Reject{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('manager.staff.izinReject')
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#Reject{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('manager.staff.izinReject')
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 2 && $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approv', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#izinTolak{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('direktur.cuti.izinReject')
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $row->jabatan == 'Direksi')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approv', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#izinTolak{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('direktur.cuti.izinReject')
                                                                @elseif($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $row->jabatan == 'Manager')
                                                                    <div class="col-sm-3">
                                                                        <form
                                                                            action="{{ route('izin.approved', $data->id) }}"
                                                                            method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="status"
                                                                                value="Disetujui" class="form-control"
                                                                                hidden>
                                                                            <button type="submit"
                                                                                class="fa fa-check btn-success btn-sm"
                                                                                title="Setuju"></button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="col-sm-3" style="margin-left:7px">
                                                                        <form action="" method="POST">
                                                                            <a class="btn btn-danger btn-sm"
                                                                                style="height:26px" data-toggle="modal"
                                                                                data-target="#Reject{{ $data->id }}">
                                                                                <i class="fa fa-times fa-md"
                                                                                    title="Tolak"></i>
                                                                            </a>
                                                                        </form>
                                                                    </div>
                                                                    @include('manager.staff.izinReject')
                                                                @else
                                                                @endif

                                                                <div class="col-sm-3" style="margin-left:5px">
                                                                    <form action="" method="POST">
                                                                        <a class="btn btn-info btn-sm"
                                                                            style="height:26px" data-toggle="modal"
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
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#8"
                                    class="collapsed" aria-expanded="false">
                                    Pembatalan/Perubahan Sakit/Ijin

                                    @if ($jumizin)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">{{ $jumizin }}</span>
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
                                                    <th>Ijin</th>
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

                                                        <td>{{ $data->catatan }}</td>

                                                        <td>
                                                            <div class="row">
                                                                {{-- @if ($data->status == 'Pending' || $data->status == 'Disetujui Manager') --}}
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
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form
                                                                                action="{{ route('batal.tolak', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
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
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form
                                                                                action="{{ route('ubah.tolak', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
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
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form
                                                                                action="{{ route('batal.tolak', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
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
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form
                                                                                action="{{ route('ubah.tolak', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
                                                                            </form>
                                                                        </div>
                                                                    @elseif (
                                                                        $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                            $data->catatan == 'Pembatalan Disetujui Atasan' &&
                                                                            $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('batal.setuju', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form
                                                                                action="{{ route('batal.tolak', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
                                                                            </form>
                                                                        </div>
                                                                    @elseif (
                                                                        $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                            $data->catatan == 'Perubahan Disetujui Atasan' &&
                                                                            $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('ubah.setuju', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form
                                                                                action="{{ route('ubah.tolak', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
                                                                            </form>
                                                                        </div>
                                                                    @elseif (
                                                                        $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                            $data->catatan == 'Mengajukan Pembatalan' &&
                                                                            $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('batal.setuju', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form
                                                                                action="{{ route('batal.tolak', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
                                                                            </form>
                                                                        </div>
                                                                    @elseif (
                                                                        $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                            $data->catatan == 'Mengajukan Perubahan' &&
                                                                            $row->jabatan == 'Direksi')
                                                                        <div class="col-sm-3">
                                                                            <form
                                                                                action="{{ route('ubah.setuju', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form
                                                                                action="{{ route('ubah.tolak', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
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
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form
                                                                                action="{{ route('batal.tolak', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
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
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-check btn-success btn-sm"
                                                                                    title="Setuju"></button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="col-sm-3" style="margin-left:7px">
                                                                            <form
                                                                                action="{{ route('ubah.tolak', $data->id) }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                <input type="hidden" name="status"
                                                                                    value="Disetujui"
                                                                                    class="form-control" hidden>
                                                                                <button type="submit"
                                                                                    class="fa fa-times btn-danger  btn-sm"
                                                                                    title="Tolak"></button>
                                                                            </form>
                                                                        </div>
                                                                    @endif


                                                                </div>
                                                                <div class="col-sm-3" style="margin-left:5px">
                                                                    <form action="" method="POST">
                                                                        <a class="btn btn-info btn-sm"
                                                                            style="height:26px" data-toggle="modal"
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
                </div>
            </div>

            <div class="col-lg-6">
                <div class="panel-group" id="accordion-test-2">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion-test-2" href="#3"
                                    class="collapsed" aria-expanded="false">
                                    Permintaan Resign Karyawan

                                    @if ($resignjumlah)
                                        <span class="badge badge badge-danger"
                                            style="background-color:red">{{ $resignjumlah }}</span>
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
                                                        <td>{{ \Carbon\Carbon::parse($r->tgl_resign)->format('d/m/Y') }}
                                                        </td>
                                                        {{-- <td>{{ $r->tipe_resign }}</td> --}}
                                                        <!-- data for status -->
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
                                                                        <input type="hidden" name="status"
                                                                            value="1" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="btn btn-success btn-sm"><i
                                                                                class="fa fa-check"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ route('resignreject', $r->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="status"
                                                                            value="5" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm"><i
                                                                                class="fa fa-times"></i>
                                                                        </button>
                                                                    </form>
                                                                @elseif($r->karyawan->atasan_kedua == Auth::user()->id_pegawai && $r->status == 6)
                                                                    <form
                                                                        action="{{ route('resign_approved_manager', $r->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status"
                                                                            value="1" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="btn btn-success btn-sm"><i
                                                                                class="fa fa-check"></i>
                                                                        </button>
                                                                    </form>
                                                                    <form action="{{ route('resignreject', $r->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('POST')
                                                                        <input type="hidden" name="status"
                                                                            value="5" class="form-control" hidden>
                                                                        <button type="submit"
                                                                            class="btn btn-danger btn-sm"><i
                                                                                class="fa fa-times"></i>
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

                    {{-- <div class="col-lg-6">
                    <div class="panel-group" id="accordion-test-7">
                        <div class="panel panel-default ">
                            <div class="panel-heading ">
                                <h4 class="panel-title ">
                                    <a data-toggle="collapse" data-parent="#accordion-test-2" href="#13" aria-expanded="false"
                                        class="dropdown-toggle waves-effect waves-light collapsed">
                                        Informasi HRD
                                        @if (isset($jmlinfo))
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
                                                            <td>{{$loop->iteration}}</td>
                                                            <td>
                                                                <b>{{$k->judul}}</b> <br><br>
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
                </div> --}}

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
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


                    @if ((Auth::check() && Auth::user()->role == 1) || (Auth::check() && Auth::user()->role == 2))
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
                                                            <td>{{ \Carbon\Carbon::parse($k->tgl_selesai)->format('d/m/Y') }}
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

                        <div class="panel panel-default ">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion-test-8" href="#16"
                                        aria-expanded="false"
                                        class="dropdown-toggle waves-effect waves-light collapsed">
                                        Data Kehadiran Kerja Karyawan
                                        {{-- @if (isset($jumAbsen))
                                    <span class="badge badge badge-danger"
                                        style="background-color:red">@php  echo $jumAbsen; @endphp</span>
                                @endif --}}
                                        @if ($jumAbsen != 0)
                                            <span class="badge badge badge-danger"
                                                style="background-color:red">{{ $jumAbsen }}</span>
                                        @endif
                                    </a>
                                </h4>
                            </div>
                            <div id="16" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="col-xs-12 m-b-10">
                                                <button id="tarikAbsenBtn" class="btn btn-success btn-sm">Tarik
                                                    Absen</button>
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
                                                            <td>{{ \Carbon\Carbon::parse($k->total)->format('d/m/Y') }}
                                                            </td>
                                                            <td>{{ $k->jam_masuk }}</td>
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
                            @if (count($sisacutis) > 0)
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
                                    @foreach ($alokasicuti as $alokasi)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $alokasi->karyawans->nama }}</td>
                                            <td>{{ $alokasi->jeniscutis->jenis_cuti }}</td>
                                            <td>{{ $alokasi->durasi }} hari</td>
                                            <td>{{ \Carbon\Carbon::parse($alokasi->aktif_dari)->format('d/m/Y') }} s.d
                                                {{ \Carbon\Carbon::parse($alokasi->sampai)->format('d/m/Y') }}</td>
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
            <div id="a" class="panel panel-warning text-center">
                <div class="panel-heading btn-warning">
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
                    <h3 class=""><a href="{{ url('absensi-karyawan') }}"><b class="text text-danger">Belum
                                Absen</b></a></h3>
                    <p class="text-muted"><b>Anda Belum Absen</b></p>
                </div>
                <?php } ?>
            </div>
        </div>

    </div> <!-- End Row -->

    <!-- baris kedua -->
    <div class="row">
        @if (Auth::check() &&  Auth::user()->role == 4)
            <div class="col-sm-6 col-lg-3">
                <div id="a" class="panel panel-warning text-center">
                    <div class="panel-heading btn-warning">
                        <h4 class="panel-title">Data Absen Bulan Ini</h4>
                    </div>
                    <div class="panel-body">
                        <h3 class=""><b>{{ $absenBulanini }}</b></h3>
                        <p class="text-muted"><b>Kali absensi</b></p>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-lg-3">
                <div id="a" class="panel panel-warning text-center">
                    <div class="panel-heading btn-warning">
                        <h4 class="panel-title">Data Absen Bulan Lalu</h4>
                    </div>
                    <div class="panel-body">
                        <h3 class=""><b>{{ $absenBulanlalu }}</b></h3>
                        <p class="text-muted"><b>Kali absensi</b></p>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-lg-3">
                <div id="a" class="panel panel-warning text-center">
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
                <div id="a" class="panel panel-warning text-center">
                    <div class="panel-heading btn-warning">
                        <h4 class="panel-title">Terlambat Bulan Lalu</h4>
                    </div>
                    <div class="panel-body">
                        <h3 class=""><b>{{ $absenTerlambatbulanlalu }}</b></h3>
                        <p class="text-muted"><b>Kali absensi</b></p>
                    </div>
                </div>
            </div>
        @elseif(Auth::check() &&  Auth::user()->role == 3 || Auth::check() && Auth::user()->role !== 4)
                <div class="col-sm-6 col-lg-3">
                    <div id="a" class="panel panel-warning text-center">
                        <div class="panel-heading btn-warning">
                            <h4 class="panel-title">Data Absen Bulan Ini</h4>
                        </div>
                        <div class="panel-body">
                            @if (Auth::user()->role == 3 && $row->jabatan !== "Direksi" || Auth::user()->role == 3 && $row->jabatan == "Manager" || Auth::user()->role == 3 && $row->jabatan == "Asistant Manager")
                                <h3 class=""><b>{{ $absenBulaninimanager }}</b></h3>
                            @endif
                            @if(Auth::user()->role == 7 || Auth::user()->role == 3 && $row->jabatan == "Direksi")
                                <h3 class=""><b>{{ $absenBulanini }}</b></h3>
                            @endif
                            @if(Auth::user()->role == 2)
                                <h3 class=""><b>{{ $absenBulanini }}</b></h3>
                            @endif
                            <p class="text-muted"><b>Kali absensi</b></p>
                        </div>
                    </div>
                </div>


            <div class="col-sm-6 col-lg-3">
                <div id="a" class="panel panel-warning text-center">
                    <div class="panel-heading btn-warning">
                        <h4 class="panel-title">Data Absen Bulan Lalu</h4>
                    </div>
                    <div class="panel-body">
                        @if (Auth::user()->role == 3 && $row->jabatan !== "Direksi" || Auth::user()->role == 3 && $row->jabatan == "Manager" || Auth::user()->role == 3 && $row->jabatan == "Asistant Manager")
                            <h3 class=""><b>{{ $absenBulanlalumanager }}</b></h3>
                        @endif
                        @if(Auth::user()->role == 7 || Auth::user()->role == 3 && $row->jabatan == "Direksi")
                            <h3 class=""><b>{{ $absenBulanlalu }}</b></h3>
                        @endif
                        @if(Auth::user()->role == 2)
                            <h3 class=""><b>{{ $absenBulanlalu }}</b></h3>
                        @endif
                        <p class="text-muted"><b>Kali absensi</b></p>
                    </div>
                </div>
            </div>


            <div class="col-sm-6 col-lg-3">
                <div id="a" class="panel panel-warning text-center">
                    <div class="panel-heading btn-warning">
                        <h4 class="panel-title">Terlambat Bulan Ini</h4>
                    </div>
                    <div class="panel-body">
                        @if (Auth::user()->role == 3 && $row->jabatan !== "Direksi" || Auth::user()->role == 3 && $row->jabatan == "Manager" || Auth::user()->role == 3 && $row->jabatan == "Asistant Manager")
                            <h3 class=""><b>{{ $absenTerlambatBulanini }}</b></h3>
                        @endif
                        @if(Auth::user()->role == 7 || Auth::user()->role == 3  && $row->jabatan == "Direksi")
                            <h3 class=""><b>{{ $absenTerlambatBulanIni }}</b></h3>
                        @endif
                        @if(Auth::user()->role == 2)
                            <h3 class=""><b>{{ $absenTerlambatBulanIni }}</b></h3>
                        @endif
                        <p class="text-muted"><b>Kali absensi</b> </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div id="a" class="panel panel-warning text-center">
                    <div class="panel-heading btn-warning">
                        <h4 class="panel-title">Terlambat Bulan Lalu</h4>
                    </div>
                    <div class="panel-body">
                        @if (Auth::user()->role == 3 && $row->jabatan !== "Direksi" || Auth::user()->role == 3 && $row->jabatan == "Manager" || Auth::user()->role == 3 && $row->jabatan == "Asistant Manager")
                            <h3 class=""><b>{{ $absenTerlambatbulanlalumanager }}</b></h3>
                        @endif
                        @if(Auth::user()->role == 7 || Auth::user()->role == 3  && $row->jabatan == "Direksi")
                            <h3 class=""><b>{{ $absenTerlambatbulanlalu }}</b></h3>
                        @endif
                        @if(Auth::user()->role == 2)
                            <h3 class=""><b>{{ $absenTerlambatbulanlalu }}</b></h3>
                        @endif
                        <p class="text-muted"><b>Kali absensi</b></p>
                    </div>
                </div>
            </div>
    </div>

    @if (Auth::user()->role == 3 && $row->jabatan == "Manager" || Auth::user()->role == 3 && $row->jabatan == "Asistant Manager")
        <div class="row">
            <div class="col-lg-3">
                <div class="panel panel-border panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title text-white text-center">Absensi Bulan Ini</h3>
                    </div>
                    <div class="panel-body">
                        <div>
                            <canvas id="absensiChart" style="height: 300px"></canvas>
                        </div>
                    </div>
                </div>
            </div>

                <div class="col-lg-3">
                    <div class="panel panel-border panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title text-white text-center">Absen Bulan Lalu</h3>
                        </div>
                        <div class="panel-body">
                            <div>
                                <canvas id="absensiBulanLaluChart" style="height: 300px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="panel panel-border panel-warning">
                        <div class="panel-heading">
                            <h3 class="panel-title text-white text-center">Cuti & Ijin Bulan Ini</h3>
                        </div>
                        <div class="panel-body">
                            <div>
                                <canvas id="terlambatBulanIniChart" style="height: 300px"></canvas>
                            </div>
                        </div>
                    </div>
                </div>



            <div class="col-lg-3">
                <div class="panel panel-border panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title text-white text-center">Cuti & Ijin Bulan Lalu</h3>
                    </div>
                    <div class="panel-body">
                        <div>
                            <canvas id="terlambatBulanLaluChart" style="height: 300px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- End Row -->
    @endif
    @if (Auth::user()->role === 7 || Auth::user()->role == 3 && $row->jabatan == "Direksi")
        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-border panel-warning">
                    <div class="panel-heading" style="height:40px;">
                        <h3 class="panel-title text-white text-center">Absensi Tahun Ini</h3>
                    </div>
                    <div class="panel-body">
                        <div>
                            <canvas id="absensiTahuniniChart" style="height: 300px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="col-lg-6">
                <div class="panel panel-border panel-warning">
                    <div class="panel-heading" style="height:40px;">
                        <h3 class="panel-title text-white text-center">Cuti & Ijin Tahun Ini</h3>
                    </div>
                    <div class="panel-body">
                        <div>
                            <canvas id="cutiTahuniniChart" style="height: 300px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- {{$absenmasuk}} --}}
        {{-- {{dd($terlambats)}} --}}
        {{-- {{dd($attendance)}} --}}
        {{-- {{$terlambats}}{{$tidakmasuk}} --}}
    @endif
    <style>
        #a {
            border-radius: 10px;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @if (Auth::user()->role == 3 && $row->jabatan == "Manager" || Auth::user()->role == 3 && $row->jabatan == "Asistant Manager")
        <script>
            var absenBulaninimanager = {{ $absenBulaninimanager }};
            var absenTerlambatBulanini = {{ $absenTerlambatBulanini }};
            var tidakMasukBulanini = {{ $tidakMasukBulanini }};
            var absenBulanlalumanager = {{ $absenBulanlalumanager }};
            var absenTerlambatbulanlalumanager = {{ $absenTerlambatbulanlalumanager }};
            var tidakMasukBulanlalu = {{ $tidakMasukBulanlalu }};
            var cutiBulanInimanager = {{ $cutiBulanInimanager }};
            var dataIzinBulanInimanager = {{ $dataIzinBulanInimanager }};
            var cutiBulanLalumanager = {{ $cutiBulanLalumanager }};
            var dataIzinBulanLalumanager = {{ $dataIzinBulanLalumanager }};

                // '#FF8C00',

            const data = {
                labels: ['Masuk', 'Terlambat', 'Tidak Masuk'],
                datasets: [{
                    label: '',
                    backgroundColor: ['#18bae2', '#FF8C00', '#f44336'],
                    borderColor: ['#18bae2', '#FF8C00', '#f44336'],
                    borderWidth: 1,
                    data: [absenBulaninimanager, absenTerlambatBulanini, tidakMasukBulanini],
                }]
            };

            const data1 = {
                labels: ['Cuti', 'Ijin'],
                datasets: [{
                    label: '',
                    backgroundColor: ['#18bae2', '#FF8C00'],
                    borderColor: ['#18bae2', '#FF8C00'],
                    borderWidth: 1,
                    data: [cutiBulanInimanager, dataIzinBulanInimanager],
                }]
            };
            const data2 = {
                labels: ['Masuk', 'Terlambat', 'Tidak Masuk'],
                datasets: [{
                    label: '',
                    backgroundColor: ['#18bae2', '#FF8C00', '#f44336'],
                    borderColor: ['#18bae2', '#FF8C00', '#f44336'],
                    borderWidth: 1,
                    data: [absenBulanlalumanager, absenTerlambatbulanlalumanager, tidakMasukBulanlalu],
                }]
            };

            const data3 = {
                labels: ['Cuti', 'Ijin'],
                datasets: [{
                    label: '',
                    backgroundColor: ['#18bae2', '#FF8C00'],
                    borderColor: ['#18bae2', '#FF8C00'],
                    borderWidth: 1,
                    data: [cutiBulanLalumanager, dataIzinBulanLalumanager],
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

            const absensiChart = new Chart(
                document.getElementById('absensiChart'),
                config
            );
            const terlambatBulanIniChart = new Chart(
                document.getElementById('terlambatBulanIniChart'),
                config1
            );
            const absensiBulanLaluChart = new Chart(
                document.getElementById('absensiBulanLaluChart'),
                config2
            );
            const terlambatBulanLaluChart = new Chart(
                document.getElementById('terlambatBulanLaluChart'),
                config3
            );
        </script>
    @elseif(Auth::user()->role === 7 || Auth::user()->role === 3 && $row->jabatan == "Direksi")
        <script>
            var namabulan = @json($namabulan);
            var attendance = @json($attendance);
            var terlambats = @json($terlambats);
            var tidakmasuk = @json($tidakmasuk);

                var attendanceArray = attendance.split(', ');
                var terlambatsArray = terlambats.split(', ');
                var tidakmasukArray = tidakmasuk.split(', ');

                //cuti dan izin
                var leave       =  @json($leave);
                var permission  =  @json($permission);
                var leaveArray  = leave.split(', ');
                var permissionArray = permission.split(', ');

                const data = {
                    labels: namabulan,
                    datasets: [
                        {
                            label: 'Absen Masuk',
                            backgroundColor: ['#006400'],
                            borderColor: ['#006400'],
                            borderWidth: 1,
                            data: attendanceArray,
                        },
                        {
                            label: 'Terlambat',
                            backgroundColor: ['#FF1493'],
                            borderColor: ['#FF1493'],
                            borderWidth: 1,
                            data: terlambatsArray,
                        },
                        {
                            label: 'Tidak masuk',
                            backgroundColor: ['#18bae2'],
                            borderColor: ['#18bae2'],
                            borderWidth: 1,
                            data: tidakmasukArray,
                        },
                    ]
                };

                const data2 = {
                    labels: namabulan,
                    datasets: [
                        {
                            label: 'Cuti',
                            backgroundColor: ['#FF1493'],
                            borderColor: ['#FF1493'],
                            borderWidth: 1,
                            data: leaveArray,
                        },
                        {
                            label: 'Ijin',
                            backgroundColor: ['#18bae2'],
                            borderColor: ['#18bae2'],
                            borderWidth: 1,
                            data: permissionArray,
                        },
                    ]
                };

                const config = {
                    type: 'line',
                    data: data,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        }
                    },
                };

                const config2 = {
                    type: 'line',
                    data: data2,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        }
                    },
                };
                const absensiTahuniniChart = new Chart(
                    document.getElementById('absensiTahuniniChart'),
                    config
                );

                const cutiTahuniniChart = new Chart(
                    document.getElementById('cutiTahuniniChart'),
                    config2
                );

            </script>
        @endif
    @endif
@endsection
