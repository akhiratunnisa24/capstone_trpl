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
                <h4 class="pull-left page-title ">Detail Karyawan</h4>

                <ol class="breadcrumb pull-right">
                    <li>Human Resources Management System</li>
                    <li class="active">Detail Karyawan</li>
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
                                {{-- <form action="/storepage" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('post') --}}
                                    <div class="control-group after-add-more">
                                    
                                        <div class="modal-body">
                                            <table class="table table-bordered table-striped">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div>
                                                            <div class="modal-header bg-info panel-heading  col-sm-15 m-b-5">
                                                                <label class="text-white">A. IDENTITAS DIRI</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 m-t-10">

                                                            
                                                            <div class="row">
                                                            <div class="form-group">
                                                                <div class="mb-3 col-sm-12 text-center">
                                                                    <label  class="form-label ">Foto Karyawan</label>
                                                                </div>
                                                                <div class="mb-3 col-sm-12 text-center">
                                                                <img src="{{ asset('Foto_Profile/'.$karyawan->foto) }}" style="width:299px;" >
                                                                </div>
                                                            </div>
                                                            </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">NIP Karyawan</label>
                                                                        <label class="form-control" >{{ $karyawan->nip ?? '-' }}</label>
                                                                    </div>
                                                                </div>

                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Nama Lengkap</label>
                                                                    <label class="form-control">{{ $karyawan->nama ?? '-' }}</label>
                                                                </div>
                                                            </div>
                        
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tanggal Lahir</label>
                                                                    <label class="form-control">{{\Carbon\Carbon::parse($karyawan->tgllahir)->format('d/m/Y') ?? '-' }}</label>
                                                                </div>
                                                            </div>
                        
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label  class="form-label">Tempat Lahir</label>
                                                                    <label class="form-control">{{ $karyawan->tempatlahir ?? '-' }}</label>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label  class="form-label">Jenis Kelamin</label>@if($karyawan->jenis_kelamin == 'Perempuan')<label class="form-control" >Perempuan</label>
                                                                @else
                                                                <label class="form-control">Laki-Laki</label>
                                                                @endif
                                                            </div>  
                        
                                                            <div class="form-group">
                                                                <label  class="form-label">Divisi</label>
                                                                <label class="form-control">{{ $karyawan->departemen->nama_departemen ?? '-' }}</label>
                                                            </div>
                        
                                                            <div class="form-group">
                                                                <label  class="form-label">Atasan Langsung (Asisten Manager/Manager/Direktur)</label>
                                                                <label class="form-control">{{ $karyawan->atasan_pertamaa->nama ?? '-' }}</label>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label  class="form-label">Atasan/Pimpinan (Manager/Direktur)</label>
                                                                <label class="form-control">{{ $karyawan->atasan_keduab->nama ?? '-' }}</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label  class="form-label">Nama Jabatan</label>
                                                                <label class="form-control">{{ $karyawan->nama_jabatan ?? '-' }}</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label  class="form-label">Level Jabatan</label>
                                                                <label class="form-control">{{ $karyawan->jabatan ?? '-' }}</label>
                                                            </div>

                                                            <div class="form-group">
                                                                <label  class="form-label">Status Karyawan</label>
                                                                <label class="form-control">{{ $karyawan->status_karyawan ?? '-' }}</label>
                                                            </div>

                                                            <div class="form-group">
                                                                    <label  class="form-label">Golongan Darah</label>
                                                                    <label class="form-control">{{ $karyawan->gol_darah ?? '-' }}</label>
                                                                </div>

                                                                
                        
                                                            <div class="form-group">
                                                                <div class="mb-3">
                                                                    <label  class="form-label">Alamat</label>
                                                                    <textarea class="form-control" rows="5" readonly>{{ $karyawan->alamat ?? '' }}</textarea>
                                                                </div>
                                                            </div>

                                                        </div>
                        
                                                        <!-- baris sebelah kanan  -->
                        
                                                        <div class="col-md-6 m-t-10">
                                                            <div class="form-group">

                                                                
                        
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                    <label  class="form-label">Status Pernikahan</label>
                                                                   <label class="form-control">{{ $karyawan->status_pernikahan ?? '-' }}</label>
                                                                </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                    <label  class="form-label">Jumlah Anak</label>
                                                                    <label class="form-control">{{ $karyawan->jumlah_anak ?? '-' }}</label>
                                                                </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">No. Handphone</label>
                                                                        <label class="form-control">{{ $karyawan->no_hp ?? '-' }}</label>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">Alamat E-mail</label>
                                                                        <label class="form-control">{{ $karyawan->email ?? '-' }}</label>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Agama</label>
                                                                        <label class="form-control">{{ $karyawan->agama ?? '-' }}</label>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">Tanggal Masuk</label>
                                                                        <label class="form-control">{{ \Carbon\Carbon::parse($karyawan->tglmasuk)->format('d/m/Y') ?? '-' }}</label>
                                                                    </div>
                                                                </div>
                        
                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">No. KTP</label>
                                                                        <label class="form-control">{{ $karyawan->nik ?? '-' }}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">No. Kartu Keluarga</label>
                                                                        <label class="form-control">{{ $karyawan->no_kk ?? '-' }}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">No. NPWP</label>
                                                                        <label class="form-control">{{ $karyawan->no_npwp ?? '-' }}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">No. BPJS Ketenagakerjaan</label>
                                                                        <label class="form-control">{{ $karyawan->no_bpjs_ket ?? '-' }}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">No. BPJS Kesehatan</label>
                                                                        <label class="form-control">{{ $karyawan->no_bpjs_kes ?? '-' }}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">No. Asuransi AKDHK</label>
                                                                        <label class="form-control">{{ $karyawan->no_akdhk ?? '-' }}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">No. Program Pensiun</label>
                                                                        <label class="form-control">{{ $karyawan->no_program_pensiun ?? '-' }}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">No. Program ASKES</label>
                                                                        <label class="form-control">{{ $karyawan->no_program_askes ?? '-' }}</label>
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                    <label  class="form-label">Nama Bank</label>
                                                                    <label class="form-control">{{ $karyawan->nama_bank ?? '-' }}</label>
                                                                </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <div class="mb-3">
                                                                        <label  class="form-label">No. Rekening</label>
                                                                        <label class="form-control">{{ $karyawan->no_rek ?? '-' }}</label>
                                                                    </div>
                                                                </div>
                                                                
                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">

                                                    <a href="editidentitas{{ $karyawan->id }}" class="btn btn-sm btn-primary" type="button">Edit Data <i class="fa fa-edit"></i></a>
                                                    
                                                    {{-- <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateIdentitas{{$karyawan->id}}" >
                                                    <i class="fa fa-edit"> <strong>Edit Identitas Diri</strong></i></a> --}}
                                                    {{-- @include('admin.karyawan.editIdentitas') --}}
                                                    <a href="showpendidikan{{ $karyawan->id }}" class="btn btn-sm btn-success" type="button">Selanjutnya <i class="fa fa-forward"></i></a>
                                                </div>
                                            </table>
                                        </div>
                                    </div>
                                {{-- </form> --}}
                            </div>
                        </div> 
                    </div> 
                </div> 
            </div> 
        </div>
    </div>  


@endsection