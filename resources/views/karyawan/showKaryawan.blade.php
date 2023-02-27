@extends('layouts.default')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="page-header-title">
            <div class="flex-grow-1 mt-1 ms-4 col-mb-12 d-flex">
                <div class="row col-mb-12" style="margin-left:20px">
                    <a href="" class="dropdown-toggle profile waves-effect waves-light pull-left"><img src="{{ asset('Foto_Profile/' . $karyawan->foto)}}" alt="user-img" class="img-circle" style="width:80px;height:80px"> </a>
                    <div class="col-md-7 pull-left m-t-10">
                        <span class="text-muted font-size-14">Selamat Datang,</span>
                        <span class="text-muted d-block mb-2"><h4 class="fw-bolder mb-3">{{$karyawan->nama}}</h4></span>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="panel panel-primary" style="border-radius:30px">
            <div class="panel-body">
                <div class="row col-mb-12" style="margin-left:10px">
                     <a href=""><i class="fa m-t-15 fa-user-secret fa-3x text-success pull-left"></i></a>
                    <div class="col-md-7 pull-left">
                        <a href=""><h2 class=""><b>5</b></h2></a>
                        <a href=""><span class="text-muted font-size-14">Data Keluarga</span></a>
                    </div>
                    
                </div> 
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel panel-primary" style="border-radius:30px">
            <div class="panel-body">
                <div class="row col-mb-12" style="margin-left:15px">
                    <a href=""><i class="fa m-t-15 fa-phone-square fa-3x text-success pull-left"></i></a>
                    <div class="col-md-7 pull-left">
                        <a href=""><h2 class=""><b>1</b></h2></a>
                        <a href=""><span class="text-muted font-size-14">Kontak Darurat</span></a>
                    </div>
                    
                </div> 
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel panel-primary" style="border-radius:30px">
            <div class="panel-body">
                <div class="row col-mb-12" style="margin-left:15px">
                    <a href=""><i class="fa m-t-15 fa-mortar-board (alias) fa-3x text-success pull-left"></i></a>
                    <div class="col-md-7 pull-left">
                        <a href=""><h2 class=""><b>3</b></h2></a>
                        <a href=""><span class="text-muted font-size-14">Data Pendidikan</span></a>
                    </div>
                    
                </div> 
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="panel panel-primary" style="border-radius:30px">
            <div class="panel-body">
                <div class="row col-mb-12" style="margin-left:10px">
                    <a href=""><i class="fa m-t-15 fa-briefcase fa-3x text-success pull-left"></i></a>
                    <div class="col-md-7 pull-left">
                        <a href=""><h2 class=""><b>2</b></h2></a>
                        <a href=""><span class="text-muted font-size-14">Data Pekerjaan</span></a>
                    </div>
                    
                </div> 
            </div>
        </div>
    </div>
</div>  

