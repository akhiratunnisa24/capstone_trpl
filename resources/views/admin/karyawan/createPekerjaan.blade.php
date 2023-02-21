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
            <div class="panel panel-secondary" id="riwayatpekerjaan">
                <div class="panel-heading"></div>
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20">
                                <table id="datatable-responsive10" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Jabatan</th>
                                            <th>Lama Kerja</th>
                                            <th>Gaji</th>
                                            <th>Atasan Langsung</th>
                                            <th>Direktur</th>
            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- @foreach($pekerjaan as $pek)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $pek->nama_perusahaan }}</td>
                                                <td>{{ $pek->jabatan }}</td>
                                                <td>{{ $pek->lama_kerja }}</td>
                                                <td>{{ $pek->gaji }}</td>
                                                <td>{{ $pek->nama_atasan }}</td>
                                                <td>{{ $pek->nama_direktur }}</td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table><br>
                                <form action="/storepekerjaan" method="POST" enctype="multipart/form-data">
                                    <div class="control-group after-add-more">
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div>
                                                            <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                <label class="text-white m-b-10">E. Riwayat Pekerjaan</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 m-t-10">
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Nama  Perusahaan</label>
                                                                    <input type="text" name="namaPerusahaan"  value="{{ $pekerjaan->nama_perusahaan ?? '' }}" class="form-control"  placeholder="Masukkan Nama Perusahaan" autocomplete="off">
                                                                </div>
                                                            </div>
    
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">  Alamat </label>
                                                                    <input type="text"  name="alamatPerusahaan" value="{{ $pekerjaan->alamat ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                                                        placeholder="Masukkan Alamat"autocomplete="off">
                                                                </div>
                                                            </div>
    
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Jenis Usaha</label>
                                                                    <input type="text" name="jenisUsaha" value="{{ $pekerjaan->jenis_usaha ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Jenis Usaha" autocomplete="off">
                                                                </div>
                                                            </div>
    
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label"> Jabatan</label>
                                                                    <input type="text" name="jabatanRpkerejaan" value="{{ $pekerjaan->jabatan ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Jabatan" autocomplete="off">
                                                                </div>
                                                            </div>
    
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label"> Nama Atasan Langsung</label>
                                                                    <input type="text" name="namaAtasan" value="{{ $pekerjaan->nama_atasan ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Nama Atasan" autocomplete="off">
                                                                
                                                                </div>
                                                            </div>
                                                        </div>
    
                                                        {{-- KANAN --}}
                                                        <div class="col-md-6 m-t-10">
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">  Nama Direktur</label>
                                                                    <input type="text" name="namaDirektur" value="{{ $pekerjaan->nama_direktur ?? '' }}" class="form-control" id="exampleInputEmail1"
                                                                        aria-describedby="emailHelp" placeholder="Masukkan Nama Direktur" autocomplete="off">
                                                                </div>
                                                            </div>
    
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Lama Kerja</label>
                                                                    <input  type="text" name="lamaKerja" value="{{ $pekerjaan->lama_kerja ?? '' }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Lama Kerja" autocomplete="off">
                                                                </div>
                                                            </div>
    
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Alasan Berhenti</label>
                                                                    <input type="text"  name="alasanBerhenti" value="{{ $pekerjaan->alasan_berhenti ?? '' }}" class="form-control" id="exampleInputEmail1"  aria-describedby="emailHelp" placeholder="Masukkan Alasan Berhenti" autocomplete="off">
                                                                    
                                                                </div>
                                                            </div>
    
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Gaji</label>
                                                                    <input type="text" name="gajiRpekerjaan" value="{{ $pekerjaan->gaji ?? '' }}" class="form-control" id="gaji" aria-describedby="emailHelp" placeholder="Masukkan Gaji" autocomplete="off">
                                                                </div>
                                                            </div>
    
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="pull-left">
                                                        <a href="/create-data-pendidikan" class="btn btn-sm btn-info"><i class="fa fa-backward"></i> Sebelumnya</a>
                                                    </div>
                                                    <div class="pull-right">
                                                        <a href="/karyawan" type="submit" name="submit" class="btn btn-sm btn-success"><strong><i class="fa fa-paper-plane"></i></strong>  Simpan Data</a>
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

    <script>
        var rupiah = document.getElementById('gaji');
        rupiah.addEventListener('keyup', function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah.value = formatRupiah(this.value);
        });
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }
    </script>

@endsection