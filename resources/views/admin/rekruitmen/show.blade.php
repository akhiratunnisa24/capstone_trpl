@extends('layouts.default')

@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title ">Detail Rekrutmen</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Detail Rekrutmen</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>



    <div class="panel panel-primary">

        @csrf
        @method('put')

        <div class="modal-body">

            <table class="table table-bordered table-striped" style="width:100%">
                <tbody class="col-sm-20">
                    @if ($lowongan->status == 'Aktif')
                        <label class="">
                            <h4> {{ $lowongan->posisi }} </h4>
                        </label>
                    @else
                        <label class="">
                            <h4> {{ $lowongan->posisi }} </h4>
                            <h3 class="badge badge-danger">Lowongan Tidak Aktif</h3>
                        </label>
                    @endif

                    <tr>
                        <td><label>Jumlah dibutuhkan</label></td>
                        <td><label> {{ $lowongan->jumlah_dibutuhkan }}</label></td>
                    </tr>
                    <tr>
                        <td><label>Persyaratan</label></td>
                        <td><label> {{ $lowongan->persyaratan }}</label></td>
                    </tr>
                    <tr>
                        <td><label>Periode Lamaran</label></td>
                        <td>
                            @if ($lowongan->tgl_mulai && $lowongan->tgl_selesai)
                                <label>{{ date('d/m/Y', strtotime($lowongan->tgl_mulai)) }}</label> sampai dengan
                                <label>{{ date('d/m/Y', strtotime($lowongan->tgl_selesai)) }}</label>
                            @else
                                <label>Periode lamaran tidak tersedia</label>
                            @endif
                        </td>
                    </tr>

                    <tr>
                </tbody>
            </table>

            <div class="panel-body">
                <div class="row">
                    @foreach ($posisi as $k)
                        <div class="col-sm-3">
                            <div class="panel panel-primary text-center">
                                <div class="panel-heading btn-success">
                                    <a href="#{{ $k->mrekruitmen->id }}" data-toggle="tab" class="panel-title ">
                                        <h4 class="panel-title">Data Pelamar</h4>
                                    </a>
                                </div>
                                <div class="panel-body">
                                    <h3 class=""><b>{{ $k->mrekruitmen->nama_tahapan }}</b></h3>
                                    {{-- <p class="text-muted"><b>Total {{ $totalTahap2 }} Pelamar</b>  --}}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="row">

                <div class="col-sm-12">
                    <div class="panel panel-primary text-center">
                        <ul class="nav nav-tabs navtab-bg nav-justified">
                            @foreach ($posisi as $k)
                                <li>
                                    <a href="#{{ $k->mrekruitmen->id }}" data-toggle="tab" aria-expanded="true">
                                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                                        <span class="hidden-xs">{{ $k->mrekruitmen->nama_tahapan }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Tabel Pelamar Tahap 1 --}}
                    <div class="tab-content">

                        <div class="tab-pane" id="1">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Penyerahan CV</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($dataId1 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>

                                                {{-- @if ($k->status_lamaran == 'tahap 1') --}}

                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>

                                                {{-- <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#myModal{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.showModal') --}}

                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')


                                                {{-- <div class="col-md-3">
                                                <form action="update_pelamar{{ $k->id }}" method="POST"
                                                    onsubmit="#">
                                                    @csrf
                                                    <select class="form-control selectpicker "
                                                        onchange="if(confirm('Apakah Anda yakin?')){this.form.submit()}" name="status_lamaran">
                                                        <option value="">Pilih Tahap Selanjutnya</option>
                                                        @foreach ($metode as $k)
                                                            <option value="{{ $k->mrekruitmen->id }}">{{ $k->mrekruitmen->nama_tahapan }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <button type="submit" class="fa fa-check btn-success btn-sm"></button>
                                                    <input type="hidden" name="status_lamaran" value="3"
                                                        class="form-control" hidden>
                                                    <button type="submit" class="fa fa-check btn-success btn-sm"></button>

                                                </form>
                                            </div> --}}


                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status_lamaran" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>

                                                {{-- @endif --}}
                                            </td>



                                            <!-- <button class="btn btn-default waves-effect waves-light" id="sa-success">Click me</button> -->

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="5">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Test Psikotest</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataId5 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>
                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')
                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="7">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Test Asuransi Umum</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($dataId7 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? ''}}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>
                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')

                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="8">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Test Asuransi Syariah</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($dataId8 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>

                                                {{-- @if ($k->status_lamaran == 'tahap 2') --}}

                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>

                                                {{-- <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#myModal{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.showModal') --}}

                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')

                                                {{-- <div class="col-md-3">
                                                <form action="update_pelamar{{ $k->id }}" method="POST"
                                                    onsubmit="return confirmSave2()">
                                                    @csrf
                                                   <select class="form-control selectpicker "
                                                        onchange="if(confirm('Apakah Anda yakin?')){this.form.submit()}" name="status_lamaran">
                                                        <option value="">Pilih Tahap Selanjutnya</option>
                                                        @foreach ($metode as $k)
                                                            <option value="{{ $k->mrekruitmen->id }}">{{ $k->mrekruitmen->nama_tahapan }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                            </div> --}}

                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                                {{-- @endif --}}
                                            </td>




                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="9">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Test Pengetahuan Umum & Teknis</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataId9 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>
                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')
                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="10">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Wawancara Tahap 1 (HRD)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataId10 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>
                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')
                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="11">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Wawancara Tahap 2 (Atasan Karyawan / Pimpinan Unit Kerja)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataId11 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>
                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')
                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="12">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Wawancara Tahap 3 (Direksi)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataId12 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>
                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')
                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="13">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Wawancara Tahap 4 (Wakil Direktur Utama)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataId13 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>
                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')
                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="14">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Wawancara Tahap 5 (Direktur Utama)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataId14 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>
                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')
                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="15">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Test Kesehatan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataId15 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>
                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')
                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="17">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Pengumuman Hasil Seleksi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataId17 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>
                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')
                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="18">
                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Penempatan Tenaga Kerja</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataId18 as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>
                                            <td>
                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#lulusModal{{ $k->id }}">
                                                        <i class="fa fa-check btn-success btn-sm "></i>
                                                    </a>
                                                </div>
                                                @include('admin.rekruitmen.lulusModal')
                                                <div class="col-md-3">
                                                    <form action="update_pelamar{{ $k->id }}" method="POST"
                                                        onsubmit="return confirmTolak2()">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="hidden" name="status" value="Ditolak"
                                                            class="form-control" hidden>
                                                        <button type="submit"
                                                            class="fa fa-times btn-danger btn-sm"></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="tab-pane" id="6">


                            <table class="table table-bordered table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Email</th>
                                        <th>L / P</th>
                                        <th>Alamat</th>
                                        <th>Status</th>
                                        <th>Tanggal Diterima</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    @foreach ($dataDiterima as $k)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $k->nik }}</td>
                                            <td>{{ $k->nama }}</td>
                                            <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                            <td>{{ $k->email }}</td>
                                            <td>{{ $k->jenis_kelamin }}</td>
                                            <td>{{ $k->alamat }}</td>
                                            <td>{{ $k->mrekruitmen->nama_tahapan ?? '' }}</td>
                                            <td>{{ $k->tanggal_tahapan }}</td>

                                            <td>

                                                {{-- @if ($k->status_lamaran == 'Diterima') --}}

                                                <div class="col-md-3">
                                                    <a href="showkanidat{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div>
                                                
                                                {{-- <div class="col-md-3">
                                                    @csrf
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#myModal{{ $k->id }}">
                                                        <i class="fa fa-eye btn-info btn-sm "></i>
                                                    </a>
                                                </div> --}}
                                                {{-- @endif --}}
                                            </td>


                                            @include('admin.rekruitmen.showModal')

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
    {{-- </form> --}}


    <div class="modal-footer">
        <a href="/data_rekrutmen" type="button" class="btn btn-sm btn-danger"> Kembali <i class="fa fa-home"></i></a>
    </div>


    <style>
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-sm-3 {
            flex: 0 0 25%;
            max-width: 25%;
        }
    </style>

    <script>
        function confirmSave() {
            return confirm("Apakah Anda yakin akan melanjutkan kanidat ini ke tahap 2?");
        }

        function confirmSave2() {
            return confirm("Apakah Anda yakin akan melanjutkan kanidat ini ke tahap 3?");
        }

        function confirmSave3() {
            return confirm("Apakah Anda yakin akan menerima kanidat ini?");
        }

        function confirmTolak() {
            return confirm("Apakah Anda yakin akan menolak kanidat ini?");
        }

        function confirmTolak2() {
            return confirm("Apakah Anda yakin akan menolak kanidat ini?");
        }

        function confirmTolak3() {
            return confirm("Apakah Anda yakin akan menolak kanidat ini?");
        }
    </script>
@endsection