<div class="panel panel-primary">
    <div class=" col-sm-0 m-b-0">
    </div>

    {{-- <form action="karyawan/update/{{$karyawan->id}}" method="POST"> --}}
        @csrf
        @method('put')

        <div class="modal-body">
            <table class="table table-bordered table-striped" style="width:100%">
                <tbody class="col-sm-20">
                    <div class="col-md-4 row">
                        <label class=""><h4> A. DATA DIRI</h4></label>
                        <div class="my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">Nama lengkap *</label>
                                            <p style="text-transform: uppercase;">{{$karyawan->nama}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">Tanggal Lahir *</label>
                                            <p style="text-transform: uppercase;">{{\Carbon\Carbon::parse($karyawan->tgllahir)->format('d/m/Y')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">Nomor Induk Kependudukan (NIK) *</label>
                                            <p style="text-transform: uppercase;">{{$karyawan->nik}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">Jenis Kelamin *</label>
                                            @if($karyawan->jenis_kelamin == 'P')
                                                <p style="text-transform: uppercase;">Perempuan</p>
                                            @else
                                            <p style="text-transform: uppercase;">Laki-Laki</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
   
                    </div>

                    <div class="col-md-4 row">
                        <label class=""><h4 class="text-white">#</h4></label>
                        <div class="my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">E-Mail *</label>
                                            <p>{{$karyawan->email}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">Agama *</label>
                                            <p style="text-transform: uppercase;">{{$karyawan->agama}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">Golongan Darah *</label>
                                            <p style="text-transform: uppercase;">{{$karyawan->gol_darah}} </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">Alamat *</label>
                                            <p style="text-transform: uppercase;">{{$karyawan->alamat}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>
                    <div class="col-md-4 row">
                        <label class=""><h4 class="text-white">#</h4></label>
                        <div class="row my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">Departemen *</label>
                                            <p style="text-transform: uppercase;">{{$karyawan->departemens->nama_departemen}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">Jabatan *</label>
                                            <p style="text-transform: uppercase;">{{$karyawan->jabatan}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">Nama Atasan *</label>
                                            @if($karyawan->atasan_pertama != null)
                                                <p style="text-transform: uppercase;">{{$karyawan->atasan_pertama}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row my-5">
                            <div class="col-12 pl-0">
                                <div class="form-group mb-3">
                                    <div class="row align-items-end">
                                        <div class="col-md mb-md-0 m-l-15">
                                            <label class="font-size-14 fw-bold">Nama Atasan (SPV / Manager / Management)</label>
                                            @if($karyawan->atasan_kedua != null)
                                                <p style="text-transform: uppercase;">{{$karyawan->atasan_kedua}}</p>
                                            @else
                                                <p style="text-transform: uppercase;">-</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>    
                    </div>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <label class="" width="50%"><h4>B. KELUARGA </h4></label>
                            <tr>
                                <td style="width:25%"><label class="text-white badge bg-info">Data Istri / Suami *)</label></td>
                            </tr>
                            <tr>
                                <td style="width:40%"><label>Status Pernikahan</label></td>
                                <td style="width:60%"><label>{{$keluarga->status_pernikahan}} </label></td>
                            </tr>
                            <tr>
                                <td><label>Nama Pasangan</label></td>
                                <td><label>{{$keluarga->nama}}</label></td>
                            </tr>
                            <tr>
                                <td><label>Tanggal Lahir</label></td>
                                <td><label>{{\Carbon\Carbon::parse($keluarga->tgllahir)->format('d/m/Y')}}</label></td>
                            </tr>
                            <tr>
                                <td><label for="bpjskes_number">Alamat</label></td>
                                <td><label for="bpjskes_number">{{$keluarga->alamat}}</label></td>
                            </tr>
                            <tr>
                                <td><label for="bpjskes_number">Pendidikan Terakhir</label></td>
                                <td><label for="bpjskes_number">{{$keluarga->pendidikan_terakhir}}</label></td>
                            </tr>
                            <tr>
                                <td><label for="bpjskes_number">Pekerjaan</label></td>
                                <td><label for="bpjskes_number">{{$keluarga->pekerjaan}}</label></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <label class="" width="50%"><h4>C. KONTAK DARURAT </h4></label>
                            <tr>
                                <td><label class="text-white badge bg-info">Kontak yang Dapat Dihubungi</label></td>
                            </tr>
                            <tr>
                                <td style="width:40%"><label for="bpjsket_number">Nama Lengkap</label></td>
                                <td style="width:60%"><label for="bpjsket_number">{{$kdarurat->nama}} </label></td>
                            </tr>
                            <tr>
                                <td><label for="bpjsket_number">Alamat</label></td>
                                <td><label for="bpjsket_number">{{$kdarurat->alamat}} </label></td>
                            </tr>
                            <tr>
                                <td><label for="bpjsket_number">Nomor Handphone</label></td>
                                <td><label for="bpjsket_number">{{$kdarurat->no_hp}} </label></td>
                            </tr>
                            <tr>
                                <td><label for="bpjsket_number">Hubungan</label></td>
                                <td><label for="bpjsket_number">{{$kdarurat->hubungan}}</label></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <label class="" width="100%"><h4>D. RIWAYAT PENDIDIKAN </h4></label>
                            <tr>
                                <td style="width:25%"><label class="text-white badge bg-info"> Pendidikan Formal </label></td>
                            </tr>
                            <tr>
                                <td width="40%"><label>Tingkat</label></td>
                                <td width="60%"><label>{{$rpendidikan->tingkat}}</label></td>
                            </tr>
                            <tr>
                                <td><label>Nama Sekolah</label></td>
                                <td><label>{{$rpendidikan->nama_sekolah}} </label></td>
                            </tr>
                            <tr>
                                <td><label>Kota</label></td>
                                <td><label>{{$rpendidikan->kota_pformal}} </label></td>
                            </tr>
                            <tr>
                                <td><label>Jurusan</label></td>
                                <td><label>{{$rpendidikan->jurusan}}</label></td>
        
                            </tr>
                            <tr>
                                <td><label for="bpjsket_number">Lulus Tahun</label></td>
                                <td><label for="bpjsket_number">{{\Carbon\Carbon::parse($rpendidikan->tahun_lulus_formal)->format('d/m/Y')}}</label></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <label style="-webkit-text-fill-color: white;"><h4>#</h4></label>
                            <tr>
                                <td><label class="text-white badge bg-info">Pendidikan Non Formal</label></td>
                            </tr>
                            <tr>
                                <td width="40%"><label>Bidang / Jenis</label></td>
                                <td width="60%"><label>{{$rpendidikan->jenis_pendidikan}}</label></td>
                            </tr>
                            <tr>
                                <td><label>Kota</label></td>
                                <td><label>{{$rpendidikan->kota_pnonformal}}</label></td>
                            </tr>
                            <tr>
                                <td><label>Lulus Tahun</label></td>
                                <td><label>{{\Carbon\Carbon::parse($rpendidikan->tahun_lulus_nonformal)->format('d/m/Y')}}</label></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <label class="  "><h4>E. RIWAYAT PEKERJAAN</h4></label>
                            <tr>
                                <td width="40%"><label>Nama Perusahaan</label></td>
                                <td width="60%"><label>{{$rpekerjaan->nama_perusahaan}} </label></td>
                            </tr>
                            <tr>
                                <td><label>Nama Direktur</label></td>
                                <td><label>{{$rpekerjaan->nama_direktur}}</label></td>
                            </tr>
                            <tr>
                                <td><label>Alamat Perusahaan</label></td>
                                <td><label>{{$rpekerjaan->alamat}}</label></td>
                            </tr>
                            <tr>
                                <td><label>Nama Atasan Langsung</label></td>
                                <td><label>{{$rpekerjaan->nama_atasan}}</label></td>
                            </tr>
                            <tr>
                                <td><label>Jenis Usaha</label></td>
                                <td><label>{{$rpekerjaan->jenis_usaha}}</label></td>
                            </tr>
                            <tr>
                                <td><label>Jabatan</label></td>
                                <td><label>{{$rpekerjaan->jabatan}}</label></td>
                            </tr>
                            <tr>
                                <td><label>Lama Kerja</label></td>
                                <td><label>{{$rpekerjaan->lama_kerja}} </label></td>
                            </tr>
                            <tr>
                                <td><label>Gaji</label></td>
                                <td><label>Rp. {{$rpekerjaan->gaji}},-</label></td>
                            </tr>
                            <tr>
                                <td><label>Alasan Berhenti</label></td>
                                <td><label>{{$rpekerjaan->alasan_berhenti}}</label></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
    {{-- </form> --}}
    <div class="modal-footer">
        <a href="karyawandashboard" class="btn btn-sm btn-danger">Kembali</a>
    </div>
</div>
@endsection