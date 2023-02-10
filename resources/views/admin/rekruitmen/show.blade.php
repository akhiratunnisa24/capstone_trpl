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
        {{-- <div class="panel-heading  col-sm-15 m-b-10">
            <a  class="btn btn-lg btn-dark"> {{ $lowongan->posisi }}</a>
        </div> --}}
        <div class=" col-sm-0 m-b-0">

        </div>

        {{-- <form action="#" method="POST"> --}}

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

                    {{-- <label class="">
                        <h4> {{ $lowongan->posisi }} </h4>
                    </label> --}}

                    <tr>
                        <td><label>Jumlah dibutuhkan</label></td>
                        <td><label> {{ $lowongan->jumlah_dibutuhkan }}</label></td>
                    </tr>
                    <tr>
                        <td><label>Persyaratan</label></td>
                        <td><label> {{ $lowongan->persyaratan }}</label></td>
                    </tr>
                    <tr>

                </tbody>
            </table>



            {{-- <div class="col-sm-6 col-lg-3 nav nav-tabs navtab-bg">
                <div class="panel panel-primary text-center active">
                    <div class="panel-heading btn-success">
                        <a href="#tahap1" data-toggle="tab" class="panel-title ">
                            <h4 class="panel-title">Data Pelamar</h4>
                        </a>
                    </div>
                    <div class="panel-body">
                        <h3 class=""><b>Penyerahan CV</b></h3>
                        <p class="text-muted"><b>Total {{ $totalTahap1 }} Pelamar</b>
                        </p>
                    </div>
                </div>
            </div> --}}



            @foreach ($posisi as $k)
                <div class="col-sm-6 col-lg-3">
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


            {{-- <div class="col-sm-6 col-lg-3">
                <div class="panel panel-primary text-center">
                    <div class="panel-heading btn-success">
                        <a href="#tahap3" data-toggle="tab" class="panel-title ">
                            <h4 class="panel-title">Data Pelamar</h4>
                        </a>
                    </div>
                    <div class="panel-body">
                        <h3 class=""><b>Tahap 3</b></h3>
                        <p class="text-muted"><b>Total {{ $totalTahap3 }} Pelamar</b>
                        </p>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-sm-6 col-lg-3">
                <div class="panel panel-primary text-center">
                    <div class="panel-heading btn-success">
                        <a href="#tahap4" data-toggle="tab" class="panel-title ">
                            <h4 class="panel-title">Data Pelamar</h4>
                        </a>
                    </div>
                    <div class="panel-body">
                        <h3 class=""><b>Diterima</b></h3>
                        <p class="text-muted"><b>Total {{ $totalDiterima }} Pelamar</b>
                        </p>
                    </div>
                </div>
            </div> --}}

            <div class="row">

                <div class="col-sm-6 col-lg-12">
                    <div class="panel panel-primary text-center">
                        <ul class="nav nav-tabs navtab-bg nav-justified">

                            {{-- <li class="">
                                <a href="#tahap1" data-toggle="tab" aria-expanded="false">
                                    <span class="visible-xs"><i class="fa fa-home"></i></span>
                                    <span class="hidden-xs">Penyerahan CV</span>
                                </a>
                            </li> --}}

                            @foreach ($posisi as $k)
                                <li class="">
                                    <a href="#{{ $k->mrekruitmen->id }}" data-toggle="tab" aria-expanded="true">
                                        <span class="visible-xs"><i class="fa fa-user"></i></span>
                                        <span class="hidden-xs">{{ $k->mrekruitmen->nama_tahapan }}</span>
                                    </a>
                                </li>
                            @endforeach

                            {{-- <li class="">
                                <a href="#tahap3" data-toggle="tab" aria-expanded="true">
                                    <span class="visible-xs"><i class="fa fa-user"></i></span>
                                    <span class="hidden-xs">Tahap 3</span>
                                </a>
                            </li> --}}

                            {{-- <li class="">
                                <a href="#tahap4" data-toggle="tab" aria-expanded="true">
                                    <span class="visible-xs"><i class="fa fa-user"></i></span>
                                    <span class="hidden-xs">Diterima</span>
                                </a>
                            </li> --}}

                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="tab-pane active" id="1">

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
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($dataTahap1 as $k)
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
                                                @csrf
                                                <a href="#" data-toggle="modal"
                                                    data-target="#myModal{{ $k->id }}">
                                                    <i class="fa fa-eye btn-info btn-sm "></i>
                                                </a>
                                            </div>
                                            @include('admin.rekruitmen.showModal')

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
                                                    <button type="submit" class="fa fa-times btn-danger btn-sm"></button>
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
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($dataTahap1 as $k)
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
                                                @csrf
                                                <a href="#" data-toggle="modal"
                                                    data-target="#myModal{{ $k->id }}">
                                                    <i class="fa fa-eye btn-info btn-sm "></i>
                                                </a>
                                            </div>
                                            @include('admin.rekruitmen.showModal')

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
                                                    <button type="submit" class="fa fa-times btn-danger btn-sm"></button>
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

                    <div class="tab-pane" id="2">

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
                                    <th>Tanggal Psikotest</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($dataTahap2 as $k)
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

                                            {{-- @if ($k->status_lamaran == 'tahap 2') --}}
                                            <div class="col-md-3">
                                                @csrf
                                                <a href="#" data-toggle="modal"
                                                    data-target="#myModal{{ $k->id }}">
                                                    <i class="fa fa-eye btn-info btn-sm "></i>
                                                </a>
                                            </div>
                                            @include('admin.rekruitmen.showModal')

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
                                                    <button type="submit" class="fa fa-times btn-danger btn-sm"></button>
                                                </form>
                                            </div>
                                            {{-- @endif --}}
                                        </td>




                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>


                    <div class="tab-pane" id="3">
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
                                    <th>Tanggal Interview Ke-1</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($dataTahap3 as $k)
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

                                            {{-- @if ($k->status_lamaran == 'tahap 2') --}}
                                            <div class="col-md-3">
                                                @csrf
                                                <a href="#" data-toggle="modal"
                                                    data-target="#myModal{{ $k->id }}">
                                                    <i class="fa fa-eye btn-info btn-sm "></i>
                                                </a>
                                            </div>
                                            @include('admin.rekruitmen.showModal')

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
                                                    <button type="submit" class="fa fa-times btn-danger btn-sm"></button>
                                                </form>
                                            </div>
                                            {{-- @endif --}}
                                        </td>




                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane" id="4">
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
                                    <th>Tanggal Medical Check-Up</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($dataTahap4 as $k)
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

                                            {{-- @if ($k->status_lamaran == 'tahap 2') --}}
                                            <div class="col-md-3">
                                                @csrf
                                                <a href="#" data-toggle="modal"
                                                    data-target="#myModal{{ $k->id }}">
                                                    <i class="fa fa-eye btn-info btn-sm "></i>
                                                </a>
                                            </div>
                                            @include('admin.rekruitmen.showModal')

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
                                                    <button type="submit" class="fa fa-times btn-danger btn-sm"></button>
                                                </form>
                                            </div>
                                            {{-- @endif --}}
                                        </td>




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
                                    <th>Tanggal Interview ke-2</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($dataTahap5 as $k)
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

                                            {{-- @if ($k->status_lamaran == 'tahap 2') --}}
                                            <div class="col-md-3">
                                                @csrf
                                                <a href="#" data-toggle="modal"
                                                    data-target="#myModal{{ $k->id }}">
                                                    <i class="fa fa-eye btn-info btn-sm "></i>
                                                </a>
                                            </div>
                                            @include('admin.rekruitmen.showModal')

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
                                                    <button type="submit" class="fa fa-times btn-danger btn-sm"></button>
                                                </form>
                                            </div>
                                            {{-- @endif --}}
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
                                    <th>Action</th>
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
                                        <td>{{ $k->mrekruitmen->nama_tahapan }}</td>
                                        <td>{{ $k->tanggal_tahapan }}</td>

                                        <td>

                                            {{-- @if ($k->status_lamaran == 'Diterima') --}}
                                            <div class="col-md-3">
                                                @csrf
                                                <a href="#" data-toggle="modal"
                                                    data-target="#myModal{{ $k->id }}">
                                                    <i class="fa fa-eye btn-info btn-sm "></i>
                                                </a>
                                            </div>
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
    {{-- </form> --}}


    <div class="modal-footer">

        <a href="/data_rekrutmen" type="button" class="btn btn-sm btn-danger fa fa-mail-reply"> Kembali</a>


    </div>


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
