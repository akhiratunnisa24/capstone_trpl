<!DOCTYPE html>

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

<body class="fixed-left">

    <!-- Begin page -->
    <div id="wrapper">

        {{-- <div class="content-page"> --}}
        <!-- Start content -->
        <div class="content">
            <div class="container">
                <form action="store_pelamar" method="POST" enctype="multipart/form-data" onsubmit="return confirmSave()">
                    @csrf
                    @method('post')
                    <!-- Page-Title -->
                    <div class="row" style="margin-top: 30px">
                        <div class="col-sm-12">
                            <div class="page-header-title">
                                <h4 class="pull-left page-title">Form Penerimaan Rekruitmen</h4>
                                <ol class="breadcrumb pull-right">
                                    <li><a href="#">RYNEST TI</a></li>
                                    <li><a href="#">Form</a></li>
                                    <li class="active">Form Rekruitmen</li>
                                </ol>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Form Pelamar</h3>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">



                                            <div class="form-group">
                                                <label class="form-label">Posisi</label>
                                                <select id="posisi" class="form-control" name="posisiPelamar"
                                                    required>
                                                    <option value="">Pilih Posisi</option>
                                                    @foreach ($posisi as $d)
                                                        <option value="{{ $d->id }}">{{ $d->posisi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">NIK</label>
                                                    <input type="number" name="nikPelamar" class="form-control"
                                                        placeholder="Masukkan NIK" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama</label>
                                                    <input type="text" name="namaPelamar" class="form-control"
                                                        placeholder="Masukkan Nama" autocomplete="off" required>
                                                    <div id="emailHelp" class="form-text"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal
                                                        Lahir</label>
                                                    <div class="input-group">
                                                        <input id="datepicker-autoclose24" type="text"
                                                            class="form-control" placeholder="yyyy/mm/dd"
                                                            name="tgllahirPelamar" autocomplete="off" rows="10"
                                                            required></input><br>
                                                        <span class="input-group-addon bg-custom b-0"><i
                                                                class="mdi mdi-calendar text-white"></i></span>
                                                    </div><!-- input-group -->
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="text" name="emailPelamar" class="form-control"
                                                        placeholder="Masukkan Email" autocomplete="off" required>
                                                    <div class="form-text"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">Agama</label>
                                                    <select class="form-control" name="agamaPelamar" required>
                                                        <option value="">Pilih Agama</option>
                                                        <option value="Islam">Islam</option>
                                                        <option value="Kristen">Kristen</option>
                                                        <option value="Katholik">Katholik</option>
                                                        <option value="Hindu">Hindu</option>
                                                        <option value="Budha">Budha</option>
                                                        <option value="Khong Hu Chu">Khong Hu Chu</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Jenis Kelamin</label>
                                                <select class="form-control" name="jenis_kelaminPelamar" required>
                                                    <option value="">Pilih Jenis Kelamin</option>
                                                    <option value="L">Laki-Laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>





                                        </div>

                                        <!-- baris sebelah kanan  -->

                                        <div class="col-md-6">
                                            <div class="form-group">


                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label class="form-label">Upload CV</label>
                                                        <input type="file" name="pdfPelamar" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label class="form-label">No.
                                                            Handphone</label>
                                                        <input type="number" name="no_hpPelamar"
                                                            class="form-control"
                                                            placeholder="Masukkan Nomor Handphone" required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label class="form-label">No.
                                                            Kartu Keluarga</label>
                                                        <input type="number" name="no_kkPelamar"
                                                            class="form-control"
                                                            placeholder="Masukkan Nomor Kartu Keluarga">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            Gaji yang diharapkan IDR</label>
                                                        <input type="text" name="gajiPelamar" no_kk
                                                            class="form-control" id="gaji"
                                                            aria-describedby="emailHelp" placeholder="Masukkan Gaji"
                                                            autocomplete="off">
                                                        <div id="emailHelp" class="form-text">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label class="form-label">Alamat</label>
                                                        <textarea class="form-control" autocomplete="off" name="alamatPelamar" rows="5"></textarea><br>
                                                    </div>
                                                </div>



                                            </div>
                                        </div>


                                    </div>
                                </div>


                                <div class="modal-footer">

                                    <button type="submit" name="submit"
                                        class="btn btn-sm btn-primary">Kirim</button>
                                    <a href="karyawan" class="btn btn-sm btn-danger">Kembali</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</body>

<script>
function confirmSave() {
    return confirm("Apakah Anda yakin ingin mengirim data?");
}
</script>

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

<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
{{-- plugin js --}}
<script src="assets/plugins/timepicker/bootstrap-timepicker.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<!-- Plugins Init js -->
<script src="assets/pages/form-advanced.js"></script>




