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

            .form-group{
                margin-left:10px;
                margin-right:10px;
            }

            .badge a{
                margin-left:10px;
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
                            <div class="col-md-20 col-sm-20 col-xs-20" style="margin-left:15px;margin-right:15px;">
                                <table id="datatable-responsive8" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                    <span class=""><strong>A. PENDIDIKAN FORMAL</strong></span>
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tingkat Pendidikan</th>
                                            <th>Nama Sekolah</th>
                                            <th>Alamat</th>
                                            <th>Jurusan</th>
                                            <th>Tahun Lulus</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendidikan as $key => $p)
                                            @if($p['tingkat'] != null)
                                                <tr>
                                                    <td id="key">{{ $key }}</td>
                                                    <td>{{$p['tingkat'] }}</td>
                                                    <td>{{$p['nama_sekolah'] }}</td>
                                                    <td>{{$p['kota_pformal'] }}</td>
                                                    <td>{{$p['jurusan'] }}</td>
                                                    <td>{{$p['tahun_lulus_formal'] }}</td>
                                                    <td class="text-center">
                                                        <div class="row d-grid gap-2" role="group" aria-label="Basic example">
                                                            <a href="#formUpdatePendidikan" class="btn btn-sm btn-info" id="editPendidikan" data-key="{{ $key }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            {{-- /delete-pendidikan/{{$key}} --}}
                                                            <form class="pull-right" action="" method="POST" style="margin-right:5px;">
                                                                <button type="submit" class="btn btn-danger btn-sm delete_dakel" data-key="{{ $key }}"><i class="fa fa-trash"></i></button>
                                                            </form> 
                                                            {{-- <button type="button" id="hapus_dakel" data-key="{{ $key }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table><br>

                                <span class=""><strong>B. PENDIDIKAN NON FORMAL</strong></span>
                                <table id="datatable-responsive9" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bidang/Jenis</th>
                                            <th>Alamat</th>
                                            <th>Tahun Lulus</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendidikan as $key => $nf)
                                            @if($nf['jenis_pendidikan'] != null)
                                                <tr>
                                                    <td id="key">{{ $key }}</td>
                                                    <td>{{ $nf['jenis_pendidikan'] }}</td>
                                                    <td>{{ $nf['kota_pnonformal'] }}</td>
                                                    <td>{{ $nf['tahun_lulus_nonformal'] }}</td>
                                                    <td class="text-center">
                                                        <div class="row d-grid gap-2" role="group" aria-label="Basic example">
                                                            <a href="#formUpdatePendidikan" class="btn btn-sm btn-info" id="edittPendidikan" data-key="{{ $key }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            {{-- /delete-pendidikan/{{$key}} --}}
                                                            <form class="pull-right" action="" method="POST" style="margin-right:5px;">
                                                                <button type="submit" class="btn btn-danger btn-sm delete_dakel" data-key="{{ $key }}"><i class="fa fa-trash"></i></button>
                                                            </form> 
                                                            {{-- <button type="button" id="hapus_dakel" data-key="{{ $key }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table><br> 
                                <form action="/storepformal" method="POST" id="formCreatePendidikan" enctype="multipart/form-data">
                                    {{-- <div class="control-group after-add-more"> --}}
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
                                                                <span class="form-group badge badge-secondary col-sm-15 m-b-5 m-t-10"><label class="text-white"> 1. Pendidikan Formal</label></span>
                                                            {{-- </div> --}}
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Tingkat</label>
                                                                <select class="form-control selectpicker" name="tingkat_pendidikan">
                                                                    <option value="">Pilih Tingkat Pendidikan</option>
                                                                    <option value="SD">SD</option>
                                                                    <option value="SMP">SMP</option>
                                                                    <option value="SMA/K">SMA/K</option>
                                                                    <option value="Perguruan Tinggi">Perguruan Tinggi</option>

                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Nama Sekolah</label>
                                                                    <input type="text" name="nama_sekolah" class="form-control" placeholder="Masukkan Sekolah" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Alamat</label>
                                                                    <input type="text" name="kotaPendidikanFormal"  class="form-control" id="exampleInputEmail1" placeholder="Masukkan Alamat">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Jurusan</label>
                                                                    <input type="text" name="jurusan" class="form-control" id="exampleInputEmail1" placeholder="Masukkan Jurusan" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tahun Lulus</label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose20" type="text"  class="form-control" placeholder="yyyy" id="4"
                                                                                name="tahun_lulusFormal" rows="10" autocomplete="off"></input><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Ijazah</label>
                                                                    <input type="number" name="noijazahPformal"  class="form-control" aria-describedby="emailHelp"   placeholder="Masukkan No. Ijazah" autocomplete="off">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        {{-- KANAN --}}
                                                        <div class="col-md-6">
                                                            {{-- <div class="modal-header  panel-heading  col-sm-15 m-b-5 m-t-10"> --}}
                                                                <span class="form-group badge badge-secondary col-sm-15 m-b-5 m-t-10"><label class="text-white"> 2. Pendidikan Non Formal</label></span>
                                                            {{-- </div> --}}
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Bidang / Jenis</label>
                                                                    <input type="text" name="jenis_pendidikan" class="form-control" placeholder="Masukkan Jenis Pendidikan" autocomplete="off"> 
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lembaga Pendidikan</label>
                                                                    <input type="text" name="namaLembaga" class="form-control" placeholder="Masukkan Nama Lembaga" autocomplete="off"> 
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Alamat</label>
                                                                    <input type="text" name="kotaPendidikanNonFormal"  class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"   placeholder="Masukkan Alamat" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lulus Tahun</label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose21" type="text" class="form-control" placeholder="yyyy" id="4"
                                                                                name="tahunLulusNonFormal" autocomplete="off" rows="10" ><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Ijazah</label>
                                                                    <input type="number" name="noijazahPnonformal"  class="form-control" id="kotaPendidikanNonFormal" aria-describedby="emailHelp"   placeholder="Masukkan No. Ijazah" autocomplete="off">
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
                                                            <button type="submit" name="submit" class="btn btn-sm btn-dark">Simpan</button>
                                                            <a href="{{route('create.pekerjaan')}}" class="btn btn-sm btn-success">Selanjutnya <i class="fa fa-forward"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </table>
                                        </div>
                                    {{-- </div> --}}
                                </form>  
                                
                                <form action="/updatependidikan" method="POST" id="formUpdatePendidikan"  enctype="multipart/form-data">
                                    {{-- <div class="control-group after-add-more"> --}}
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
                                                        <input type="hidden" name="nomor_index" id="nomor_index_update" value="">
                                                        <div class="col-md-6">
                                                            {{-- <div class="modal-header panel-heading  col-sm-15 m-b-5 m-t-10"> --}}
                                                                <span class="form-group badge badge-secondary col-sm-15 m-b-5 m-t-10"><label class=""> 1. Pendidikan Formal</label></span>
                                                            {{-- </div> --}}
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1" class="form-label">Tingkat</label>
                                                                <select class="form-control selectpicker" id="tingkat_pendidikan" name="tingkat_pendidikan">
                                                                    <option value="">Pilih Tingkat Pendidikan</option>
                                                                    <option value="SD">SD</option>
                                                                    <option value="SMP">SMP</option>
                                                                    <option value="SMA/K">SMA/K</option>
                                                                    <option value="Perguruan Tinggi">Perguruan Tinggi</option>

                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Nama Sekolah</label>
                                                                    <input type="text" name="nama_sekolah" id="nama_sekolah" class="form-control" placeholder="Masukkan Sekolah" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Alamat</label>
                                                                    <input type="text" name="kotaPendidikanFormal" id="kotaPendidikanFormal"  class="form-control" id="exampleInputEmail1" placeholder="Masukkan Alamat">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label"> Jurusan</label>
                                                                    <input type="text" name="jurusan" id="jurusan" class="form-control"  placeholder="Masukkan Jurusan" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tahun Lulus</label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose31" type="text"  class="form-control" placeholder="yyyy" id="4"
                                                                                name="tahun_lulusFormal" rows="10" autocomplete="off"></input><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Ijazah</label>
                                                                    <input type="numberv" name="noijazahPformal"  class="form-control" aria-describedby="emailHelp"   placeholder="Masukkan No. Ijazah" autocomplete="off">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        {{-- KANAN --}}
                                                        <div class="col-md-6">
                                                            {{-- <div class="modal-header  panel-heading  col-sm-15 m-b-5 m-t-10"> --}}
                                                                <span class="form-group badge badge-secondary col-sm-15 m-b-5 m-t-10"><label class=""> 2. Pendidikan Non Formal</label></span>
                                                            {{-- </div> --}}
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Bidang / Jenis</label>
                                                                    <input type="text" name="jenis_pendidikan" id="jenis_pendidikan" class="form-control" placeholder="Masukkan Jenis Pendidikan" autocomplete="off"> 
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lembaga Pendidikan</label>
                                                                    <input type="text" name="namaLembaga" class="form-control" placeholder="Masukkan Nama Lembaga" autocomplete="off"> 
                                                                </div>
                                                            </div>  

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alamat</label>
                                                                    <input type="text" name="kotaPendidikanNonFormal"  class="form-control" id="kotaPendidikanNonFormal" aria-describedby="emailHelp"   placeholder="Masukkan Alamat" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lulus Tahun</label>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose32" type="text" class="form-control" placeholder="yyyy" id="4"
                                                                                name="tahunLulusNonFormal" autocomplete="off" rows="10" ><br>
                                                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">No. Ijazah</label>
                                                                    <input type="number" name="noijazahPnonformal"  class="form-control" id="kotaPendidikanNonFormal" aria-describedby="emailHelp"   placeholder="Masukkan No. Ijazah" autocomplete="off">
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
                                                            <button type="submit" name="submit" class="btn btn-sm btn-dark">Update</button>
                                                            <a href="{{route('create.pekerjaan')}}" class="btn btn-sm btn-success">Selanjutnya <i class="fa fa-forward"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </table>
                                        </div>
                                    {{-- </div> --}}
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#formCreatePendidikan').prop('hidden', false);
            $('#formUpdatePendidikan').prop('hidden',true);
            $(document).on('click', '#editPendidikan', function() {
                // Menampilkan form update data dan menyembunyikan form create data
                $('#formCreatePendidikan').prop('hidden', true);
                $('#formUpdatePendidikan').prop('hidden', false);

                // Ambil nomor index data yang akan diubah
                var nomorIndex = $(this).data('key');

                // Isi nomor index ke input hidden pada form update data
                $('#nomor_index_update').val(nomorIndex);

                // Ambil data dari objek yang sesuai dengan nomor index
                var data = {!! json_encode($pendidikan) !!}[nomorIndex];
                // Isi data ke dalam form
                    $('#tingkat_pendidikan').val(data.tingkat);
                    $('#nama_sekolah').val(data.nama_sekolah);
                    $('#jurusan').val(data.jurusan);
                    $('#kotaPendidikanFormal').val(data.kota_pformal);
                    $('#datepicker-autoclose31').val(data.tahun_lulus_formal);
                    $('#jenis_pendidikan').val(data.jenis_pendidikan);
                    $('#kotaPendidikanNonFormal').val(data.kota_pnonformal);
                    $('#datepicker-autoclose32').val(data.tahun_lulus_nonformal);
        
                    // Set opsi yang dipilih pada dropdown select option
                    var select = document.getElementById("tingkat_pendidikan");
                    for (var i = 0; i < select.options.length; i++) {
                        if (select.options[i].value == data.tingkat) {
                            select.options[i].selected = true;
                            break;
                        }
                    }
            });

            $(document).on('click', '#edittPendidikan', function() {
                // Menampilkan form update data dan menyembunyikan form create data
                $('#formCreatePendidikan').prop('hidden', true);
                $('#formUpdatePendidikan').prop('hidden', false);

                // Ambil nomor index data yang akan diubah
                var nomorIndex = $(this).data('key');

                // Isi nomor index ke input hidden pada form update data
                $('#nomor_index_update').val(nomorIndex);

                // Ambil data dari objek yang sesuai dengan nomor index
                var data = {!! json_encode($pendidikan) !!}[nomorIndex];
                // Isi data ke dalam form
                    $('#tingkat_pendidikan').val(data.tingkat);
                    $('#nama_sekolah').val(data.nama_sekolah);
                    $('#jurusan').val(data.jurusan);
                    $('#kotaPendidikanFormal').val(data.kota_pformal);
                    $('#datepicker-autoclose31').val(data.tahun_lulus_formal);
                    $('#jenis_pendidikan').val(data.jenis_pendidikan);
                    $('#kotaPendidikanNonFormal').val(data.kota_pnonformal);
                    $('#datepicker-autoclose32').val(data.tahun_lulus_nonformal);
        
                    // Set opsi yang dipilih pada dropdown select option
                    var select = document.getElementById("tingkat_pendidikan");
                    for (var i = 0; i < select.options.length; i++) {
                        if (select.options[i].value == data.tingkat) {
                            select.options[i].selected = true;
                            break;
                        }
                    }
            });
        });
    </script>

@endsection