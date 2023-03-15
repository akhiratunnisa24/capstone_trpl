@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title ">Upload File Digital</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Upload File Digital</li>
                </ol>

                <div class="clearfix">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-secondary">
                <div class="panel-heading"></div>
                <div class="content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20">
                                <form action="/storeupload" method="POST" enctype="multipart/form-data" onsubmit="myFunction()">
                                    @csrf
                                    @method('post')
                                    <div class="control-group after-add-more">

                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div>
                                                            <div
                                                                class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                <label class="text-white m-b-10">UPLOAD FILE DIGITAL</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 m-t-10">
                                                            <div class="form-group">
                                                                <label for="exampleInputEmail1"
                                                                    class="form-label">Karyawan</label>
                                                                <select class="form-control selectpicker" name="karyawan"
                                                                    data-live-search="true" required>
                                                                    <option value="">Pilih Karyawan</option>
                                                                    @foreach ($karyawan as $k)
                                                                        <option value="{{ $k->id }}">
                                                                            {{ $k->nama }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-6 m-t-10">

                                                            {{-- <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Foto
                                                                        Karyawan</label>
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoKaryawan"
                                                                        id="fotoKaryawan" class="form-control"
                                                                        onchange="previewImage()">
                                                                </div>
                                                            </div> --}}

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Kartu Tanda Penduduk ( KTP )</label>
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoKTP" id="fotoKTP"
                                                                        class="form-control" onchange="previewImage()">
                                                                        
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Kartu Keluarga ( KK )</label>
                                                                    <img class="img-preview2 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoKK" id="fotoKK"
                                                                        class="form-control" onchange="previewImageKK()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Nomor Pokok Wajib Pajak ( NPWP )</label>
                                                                    <img class="img-preview3 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoNPWP" id="fotoNPWP"
                                                                        class="form-control" onchange="previewImageNPWP()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">BPJS Ketenagakerjaan</label>
                                                                    <img class="img-preview4 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoBPJSket" id="fotoBPJSket"
                                                                        class="form-control" onchange="previewImageBPJSket()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">BPJS Kesehatan ( Karyawan + Keluarga )</label>
                                                                    <img class="img-preview5 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoBPJSkes" id="fotoBPJSkes"
                                                                        class="form-control" onchange="previewImageBPJSkes()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Asuransi AKDHK</label>
                                                                    <img class="img-preview6 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoAKDHK" id="fotoAKDHK"
                                                                        class="form-control" onchange="previewImageAKDHK()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Buku Tabungan Nomor Rekening & Nama Bank</label>
                                                                    <img class="img-preview7 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoTabungan" id="fotoTabungan"
                                                                        class="form-control" onchange="previewImageTabungan()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Keterangan Kepolisian ( SKKB/SKCK/Lainnya )</label>
                                                                    <img class="img-preview8 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoSKCK" id="fotoSKCK"
                                                                        class="form-control" onchange="previewImageSKCK()">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- baris sebelah kanan  -->

                                                        <div class="col-md-6 m-t-10">

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Ijazah Pendidikan Terakhir</label>
                                                                        <img class="img-preview9 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoIjazah" id="fotoIjazah"
                                                                        class="form-control" onchange="previewImageIjazah()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Formulir Lamaran & Penawaran Pekerjaan ( Remunerasi )</label>
                                                                    <img class="img-preview10 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoLamaran" id="fotoLamaran"
                                                                        class="form-control" onchange="previewImageLamaran()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Pengalaman Bekerja</label>
                                                                    <img class="img-preview11 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoSuratPengalaman" id="fotoSuratPengalaman"
                                                                        class="form-control" onchange="previewImagePengalaman()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Penghargaan/Prestasi</label>
                                                                    <img class="img-preview12 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoSuratPrestasi" id="fotoSuratPrestasi"
                                                                        class="form-control" onchange="previewImagePrestasi()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Pendidikan & Pelatihan ( Kursus/Seminar/Workshop/DLL )</label>
                                                                    <img class="img-preview13 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoSuratPendidikan" id="fotoSuratPendidikan"
                                                                        class="form-control" onchange="previewImagePendidikan()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Perjanjian Kerja ( Kontrak/Percobaan/Staff-Ahli )</label>
                                                                    <img class="img-preview14 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoPerjanjianKerja" id="fotoPerjanjianKerja"
                                                                        class="form-control" onchange="previewImagePerjanjianKerja()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Pengangkatan Karyawan Tetap</label>
                                                                    <img class="img-preview15 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoSuratPengangkatan" id="fotoSuratPengangkatan"
                                                                        class="form-control" onchange="previewImagePengangkatan()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Keputusan Alih-Tugas Jabatan</label>
                                                                    <img class="img-preview16 img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoSuratKeputusan" id="fotoSuratKeputusan"
                                                                        class="form-control" onchange="previewImageKeputusan()">
                                                                </div>
                                                            </div>


                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" name="submit" id="simpan"
                                                        class="btn btn-sm btn-success">Simpan</button>
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

    <script>
  function myFunction() {
    alert("Data berhasil disimpan !");
  }
</script>

{{-- Script Preview Image --}}
<script>
        function previewImage() {
            const image = document.querySelector('#fotoKTP',);
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImageKK() {
            const image = document.querySelector('#fotoKK',);
            const imgPreview = document.querySelector('.img-preview2');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImageNPWP() {
            const image = document.querySelector('#fotoNPWP',);
            const imgPreview = document.querySelector('.img-preview3');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImageBPJSket() {
            const image = document.querySelector('#fotoNPWP',);
            const imgPreview = document.querySelector('.img-preview4');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImageBPJSkes() {
            const image = document.querySelector('#fotoBPJSkes',);
            const imgPreview = document.querySelector('.img-preview5');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImageAKDHK() {
            const image = document.querySelector('#fotoAKDHK',);
            const imgPreview = document.querySelector('.img-preview6');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImageTabungan() {
            const image = document.querySelector('#fotoTabungan',);
            const imgPreview = document.querySelector('.img-preview7');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImageSKCK() {
            const image = document.querySelector('#fotoSKCK',);
            const imgPreview = document.querySelector('.img-preview8');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImageIjazah() {
            const image = document.querySelector('#fotoIjazah',);
            const imgPreview = document.querySelector('.img-preview9');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImageLamaran() {
            const image = document.querySelector('#fotoLamaran',);
            const imgPreview = document.querySelector('.img-preview10');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImagePengalaman() {
            const image = document.querySelector('#fotoSuratPengalaman',);
            const imgPreview = document.querySelector('.img-preview11');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImagePrestasi() {
            const image = document.querySelector('#fotoSuratPrestasi',);
            const imgPreview = document.querySelector('.img-preview12');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImagePendidikan() {
            const image = document.querySelector('#fotoSuratPendidikan',);
            const imgPreview = document.querySelector('.img-preview13');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImagePerjanjianKerja() {
            const image = document.querySelector('#fotoPerjanjianKerja',);
            const imgPreview = document.querySelector('.img-preview14');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

         function previewImagePengangkatan() {
            const image = document.querySelector('#fotoSuratPengangkatan',);
            const imgPreview = document.querySelector('.img-preview15');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        function previewImageKeputusan() {
            const image = document.querySelector('#fotoSuratKeputusan',);
            const imgPreview = document.querySelector('.img-preview16');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

</script>
   
    
@endsection
