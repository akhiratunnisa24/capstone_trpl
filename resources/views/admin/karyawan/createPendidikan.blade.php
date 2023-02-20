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
    <div class="tab-pane" id="riwayatpendidikan">
        <div class="content">
            <div class="container">
                <div class="row">
                    <div class="col-md-20 col-sm-20 col-xs-20">
                        <table id="datatable-responsive8" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
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
                                @foreach($pformal as $p)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$p->tingkat }}</td>
                                        <td>{{$p->nama_sekolah }}</td>
                                        <td>{{$p->kota_pformal }}</td>
                                        <td>{{$p->jurusan }}</td>
                                        <td>{{$p->tahun_lulus_formal }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table><br>

                        <span class="badge badge-info"><strong>B. PENDIDIKAN NON FORMAL</strong></span>
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
                            </tbody>
                        </table><br>
                        <form action="/storepformal" method="POST" enctype="multipart/form-data">
                            <div class="control-group after-add-more">
                                @csrf
                                @method('post')
                                <div class="modal-body">
                                    <table class="table table-bordered table-striped">
                                        <div class="col-md-12">
                                            <div class="row">
                                                {{-- KIRI --}}
                                                <div class="col-md-6">
                                                    <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5 ">
                                                        <label class="text-white">Pendidikan Formal</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="form-label">Tingkat</label>
                                                        <select class="form-control selectpicker" name="tingkat_pendidikan">
                                                            <option value="">Pilih TingkatPendidikan</option>
                                                            <option value="SD">SD</option>
                                                            <option value="SMP">SMP</option>
                                                            <option value="SMA/K">SMA/K</option>
                                                            <option value="Universitas">Universitas</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">Nama Sekolah</label>
                                                            <input type="text" name="nama_sekolah" class="form-control" placeholder="Masukkan Sekolah" autocomplete="off">
                                                            <div id="emailHelp" class="form-text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label"> Kota</label>
                                                            <input type="text" name="kotaPendidikanFormal"  class="form-control"
                                                                id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Kota">
                                                            <div id="emailHelp" class="form-text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label"> Jurusan</label>
                                                            <input type="text" name="jurusan" no_kk class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                placeholder="Masukkan Jurusan" autocomplete="off">
                                                            <div id="emailHelp" class="form-text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">Lulus Tahun</label>
                                                            <div class="input-group">
                                                                <input id="datepicker-autoclose20" type="text"  class="form-control" placeholder="yyyy" id="4"
                                                                        name="tahun_lulusFormal" rows="10" autocomplete="off"></input><br>
                                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="pull-right">
                                                        <button type="submit" name="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                       
                                                    </div> --}}
                                                </div>

                                                {{-- KANAN --}}
                                                <div class="col-md-6">
                                                    <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                        <label class="text-white">Pendidikan NonFormal</label>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">Bidang / Jenis</label>
                                                            <input type="text" name="jenis_pendidikan" class="form-control" placeholder="Masukkan Nama" autocomplete="off"> 
                                                            <div id="emailHelp" class="form-text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label"> Kota</label>
                                                            <input type="text" name="kotaPendidikanNonFormal"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"   placeholder="Masukkan Kota" autocomplete="off">
                                                            <div id="emailHelp" class="form-text">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">Lulus Tahun</label>
                                                            <div class="input-group">
                                                                <input id="datepicker-autoclose21" type="text" class="form-control" placeholder="yyyy" id="4"
                                                                        name="tahunLulusNonFormal" autocomplete="off" rows="10" ><br>
                                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div></div><br><br><br><br><br><br><br><br>
                                                    <div class="pull-right">
                                                        <button type="submit" name="submit" class="btn btn-sm btn-primary">Simpan</button>
                                                        <a href="#riwayatpekerjaan" data-toggle="tab" class="btn btn-sm btn-danger">Selanjutnya</a>
                                                    </div>
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
     {{-- <script src="assets/js/jquery.min.js"></script> --}}
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
     <script src="assets/pages/form-advanced.js"></script>


@endsection