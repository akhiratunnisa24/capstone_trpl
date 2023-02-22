@extends('layouts.default')
@section('content')
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <style>
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type=number] {
                -moz-appearance: textfield;
            }
        </style>
    </head>
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title ">Tambah Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Tambah Karyawan</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-secondary" id="riwayatpendidikan">
                <div class="panel-heading"></div>
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20">
                                {{-- <table id="datatable-responsive8" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                <span class="badge badge-info"><strong>A. PENDIDIKAN FORMAL</strong></span>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tingkat Pendidikan</th>
                                            <th>Nama Sekolah</th>
                                            <th>Kota</th>
                                            <th>Jurusan</th>
                                            <th>Tahun Lulus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($pformal as $p)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$p->tingkat }}</td>
                                                <td>{{$p->nama_sekolah }}</td>
                                                <td>{{$p->kota_pformal }}</td>
                                                <td>{{$p->jurusan }}</td>
                                                <td>{{$p->tahun_lulus_formal }}</td>
                                            </tr>
                                        @endforeach --}}
                                    {{-- </tbody>
                                </table><br> --}}

                                {{-- <span class="badge badge-info"><strong>B. PENDIDIKAN NON FORMAL</strong></span>
                                <table id="datatable-responsive9" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bidang/Jenis</th>
                                            <th>Kota</th>
                                            <th>Tahun Lulus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($nonformal as $nf)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $nf->jenis_pendidikan }}</td>
                                                <td>{{ $nf->kota_pnonformal }}</td>
                                                <td>{{ $nf->tahun_lulus_nonformal }}</td>
                                            </tr>
                                        @endforeach --}}
                                    {{-- </tbody>
                                </table><br> --}} 
                                <form action="/storepformal" method="POST" enctype="multipart/form-data">
                                    <div class="control-group after-add-more">
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        {{-- KIRI --}}
                                                        <div class="col-md-12">
                                                            <div class="modal-header bg-primary panel-heading  col-sm-15 m-b-5">
                                                                <label class="text-white m-b-10">D. RIWAYAT PENDIDIKAN</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            {{-- <div class="modal-header panel-heading  col-sm-15 m-b-5 m-t-10"> --}}
                                                                <span class="badge badge-info col-sm-15 m-b-5 m-t-10"><label class="text-white"> 1. Pendidikan Formal</label></span>
                                                            {{-- </div> --}}
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Tingkat</label>
                                                                <select class="form-control selectpicker" name="tingkat_pendidikan">
                                                                    <option value="">Pilih Tingkat Pendidikan</option>
                                                                    <option value="SD" {{ $pendidikan->tingkat ?? '' == 'SD' ? 'selected' : '' }}>SD</option>
                                                                    <option value="SMP" {{ $pendidikan->tingkat ?? '' == 'SMP' ? 'selected' : '' }}>SMP</option>
                                                                    <option value="SMA/K" {{ $pendidikan->tingkat ?? '' == 'SMA/K' ? 'selected' : '' }}>SMA/K</option>
                                                                    <option value="Universitas" {{ $pendidikan->tingkat ?? '' == 'Universitas' ? 'selected' : '' }}>Universitas</option>

                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Nama Sekolah</label>
                                                                    <input type="text" value="{{ $pendidikan->nama_sekolah ?? '' }}" name="nama_sekolah" class="form-control" placeholder="Masukkan Sekolah" autocomplete="off">
                                                                    <div id="emailHelp" class="form-text">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label"> Kota</label>
                                                                    <input type="text" name="kotaPendidikanFormal"  class="form-control"
                                                                        id="exampleInputEmail1" value="{{ $pendidikan->kota_pformal ?? '' }}" aria-describedby="emailHelp" placeholder="Masukkan Kota">
                                                                    <div id="emailHelp" class="form-text">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label"> Jurusan</label>
                                                                    <input type="text" name="jurusan" value="{{ $pendidikan->jurusan ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                        placeholder="Masukkan Jurusan" autocomplete="off">
                                                                    <div id="emailHelp" class="form-text">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Tahun Lulus</label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose20" type="text"  class="form-control" placeholder="yyyy" id="4"
                                                                                name="tahun_lulusFormal" value="{{ $pendidikan->tahun_lulus_formal ?? '' }}" rows="10" autocomplete="off"></input><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- KANAN --}}
                                                        <div class="col-md-6">
                                                            {{-- <div class="modal-header  panel-heading  col-sm-15 m-b-5 m-t-10"> --}}
                                                                <span class="badge badge-info col-sm-15 m-b-5 m-t-10"><label class="text-white"> 2. Pendidikan Non Formal</label></span>
                                                            {{-- </div> --}}
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Bidang / Jenis</label>
                                                                    <input type="text" value="{{ $pendidikan->jenis_pendidikan ?? '' }}" name="jenis_pendidikan" class="form-control" placeholder="Masukkan Nama" autocomplete="off"> 
                                                                    <div id="emailHelp" class="form-text">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label"> Kota</label>
                                                                    <input type="text" value="{{ $pendidikan->kota_pnonformal ?? '' }}" name="kotaPendidikanNonFormal"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"   placeholder="Masukkan Kota" autocomplete="off">
                                                                    <div id="emailHelp" class="form-text">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Lulus Tahun</label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose21" type="text" class="form-control" placeholder="yyyy" id="4"
                                                                                name="tahunLulusNonFormal" value="{{ $pendidikan->tahun_lulus_nonformal ?? '' }}" autocomplete="off" rows="10" ><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div></div><br><br><br><br><br><br><br><br>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="pull-left">
                                                            <a href="/create-kontak-darurat" class="btn btn-sm btn-info"><i class="fa fa-backward"></i> Sebelumnya</a>
                                                        </div>
                                                        <div class="pull-right">
                                                            <button type="submit" name="submit" class="btn btn-sm btn-success">Selanjutnya <i class="fa fa-forward"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </table>
                                        </div>
                                    </div>
                                </form>                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     {{-- <script src="assets/js/jquery.min.js"></script> --}}
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     <script src="assets/pages/form-advanced.js"></script>


@endsection