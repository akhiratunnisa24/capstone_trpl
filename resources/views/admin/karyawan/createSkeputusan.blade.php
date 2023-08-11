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

            .form-group {
                margin-left: 10px;
                margin-right: 10px
            }
        </style>
    </head>
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">

            <div class="page-header-title">
                <h4 class="pull-left page-title ">Tambah Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employees Management System</li>
                    <li class="active">Tambah Karyawan</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-secondary" id="suratKeputusan">
                <div class="panel-heading"></div>
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20" style="margin-left:15px;margin-right:15px;">
                                <table id="datatable-responsive10"
                                    class="table dt-responsive nowrap table-striped table-bordered" cellpadding="0"
                                    width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Surat</th>
                                            <th>No. Surat</th>
                                            <th>Tanggal Surat</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Akhir</th>
                                            <th>Gaji</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($skeputusan as $key => $skep)
                                            <tr>
                                                <td id="key">{{ $key }}</td>
                                                <td>{{ $skep['jenis_surat'] }}</td>
                                                <td>{{ $skep['nomor_surat'] }}</td>
                                                <td>{{ $skep['tglsurat'] }}</td>
                                                <td>{{ $skep['tgl_mulai'] }}</td>
                                                <td>{{ $skep['tgl_selesai'] }}</td>
                                                <td>{{ $skep['gaji'] }}</td>
                                                <td class="text-center">
                                                    <div class="row d-grid gap-2" role="group" aria-label="Basic example">
                                                        <a href="#formUpdateSkeputusan" class="btn btn-sm btn-info"
                                                            id="editPrestasi" data-key="{{ $key }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        {{-- /delete-pekerjaan/{{$key}} --}}
                                                        <form class="pull-right" action="" method="POST"
                                                            style="margin-right:5px;">
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm delete_dakel"
                                                                data-key="{{ $key }}"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </form>
                                                        {{-- <button type="button" id="hapus_dakel" data-key="{{ $key }}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table><br>
                                <form action="/storeprestasi" id="formCreateSkeputusan" method="POST">
                                    <div class="control-group after-add-more">
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div>
                                                            <div
                                                                class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                <label class="text-white m-b-10">H. SURAT KEPUTUSAN</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6 m-t-10">

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Jenis Surat</label>
                                                                    <input type="text" name="jenis_surat"
                                                                        class="form-control"
                                                                        placeholder="Masukkan Jenis Surat"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nomor Surat </label>
                                                                    <input type="number" name="noSurat"
                                                                        class="form-control" id="noSurat"
                                                                        placeholder="Masukkan Nomor Surat">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tanggal Surat </label>
                                                                    <input type="text" name="tglSurat"
                                                                        class="form-control" id="datepicker-autoclose35"
                                                                        placeholder="yyyy/mm/dd">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        {{-- KANAN --}}
                                                        <div class="col-md-6 m-t-10">


                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Mulai Berlaku</label>
                                                                    <div>
                                                                        <div class="input-daterange input-group"
                                                                            id="date-range">
                                                                            <input type="text" class="form-control"
                                                                                name="tglmulai" id="tglmulai"  />
                                                                            <span
                                                                                class="input-group-addon bg-primary text-white b-0">To</span>
                                                                            <input type="text" class="form-control"
                                                                                name="tglselesai" id="tglselesai"  />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label">Gaji Pokok</label>
                                                                    <input type="number" name="noSurat" id="gaji"
                                                                        class="form-control" placeholder="Masukkan Gaji Pokok"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="pull-left">
                                                        <a href="/create-data-prestasi" class="btn btn-sm btn-info"><i
                                                                class="fa fa-backward"></i> Sebelumnya</a>
                                                    </div>
                                                    <div class="pull-right">
                                                        <button type="submit" name="submit"
                                                            class="btn btn-sm btn-dark"> Simpan</button>
                                                        <a href="/preview-data-karyawan"
                                                            class="btn btn-sm btn-primary">Lihat Data <i
                                                                class="fa fa-forward"></i></a>
                                                    </div>
                                                </div>
                                            </table>
                                        </div>
                                    </div>
                                </form>

                                <form action="/updateprestasi" id="formUpdateSkeputusan" method="POST">
                                    @csrf
                                    @method('post')
                                    <div class="modal-body">
                                        {{-- <table class="table table-bordered table-striped"> --}}
                                        <input type="text" name="nomor_index" id="nomor_index_update" value="">
                                        <div class="col-md-12">
                                            <div class="row">
                                                        <div>
                                                            <div
                                                                class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                <label class="text-white m-b-10">H. SURAT KEPUTUSAN</label>
                                                            </div>
                                                        </div>
                                                         <div class="col-md-6 m-t-10">

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Jenis Surat</label>
                                                                    <input type="text" name="jenis_surat"
                                                                        class="form-control"
                                                                        placeholder="Masukkan Jenis Surat"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nomor Surat </label>
                                                                    <input type="number" name="noSurat"
                                                                        class="form-control" id="noSurat"
                                                                        placeholder="Masukkan Nomor Surat">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tanggal Surat </label>
                                                                    <input type="text" name="tglSurat"
                                                                        class="form-control" id="datepicker-autoclose35"
                                                                        placeholder="yyyy/mm/dd">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        {{-- KANAN --}}
                                                        <div class="col-md-6 m-t-10">


                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Mulai Berlaku</label>
                                                                    <div>
                                                                        <div class="input-daterange input-group"
                                                                            id="date-range">
                                                                            <input type="text" class="form-control"
                                                                                name="tglmulai" id="tglmulai"  />
                                                                            <span
                                                                                class="input-group-addon bg-primary text-white b-0">To</span>
                                                                            <input type="text" class="form-control"
                                                                                name="tglselesai" id="tglselesai"  />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label">Gaji Pokok</label>
                                                                    <input type="number" name="noSurat" id=""
                                                                        class="form-control" placeholder="Masukkan Gaji Pokok"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                    </div>
                                        </div>
                                        <div class="row">
                                            <div class="pull-left">
                                                <a href="/create-data-prestasi" class="btn btn-sm btn-info"><i
                                                        class="fa fa-backward"></i> Sebelumnya</a>
                                            </div>
                                            <div class="pull-right">
                                                <button type="submit" name="submit" class="btn btn-sm btn-dark"> Update
                                                    Data</button>
                                                <a href="/preview-data-karyawan" class="btn btn-sm btn-primary">Lihat Data
                                                    <i class="fa fa-forward"></i></a>
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#formCreateSkeputusan').prop('hidden', false);
            $('#formUpdateSkeputusan').prop('hidden', true);
            $(document).on('click', '#editPrestasi', function() {
                // Menampilkan form update data dan menyembunyikan form create data
                $('#formCreateSkeputusan').prop('hidden', true);
                $('#formUpdateSkeputusan').prop('hidden', false);

                // Ambil nomor index data yang akan diubah
                var nomorIndex = $(this).data('key');

                // Isi nomor index ke input hidden pada form update data
                $('#nomor_index_update').val(nomorIndex);

                // Ambil data dari objek yang sesuai dengan nomor index
                var data = {!! json_encode($prestasi) !!}[nomorIndex];
                // console.log(data.jenis_usaha, data.gaji);
                // Isi data ke dalam form
                $('#keterangan').val(data.keterangan);
                $('#namaInstansi').val(data.nama_instansi);
                $('#alamatInstansi').val(data.alamat);
                $('#noSurat').val(data.no_surat);
            });
        });
    </script>
@endsection
