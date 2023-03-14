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
            <div class="panel panel-secondary" id="riwayatpekerjaan">
                <div class="panel-heading"></div>
                <div class="content">
                    {{-- alert danger --}}
                    <div class="alert alert-danger" id="error-message" style="display: none;">
                        <button type="button" class="close" onclick="$('#error-message').hide()">&times;</button>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-20 col-sm-20 col-xs-20">
                                <form action="/storepage" method="POST" enctype="multipart/form-data">
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
                                                                <select class="form-control selectpicker" name="divisi"
                                                                    data-live-search="true" required>
                                                                    <option value="">Pilih Karyawan</option>
                                                                    {{-- @foreach ($departemen as $d)
                                                                    <option value="{{ $d->id }}" 
                                                                        {{ $karyawan->divisi == $d->id ? 'selected' : '' }}>
                                                                        {{ $d->nama_departemen ?? '' }}
                                                                    </option>
                                                                    @endforeach --}}
                                                                    <option value="">1</option>
                                                                    <option value="">1</option>
                                                                    <option value="">1</option>
                                                                </select>
                                                            </div>

                                                        </div>

                                                        <div class="col-md-6 m-t-10">

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Foto
                                                                        Karyawan</label>
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <input type="file" name="fotoKaryawan"
                                                                        id="fotoKaryawan" class="form-control"
                                                                        onchange="previewImage()">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Kartu Tanda Penduduk ( KTP )</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Kartu Keluarga ( KK )</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Nomor Pokok Wajib Pajak ( NPWP )</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">BPJS Ketenagakerjaan</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">BPJS Kesehatan ( Karyawan+Keluarga )</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Asuransi AKDHK</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Buku Tabungan Nomor Rekening & Nama Bank</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Surat Keterangan Kepolisian ( SKKB/SKCK/Lainnya )</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- baris sebelah kanan  -->

                                                        <div class="col-md-6 m-t-10">

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Ijazah Pendidikan
                                                                        Terakhir</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Formulir Lamaran Pekerjaan &
                                                                        Penawaran Pekerjaan ( Remunerasi )</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Surat Pengalaman Bekerja</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Surat Penghargaan/Prestasi</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Pendidikan & Pelatihan (
                                                                        Kursus/Seminar/Workshop/DLL )</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Surat Perjanjian Kerja (
                                                                        Karyawan Kontrak/Percobaan/Staff-Ahli )</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Surat Pengangkatan Karyawan
                                                                        Tetap</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <img class="img-preview img-fluid mb-3 col-sm-4">
                                                                    <label class="form-label">Surat Keputusan Alih-Tugas
                                                                        Jabatan</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control">
                                                                </div>
                                                            </div>


                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    {{-- <button type="submit" id="btnsimpan" name="submit" class="btn btn-sm btn-primary">Simpan</button> --}}
                                                    <button type="submit" name="submit" id="btnselanjutnya"
                                                        class="btn btn-sm btn-success">Simpan & Selanjutnya <i
                                                            class="fa fa-forward"></i></button>
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
    {{-- <script src="assets/js/jquery.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/pages/form-advanced.js"></script>

    <script>
        function previewImage() {
            const image = document.querySelector('#fotoKaryawan');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';

            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
