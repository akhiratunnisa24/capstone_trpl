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
            <div class="panel panel-secondary" id="datakeluarga">
                <div class="panel-heading"></div>
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20">
                                    <table id="datatable-responsive6" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Hubungan Keluarga</th>
                                                <th>Alamat</th>
                                                <th>Pekerjaan</th>
                                            </tr>
                                        </thead>
                                        @php
                                         $no = 1;
                                        @endphp
                                            
                                        @endphp
                                        <tbody>  
                                           
                                                {{-- @forelse($datakeluarga as $datakeluarga) --}}
                                                    <tr>
                                                        <td>{{$no++}}</td>
                                                        <td>{{ $datakeluarga->nama}}</td>
                                                        <td>{{ $datakeluarga->tgllahir}}</td>
                                                        <td>{{ $datakeluarga->hubungan}}</td>
                                                        <td>{{ $datakeluarga->alamat}}</td>
                                                        <td>{{ $datakeluarga->pekerjaan}}</td>
                                                    </tr>
                                                {{-- @empty 
                                                    <tr>
                                                        <td>No data available</td>
                                                    </tr> 
                                                @endforelse --}}
                                        
                                        
                                        </tbody>
                                    </table><br> 
                                <form action="/storedatakeluarga" method="POST" enctype="multipart/form-data">
                                    <div class="control-group after-add-more">
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <!-- FORM -->
                                                        <div class="col-md-2"></div>
                                                        <!-- SEBELAH KANAN -->
                                                        <div class="col-md-8">
                                                            <div class="modal-header bg-info panel-heading  col-sm-15 m-b-10 ">
                                                                <label class="text-white">Status Pernikahan *)</label>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Status Pernikahan</label>
                                                                <select class="form-control selectpicker" name="status_pernikahan">
                                                                    <option value="">Pilih Status Pernikahan</option>
                                                                    {{-- <option value="Sudah" {{ $datakeluarga->status_pernikahan == 'Sudah' ? 'selected' : '' }}>Sudah Menikah</option>
                                                                    <option value="Belum" {{ $datakeluarga->status_pernikahan == 'Belum' ? 'selected' : '' }}>Belum Menikah</option> --}}
                                                                    <option value="Sudah Menikah">Sudah Menikah</option>
                                                                    <option value="Belum Menikah">Belum Menikah</option>
                                                                    <option value="Duda">Duda</option>
                                                                    <option value="Janda">Janda</option>
                                                                </select>
                                                            </div>
                                                            <div class="modal-header bg-info panel-heading  col-sm-15 m-b-10 m-t-10">
                                                                <label class="text-white">B. DATA KELUARGA *) </label>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                                                    <input type="text" name="namaPasangan" class="form-control" autocomplete="off" placeholder="Masukkan Nama" required>
                                                            
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" placeholder="yyyy/mm/dd"
                                                                            id="datepicker-autoclose8" autocomplete="off" name="tgllahirPasangan" rows="10" required></input><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Hubungan</label>
                                                                    <select class="form-control selectpicker" name="hubungankeluarga" required>
                                                                        <option value="">Pilih Hubungan</option>
                                                                        <option value="Ayah">Ayah</option>
                                                                        <option value="Ibu">Ibu</option>
                                                                        <option value="Suami">Suami</option>
                                                                        <option value="Istri">Istri</option>
                                                                        <option value="Kakak">Kakak</option>
                                                                        <option value="Adik">Adik</option>
                                                                        <option value="Anak Pertama">Anak Pertama</option>
                                                                        <option value="Anak Ke-2">Anak Ke-2</option>
                                                                        <option value="Anak Ke-3">Anak Ke-3</option>
                                                                        <option value="Anak Ke-4">Anak Ke-4</option>
                                                                        <option value="Anak Ke-5">Anak Ke-5</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                                                    <input class="form-control" name="alamatPasangan" autocomplete="off" rows="9" placeholder="Masukkan Alamat"required></input>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Pendidikan Terakhir</label>
                                                                <select class="form-control selectpicker" name="pendidikan_terakhirPasangan"required>
                                                                    <option value="">Pilih Pendidikan Terakhir</option>
                                                                    <option value="SD">SD</option>
                                                                    <option value="SMP">SMP</option>
                                                                    <option value="SMA/K">SMA/K</option>
                                                                    <option value="D-3">D-3</option>
                                                                    <option value="S-1">S-1</option>
                                                                    <option value="S-2">S-2</option>
                                                                    <option value="S-3">S-3</option>
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Pekerjaan</label>
                                                                    <input type="text" name="pekerjaanPasangan" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Pekerjaan" required>
                                                                    <div id="emailHelp" class="form-text"></div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="pull-left">
                                                                    <a href="/karyawancreates" class="btn btn-sm btn-info"><i class="fa fa-backward"></i> Sebelumnya</a>
                                                                </div>
                                                                <div class="pull-right">
                                                                    <button type="submit" name="submit" class="btn btn-sm btn-dark">Simpan</button>
                                                                    <a href="{{route('create.konrat')}}" class="btn btn-sm btn-success">Selanjutnya <i class="fa fa-forward"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2"></div>
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