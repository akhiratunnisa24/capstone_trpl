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

        <form action="#" method="POST">

            @csrf
            @method('put')

            <div class="modal-body">

                <table class="table table-bordered table-striped" style="width:100%">
                    <tbody class="col-sm-20">
                        <label class="">
                            <h4> {{ $lowongan->posisi }} </h4>
                        </label>

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

                <div class="col-sm-6 col-lg-3 nav nav-tabs navtab-bg">
                    <div class="panel panel-primary text-center active">
                        <div class="panel-heading btn-success">
                            <a href="#" class="panel-title ">
                                <h4 class="panel-title">Data Pelamar</h4>
                            </a>
                        </div>
                        <div class="panel-body">
                            <h3 class=""><b>Tahap 1</b></h3>
                            <p class="text-muted"><b>Total {{ $totalTahap1 }} Pelamar</b>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="panel panel-primary text-center">
                        <div class="panel-heading btn-success">
                            <a href="#" class="panel-title ">
                                <h4 class="panel-title">Data Pelamar</h4>
                            </a>
                        </div>
                        <div class="panel-body">
                            <h3 class=""><b>Tahap 2</b></h3>
                            <p class="text-muted"><b>Total {{ $totalTahap2 }} Pelamar</b>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3">
                    <div class="panel panel-primary text-center">
                        <div class="panel-heading btn-success">
                            <a href="#" class="panel-title ">
                                <h4 class="panel-title">Data Pelamar</h4>
                            </a>
                        </div>
                        <div class="panel-body">
                            <h3 class=""><b>Tahap 3</b></h3>
                            <p class="text-muted"><b>Total {{ $totalTahap3 }} Pelamar</b>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-12">
                    <div class="panel panel-primary text-center">
                        <ul class="nav nav-tabs navtab-bg">

                            <li class="active">
                                <a id="tahap1" href="#tahap1" data-toggle="tab" aria-expanded="false">
                                    <span class="visible-xs"><i class="fa fa-home"></i></span>
                                    <span class="hidden-xs">Tahap 1</span>
                                </a>
                            </li>
                            <li class="">
                                <a id="tahap2" href="#tahap2" data-toggle="tab" aria-expanded="true">
                                    <span class="visible-xs"><i class="fa fa-user"></i></span>
                                    <span class="hidden-xs">Tahap 2</span>
                                </a>
                            </li>
                            <li class="">
                                <a id="tahap3" href="#tahap3" data-toggle="tab" aria-expanded="true">
                                    <span class="visible-xs"><i class="fa fa-user"></i></span>
                                    <span class="hidden-xs">Tahap 3</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="tab-content">

                    <div class="tab-pane active" id="tahap1">


                        <table class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Email</th>
                                    <th>Nomor Handphone</th>
                                    <th>L / P</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($staff as $k)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $k->nik }}</td>
                                        <td>{{ $k->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                        <td>{{ $k->email }}</td>
                                        <td>{{ $k->no_hp }}</td>
                                        <td>{{ $k->jenis_kelamin }}</td>
                                        <td>{{ $k->alamat }}</td>
                                        <td>{{ $k->status_lamaran }}</td>
                                        <td>
                                            <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                <a href="#" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                <button onclick="#" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <!-- <button class="btn btn-default waves-effect waves-light" id="sa-success">Click me</button> -->
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="tab-pane" id="tahap2">


                        <table class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No Tahap2</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Email</th>
                                    <th>Nomor Handphone</th>
                                    <th>L / P</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($staff as $k)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $k->nik }}</td>
                                        <td>{{ $k->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                        <td>{{ $k->email }}</td>
                                        <td>{{ $k->no_hp }}</td>
                                        <td>{{ $k->jenis_kelamin }}</td>
                                        <td>{{ $k->alamat }}</td>
                                        <td>{{ $k->status_lamaran }}</td>
                                        <td>
                                            <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                <a href="#" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                <button onclick="#" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <!-- <button class="btn btn-default waves-effect waves-light" id="sa-success">Click me</button> -->
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                    <div class="tab-pane" id="tahap3">


                        <table class="table table-bordered table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No Tahap3</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Email</th>
                                    <th>Nomor Handphone</th>
                                    <th>L / P</th>
                                    <th>Alamat</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>


                            <tbody>
                                @foreach ($staff as $k)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $k->nik }}</td>
                                        <td>{{ $k->nama }}</td>
                                        <td>{{ \Carbon\Carbon::parse($k->tgllahir)->format('d/m/Y') }}</td>
                                        <td>{{ $k->email }}</td>
                                        <td>{{ $k->no_hp }}</td>
                                        <td>{{ $k->jenis_kelamin }}</td>
                                        <td>{{ $k->alamat }}</td>
                                        <td>{{ $k->status_lamaran }}</td>
                                        <td>
                                            <div class="d-grid gap-2 " role="group" aria-label="Basic example">
                                                <a href="#" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                                                <button onclick="#" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                            <!-- <button class="btn btn-default waves-effect waves-light" id="sa-success">Click me</button> -->
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
        </form>


        <div class="modal-footer">

            {{-- <a href="karyawanedit{{$karyawan->id}}" type="button" class="btn btn-sm btn-primary ">Edit Rekrutmen</a> --}}
            <a href="/data_rekrutmen" class="btn btn-sm btn-danger">Kembali</a>
        </div>

  <!-- jQuery  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/pages/datatables.init.js"></script>
    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/pages/form-advanced.js"></script>

        <script type="text/javascript">
            let tp = `{{$code}}`;

            if (tp == 1) {
                $('#tahap1').click();
            } elseif (tp == 2) {
                $('#tahap2').click();
            }else {
                $('#tahap3').click();
            }
        </script>

    @endsection
