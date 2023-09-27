<head>

    <!-- Datapicker -->
    <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <meta charset="utf-8" />
    <title>REMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="shortcut icon" href="{{ asset('') }}assets/images/remss.png" width="38px" height="20px">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

</head>

<div class="container">
    <!-- Page-Title -->
    <div class="row" style="margin-top: 30px">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title">Form Penerimaan Rekruitmen</h4>

                <div class="clearfix"></div>
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
                                                {{-- <td id="key">{{ $key }}</td> --}}
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $pek['nama_organisasi'] }}</td>
                                                <td>{{ $pek['alamat'] }}</td>
                                                {{-- <td>{{ $pek['tgl_mulai'] }}</td>
                                                <td>{{ $pek['tgl_selesai'] }}</td> --}}
                                                <td>{{ $pek['tgl_mulai']}}</td>
                                                <td>{{ $pek['tgl_selesai'] }}</td>
                                                <td>{{ $pek['jabatan'] }}</td>
                                                <td>{{ $pek['no_sk'] }}</td>
                                                <td class="text-center">
                                                    <div class="row d-grid gap-2" role="group"
                                                        aria-label="Basic example">
                                                        <a href="#formUpdateOrganisasi" class="btn btn-sm btn-info"
                                                            id="editOrganisasi" data-key="{{ $key }}">
                                                            <i class="fa fa-edit" title="Edit"></i>
                                                        </a>
                                                        <form class="pull-right" action="{{ route('delete_organisasi') }}" method="POST" style="margin-right: 5px;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="key" value="{{$key}}">
                                                            <button type="submit" class="btn btn-danger btn-sm delete_organisasi" data-key="{{$key}}">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table><br>
                                <form action="/store_organisasi" id="formCreateOrganisasi" method="POST">
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
                                                                        placeholder="Masukkan Alamat"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Lama Bertugas</label>
                                                                    <div>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose506" type="text"
                                                                                class="form-control" placeholder="mm/yyyy"
                                                                                name="tglmulai" style="text-align: center"
                                                                                autocomplete="off" rows="10" readonly>
                                                                            <span
                                                                                class="input-group-addon bg-primary text-white b-0">-</span>
                                                                            <input id="datepicker-autoclose507" type="text"
                                                                                class="form-control" placeholder="mm/yyyy"
                                                                                style="text-align: center" name="tglselesai"
                                                                                autocomplete="off" rows="10" readonly>
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
                                                                        class="form-control"
                                                                        placeholder="Masukkan Jabatan"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputEmail1"
                                                                        class="form-label">No. Surat Keterangan /
                                                                        SK</label>
                                                                    <input type="text" name="noSKorganisasi"
                                                                        class="form-control"
                                                                        placeholder="Masukkan Nomor SK"
                                                                        autocomplete="off">
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="pull-left">
                                                        <a href="/create_data_pekerjaan"
                                                            class="btn btn-sm btn-info"><i class="fa fa-backward"></i>
                                                            Sebelumnya</a>
                                                    </div>
                                                    <div class="pull-right">
                                                        <button type="submit" name="submit"
                                                            class="btn btn-sm btn-dark"> Simpan</button>
                                                        <a href="/create_data_prestasi"
                                                            class="btn btn-sm btn-success">Selanjutnya <i
                                                                class="fa fa-forward"></i></a>
                                                        {{-- <a href="/preview-data-karyawan"
                                                            class="btn btn-sm btn-primary">Lihat Data <i
                                                                class="fa fa-forward"></i></a> --}}
                                                    </div>
                                                </div>
                                            </table>
                                        </div>
                                    </div>
                                </form>

                                <form action="/update_organisasi" id="formUpdateOrganisasi" method="POST">
                                    @csrf
                                    @method('post')
                                    <div class="modal-body">
                                        {{-- <table class="table table-bordered table-striped"> --}}
                                        <input type="text" name="nomor_index" id="nomor_index_update"
                                            value="" hidden>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div>
                                                    <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                        <label class="text-white m-b-10">F. RIWAYAT
                                                            ORGANISASI</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 m-t-10">
                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nama Organisasi</label>
                                                            <input type="text" name="namaOrganisasi"
                                                                id="namaOrganisasi" class="form-control"
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

                                                    {{-- <div class="form-group">
                                                        <div class="mb-3">
                                                            <label class="form-label">Lama Bertugas</label>
                                                            <div>
                                                                <div class="input-daterange input-group"
                                                                    id="date-range2">
                                                                    <input type="text" class="form-control"
                                                                        name="tglmulai" id="tglmulai"
                                                                        autocomplete="off" />
                                                                    <span
                                                                        class="input-group-addon bg-primary text-white b-0">To</span>
                                                                    <input type="text" class="form-control"
                                                                        name="tglselesai" id="tglselesai"
                                                                        autocomplete="off" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> --}}
                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label class="form-label">Lama Bertugas</label>
                                                            <div>
                                                                <div class="input-group">
                                                                    <input id="datepicker-autoclose508" type="text"
                                                                        class="form-control" placeholder="mm/yyyy"
                                                                        name="tglmulai" style="text-align: center"
                                                                        autocomplete="off" rows="10" readonly>
                                                                    <span
                                                                        class="input-group-addon bg-primary text-white b-0">-</span>
                                                                    <input id="datepicker-autoclose509" type="text"
                                                                        class="form-control" placeholder="mm/yyyy"
                                                                        style="text-align: center" name="tglselesai"
                                                                        autocomplete="off" rows="10" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                {{-- KANAN --}}
                                                <div class="col-md-6 m-t-10">


                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">Jabatan
                                                                Terakhir</label>
                                                            <input type="text" name="jabatanRorganisasi"
                                                                id="jabatanRorganisasi" class="form-control"
                                                                placeholder="Masukkan Jabatan" autocomplete="off">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="mb-3">
                                                            <label for="exampleInputEmail1" class="form-label">No.
                                                                Surat Keterangan / SK</label>
                                                            <input type="text" name="noSKorganisasi"
                                                                id="noSKorganisasi" class="form-control"
                                                                placeholder="Masukkan Nomor SK" autocomplete="off">
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="pull-left">
                                                <a href="/create_data_pekerjaan" class="btn btn-sm btn-info"><i
                                                        class="fa fa-backward"></i> Sebelumnya</a>
                                            </div>
                                            <div class="pull-right">
                                                <button type="submit" name="submit" class="btn btn-sm btn-dark">
                                                    Update
                                                    Data</button>
                                                <a href="/create_data_prestasi"
                                                    class="btn btn-sm btn-success">Selanjutnya <i
                                                        class="fa fa-forward"></i></a>
                                                {{-- <a href="/preview-data-karyawan" class="btn btn-sm btn-primary">Lihat Data
                                                    <i class="fa fa-forward"></i></a> --}}
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
                $('#datepicker-autoclose508').val(data.tgl_mulai);
                $('#datepicker-autoclose509').val(data.tgl_selesai);
                // var tanggal = new Date(data.tgl_mulai);
                // var tanggalFormatted = ("0" + tanggal.getDate()).slice(-2) + '/' + ("0" + (tanggal
                //     .getMonth() + 1)).slice(-2) + '/' + tanggal.getFullYear();
                // $('#tglmulai').val(tanggalFormatted);

                // var tanggal = new Date(data.tgl_selesai);
                // var tanggalFormatted = ("0" + tanggal.getDate()).slice(-2) + '/' + ("0" + (tanggal
                //     .getMonth() + 1)).slice(-2) + '/' + tanggal.getFullYear();
                // $('#tglselesai').val(tanggalFormatted);

                $('#jabatanRorganisasi').val(data.jabatan);
                $('#noSKorganisasi').val(data.no_sk);
            });
        });
    </script>

    <!-- datepicker  -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/pages/form-advanced.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/i18n/jquery-ui-i18n.min.js"></script>
