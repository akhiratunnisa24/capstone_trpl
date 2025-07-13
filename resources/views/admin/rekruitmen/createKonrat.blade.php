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

        <link rel="shortcut icon" href="{{ asset('') }}assets/images/rem.png" width="38px" height="20px">

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
                <div class="panel panel-secondary" id="dataKdarurat">
                    <div class="panel-heading"></div>
                    <div class="content">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-20 col-sm-20 col-xs-20" style="margin-left:15px;margin-right:15px;">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>No HP</th>
                                                <th>Alamat</th>
                                                <th>Hubungan Keluarga</th>
                                                <th >Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($kontakdarurat as $key => $kd)
                                                <tr>
                                                    {{-- <td id="key">{{ $key }}</td> --}}
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $kd['nama'] }}</td>
                                                    <td>{{ $kd['no_hp'] }}</td>
                                                    <td>{{ $kd['alamat'] }}</td>
                                                    <td>{{ $kd['hubungan'] }}</td>
                                                    <td class="text-center">
                                                        <div class="row">
                                                            <a class="btn btn-sm btn-info" id="editKonrat"
                                                                data-key="{{ $key }}">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                            <form class="pull-right" action="{{ route('delete_kd') }}" method="POST" style="margin-right: 60px;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="key" value="{{$key}}">
                                                                <button type="submit" class="btn btn-danger btn-sm delete_konrat" data-key="{{$key}}">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table><br>
                                    <form action="/store_kontak_darurat" id="formCreateKontakdarurat" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        <div class="control-group after-add-more">
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                                <div
                                                                    class="modal-header bg-info panel-heading  col-sm-15 m-b-5  ">
                                                                    <label class="text-white">C. KONTAK DARURAT</label>
                                                                </div>
                                                                <div class="form-group m-t-10">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Nama Lengkap</label>
                                                                        <input type="text"
                                                                            value="{{ $kontakdarurat->nama ?? '' }}"
                                                                            name="namaKdarurat" class="form-control"
                                                                            placeholder="Masukkan Nama"
                                                                            autocomplete="off" required>
                                                                        <div id="emailHelp" class="form-text"></div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Hubungan</label>
                                                                        <select class="form-control selectpicker"
                                                                            name="hubunganKdarurat" required>
                                                                            <option value="">Pilih Hubungan
                                                                            </option>
                                                                            <option value="Ayah"
                                                                                {{ $kontakdarurat->hubungan ?? 'Ayah' == '' ? 'selected' : '' }}>
                                                                                Ayah</option>
                                                                            <option value="Ibu"
                                                                                {{ $kontakdarurat->hubungan ?? 'Ibu' == '' ? 'selected' : '' }}>
                                                                                Ibu</option>
                                                                            <option value="Suami"
                                                                                {{ $kontakdarurat->hubungan ?? 'Suami' == '' ? 'selected' : '' }}>
                                                                                Suami</option>
                                                                            <option value="Istri"
                                                                                {{ $kontakdarurat->hubungan ?? 'Istri' == '' ? 'selected' : '' }}>
                                                                                Istri</option>
                                                                            <option value="Kakak"
                                                                                {{ $kontakdarurat->hubungan ?? 'Kakak' == '' ? 'selected' : '' }}>
                                                                                Kakak</option>
                                                                            <option value="Adik"
                                                                                {{ $kontakdarurat->hubungan ?? 'Adik' == '' ? 'selected' : '' }}>
                                                                                Adik</option>
                                                                            <option value="Anak"
                                                                                {{ $kontakdarurat->jhubungan ?? 'Anak' == '' ? 'selected' : '' }}>
                                                                                Anak</option>
                                                                                <option value="Saudara"
                                                                                {{ $kontakdarurat->jhubungan ?? 'Saudara' == '' ? 'selected' : '' }}>
                                                                                Saudara</option>
                                                                                <option value="Teman"
                                                                                {{ $kontakdarurat->jhubungan ?? 'Teman' == '' ? 'selected' : '' }}>
                                                                                Teman</option>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3 ">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Alamat</label>
                                                                        <input class="form-control"
                                                                            value="{{ $kontakdarurat->alamat ?? '' }}"
                                                                            name="alamatKdarurat" rows="9"
                                                                            placeholder="Masukkan Alamat"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">No. Handphone</label>
                                                                        <input type="number" name="no_hpKdarurat"
                                                                            value="{{ $kontakdarurat->no_hp ?? '' }}"
                                                                            class="form-control" id="no_hp"
                                                                            placeholder="Masukkan Nomor Handphone"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="pull-left">
                                                                        <a href="/create_data_keluarga_pelamar"
                                                                            class="btn btn-sm btn-info"><i
                                                                                class="fa fa-backward"></i>
                                                                            Sebelumnya</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <button type="submit" name="submit"
                                                                            id="btn-simpan"
                                                                            class="btn btn-sm btn-dark">Simpan</button>
                                                                        <a href="/create_data_pendidikan"
                                                                            class="btn btn-sm btn-success"
                                                                            id="btn-selanjutnya">Selanjutnya <i
                                                                                class="fa fa-forward"></i></a>
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

                                    <form action="/update_kontak_darurat" id="formUpdateKontakdarurat" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('post')
                                        <div class="control-group after-add-more">
                                            <div class="modal-body">
                                                <table class="table table-bordered table-striped">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-2"></div>
                                                            <div class="col-md-8">
                                                                <div
                                                                    class="modal-header bg-info panel-heading  col-sm-15 m-b-5  ">
                                                                    <label class="text-white">C. KONTAK DARURAT</label>
                                                                </div>
                                                                <input type="hidden" name="nomor_index"
                                                                    id="nomor_index_update" value="">
                                                                <div class="form-group m-t-10">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Nama Lengkap</label>
                                                                        <input type="text" id="namaKdarurat"
                                                                            name="namaKdarurat" class="form-control"
                                                                            placeholder="Masukkan Nama"
                                                                            autocomplete="off" required>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Hubungan</label>
                                                                        <select class="form-control selectpicker"
                                                                            id="hubunganKdarurat"
                                                                            name="hubunganKdarurat" required>
                                                                            <option value="">Pilih Hubungan
                                                                            </option>
                                                                            <option value="Ayah"
                                                                                {{ $kontakdarurat->hubungan ?? 'Ayah' == '' ? 'selected' : '' }}>
                                                                                Ayah</option>
                                                                            <option value="Ibu"
                                                                                {{ $kontakdarurat->hubungan ?? 'Ibu' == '' ? 'selected' : '' }}>
                                                                                Ibu</option>
                                                                            <option value="Suami"
                                                                                {{ $kontakdarurat->hubungan ?? 'Suami' == '' ? 'selected' : '' }}>
                                                                                Suami</option>
                                                                            <option value="Istri"
                                                                                {{ $kontakdarurat->hubungan ?? 'Istri' == '' ? 'selected' : '' }}>
                                                                                Istri</option>
                                                                            <option value="Kakak"
                                                                                {{ $kontakdarurat->hubungan ?? 'Kakak' == '' ? 'selected' : '' }}>
                                                                                Kakak</option>
                                                                            <option value="Adik"
                                                                                {{ $kontakdarurat->hubungan ?? 'Adik' == '' ? 'selected' : '' }}>
                                                                                Adik</option>
                                                                            <option value="Anak"
                                                                                {{ $kontakdarurat->jhubungan ?? 'Anak' == '' ? 'selected' : '' }}>
                                                                                Anak</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="mb-3 ">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Alamat</label>
                                                                        <input class="form-control"
                                                                            id="alamatKdarurat" name="alamatKdarurat"
                                                                            rows="9"
                                                                            placeholder="Masukkan Alamat"
                                                                            required>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">No. Handphone</label>
                                                                        <input type="number" id="no_hpKdarurat"
                                                                            name="no_hpKdarurat" class="form-control"
                                                                            id="no_hp"
                                                                            placeholder="Masukkan Nomor Handphone"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="pull-left">
                                                                        <a href="/create_data_keluarga_pelamar"
                                                                            class="btn btn-sm btn-info"><i
                                                                                class="fa fa-backward"></i>
                                                                            Sebelumnya</a>
                                                                    </div>
                                                                    <div class="pull-right">
                                                                        <button type="submit" name="submit"
                                                                            id="btn-simpan"
                                                                            class="btn btn-sm btn-dark">Update
                                                                            Data</button>
                                                                        <a href="/create_data_pendidikan"
                                                                            class="btn btn-sm btn-success"
                                                                            id="btn-selanjutnya">Selanjutnya <i
                                                                                class="fa fa-forward"></i></a>
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
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/pages/form-advanced.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#formCreateKontakdarurat').prop('hidden', false);
            $('#formUpdateKontakdarurat').prop('hidden', true);
            $(document).on('click', '#editKonrat', function() {
                // Menampilkan form update data dan menyembunyikan form create data
                $('#formCreateKontakdarurat').prop('hidden', true);
                $('#formUpdateKontakdarurat').prop('hidden', false);

                // Ambil nomor index data yang akan diubah
                var nomorIndex = $(this).data('key');

                // Isi nomor index ke input hidden pada form update data
                $('#nomor_index_update').val(nomorIndex);

                // Ambil data dari objek yang sesuai dengan nomor index
                var data = {!! json_encode($kontakdarurat) !!}[nomorIndex];
                // Isi data ke dalam form
                $('#namaKdarurat').val(data.nama);
                $('#no_hpKdarurat').val(data.no_hp);
                $('#alamatKdarurat').val(data.alamat);
                $('#hubunganKdarurat').val(data.hubungan);

                // Set opsi yang dipilih pada dropdown select option
                var select = document.getElementById("hubunganKdarurat");
                for (var i = 0; i < select.options.length; i++) {
                    if (select.options[i].value == data.hubungan) {
                        select.options[i].selected = true;
                        break;
                    }
                }
            });
        });
    </script>
