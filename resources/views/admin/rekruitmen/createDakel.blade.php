    <head>
        <!-- Datapicker -->
        <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">


        <meta charset="utf-8" />
        <title>HRMS</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <link rel="shortcut icon" href="{{ asset('') }}assets/images/favicon2.png">

        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="assets/css/style.css" rel="stylesheet" type="text/css">
    </head>

    <div class="container">
        <form action="store_data_keluarga" method="POST" enctype="multipart/form-data">
            @csrf
            @method('post')
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
                    <div class="panel panel-secondary" id="datakeluarga">
                        <div class="panel-heading"></div>
                        <div class="content">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-20 col-sm-20 col-xs-20"
                                        style="margin-left:15px;margin-right:15px;">

                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Hubungan</th>
                                                    <th>Nama</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Kota Kelahiran</th>
                                                    <th>Pendidikan Terakhir</th>
                                                    <th>Pekerjaan</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($datakeluarga as $key => $data)
                                                    <tr>
                                                        {{-- <td id="key">{{ $key }}</td> --}}
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data['hubungan'] }}</td>
                                                        <td>{{ $data['nama'] }}</td>
                                                        <td>{{ $data['jenis_kelamin'] }}</td>
                                                        <td>{{ $data['tgllahir'] }}</td>
                                                        <td>{{ $data['tempatlahir'] }}</td>
                                                        <td>{{ $data['pendidikan_terakhir'] }}</td>
                                                        <td>{{ $data['pekerjaan'] }}</td>
                                                        <td class="text-center">
                                                            <div class="row d-grid gap-2" role="group"
                                                                aria-label="Basic example">
                                                                <a class="btn btn-sm btn-info" id="editKeluarga"
                                                                    data-key="{{ $key }}">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <form class="pull-right"
                                                                    action="/delete-keluarga/{{ $key }}"
                                                                    method="POST" style="margin-right:5px;">
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm delete_dakel"
                                                                        data-key="{{ $key }}"><i
                                                                            class="fa fa-trash"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <form action="/update_data_keluarga" method="POST" id="formCreateDatakeluarga"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('post')
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-8 m-t-10">

                                                                <div
                                                                    class="modal-header bg-info panel-heading  col-sm-15 m-b-10 m-t-10">
                                                                    <label class="text-white">B. DATA KELUARGA *)
                                                                    </label>
                                                                </div>


                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Hubungan</label>
                                                                        <select class="form-control selectpicker"
                                                                            id="hubungan" name="hubungankeluarga"
                                                                            required>
                                                                            <option value="">Pilih Hubungan
                                                                            </option>
                                                                            <option value="Ayah">Ayah</option>
                                                                            <option value="Ibu">Ibu</option>
                                                                            <option value="Suami">Suami</option>
                                                                            <option value="Istri">Istri</option>
                                                                            <option value="Kakak">Kakak</option>
                                                                            <option value="Adik">Adik</option>
                                                                            <option value="Anak Pertama">Anak ke-1
                                                                            </option>
                                                                            <option value="Anak Ke-2">Anak Ke-2</option>
                                                                            <option value="Anak Ke-3">Anak Ke-3</option>
                                                                            <option value="Anak Ke-4">Anak Ke-4</option>
                                                                            <option value="Anak Ke-5">Anak Ke-5</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nama Lengkap</label>
                                                                        <input type="text" id="namaPasangan"
                                                                            name="namaPasangan" class="form-control"
                                                                            autocomplete="off"
                                                                            placeholder="Masukkan Nama" required>

                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="form-label">Jenis Kelamin</label>
                                                                    <select class="form-control selectpicker"
                                                                        name="jenis_kelaminKeluarga" required>
                                                                        <option value="">Pilih Jenis Kelamin
                                                                        </option>
                                                                        <option value="Laki-Laki">Laki-Laki</option>
                                                                        <option value="Perempuan">Perempuan</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Tanggal Lahir</label>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose36" type="text" class="form-control"
                                                                                placeholder="yyyy/mm/dd"
                                                                                autocomplete="off"
                                                                                name="tgllahirPasangan" required>
                                                                            {{-- <span
                                                                                class="input-group-addon bg-custom b-0"><i
                                                                                    class="mdi mdi-calendar text-white"></i></span> --}}
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Kota
                                                                            Kelahiran</label>
                                                                        <input class="form-control"
                                                                            name="tempatlahirKeluarga"
                                                                            autocomplete="off" rows="9"
                                                                            placeholder="Masukkan Kota Kelahiran"required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="form-label">Pendidikan
                                                                        Terakhir</label>
                                                                    <select class="form-control selectpicker"
                                                                        id="pendidikan_terakhirPasangan"
                                                                        name="pendidikan_terakhirPasangan"required>
                                                                        <option value="">Pilih Pendidikan
                                                                            Terakhir</option>
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
                                                                        <label class="form-label">Pekerjaan</label>
                                                                        <input type="text" name="pekerjaanPasangan"
                                                                            class="form-control"
                                                                            id="pekerjaanPasangan"
                                                                            aria-describedby="emailHelp"
                                                                            placeholder="Masukkan Pekerjaan" autocomplete="off">
                                                                        <div id="emailHelp" class="form-text"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="pull-left">
                                                                        <a href="/create_pelamar"
                                                                            class="btn btn-sm btn-info"><i
                                                                                class="fa fa-backward"></i>
                                                                            Sebelumnya</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <button type="submit" name="submit"
                                                                            class="btn btn-sm btn-dark">Simpan</button>
                                                                        <a href="/create_kontak_darurat"
                                                                            class="btn btn-sm btn-success">Selanjutnya
                                                                            <i class="fa fa-forward"></i></a>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </table>
                                            </div>
                                            {{-- </div> --}}
                                        </form>
                                        {{-- /updatedatakeluarga  --}}
                                        <form action="/update_data_keluarga" method="POST" id="formUpdateDatakeluarga"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('post')
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            {{-- nomor array --}}
                                                            <input type="hidden" name="nomor_index"
                                                                id="nomor_index_update" value="">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-8 m-t-10">
                                                                <div
                                                                    class="modal-header bg-info panel-heading  col-sm-15 m-b-10 m-t-10">
                                                                    <label class="text-white">B. DATA KELUARGA *)
                                                                    </label>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Hubungan</label>
                                                                        <select class="form-control selectpicker"
                                                                            id="hubungankeluargaa"
                                                                            name="hubungankeluarga" required>
                                                                            <option value="">Pilih Hubungan
                                                                            </option>
                                                                            <option value="Ayah">Ayah</option>
                                                                            <option value="Ibu">Ibu</option>
                                                                            <option value="Suami">Suami</option>
                                                                            <option value="Istri">Istri</option>
                                                                            <option value="Kakak">Kakak</option>
                                                                            <option value="Adik">Adik</option>
                                                                            <option value="Anak Pertama">Anak Pertama
                                                                            </option>
                                                                            <option value="Anak Ke-2">Anak Ke-2
                                                                            </option>
                                                                            <option value="Anak Ke-3">Anak Ke-3
                                                                            </option>
                                                                            <option value="Anak Ke-4">Anak Ke-4
                                                                            </option>
                                                                            <option value="Anak Ke-5">Anak Ke-5
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nama Lengkap</label>
                                                                        <input type="text" id="nama"
                                                                            name="namaPasangan" class="form-control"
                                                                            autocomplete="off"
                                                                            placeholder="Masukkan Nama" required>

                                                                    </div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <label class="form-label">Jenis Kelamin</label>
                                                                    <select class="form-control selectpicker"
                                                                        name="jenis_kelaminKeluarga"
                                                                        id="jenis_kelaminKeluarga" required>
                                                                        <option value="">Pilih Jenis Kelamin
                                                                        </option>
                                                                        <option value="Laki-Laki">Laki-Laki</option>
                                                                        <option value="Perempuan">Perempuan</option>
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Tanggal Lahir</label>
                                                                        <div class="input-group">
                                                                            <input id="datepicker-autoclose39" type="text" class="form-control"
                                                                                placeholder="yyyy/mm/dd"
                                                                                id="tgllahirPasangan"
                                                                                autocomplete="off"
                                                                                name="tgllahirPasangan" rows="10"
                                                                                required><br>
                                                                            <span
                                                                                class="input-group-addon bg-custom b-0"><i
                                                                                    class="mdi mdi-calendar text-white"></i></span>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Kota
                                                                            Kelahiran</label>
                                                                        <input class="form-control"
                                                                            name="tempatlahirKeluarga"
                                                                            id="tempatlahirKeluarga"
                                                                            autocomplete="off" rows="9"
                                                                            placeholder="Masukkan Kota Kelahiran"required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="form-label">Pendidikan
                                                                        Terakhir</label>
                                                                    <select class="form-control selectpicker"
                                                                        id="pendidikan_terakhir"
                                                                        name="pendidikan_terakhirPasangan"required>
                                                                        <option value="">Pilih Pendidikan
                                                                            Terakhir</option>
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
                                                                        <label class="form-label">Pekerjaan</label>
                                                                        <input type="text" name="pekerjaanPasangan"
                                                                            class="form-control" id="pekerjaan"
                                                                            aria-describedby="emailHelp"
                                                                            placeholder="Masukkan Pekerjaan" required>
                                                                        <div id="emailHelp" class="form-text"></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="pull-left">
                                                                        <a href="/create_pelamar"
                                                                            class="btn btn-sm btn-info"><i
                                                                                class="fa fa-backward"></i>
                                                                            Sebelumnya</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <button type="submit" name="submit"
                                                                            class="btn btn-sm btn-dark">Update
                                                                            Data</button>
                                                                        <a href="/create_kontak_darurat"
                                                                            class="btn btn-sm btn-success">Selanjutnya
                                                                            <i class="fa fa-forward"></i></a>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="col-md-2"></div>
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
    </div>

    {{-- <script src="assets/js/jquery.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/pages/form-advanced.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#formCreateDatakeluarga').prop('hidden', false);
            $('#formUpdateDatakeluarga').prop('hidden', true);
            $(document).on('click', '#editKeluarga', function() {
                // Menampilkan form update data dan menyembunyikan form create data
                $('#formCreateDatakeluarga').prop('hidden', true);
                $('#formUpdateDatakeluarga').prop('hidden', false);

                // Ambil nomor index data yang akan diubah
                var nomorIndex = $(this).data('key');

                // Isi nomor index ke input hidden pada form update data
                $('#nomor_index_update').val(nomorIndex);

                // Ambil data dari objek yang sesuai dengan nomor index
                var data = {!! json_encode($datakeluarga) !!}[nomorIndex];
                // Isi data ke dalam form
                $('#nama').val(data.nama);
                $('#tgllahirPasangan').val(data.tgllahir);
                $('#hubungankeluargaa').val(data.hubungan);
                $('#alamat').val(data.alamat);
                $('#pekerjaan').val(data.pekerjaan);
                $('#pendidikan_terakhir').val(data.pendidikan_terakhir);
                $('#jenis_kelaminKeluarga').val(data.jenis_kelamin);
                $('#tempatlahirKeluarga').val(data.tempatlahir);

                // Set opsi yang dipilih pada dropdown select option
                var select = document.getElementById("hubungankeluargaa");
                for (var i = 0; i < select.options.length; i++) {
                    if (select.options[i].value == data.hubungan) {
                        select.options[i].selected = true;
                        break;
                    }
                }
                // Set opsi yang dipilih pada dropdown select option
                var select = document.getElementById("pendidikan_terakhir");
                for (var i = 0; i < select.options.length; i++) {
                    if (select.options[i].value == data.pendidikan_terakhir) {
                        select.options[i].selected = true;
                        break;
                    }
                }
            });
        });
    </script>
    <!-- datepicker  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
