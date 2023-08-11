@extends('layouts.default')
@section('content')
    <!-- Header -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-header-title">
                <h4 class="pull-left page-title ">Open File Digital</h4>

                <ol class="breadcrumb pull-right">
                    <li>Rynest Employees Management System</li>
                    <li class="active">Open File Digital</li>
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
                                <form action="/storeupload" method="POST" enctype="multipart/form-data"
                                    onsubmit="myFunction()">
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
                                                                <label
                                                                    class="text-white m-b-10">{{ $karyawan->nama }}</label>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-6 m-t-10">

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Kartu Tanda Penduduk (
                                                                    KTP )</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->ktp))
                                                                        <a href="{{ asset('File_KTP/' . $file->ktp) }}"
                                                                            class="btn btn-sm btn-primary "
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Kartu Keluarga ( KK
                                                                    )</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->kk))
                                                                        <a href="{{ asset('File_KK/' . $file->kk) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Nomor Pokok Wajib Pajak
                                                                    ( NPWP )</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->npwp))
                                                                        <a href="{{ asset('File_NPWP/' . $file->npwp) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">BPJS
                                                                    Ketenagakerjaan</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->bpjs_ket))
                                                                        <a href="{{ asset('File_BPJSKet/' . $file->bpjs_ket) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">BPJS Kesehatan (
                                                                    Karyawan + Keluarga )</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->bpjs_kes))
                                                                        <a href="{{ asset('File_BPJSKes/' . $file->bpjs_kes) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Asuransi AKDHK</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->as_akdhk))
                                                                        <a href="{{ asset('File_AKDHK/' . $file->as_akdhk) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Buku Tabungan Nomor
                                                                    Rekening & Nama Bank</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->buku_tabungan))
                                                                        <a href="{{ asset('File_Tabungan/' . $file->buku_tabungan) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Surat Keterangan
                                                                    Kepolisian ( SKKB/SKCK/Lainnya )</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->skck))
                                                                        <a href="{{ asset('File_SKCK/' . $file->skck) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <!-- baris sebelah kanan  -->

                                                    <div class="col-md-6 m-t-10">

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Ijazah Pendidikan
                                                                    Terakhir</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->ijazah))
                                                                        <a href="{{ asset('File_Ijazah/' . $file->ijazah) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Formulir Lamaran &
                                                                    Penawaran Pekerjaan ( Remunerasi )</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->lamaran))
                                                                        <a href="{{ asset('File_Lamaran/' . $file->lamaran) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Surat Pengalaman
                                                                    Bekerja</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->surat_pengalaman_kerja))
                                                                        <a href="{{ asset('File_Pengalaman/' . $file->surat_pengalaman_kerja) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Surat
                                                                    Penghargaan/Prestasi</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->surat_penghargaan))
                                                                        <a href="{{ asset('File_Prestasi/' . $file->surat_penghargaan) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Pendidikan & Pelatihan
                                                                    ( Kursus/Seminar/Workshop/DLL )</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->surat_pelatihan))
                                                                        <a href="{{ asset('File_Pendidikan/' . $file->surat_pelatihan) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Surat Perjanjian Kerja
                                                                    ( Kontrak/Percobaan/Staff-Ahli )</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->surat_perjanjian_kerja))
                                                                        <a href="{{ asset('File_Perjanjian/' . $file->surat_perjanjian_kerja) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Surat Pengangkatan
                                                                    Karyawan Tetap</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->surat_pengangkatan_kartap))
                                                                        <a href="{{ asset('File_Pengangkatan/' . $file->surat_pengangkatan_kartap) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="mb-3">
                                                                <label class="form-label col-sm-12">Surat Keputusan
                                                                    Alih-Tugas Jabatan</label>
                                                                <div class="col-sm-9">
                                                                    @if (!empty($file->surat_alih_tugas))
                                                                        <a href="{{ asset('File_Keputusan/' . $file->surat_alih_tugas) }}"
                                                                            class="btn btn-sm btn-primary"
                                                                            target='_blank'>Lihat File</a>
                                                                    @else
                                                                        <p style="color: red;">File tidak tersedia.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            {{-- <a href="editfile{{ $karyawan->id }}" class="btn btn-sm btn-primary" type="button">Edit Data <i class="fa fa-edit"></i></a> --}}
                                            @if (!isset($file))
                                                <a href="/karyawanupload{{ $karyawan->id }}"
                                                    class="btn btn-sm btn-success"> Upload Data <i
                                                        class="fa fa-upload"></i> </a>
                                            @elseif (isset($file))
                                                <a href="editfile{{ $karyawan->id }}" class="btn btn-sm btn-primary"
                                                    type="button">Edit Data <i class="fa fa-edit"></i></a>
                                            @endif
                                            {{-- @if (!empty($file->surat_pengangkatan_kartap)) --}}
                                            {{-- <a href="editfile{{ $karyawan->id }}" class="btn btn-sm btn-primary" type="button" <?php echo $file === null ? 'disabled' : ''; ?>>Edit Data <i class="fa fa-edit"></i></a> --}}
                                            <a href="karyawan" class="btn btn-sm btn-danger" type="button">Kembali <i
                                                    class="fa fa-home"></i></a>
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
@endsection
