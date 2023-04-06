@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title ">Edit File Digital</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Edit File Digital</li>
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
                                <form action="/updatefile{{ $karyawan->id }}" method="POST" enctype="multipart/form-data" onsubmit="myFunction()">
                                    @csrf
                                    @method('PUT')
                                    <div class="control-group after-add-more">

                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div>
                                                            <div
                                                                class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                <label class="text-white m-b-10">EDIT FILE DIGITAL</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 m-t-10">
                                                           

                                                        </div>

                                                        <div class="col-md-6 m-t-10">

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Kartu Tanda Penduduk ( KTP )</label>
                                                                    <label class="form-label col-sm-12">{{ $file->ktp ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoKTP" id="fotoKTP" class="form-control" >    
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Kartu Keluarga ( KK )</label>
                                                                    <label class="form-label col-sm-12">{{ $file->kk ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoKK" id="fotoKK" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Nomor Pokok Wajib Pajak ( NPWP )</label>
                                                                    <label class="form-label col-sm-12">{{ $file->npwp ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoNPWP" id="fotoNPWP" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">BPJS Ketenagakerjaan</label>
                                                                    <label class="form-label col-sm-12">{{ $file->bpjs_ket ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoBPJSket" id="fotoBPJSket" class="form-control" >
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">BPJS Kesehatan ( Karyawan + Keluarga )</label>
                                                                    <label class="form-label col-sm-12">{{ $file->bpjs_kes ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoBPJSkes" id="fotoBPJSkes" class="form-control" >
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Asuransi AKDHK</label>
                                                                    <label class="form-label col-sm-12">{{ $file->as_akdhk ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoAKDHK" id="fotoAKDHK" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Buku Tabungan Nomor Rekening & Nama Bank</label>
                                                                    <label class="form-label col-sm-12">{{ $file->buku_tabungan ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoTabungan" id="fotoTabungan" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Keterangan Kepolisian ( SKKB/SKCK/Lainnya )</label>
                                                                    <label class="form-label col-sm-12">{{ $file->skck ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoSKCK" id="fotoSKCK" class="form-control" >
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- baris sebelah kanan  -->

                                                        <div class="col-md-6 m-t-10">

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Ijazah Pendidikan Terakhir</label>
                                                                    <label class="form-label col-sm-12">{{ $file->ijazah ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoIjazah" id="fotoIjazah" class="form-control" >
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Formulir Lamaran & Penawaran Pekerjaan ( Remunerasi )</label>
                                                                    <label class="form-label col-sm-12">{{ $file->lamaran ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoLamaran" id="fotoLamaran" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Pengalaman Bekerja</label>
                                                                    <label class="form-label col-sm-12">{{ $file->surat_pengalaman_kerja ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoSuratPengalaman" id="fotoSuratPengalaman" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Penghargaan/Prestasi</label>
                                                                    <label class="form-label col-sm-12">{{ $file->surat_penghargaan ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoSuratPrestasi" id="fotoSuratPrestasi" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Pendidikan & Pelatihan ( Kursus/Seminar/Workshop/DLL )</label>
                                                                    <label class="form-label col-sm-12">{{ $file->surat_pelatihan ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoSuratPendidikan" id="fotoSuratPendidikan" class="form-control" >
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Perjanjian Kerja ( Kontrak/Percobaan/Staff-Ahli )</label>
                                                                    <label class="form-label col-sm-12">{{ $file->surat_perjanjian_kerja ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoPerjanjianKerja" id="fotoPerjanjianKerja" class="form-control" >
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Pengangkatan Karyawan Tetap</label>
                                                                    <label class="form-label col-sm-12">{{ $file->surat_pengangkatan_kartap ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoSuratPengangkatan" id="fotoSuratPengangkatan" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label col-sm-12">Surat Keputusan Alih-Tugas Jabatan</label>
                                                                    <label class="form-label col-sm-12">{{ $file->surat_alih_tugas ?? 'File tidak tersedia.' }}</label>
                                                                    <input type="file" name="fotoSuratKeputusan" id="fotoSuratKeputusan" class="form-control" >
                                                                </div>
                                                            </div>


                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                            <a href="showfile{{ $karyawan->id }}" class="btn btn-sm btn-danger" type="button">Kembali <i class="fa fa-home"></i></a>
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
   
    
@endsection
