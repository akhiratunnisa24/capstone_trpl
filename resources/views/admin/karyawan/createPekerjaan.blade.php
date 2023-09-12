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
                margin-right:10px
            }
        </style>
    </head>
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title ">Tambah Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employee Management System</li>
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
                            <div class="col-md-20 col-sm-20 col-xs-20" style="margin-left:15px;margin-right:15px;">
                                <table id="datatable-responsive10" class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Perusahaan</th>
                                            <th>Alamat</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Jabatan</th>
                                            <th>Level</th>
                                            <th>Gaji</th>
                                            {{-- <th>Alasan Berhenti</th> --}}
                                            <th>Aksi</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pekerjaan as $key => $pek)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $pek['nama_perusahaan'] }}</td>
                                                <td>{{ $pek['alamat'] }}</td>
                                                <td>{{ $pek['tgl_mulai'] }}</td>
                                                <td>{{ $pek['tgl_selesai'] }}</td>
                                                {{-- <td>{{ $pek['tgl_mulai'] }}</td>
                                                <td>{{ $pek['tgl_selesai'] }}</td> --}}
                                                <td>{{ $pek['jabatan'] }}</td>
                                                <td>{{ $pek['level'] }}</td>
                                                <td>{{ $pek['gaji'] }}</td>
                                                {{-- <td>{{ $pek['alasan_berhenti'] }}</td> --}}
                                                <td class="text-center">
                                                    <div class="row d-grid gap-2" role="group" aria-label="Basic example">
                                                        <a href="#formUpdatePekerjaan" class="btn btn-sm btn-info" id="editPekerjaan" data-key="{{ $key }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form class="pull-right" action="{{ route('deletepekerjaan') }}" method="POST" style="margin-right: 5px;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="key" value="{{$key}}">
                                                            <button type="submit" class="btn btn-danger btn-sm delete_pekerjaan" data-key="{{$key}}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                        {{-- /delete-pekerjaan/{{$key}} --}}
                                                        {{-- <form class="pull-right" action="" method="POST" style="margin-right:5px;">
                                                            <button type="submit" class="btn btn-danger btn-sm delete_dakel" data-key="{{ $key }}"><i class="fa fa-trash"></i></button>
                                                        </form>  --}}
                                                        {{-- <button type="button" id="hapus_dakel" data-key="{{ $key }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table><br>
                                <form action="/storepekerjaan" id="formCreatePekerjaan"  method="POST" enctype="multipart/form-data">
                                    <div class="control-group after-add-more">
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div>
                                                            <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                <label class="text-white m-b-10">E. RIWAYAT PENGALAMAN BEKERJA</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 m-t-10">
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nama  Perusahaan</label>
                                                                    <input type="text" name="namaPerusahaan" class="form-control"  placeholder="Masukkan Nama Perusahaan" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alamat </label>
                                                                    <input type="text"  name="alamatPerusahaan" class="form-control" id="alamat" placeholder="Masukkan Alamat" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lama Kerja</label>
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose-format-y" type="text" class="form-control" placeholder="mm/yyyy"
                                                                                name="tglmulai" autocomplete="off"  rows="10">
                                                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                                                            <input id="datepicker-autoclose-format-z" type="text" class="form-control" placeholder="mm/yyyy"
                                                                                name="tglselesai" autocomplete="off"  rows="10">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Jabatan Terakhir</label>
                                                                    <input type="text" name="jabatanRpekerjaan" class="form-control" placeholder="Masukkan Jabatan" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Jenis Usaha</label>
                                                                    <input type="text" name="jenisUsaha" class="form-control" placeholder="Masukkan Jenis Usaha" autocomplete="off">
                                                                </div>
                                                            </div> --}}

                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label"> Nama Atasan Langsung</label>
                                                                    <input type="text" name="namaAtasan" class="form-control"  placeholder="Masukkan Nama Atasan" autocomplete="off">

                                                                </div>
                                                            </div> --}}

                                                        </div>

                                                        {{-- KANAN --}}
                                                        <div class="col-md-6 m-t-10">

                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">  Nama Direktur</label>
                                                                    <input type="text" name="namaDirektur"  class="form-control"
                                                                       placeholder="Masukkan Nama Direktur" autocomplete="off">
                                                                </div>
                                                            </div> --}}

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Level / Pangkat / Golongan</label>
                                                                    <input type="text" name="levelRpekerjaan" class="form-control" placeholder="Masukkan Level" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Gaji</label>
                                                                    <input type="text" name="gajiRpekerjaan" class="form-control" id="gaji" placeholder="Masukkan Gaji" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Alasan Berhenti</label>
                                                                    <input type="text"  name="alasanBerhenti" class="form-control" placeholder="Masukkan Alasan Berhenti" autocomplete="off">

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
                                                        <button type="submit" name="submit" class="btn btn-sm btn-dark"> Simpan</button>
                                                         <a href="/create-data-organisasi" class="btn btn-sm btn-success">Selanjutnya <i class="fa fa-forward"></i></a>
                                                        {{-- <a href="/preview-data-karyawan" class="btn btn-sm btn-primary">Lihat Data <i class="fa fa-forward"></i></a> --}}
                                                    </div>
                                                </div>
                                            </table>
                                        </div>
                                    </div>
                                </form>

                                <form action="/updatepekerjaan" id="formUpdatePekerjaan"  method="POST" enctype="multipart/form-data">
                                    {{-- <div class="control-group after-add-more"> --}}
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">
                                            {{-- <table class="table table-bordered table-striped"> --}}
                                                <input type="hidden" name="nomor_index" id="nomor_index_update" value="">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div>
                                                            <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                <label class="text-white m-b-10">E. RIWAYAT PENGALAMAN BEKERJA</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 m-t-10">
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nama  Perusahaan</label>
                                                                    <input type="text" id="namaPerusahaan" name="namaPerusahaan" class="form-control"  placeholder="Masukkan Nama Perusahaan" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alamat </label>
                                                                    <input type="text" id="alamatPerusahaan"  name="alamatPerusahaan" class="form-control" id="alamat" placeholder="Masukkan Alamat">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lama Kerja</label>
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose-format-aa" type="text" class="form-control" placeholder="mm/yyyy"
                                                                            name="tglmulai"  autocomplete="off"  rows="10">
                                                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                                                            <input id="datepicker-autoclose-format-ab" type="text" class="form-control" placeholder="mm/yyyy"
                                                                                name="tglselesai" autocomplete="off"  rows="10">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label"> Jabatan</label>
                                                                    <input type="text" id="jabatanRpekerjaan" name="jabatanRpekerjaan" class="form-control" placeholder="Masukkan Jabatan" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Jenis Usaha</label>
                                                                    <input type="text" id="JenissUsaha"  name="jenisUsaha" class="form-control" placeholder="Masukkan Jenis Usaha" autocomplete="off">
                                                                </div>
                                                            </div> --}}



                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label"> Nama Atasan Langsung</label>
                                                                    <input type="text" id="namaAtasan" name="namaAtasan" class="form-control"  placeholder="Masukkan Nama Atasan" autocomplete="off">

                                                                </div>
                                                            </div> --}}
                                                        </div>

                                                        {{-- KANAN --}}
                                                        <div class="col-md-6 m-t-10">
                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">  Nama Direktur</label>
                                                                    <input type="text" id="namaDirektur" name="namaDirektur"  class="form-control" placeholder="Masukkan Nama Direktur" autocomplete="off">
                                                                </div>
                                                            </div> --}}
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Level / Pangkat / Golongan</label>
                                                                    <input type="text" name="levelRpekerjaan" class="form-control" id="levelpekerjaan" placeholder="Masukkan Level" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Gaji</label>
                                                                    <input type="text" name="gajiRpekerjaan" class="form-control" id="gajih" placeholder="Masukkan Gaji" autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1" class="form-label">Alasan Berhenti</label>
                                                                    <input type="text" id="alasanBerhenti"  name="alasanBerhenti" class="form-control" placeholder="Masukkan Alasan Berhenti" autocomplete="off">

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
                                                        <button type="submit" name="submit" class="btn btn-sm btn-dark"> Update Data</button>
                                                         <a href="/create-data-organisasi" class="btn btn-sm btn-success">Selanjutnya <i class="fa fa-forward"></i></a>
                                                        {{-- <a href="/preview-data-karyawan" class="btn btn-sm btn-primary">Lihat Data <i class="fa fa-forward"></i></a> --}}
                                                    </div>
                                                </div>
                                            {{-- </table> --}}
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
   <script>
        window.onload = function() {
            var rupiah = document.getElementById('gajih');
            rupiah.addEventListener('keyup', function(e) {
                // tambahkan 'Rp.' pada saat form di ketik
                // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                rupiah.value = formatRupiah(this.value);
            });
        };

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
            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix === undefined ? rupiah : (rupiah ? '' + rupiah : '');
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#formCreatePekerjaan').prop('hidden', false);
            $('#formUpdatePekerjaan').prop('hidden',true);
            $(document).on('click', '#editPekerjaan', function() {
                // Menampilkan form update data dan menyembunyikan form create data
                $('#formCreatePekerjaan').prop('hidden', true);
                $('#formUpdatePekerjaan').prop('hidden', false);

                // Ambil nomor index data yang akan diubah
                var nomorIndex = $(this).data('key');

                // Isi nomor index ke input hidden pada form update data
                $('#nomor_index_update').val(nomorIndex);

                // Ambil data dari objek yang sesuai dengan nomor index
                var data = {!! json_encode($pekerjaan) !!}[nomorIndex];
                console.log(data.gaji, data.tgl_mulai,data.tgl_selesai);
                // Isi data ke dalam form
                    $('#namaPerusahaan').val(data.nama_perusahaan);
                    $('#alamatPerusahaan').val(data.alamat);
                    // $('#JenissUsaha').val(data.jenis_usaha);
                    $('#jabatanRpekerjaan').val(data.jabatan);
                    // $('#namaAtasan').val(data.nama_atasan);
                    // $('#namaDirektur').val(data.nama_direktur);
                    $('#lamaKerja').val(data.lama_kerja);
                    $('#alasanBerhenti').val(data.alasan_berhenti);
                    $('#gajih').val(data.gaji);
                    $('#levelpekerjaan').val(data.level);

                    // var tanggal = new Date(data.tgl_mulai);
                    // var tanggalFormatted = ("0" + tanggal.getDate()).slice(-2) + '/' + ("0" + (tanggal.getMonth() + 1)).slice(-2) + '/' + tanggal.getFullYear();
                    // $('#tgl_mulai').val(tanggalFormatted);

                    // var tanggal = new Date(data.tgl_selesai);
                    // var tanggalFormatted = ("0" + tanggal.getDate()).slice(-2) + '/' + ("0" + (tanggal.getMonth() + 1)).slice(-2) + '/' + tanggal.getFullYear();
                    // $('#tgl_selesai').val(tanggalFormatted);

                    $('#datepicker-autoclose-format-aa').val(data.tgl_mulai);
                    $('#datepicker-autoclose-format-ab').val(data.tgl_selesai);

            });
        });
    </script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/i18n/jquery-ui-i18n.min.js"></script>


@endsection
