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
        <!-- Start content -->
        <div class="content">

            <div class="container">
                <form action="store_pelamar" method="POST" enctype="multipart/form-data"
                    onsubmit="return confirmSave()">
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
                        <div class="col-sm-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3 class="panel-title">A. IDENTITAS DIRI</h3>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-12">



                                            <div class="form-group" id="posisi">
                                                <label class="form-label">Posisi</label>
                                                <select class="form-control" name="posisiPelamar" required
                                                    onchange="getPersyaratan(this.value)">
                                                    <option value="">Pilih Posisi</option>
                                                    @foreach ($posisi as $d)
                                                        <option value="{{ $d->id }}">{{ $d->posisi }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">Persyaratan</label>
                                                    <textarea name="persyaratan" id="persyaratan" type="text" class="form-control" placeholder="" readonly
                                                        rows="9"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">NO. KTP</label>
                                                    <input type="number" name="nikPelamar" class="form-control"
                                                        placeholder="Masukkan No. KTP   "
                                                        value="{{ $pelamar->nik ?? '' }}" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">Nama Lengkap</label>
                                                    <input type="text" name="namaPelamar" class="form-control"
                                                        placeholder="Masukkan Nama Lengkap" autocomplete="off"
                                                        value="{{ $pelamar->nama ?? '' }}" required>
                                                    <div id="emailHelp" class="form-text"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">Tanggal Lahir</label>
                                                    <div class="input-group">
                                                        <input id="datepicker-autoclose34" type="text"
                                                            class="form-control" placeholder="yyyy/mm/dd"
                                                            name="tgllahirPelamar" autocomplete="off" rows="10"
                                                            value="{{ $pelamar->tgllahir ?? '' }}" required><br>
                                                        <span class="input-group-addon bg-custom b-0"><i
                                                                class="mdi mdi-calendar text-white"></i></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">Tempat Lahir</label>
                                                    <input type="text" name="tempatlahirPelamar"
                                                        class="form-control" placeholder="Masukkan Tempat Lahir"
                                                        autocomplete="off" value="{{ $pelamar->tempatlahir ?? '' }}">
                                                    <div id="emailHelp" class="form-text"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">Jenis Kelamin</label>
                                                    <select class="form-control" name="jenis_kelaminPelamar" required>
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option value="Laki-Laki"
                                                            @if ($pelamar->jenis_kelamin == 'Laki-Laki') selected @endif>Laki-Laki
                                                        </option>
                                                        <option value="Perempuan"
                                                            @if ($pelamar->jenis_kelamin == 'Perempuan') selected @endif>Perempuan
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label class="form-label">Golongan Darah</label>
                                                    <select class="form-control" name="gol_darahPelamar">
                                                        <option value="">Pilih Golongan Darah</option>
                                                        <option value="A"
                                                            @if ($pelamar->gol_darah == 'A') selected @endif>A</option>
                                                        <option value="B"
                                                            @if ($pelamar->gol_darah == 'B') selected @endif>B</option>
                                                        <option value="AB"
                                                            @if ($pelamar->gol_darah == 'AB') selected @endif>AB
                                                        </option>
                                                        <option value="O"
                                                            @if ($pelamar->gol_darah == 'O') selected @endif>O</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="form-label">Alamat</label>
                                                <textarea class="form-control" autocomplete="off" name="alamatPelamar" rows="5">{{ $pelamar->alamat ?? '' }}</textarea>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label for="exampleInputEmail1" class="form-label">Status
                                                        Pernikahan</label>
                                                    <select class="form-control selectpicker" name="status_pernikahan"
                                                        required>
                                                        <option value="">Pilih Status Pernikahan</option>
                                                        <option value="Sudah Menikah"
                                                            @if ($pelamar->status_pernikahan == 'Sudah Menikah') selected @endif>Sudah
                                                            Menikah</option>
                                                        <option value="Belum Menikah"
                                                            @if ($pelamar->status_pernikahan == 'Belum Menikah') selected @endif>Belum
                                                            Menikah</option>
                                                        <option value="Duda"
                                                            @if ($pelamar->status_pernikahan == 'Duda') selected @endif>Duda
                                                        </option>
                                                        <option value="Janda"
                                                            @if ($pelamar->status_pernikahan == 'Janda') selected @endif>Janda
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="mb-3">
                                                    <label for="exampleInputEmail1" class="form-label">Jumlah Anak
                                                        *</label>
                                                    <input type="number" name="jumlahAnak" class="form-control"
                                                        autocomplete="off" placeholder="Masukkan Jumlah Anak"
                                                        value="{{ $pelamar->jumlah_anak ?? '' }}">
                                                </div>
                                            </div>

                                        </div>

                                        <!-- baris sebelah kanan  -->

                                        <div class="col-md-6">
                                            <div class="form-group">



                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label class="form-label">No. Handphone</label>
                                                        <input type="number" name="no_hpPelamar"
                                                            class="form-control"
                                                            placeholder="Masukkan Nomor Handphone"
                                                            value="{{ $pelamar->no_hp ?? '' }}" required>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label class="form-label">Email</label>
                                                        <input type="text" name="emailPelamar"
                                                            class="form-control" placeholder="Masukkan Email"
                                                            autocomplete="off" value="{{ $pelamar->email ?? '' }}"
                                                            required>
                                                        <div class="form-text"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label class="form-label">Agama</label>
                                                        <select class="form-control" name="agamaPelamar" required>
                                                            <option value="">Pilih Agama</option>
                                                            <option value="Islam"
                                                                @if ($pelamar->agama == 'Islam') selected @endif>
                                                                Islam</option>
                                                            <option value="Kristen"
                                                                @if ($pelamar->agama == 'Kristen') selected @endif>
                                                                Kristen</option>
                                                            <option value="Katholik"
                                                                @if ($pelamar->agama == 'Katholik') selected @endif>
                                                                Katholik</option>
                                                            <option value="Hindu"
                                                                @if ($pelamar->agama == 'Hindu') selected @endif>
                                                                Hindu</option>
                                                            <option value="Budha"
                                                                @if ($pelamar->agama == 'Budha') selected @endif>
                                                                Budha</option>
                                                            <option value="Khong Hu Chu"
                                                                @if ($pelamar->agama == 'Khong Hu Chu') selected @endif>
                                                                Khong Hu Chu</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label class="form-label">No. Kartu Keluarga *</label>
                                                        <input type="number" name="no_kkPelamar"
                                                            class="form-control" value="{{ $pelamar->no_kk ?? '' }}"
                                                            placeholder="Masukkan Nomor Kartu Keluarga">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">No. NPWP
                                                            *</label>
                                                        <input type="text" name="nonpwpPelamar"
                                                            class="form-control"
                                                            value="{{ $pelamar->no_npwp ?? '' }}"
                                                            placeholder="Masukkan No. NPWP">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">No. BPJS
                                                            Ketenagakerjaan *</label>
                                                        <input type="number" name="nobpjsketPelamar"
                                                            class="form-control"
                                                            value="{{ $pelamar->no_bpjs_ket ?? '' }}"
                                                            placeholder="Masukkan No. BPJS Ketenagakerjaan">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">No.
                                                            BPJSKesehatan *</label>
                                                        <input type="number" name="nobpjskesPelamar"
                                                            class="form-control"
                                                            value="{{ $pelamar->no_bpjs_kes ?? '' }}"
                                                            placeholder="Masukkan No. BPJS Kesehatan">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">No.
                                                            Asuransi AKDHK *</label>
                                                        <input type="number" name="noAkdhk" class="form-control"
                                                            value="{{ $pelamar->no_akdhk ?? '' }}"
                                                            placeholder="Masukkan No. AKDHK">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">No. Program
                                                            Pensiun *</label>
                                                        <input type="number" name="noprogramPensiun"
                                                            class="form-control"
                                                            value="{{ $pelamar->no_program_pensiun ?? '' }}"
                                                            placeholder="Masukkan No. Program Pensiun">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">No. Program
                                                            ASKES *</label>
                                                        <input type="number" name="noprogramAskes"
                                                            class="form-control"
                                                            value="{{ $pelamar->no_program_askes ?? '' }}"
                                                            placeholder="Masukkan No. Program ASKES">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">Nama Bank
                                                            *</label>
                                                        <select class="form-control selectpicker" name="nama_bank"
                                                            required>
                                                            <option value="">Pilih Bank</option>
                                                            <option value="Bank ANZ Indonesia"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank ANZ Indonesia' ? 'selected' : '' }}>
                                                                Bank ANZ Indonesia</option>
                                                            <option value="Bank Bukopin"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Bukopin' ? 'selected' : '' }}>
                                                                Bank Bukopin</option>
                                                            <option value="Bank Central Asia (BCA)"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Central Asia (BCA)' ? 'selected' : '' }}>
                                                                Bank Central Asia (BCA)</option>
                                                            <option value="Bank Danamon"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Danamon' ? 'selected' : '' }}>
                                                                Bank Danamon</option>
                                                            <option value="Bank DBS Indonesia"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank DBS Indonesia' ? 'selected' : '' }}>
                                                                Bank DBS Indonesia</option>
                                                            <option value="Bank HSBC Indonesia"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank HSBC Indonesia' ? 'selected' : '' }}>
                                                                Bank HSBC Indonesia</option>
                                                            <option value="Bank Jabar Banten (BJB)"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Jabar Banten (BJB)' ? 'selected' : '' }}>
                                                                Bank Jabar Banten (BJB)</option>
                                                            <option value="Bank Mandiri"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Mandiri' ? 'selected' : '' }}>
                                                                Bank Mandiri</option>
                                                            <option value="Bank Maybank"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Maybank' ? 'selected' : '' }}>
                                                                Bank Maybank</option>
                                                            <option value="Bank Mega"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Mega' ? 'selected' : '' }}>
                                                                Bank Mega</option>
                                                            <option value="Bank Muamalat"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Muamalat' ? 'selected' : '' }}>
                                                                Bank Muamalat</option>
                                                            <option value="Bank Negara Indonesia (BNI)"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Negara Indonesia (BNI)' ? 'selected' : '' }}>
                                                                Bank Negara Indonesia (BNI)</option>
                                                            <option value="Bank OCBC NISP"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank OCBC NISP' ? 'selected' : '' }}>
                                                                Bank OCBC NISP</option>
                                                            <option value="Bank Panin"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Panin' ? 'selected' : '' }}>
                                                                Bank Panin</option>
                                                            <option value="Bank Permata"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Permata' ? 'selected' : '' }}>
                                                                Bank Permata</option>
                                                            <option value="Bank Rakyat Indonesia (BRI)"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Rakyat Indonesia (BRI)' ? 'selected' : '' }}>
                                                                Bank Rakyat Indonesia (BRI)</option>
                                                            <option value="Bank Syariah Mandiri"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Syariah Mandiri' ? 'selected' : '' }}>
                                                                Bank Syariah Mandiri</option>
                                                            <option value="Bank Tabungan Negara (BTN)"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank Tabungan Negara (BTN)' ? 'selected' : '' }}>
                                                                Bank Tabungan Negara (BTN)</option>
                                                            <option value="Bank UOB Indonesia"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank UOB Indonesia' ? 'selected' : '' }}>
                                                                Bank UOB Indonesia</option>
                                                            <option value="Bank CIMB Niaga"
                                                                {{ $karyawan->nama_bank ?? '' == 'Bank CIMB Niaga' ? 'selected' : '' }}>
                                                                Bank CIMB Niaga</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label for="exampleInputEmail1" class="form-label">No.
                                                            Rekening *</label>
                                                        <input type="number" name="norekPelamar"
                                                            class="form-control" value="{{ $pelamar->no_rek ?? '' }}"
                                                            placeholder="Masukkan No. Rekening">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label class="form-label">Gaji yang diharapkan IDR</label>
                                                        <input type="text" name="gajiPelamar" class="form-control"
                                                            id="gaji" aria-describedby="emailHelp"
                                                            placeholder="Masukkan Gaji" autocomplete="off"
                                                            value="{{ $pelamar->gaji ?? '' }}">
                                                        <div id="emailHelp" class="form-text">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="mb-3">
                                                        <label class="form-label">Upload CV</label>
                                                        <input type="file" name="pdfPelamar" class="form-control"
                                                            value="{{ $pelamar->cv ?? '' }}" required>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
                                </div>


                                <div class="modal-footer">

                                    <button type="submit" name="submit" class="btn btn-sm btn-primary">Simpan &
                                        Selanjutnya</button>
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
    const inputElement = document.querySelector('input[name="pdfPelamar"]');

    inputElement.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const fileType = file.type;

        if (fileType !== 'application/pdf') {
            alert('File yang diunggah harus berupa file PDF.');
            inputElement.value = '';
        }
    });
</script>

<script>
    function getPersyaratan(lowongan_id) {
        $.ajax({
            url: '/get-persyaratan/' + lowongan_id,
            type: 'GET',
            success: function(response) {
                $('#persyaratan').val(response.persyaratan);
            }
        });
    }
</script>


<!-- script untuk mengambil data Persyaratan  -->
<script>
    $('#posisi').on('change', function(e) {
        var posisi = e.target.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                    .attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{ route('getPersyaratan') }}',
            data: {
                'posisi': posisi
            },
            success: function(data) {
                // console.log(data);
                $('#persyaratan').val(data.persyaratan);
                console.log(data?.persyaratan)
            }
        });
    });
</script>

<script>
    $('#id_pegawai2').on('change', function(e) {
        var id_pegawai = e.target.value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                    .attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: '{{ route('getPersyaratan') }}',
            data: {
                'id_pegawai': id_pegawai
            },
            success: function(data) {
                // console.log(data);
                $('#emailKaryawan2').val(data.persyaratan);
                console.log(data?.persyaratan)
            }
        });
    });
</script>


<script>
    function confirmSave() {
        return confirm("Apakah Anda yakin?");
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




{{-- @endsection --}}
