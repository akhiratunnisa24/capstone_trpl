@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Data Cuti dan Izin Karyawan</h4>
                <ol class="breadcrumb pull-right">
                    <li><a href="#">Rynest Employee Management System</a></li>
                    <li class="active">Data Cuti & Izin</li>
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
                <li class="active" id="aaa">
                    <a id="tabs_a" href="#dcuti" data-toggle="tab" aria-expanded="false">
                        <span class="visible-xs"><i class="fa fa-home"></i></span>
                        <span class="hidden-xs">Data Cuti</span>
                    </a>
                </li>
                <li class="" id="bbb">
                    <a id="tabs_b" href="#dizin" data-toggle="tab" aria-expanded="true">
                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                        <span class="hidden-xs">Data Izin</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="dcuti">
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20">
                                    <form class="" action="">
                                        <div class="row">
                                            {{-- <div class="col-sm-1"></div> --}}
                                            <div class="col-sm-3 col-xs-12">
                                                <div class="m-t-20">
                                                    <div class="form-group">
                                                        <label>Karyawan</label>

                                                        <select name="id_karyawan" id="id_karyawan"
                                                            class="form-control selectpicker" data-live-search="true"
                                                            required>
                                                            <option>-- Pilih Karyawan --</option>
                                                            @foreach ($karyawan as $data)
                                                                <option value="{{ $data->id }}"
                                                                    @if ($data->id == request()->id_karyawan) selected @endif>
                                                                    {{ $data->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-xs-12">
                                                <div class="m-t-20">
                                                    <div class="form-group">
                                                        <label>Bulan</label>
                                                        <select name="bulans" id="bulans"
                                                            class="col-md-3 form-control selectpicker"
                                                            data-live-search="true" required>
                                                            <option value="">-- Pilih Bulan --</option>
                                                            <option value="01"
                                                                {{ '01' === request()->bulans ? 'selected' : '' }}>Januari
                                                            </option>
                                                            <option value="02"
                                                                {{ '02' === request()->bulans ? 'selected' : '' }}>
                                                                Februari</option>
                                                            <option value="03"
                                                                {{ '03' === request()->bulans ? 'selected' : '' }}>Maret
                                                            </option>
                                                            <option value="04"
                                                                {{ '04' === request()->bulans ? 'selected' : '' }}>April
                                                            </option>
                                                            <option value="05"
                                                                {{ '05' === request()->bulans ? 'selected' : '' }}>Mei
                                                            </option>
                                                            <option value="06"
                                                                {{ '06' === request()->bulans ? 'selected' : '' }}>Juni
                                                            </option>
                                                            <option value="07"
                                                                {{ '07' === request()->bulans ? 'selected' : '' }}>Juli
                                                            </option>
                                                            <option value="08"
                                                                {{ '08' === request()->bulans ? 'selected' : '' }}>Agustus
                                                            </option>
                                                            <option value="09"
                                                                {{ '09' === request()->bulans ? 'selected' : '' }}>
                                                                September</option>
                                                            <option value="10"
                                                                {{ '10' === request()->bulans ? 'selected' : '' }}>
                                                                Oktober</option>
                                                            <option value="11"
                                                                {{ '11' === request()->bulans ? 'selected' : '' }}>
                                                                November</option>
                                                            <option value="12"
                                                                {{ '12' === request()->bulans ? 'selected' : '' }}>
                                                                Desember</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-xs-12">
                                                <div class="m-t-20">
                                                    <div class="form-group">
                                                        <label>Tahun</label>
                                                        <select name="tahuns" id="tahuns"
                                                            class="col-md-3 form-control selectpicker"
                                                            data-live-search="true" required>
                                                            <option value="" required>-- Pilih Tahun --</option>
                                                            {{-- {{ ('01' === request()->bulans) ? 'selected' : '' }} --}}
                                                            <option value="2020"
                                                                {{ '2020' === request()->tahuns ? 'selected' : '' }}>2020
                                                            </option>
                                                            <option value="2021"
                                                                {{ '2021' === request()->tahuns ? 'selected' : '' }}>2021
                                                            </option>
                                                            <option value="2022"
                                                                {{ '2022' === request()->tahuns ? 'selected' : '' }}>2022
                                                            </option>
                                                            <option value="2023"
                                                                {{ '2023' === request()->tahuns ? 'selected' : '' }}>2023
                                                            </option>
                                                            <option value="2024"
                                                                {{ '2024' === request()->tahuns ? 'selected' : '' }}>2024
                                                            </option>
                                                            <option value="2025"
                                                                {{ '2025' === request()->tahuns ? 'selected' : '' }}>2025
                                                            </option>
                                                            <option value="2026"
                                                                {{ '2026' === request()->tahuns ? 'selected' : '' }}>2026
                                                            </option>
                                                            <option value="2027"
                                                                {{ '2027' === request()->tahuns ? 'selected' : '' }}>2027
                                                            </option>
                                                            <option value="2028"
                                                                {{ '2028' === request()->tahuns ? 'selected' : '' }}>2028
                                                            </option>
                                                            <option value="2029"
                                                                {{ '2029' === request()->tahuns ? 'selected' : '' }}>2029
                                                            </option>
                                                            <option value="2030"
                                                                {{ '2030' === request()->tahuns ? 'selected' : '' }}>2030
                                                            </option>
                                                            <option value="2011"
                                                                {{ '2011' === request()->tahuns ? 'selected' : '' }}>2031
                                                            </option>
                                                            <option value="2012"
                                                                {{ '2012' === request()->tahuns ? 'selected' : '' }}>2032
                                                            </option>
                                                            <option value="2013"
                                                                {{ '2013' === request()->tahuns ? 'selected' : '' }}>2033
                                                            </option>
                                                            <option value="2014"
                                                                {{ '2014' === request()->tahuns ? 'selected' : '' }}>2034
                                                            </option>
                                                            <option value="2015"
                                                                {{ '2015' === request()->tahuns ? 'selected' : '' }}>2035
                                                            </option>
                                                            <option value="2016"
                                                                {{ '2016' === request()->tahuns ? 'selected' : '' }}>2036
                                                            </option>
                                                            <option value="2017"
                                                                {{ '2017' === request()->tahuns ? 'selected' : '' }}>2037
                                                            </option>
                                                            <option value="2018"
                                                                {{ '2018' === request()->tahuns ? 'selected' : '' }}>2038
                                                            </option>
                                                            <option value="2019"
                                                                {{ '2019' === request()->tahuns ? 'selected' : '' }}>2039
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-xs-12">
                                                <div class="" style="margin-top:26px">
                                                    <div class="form-group">
                                                        <label></label>
                                                        <div>
                                                            <button type="submit" id="search"
                                                                class="btn btn-md btn-success fa fa-filter">
                                                                Filter</button>
                                                            <a href="/cuti-staff"
                                                                class="btn btn-md btn-success fa fa-refresh"> Reset</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading clearfix">
                                            <a href="/rekapcutiexcel" id="exportToExcel"
                                                class="btn btn-dark btn-sm fa fa-file-excel-o"> Ekspor Excel</a>
                                            <a href="/rekapcutiPdf" id="exportToPdf"
                                                class="btn btn-dark btn-sm fa fa fa-file-pdf-o" target="_blank"> Ekspor
                                                PDF</a>
                                        </div>
                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-20 col-sm-20 col-xs-20">
                                                    <table id="datatable-responsive22"
                                                        class="table table-responsive dt-responsive table-striped table-bordered"
                                                        width="100%">
                                                        <thead>
                                                            <tr>
                                                                @php
                                                                    use Carbon\Carbon;
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
                                                                <th>Saldo Hak Cuti {{ $year }}</th>
                                                                <th>Jumlah Cuti {{ $year }}</th>
                                                                <th>Sisa Cuti {{ $year }}</th>
                                                                <th>Persetujuan</th>
                                                                <th>Catatan</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($cuti as $data)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($data->tgl_permohonan)->format('d/m/Y') }}
                                                                    </td>
                                                                    <td>{{ $data->nik }}</td>
                                                                    <td>{{ $data->nama }}</td>
                                                                    <td>{{ $data->jabatan }}</td>
                                                                    <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                                        s.d
                                                                        {{ \Carbon\Carbon::parse($data->tgl_selesai)->format('d/m/Y') }}
                                                                    </td>
                                                                    <td>{{ $data->jenis_cuti }}</td>
                                                                    <td>{{ $data->jmlharikerja }}</td>
                                                                    <td>{{ $data->saldohakcuti }}</td>
                                                                    <td>{{ $data->jml_cuti }}</td>
                                                                    <td>{{ $data->sisacuti }}</td>

                                                                    <td>
                                                                        <span
                                                                            class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'danger' : ($data->status == 14 ? 'warning' : ($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' : 'secondary')))))))))))) }}">
                                                                            {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ? $data->name_status : ($data->status == 5 ? $data->name_status : ($data->status == 6 ? $data->name_status : ($data->status == 7 ? $data->name_status : ($data->status == 9 ? $data->name_status : ($data->status == 10 ? $data->name_status : ($data->status == 11 ? $data->name_status : ($data->status == 12 ? $data->name_status : ($data->status == 13 ? $data->name_status : ($data->status == 14 ? $data->name_status : ($data->status == 15 ? $data->name_status : ($data->status == 16 ? $data->name_status : '')))))))))))) }}
                                                                        </span>
                                                                    </td>
                                                                    <td>{{ $data->catatan }}</td>
                                                                    <td id="b" class="text-center">
                                                                        <div class="row">
                                                                            @if (
                                                                                $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                                    $data->status == 1 &&
                                                                                    $row->jabatan == 'Manager' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('cuti.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui Manager"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"
                                                                                            title="Setuju"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:8px">
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
                                                                            @elseif (
                                                                                $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                                    $data->status == 1 &&
                                                                                    $row->jabatan == 'Asistant Manager' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('cuti.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"
                                                                                            title="Setuju"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
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
                                                                            @elseif ($data->atasan_kedua == Auth::user()->id_pegawai && $data->status == 6 && $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('cuti.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui Manager"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"
                                                                                            title="Setuju"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:8px">
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
                                                                            @elseif (
                                                                                $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                                    $data->catatan == 'Pembatalan Disetujui Atasan' &&
                                                                                    $row->jabatan == 'Manager')
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('batal.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('batal.rejected', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
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
                                                                                        action="{{ route('ubah.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('ubah.rejected', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
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
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('batal.rejected', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
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
                                                                                        action="{{ route('ubah.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('ubah.rejected', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
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
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('batal.rejected', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
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
                                                                                        action="{{ route('ubah.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('ubah.rejected', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif (
                                                                                $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                                    $data->status == 1 &&
                                                                                    $row->jabatan == 'Direksi' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('leave.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"
                                                                                            title="Setuju"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
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
                                                                            @elseif (
                                                                                $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                                    $data->status == 2 &&
                                                                                    $row->jabatan == 'Asistant Manager' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('cuti.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"
                                                                                            title="Setuju"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
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
                                                                            @elseif (
                                                                                $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                                    $data->status == 2 &&
                                                                                    $row->jabatan == 'Manager' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('cuti.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"
                                                                                            title="Setuju"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
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
                                                                            @elseif (
                                                                                $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                                    $data->status == 2 &&
                                                                                    $row->jabatan == 'Direksi' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('leave.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"
                                                                                            title="Setuju"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
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
                                                                                        style="height:26px"
                                                                                        data-toggle="modal"
                                                                                        data-target="#shoCutiStaff{{ $data->id }}">
                                                                                        <i class="fa fa-eye"
                                                                                            title="Lihat Detail"></i>
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

                <div class="tab-pane" id="dizin">
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20">
                                    <form class="" action="">
                                        {{-- @csrf --}}
                                        <div class="row">
                                            {{-- <div class="col-sm-1"></div> --}}
                                            <div class="col-sm-3 col-xs-12">
                                                <div class="m-t-20">
                                                    <div class="form-group">
                                                        <label>Karyawan</label>

                                                        <select name="idpegawai" id="idpegawai"
                                                            class="form-control selectpicker" data-live-search="true"
                                                            required>
                                                            <option>-- Pilih Karyawan --</option>
                                                            @foreach ($pegawai as $data)
                                                                <option value="{{ $data->id }}"
                                                                    @if ($data->id == request()->id_karyawan) selected @endif>
                                                                    {{ $data->nama }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-3 col-xs-12">
                                                <div class="m-t-20">
                                                    <div class="form-group">
                                                        <label>Bulan</label>
                                                        <select name="months" id="months"
                                                            class="col-md-3 form-control selectpicker"
                                                            data-live-search="true" required>
                                                            <option value="">-- Pilih Bulan --</option>
                                                            <option value="01"
                                                                {{ '01' === request()->months ? 'selected' : '' }}>
                                                                Januari</option>
                                                            <option value="02"
                                                                {{ '02' === request()->months ? 'selected' : '' }}>
                                                                Februari</option>
                                                            <option value="03"
                                                                {{ '03' === request()->months ? 'selected' : '' }}>Maret
                                                            </option>
                                                            <option value="04"
                                                                {{ '04' === request()->months ? 'selected' : '' }}>April
                                                            </option>
                                                            <option value="05"
                                                                {{ '05' === request()->months ? 'selected' : '' }}>Mei
                                                            </option>
                                                            <option value="06"
                                                                {{ '06' === request()->months ? 'selected' : '' }}>Juni
                                                            </option>
                                                            <option value="07"
                                                                {{ '07' === request()->months ? 'selected' : '' }}>Juli
                                                            </option>
                                                            <option value="08"
                                                                {{ '08' === request()->months ? 'selected' : '' }}>
                                                                Agustus</option>
                                                            <option value="09"
                                                                {{ '09' === request()->months ? 'selected' : '' }}>
                                                                September</option>
                                                            <option value="10"
                                                                {{ '10' === request()->months ? 'selected' : '' }}>
                                                                Oktober</option>
                                                            <option value="11"
                                                                {{ '11' === request()->months ? 'selected' : '' }}>
                                                                November</option>
                                                            <option value="12"
                                                                {{ '12' === request()->months ? 'selected' : '' }}>
                                                                Desember</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-xs-12">
                                                <div class="m-t-20">
                                                    <div class="form-group">
                                                        <label>Tahun</label>
                                                        <select name="years" id="years"
                                                            class="col-md-3 form-control selectpicker"
                                                            data-live-search="true" required>
                                                            <option value="" required>-- Pilih Tahun --</option>
                                                            {{-- {{ ('01' === request()->bulans) ? 'selected' : '' }} --}}
                                                            <option value="2020"
                                                                {{ '2020' === request()->years ? 'selected' : '' }}>2020
                                                            </option>
                                                            <option value="2021"
                                                                {{ '2021' === request()->years ? 'selected' : '' }}>2021
                                                            </option>
                                                            <option value="2022"
                                                                {{ '2022' === request()->years ? 'selected' : '' }}>2022
                                                            </option>
                                                            <option value="2023"
                                                                {{ '2023' === request()->years ? 'selected' : '' }}>2023
                                                            </option>
                                                            <option value="2024"
                                                                {{ '2024' === request()->years ? 'selected' : '' }}>2024
                                                            </option>
                                                            <option value="2025"
                                                                {{ '2025' === request()->years ? 'selected' : '' }}>2025
                                                            </option>
                                                            <option value="2026"
                                                                {{ '2026' === request()->years ? 'selected' : '' }}>2026
                                                            </option>
                                                            <option value="2027"
                                                                {{ '2027' === request()->years ? 'selected' : '' }}>2027
                                                            </option>
                                                            <option value="2028"
                                                                {{ '2028' === request()->years ? 'selected' : '' }}>2028
                                                            </option>
                                                            <option value="2029"
                                                                {{ '2029' === request()->years ? 'selected' : '' }}>2029
                                                            </option>
                                                            <option value="2030"
                                                                {{ '2030' === request()->years ? 'selected' : '' }}>2030
                                                            </option>
                                                            <option value="2011"
                                                                {{ '2011' === request()->years ? 'selected' : '' }}>2031
                                                            </option>
                                                            <option value="2012"
                                                                {{ '2012' === request()->years ? 'selected' : '' }}>2032
                                                            </option>
                                                            <option value="2013"
                                                                {{ '2013' === request()->years ? 'selected' : '' }}>2033
                                                            </option>
                                                            <option value="2014"
                                                                {{ '2014' === request()->years ? 'selected' : '' }}>2034
                                                            </option>
                                                            <option value="2015"
                                                                {{ '2015' === request()->years ? 'selected' : '' }}>2035
                                                            </option>
                                                            <option value="2016"
                                                                {{ '2016' === request()->years ? 'selected' : '' }}>2036
                                                            </option>
                                                            <option value="2017"
                                                                {{ '2017' === request()->years ? 'selected' : '' }}>2037
                                                            </option>
                                                            <option value="2018"
                                                                {{ '2018' === request()->years ? 'selected' : '' }}>2038
                                                            </option>
                                                            <option value="2019"
                                                                {{ '2019' === request()->years ? 'selected' : '' }}>2039
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-xs-12">
                                                <div class="" style="margin-top:26px">
                                                    <div class="form-group">
                                                        <label></label>
                                                        <div>
                                                            <button type="submit" id="searchs"
                                                                class="btn btn-md btn-success fa fa-filter">
                                                                Filter</button>
                                                            <a href="/cuti-staff"
                                                                class="btn btn-md btn-success fa fa-refresh"> Reset</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="panel panel-primary">
                                        <div class="panel-heading clearfix">

                                            <a href="/rekapizinexcel" id="exportToExcel"
                                                class="btn btn-dark btn-sm fa fa-file-excel-o"> Ekspor Excel</a>
                                            <a href="/rekapizinPdf" id="exportToPdf"
                                                class="btn btn-dark btn-sm fa fa fa-file-pdf-o" target="_blank"> Ekspor
                                                PDF</a>
                                        </div>
                                        <div class="panel-body m-b-5">
                                            <div class="row">
                                                <div class="col-md-20 col-sm-20 col-xs-20">
                                                    <table id="datatable-responsive12"
                                                        class="table dt-responsive table-striped table-bordered"
                                                        width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Karyawan</th>
                                                                <th>Kategori</th>
                                                                <th>Keperluan</th>
                                                                <th>Tanggal</th>
                                                                <th>Jml</th>
                                                                <th>Mulai s/d Selesai</th>
                                                                <th>Status</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($izin as $data)
                                                                <tr>
                                                                    <td>{{ $loop->iteration }}</td>
                                                                    <td>{{ $data->nama }}</td>
                                                                    <td>{{ $data->jenis_izin }}</td>
                                                                    <td>{{ $data->keperluan }}</td>

                                                                    {{-- tanggal mulai & tanggal selesai --}}
                                                                    @if ($data->tgl_mulai != $data->tgl_selesai)
                                                                        <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/m/Y') }}
                                                                            s/d
                                                                            {{ \Carbon\Carbon::parse($data->tgl_selesai)->format('d/m/Y') }}
                                                                        </td>
                                                                    @else
                                                                        <td>{{ \Carbon\Carbon::parse($data->tgl_mulai)->format('d/M/Y') }}
                                                                        </td>
                                                                    @endif

                                                                    {{-- Jumlah hari izin --}}
                                                                    @if ($data->jml_hari != null)
                                                                        <td>{{ $data->jml_hari }} Hari</td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif

                                                                    {{-- jam mulai & jam selesai --}}
                                                                    @if ($data->jam_mulai != null && $data->jam_mulai != null)
                                                                        <td>{{ \Carbon\Carbon::parse($data->jam_mulai)->format('H:i') }}
                                                                            s/d
                                                                            {{ \Carbon\Carbon::parse($data->jam_selesai)->format('H:i') }}
                                                                        </td>
                                                                    @else
                                                                        <td></td>
                                                                    @endif

                                                                    {{-- status --}}
                                                                    <td>
                                                                        {{-- <span class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : '')))) }}">
                                                                            {{ $data->status == 1 ? 'Pending' : ($data->status == 2 ? 'Disetujui Manager' : ($data->status == 5 ? 'Ditolak' : ($data->status == 6 ? 'Disetujui Asistant Manager' : ($data->status == 7 ? 'Disetujui' : '')))) }}
                                                                        </span> --}}
                                                                        <span
                                                                            class="badge badge-{{ $data->status == 1 ? 'warning' : ($data->status == 2 ? 'info' : ($data->status == 5 ? 'danger' : ($data->status == 6 ? 'secondary' : ($data->status == 7 ? 'success' : ($data->status == 9 ? 'danger' : ($data->status == 10 ? 'danger' : ($data->status == 11 ? 'warning' : ($data->status == 12 ? 'secondary' : ($data->status == 13 ? 'danger' : ($data->status == 14 ? 'warning' : ($data->status == 15 ? 'primary' : ($data->status == 16 ? 'primary' : 'secondary')))))))))))) }}">
                                                                            {{ $data->status == 1 ? $data->name_status : ($data->status == 2 ? $data->name_status : ($data->status == 5 ? $data->name_status : ($data->status == 6 ? $data->name_status : ($data->status == 7 ? $data->name_status : ($data->status == 9 ? $data->name_status : ($data->status == 10 ? $data->name_status : ($data->status == 11 ? $data->name_status : ($data->status == 12 ? $data->name_status : ($data->status == 13 ? $data->name_status : ($data->status == 14 ? $data->name_status : ($data->status == 15 ? $data->name_status : ($data->status == 16 ? $data->name_status : '')))))))))))) }}
                                                                        </span>
                                                                    </td>

                                                                    <td>
                                                                        <div class="row">
                                                                            @if (
                                                                                $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                                    $data->status == 1 &&
                                                                                    $row->jabatan == 'Manager' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm"
                                                                                            style="height:26px"
                                                                                            data-toggle="modal"
                                                                                            data-target="#cutiTolak{{ $data->id }}">
                                                                                            <i
                                                                                                class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif (
                                                                                $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                                    $data->status == 1 &&
                                                                                    $row->jabatan == 'Asistant Manager' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm"
                                                                                            style="height:26px"
                                                                                            data-toggle="modal"
                                                                                            data-target="#Reject{{ $data->id }}">
                                                                                            <i
                                                                                                class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                @include('manager.staff.izinReject')
                                                                            @elseif (
                                                                                $data->atasan_pertama == Auth::user()->id_pegawai &&
                                                                                    $data->status == 1 &&
                                                                                    $row->jabatan == 'Direksi' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm"
                                                                                            style="height:26px"
                                                                                            data-toggle="modal"
                                                                                            data-target="#Reject{{ $data->id }}">
                                                                                            <i
                                                                                                class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>

                                                                                @include('manager.staff.izinReject')
                                                                            @elseif (
                                                                                $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                                    $data->status == 2 &&
                                                                                    $row->jabatan == 'Asistant Manager' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm"
                                                                                            style="height:26px"
                                                                                            data-toggle="modal"
                                                                                            data-target="#Reject{{ $data->id }}">
                                                                                            <i
                                                                                                class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                @include('manager.staff.izinReject')
                                                                            @elseif (
                                                                                $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                                    $data->status == 2 &&
                                                                                    $row->jabatan == 'Manager' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm"
                                                                                            style="height:26px"
                                                                                            data-toggle="modal"
                                                                                            data-target="#Reject{{ $data->id }}">
                                                                                            <i
                                                                                                class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                @include('manager.staff.izinReject')
                                                                            @elseif (
                                                                                $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                                    $data->status == 2 &&
                                                                                    $row->jabatan == 'Direksi' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm"
                                                                                            style="height:26px"
                                                                                            data-toggle="modal"
                                                                                            data-target="#Reject{{ $data->id }}">
                                                                                            <i
                                                                                                class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                            @elseif (
                                                                                $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                                    $data->status == 6 &&
                                                                                    $row->jabatan == 'Manager' &&
                                                                                    $data->catatan == null)
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('izin.approved', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form action="" method="POST">
                                                                                        <a class="btn btn-danger btn-sm"
                                                                                            style="height:26px"
                                                                                            data-toggle="modal"
                                                                                            data-target="#Reject{{ $data->id }}">
                                                                                            <i
                                                                                                class="fa fa-times fa-md"></i>
                                                                                        </a>
                                                                                    </form>
                                                                                </div>
                                                                                @include('manager.staff.izinReject')
                                                                            @elseif (
                                                                                $data->atasan_kedua == Auth::user()->id_pegawai &&
                                                                                    $data->catatan == 'Pembatalan Disetujui Atasan' &&
                                                                                    $row->jabatan == 'Manager')
                                                                                <div class="col-sm-3">
                                                                                    <form
                                                                                        action="{{ route('batal.setuju', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('batal.tolak', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
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
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('ubah.tolak', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
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
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('batal.tolak', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
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
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('ubah.tolak', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
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
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('batal.tolak', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
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
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-check btn-success btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                                <div class="col-sm-3"
                                                                                    style="margin-left:7px">
                                                                                    <form
                                                                                        action="{{ route('ubah.tolak', $data->id) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Disetujui"
                                                                                            class="form-control" hidden>
                                                                                        <button type="submit"
                                                                                            class="fa fa-times btn-danger  btn-sm"></button>
                                                                                    </form>
                                                                                </div>
                                                                            @else
                                                                            @endif

                                                                            <div class="col-sm-3" style="margin-left:5px">
                                                                                <form action="" method="POST">
                                                                                    <a class="btn btn-info btn-sm"
                                                                                        style="height:26px"
                                                                                        data-toggle="modal"
                                                                                        data-target=" #Showizinm{{ $data->id }}">
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
        let tipe = `{{ $tipe }}`;

        if (tipe == 1) {
            $('#tabs_a').click();
            $('#tabs_1').addClass('active');
            $('#tabs_2').removeClass('active');
            $('#dcuti').addClass('active');
            $('#dizin').removeClass('active');
            $('#aaa').addClass('active');
            $('#bbb').removeClass('active');
        } else {
            $('#tabs_b').click();
            $('#tabs_1').removeClass('active');
            $('#tabs_2').addClass('active');
            $('#dcuti').removeClass('active');
            $('#dizin').addClass('active');
            $('#aaa').removeClass('active');
            $('#bbb').addClass('active');
        }
    </script>
@endsection
