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
                <div class="panel panel-secondary" id="riwayatpekerjaan">
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
                                                <th>Nama Perusahaan</th>
                                                <th>Alamat</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Tanggal Keluar</th>
                                                <th>Jabatan</th>
                                                <th>Level</th>
                                                <th>Gaji</th>
                                                <th>Alasan Berhenti</th>
                                                <th>Aksi</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pekerjaan as $key => $pek)
                                                <tr>
                                                    {{-- <td id="key">{{ $key }}</td> --}}
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $pek['nama_perusahaan'] }}</td>
                                                    <td>{{ $pek['alamat'] }}</td>
                                                    {{-- <td>{{ $pek['tgl_mulai'] }}</td>
                                                <td>{{ $pek['tgl_selesai'] }}</td> --}}
                                                    <td>{{ \Carbon\Carbon::parse($pek['tgl_mulai'])->format('d/m/Y') }}
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($pek['tgl_selesai'])->format('d/m/Y') }}
                                                    </td>
                                                    <td>{{ $pek['jabatan'] }}</td>
                                                    <td>{{ $pek['level'] }}</td>
                                                    <td>{{ $pek['gaji'] }}</td>
                                                    <td>{{ $pek['alasan_berhenti'] }}</td>
                                                    <td class="text-center">
                                                        <div class="row d-grid gap-2" role="group"
                                                            aria-label="Basic example">
                                                            <a href="#formUpdatePekerjaan" class="btn btn-sm btn-info"
                                                                id="editPekerjaan" data-key="{{ $key }}">
                                                                <i class="fa fa-edit" title="Edit"></i>
                                                            </a>
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
                                    <form action="/store_pekerjaan" id="formCreatePekerjaan" method="POST"
                                        enctype="multipart/form-data">
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
                                                                    <label class="text-white m-b-10">E. RIWAYAT
                                                                        PEKERJAAN</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 m-t-10">
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nama
                                                                            Perusahaan</label>
                                                                        <input type="text" name="namaPerusahaan"
                                                                            class="form-control"
                                                                            placeholder="Masukkan Nama Perusahaan"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Alamat </label>
                                                                        <input type="text" name="alamatPerusahaan"
                                                                            class="form-control" id="alamat"
                                                                            placeholder="Masukkan Alamat"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                {{-- <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Lama Kerja</label>
                                                                        <div>
                                                                            <div class="input-daterange input-group"
                                                                                id="date-range">
                                                                                <input type="text"
                                                                                    class="form-control" name="tglmulai"
                                                                                    autocomplete="off"
                                                                                    placeholder="dd/mm/yyyy" />
                                                                                <span
                                                                                    class="input-group-addon bg-primary text-white b-0">To</span>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    name="tglselesai"
                                                                                    autocomplete="off"
                                                                                    placeholder="dd/mm/yyyy" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> --}}
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Lama Kerja</label>
                                                                        <div>
                                                                            <div class="input-group">
                                                                                <input id="datepicker-autoclose504" type="text" class="form-control" placeholder="mm/yyyy"
                                                                                name="tglmulai" style="text-align: center" autocomplete="off"  rows="10" readonly>
                                                                                <span class="input-group-addon bg-primary text-white b-0">-</span>
                                                                                <input id="datepicker-autoclose505" type="text" class="form-control" placeholder="mm/yyyy"
                                                                                style="text-align: center" name="tglselesai" autocomplete="off"  rows="10" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Jabatan Terakhir</label>
                                                                        <input type="text" name="jabatanRpekerjaan"
                                                                            class="form-control"
                                                                            placeholder="Masukkan Jabatan"
                                                                            autocomplete="off">
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
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Level / Pangkat /
                                                                            Golongan</label>
                                                                        <input type="text" name="levelRpekerjaan"
                                                                            class="form-control"
                                                                            placeholder="Masukkan Level"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Gaji</label>
                                                                        <input type="text" name="gajiRpekerjaan"
                                                                            class="form-control" id="gaji"
                                                                            placeholder="Masukkan Gaji"
                                                                            autocomplete="off">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1"
                                                                            class="form-label">Alasan Berhenti</label>
                                                                        <input type="text" name="alasanBerhenti"
                                                                            class="form-control"
                                                                            placeholder="Masukkan Alasan Berhenti"
                                                                            autocomplete="off">

                                                                    </div>
                                                                </div>



                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="pull-left">
                                                            <a href="/create_data_pendidikan"
                                                                class="btn btn-sm btn-info"><i
                                                                    class="fa fa-backward"></i> Sebelumnya</a>
                                                        </div>
                                                        <div class="pull-right">
                                                            <button type="submit" name="submit"
                                                                class="btn btn-sm btn-dark"> Simpan</button>
                                                            <a href="/create_data_organisasi"
                                                                class="btn btn-sm btn-success">Selanjutnya <i
                                                                    class="fa fa-forward"></i></a>
                                                            {{-- <a href="/preview-data-karyawan" class="btn btn-sm btn-primary">Lihat Data <i class="fa fa-forward"></i></a> --}}
                                                        </div>
                                                    </div>
                                                </table>
                                            </div>
                                        </div>
                                    </form>

                                    <form action="/update_pekerjaan" id="formUpdatePekerjaan" method="POST"
                                        enctype="multipart/form-data">
                                        {{-- <div class="control-group after-add-more"> --}}
                                        @csrf
                                        @method('post')
                                        <div class="modal-body">

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div>
                                                        <div
                                                            class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                            <label class="text-white m-b-10">E. RIWAYAT
                                                                PEKERJAAN</label>
                                                        </div>
                                                    </div>

                                                    {{-- Nomor index sebegai ID --}}
                                                    <input type="hidden" name="nomor_index" id="nomor_index_update"
                                                        value="">
                                                    <div class="col-md-6 m-t-10">
                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Nama Perusahaan</label>
                                                                <input type="text" id="namaPerusahaan"
                                                                    name="namaPerusahaan" class="form-control"
                                                                    placeholder="Masukkan Nama Perusahaan"
                                                                    autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Alamat </label>
                                                                <input type="text" id="alamatPerusahaan"
                                                                    name="alamatPerusahaan" class="form-control"
                                                                    id="alamat" placeholder="Masukkan Alamat">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label">Lama Kerja</label>
                                                                <div>
                                                                    <div class="input-group">
                                                                        <input id="datepicker-autoclose510" type="text" class="form-control" placeholder="mm/yyyy"
                                                                        name="tglmulai" style="text-align: center" autocomplete="off"  rows="10" readonly>
                                                                        <span class="input-group-addon bg-primary text-white b-0">-</span>
                                                                        <input id="datepicker-autoclose511" type="text" class="form-control" placeholder="mm/yyyy"
                                                                        style="text-align: center" name="tglselesai" autocomplete="off"  rows="10" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label for="exampleInputEmail1" class="form-label">
                                                                    Jabatan Terakhir</label>
                                                                <input type="text" id="jabatanRpekerjaan"
                                                                    name="jabatanRpekerjaan" class="form-control"
                                                                    placeholder="Masukkan Jabatan" autocomplete="off">
                                                            </div>
                                                        </div>

                                                    </div>

                                                    {{-- KANAN --}}
                                                    <div class="col-md-6 m-t-10">

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label for="exampleInputEmail1"
                                                                    class="form-label">Level / Pangkat /
                                                                    Golongan</label>
                                                                <input type="text" id="levelRpekerjaan"
                                                                    name="levelRpekerjaan" class="form-control"
                                                                    placeholder="Masukkan Level" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label for="exampleInputEmail1"
                                                                    class="form-label">Gaji</label>
                                                                <input type="text" name="gajiRpekerjaan"
                                                                    class="form-control" id="gajih"
                                                                    placeholder="Masukkan Gaji" autocomplete="off">
                                                            </div>
                                                        </div>


                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label for="exampleInputEmail1"
                                                                    class="form-label">Alasan Berhenti</label>
                                                                <input type="text" id="alasanBerhenti"
                                                                    name="alasanBerhenti" class="form-control"
                                                                    placeholder="Masukkan Alasan Berhenti"
                                                                    autocomplete="off">

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="pull-left">
                                                    <a href="/create_data_pendidikan" class="btn btn-sm btn-info"><i
                                                            class="fa fa-backward"></i> Sebelumnya</a>
                                                </div>
                                                <div class="pull-right">
                                                    <button type="submit" name="submit"
                                                        class="btn btn-sm btn-dark"> Update Data</button>
                                                    <a href="/create_data_organisasi"
                                                        class="btn btn-sm btn-success">Selanjutnya <i
                                                            class="fa fa-forward"></i></a>
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
            var rupiah = document.getElementById('gajih');
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
                $('#formCreatePekerjaan').prop('hidden', false);
                $('#formUpdatePekerjaan').prop('hidden', true);
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
                    console.log(data.jenis_usaha, data.gaji);
                    // Isi data ke dalam form
                    $('#namaPerusahaan').val(data.nama_perusahaan);
                    $('#alamatPerusahaan').val(data.alamat);
                    $('#JenissUsaha').val(data.jenis_usaha);
                    $('#jabatanRpekerjaan').val(data.jabatan);
                    $('#levelRpekerjaan').val(data.level);
                    $('#namaAtasan').val(data.nama_atasan);
                    $('#namaDirektur').val(data.nama_direktur);
                    // $('#datepicker-autoclose33').val(data.tgl_mulai);
                    // $('#datepicker-autoclose34').val(data.tgl_selesai);
                    var tanggal = new Date(data.tgl_mulai);
                    var tanggalFormatted = ("0" + tanggal.getDate()).slice(-2) + '/' + ("0" + (tanggal
                    .getMonth() + 1)).slice(-2) + '/' + tanggal.getFullYear();
                    $('#tgl_mulai').val(tanggalFormatted);

                    var tanggal = new Date(data.tgl_selesai);
                    var tanggalFormatted = ("0" + tanggal.getDate()).slice(-2) + '/' + ("0" + (tanggal
                    .getMonth() + 1)).slice(-2) + '/' + tanggal.getFullYear();
                    $('#tgl_selesai').val(tanggalFormatted);

                    $('#alasanBerhenti').val(data.alasan_berhenti);
                    $('#gajih').val(data.gaji);
                });
            });
        </script>

        <!-- datepicker  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/pages/form-advanced.js"></script>
