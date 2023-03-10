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
            <div class="panel panel-secondary" id="riwayatorganisasi">
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
                                            <th>Nama Organisasi</th>
                                            <th>Alamat</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Jabatan</th>
                                            <th>Nomor SK</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($organisasi as $key => $pek)
                                            <tr>
                                                <td id="key">{{ $key }}</td>
                                                <td>{{ $pek['nama_organisasi'] }}</td>
                                                <td>{{ $pek['alamat'] }}</td>
                                                <td>{{ $pek['tgl_mulai'] }}</td>
                                                <td>{{ $pek['tgl_selesai'] }}</td>
                                                <td>{{ $pek['jabatan'] }}</td>
                                                <td>{{ $pek['no_sk'] }}</td>
                                                <td class="text-center">
                                                    <div class="row d-grid gap-2" role="group" aria-label="Basic example">
                                                        <a href="#formUpdateOrganisasi" class="btn btn-sm btn-info"
                                                            id="editOrganisasi" data-key="{{ $key }}">
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
                                <form action="/storeorganisasi" id="formCreateOrganisasi" method="POST">
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
                                                                <label class="text-white m-b-10">F. RIWAYAT
                                                                    ORGANISASI</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 m-t-10">
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nama Organisasi</label>
                                                                    <input type="text" name="namaOrganisasi"
                                                                        class="form-control"
                                                                        placeholder="Masukkan Nama Organisasi"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alamat </label>
                                                                    <input type="text" name="alamatOrganisasi"
                                                                        class="form-control" id="alamat"
                                                                        placeholder="Masukkan Alamat">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lama Bertugas</label>
                                                                    <div>
                                                                        <div class="input-daterange input-group"
                                                                            id="date-range">
                                                                            <input type="text" class="form-control"
                                                                                name="tglmulai"  />
                                                                            <span
                                                                                class="input-group-addon bg-primary text-white b-0">To</span>
                                                                            <input type="text" class="form-control"
                                                                                name="tglselesai"  />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        {{-- KANAN --}}
                                                        <div class="col-md-6 m-t-10">


                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label">Jabatan Terakhir</label>
                                                                    <input type="text" name="jabatanRorganisasi"
                                                                        class="form-control" placeholder="Masukkan Jabatan"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label">No. Surat Keterangan / SK</label>
                                                                    <input type="number" name="noSKorganisasi"
                                                                        class="form-control" placeholder="Masukkan Nomor SK"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="pull-left">
                                                        <a href="/create-data-pekerjaan" class="btn btn-sm btn-info"><i
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

                                <form action="/updateorganisasi" id="formUpdateOrganisasi" method="POST">
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
                                                                <label class="text-white m-b-10">F. RIWAYAT
                                                                    ORGANISASI</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 m-t-10">
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nama Organisasi</label>
                                                                    <input type="text" name="namaOrganisasi" id="namaOrganisasi"
                                                                        class="form-control"
                                                                        placeholder="Masukkan Nama Perusahaan"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Alamat </label>
                                                                    <input type="text" name="alamatOrganisasi"
                                                                        class="form-control" id="alamatOrganisasi"
                                                                        placeholder="Masukkan Alamat">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lama Bertugas</label>
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

                                                        </div>

                                                        {{-- KANAN --}}
                                                        <div class="col-md-6 m-t-10">


                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label">Jabatan Terakhir</label>
                                                                    <input type="text" name="jabatanRorganisasi" id="jabatanRorganisasi"
                                                                        class="form-control" placeholder="Masukkan Jabatan"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label">No. Surat Keterangan / SK</label>
                                                                    <input type="number" name="noSKorganisasi" id="noSKorganisasi"
                                                                        class="form-control" placeholder="Masukkan Nomor SK"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            
                                                        </div>
                                                    </div>
                                        </div>
                                        <div class="row">
                                            <div class="pull-left">
                                                <a href="/create-data-pekerjaan" class="btn btn-sm btn-info"><i
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#formCreateOrganisasi').prop('hidden', false);
            $('#formUpdateOrganisasi').prop('hidden', true);
            $(document).on('click', '#editOrganisasi', function() {
                // Menampilkan form update data dan menyembunyikan form create data
                $('#formCreateOrganisasi').prop('hidden', true);
                $('#formUpdateOrganisasi').prop('hidden', false);

                // Ambil nomor index data yang akan diubah
                var nomorIndex = $(this).data('key');

                // Isi nomor index ke input hidden pada form update data
                $('#nomor_index_update').val(nomorIndex);

                // Ambil data dari objek yang sesuai dengan nomor index
                var data = {!! json_encode($organisasi) !!}[nomorIndex];
                console.log(data.jenis_usaha, data.gaji);
                // Isi data ke dalam form
                $('#namaOrganisasi').val(data.nama_organisasi);
                $('#alamatOrganisasi').val(data.alamat);
                $('#tglmulai').val(data.tgl_mulai);
                $('#tglselesai').val(data.tgl_selesai);
                $('#jabatanRorganisasi').val(data.jabatan);
                $('#noSKorganisasi').val(data.no_sk);
            });
        });
    </script>
@endsection
