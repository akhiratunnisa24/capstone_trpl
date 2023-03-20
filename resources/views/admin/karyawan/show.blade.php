@extends('layouts.default')

@section('content')

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

<div class="panel panel-primary">
    <div class=" col-sm-0 m-b-0">

    </div>

    {{-- karyawan/update/{{$karyawan->id}} --}}
    {{-- <form action="" method="POST"> --}}
        {{-- @csrf
        @method('put') --}}

        <div class="modal-body">
            <table class="table table-bordered table-striped" style="width:100%">
                <tbody class="col-sm-20">
                    <div class="row">
                        <label class="m-l-10"><h4> A. IDENTITAS </h4></label>
                        <a class="btn btn-sm btn-primary editIdentitas pull-right" data-toggle="modal" data-target="#editIdentitas{{$karyawan->id}}" style="margin-right:10px;margin-top:10px">
                            <i class="fa fa-edit"> <strong>Edit Identitas Diri</strong></i>
                        </a>
                    </div>
                    @include('admin.karyawan.editIdentitas')
                    <tr>
                        <td style="width: 40%"><strong><label>Nama Lengkap</label></strong></td>
                        <td style="width: 60%"><label>{{$karyawan->nama}}</label></td>
                        <td rowspan="6" colspan="2" class="text-center">
                            <img src="{{ asset('Foto_Profile/' . $karyawan->foto)}}" alt="" style="width:280px;">
                        </td>
                    </tr>
                    <tr>
                        <td><label>Nomor KTP / NIK</label></td>
                        <td><label>{{$karyawan->nik}} </label></td>
                    </tr>
                    <tr>
                        <td><label>Tanggal Lahir</label></td>
                        <td><label>{{\Carbon\Carbon::parse($karyawan->tgllahir)->format('d/m/Y')}}</label></td>
                    </tr>
                    <tr>
                        <td><label>Jenis Kelamin</label></td>
                        @if($karyawan->jenis_kelamin == 'P')
                            <td><label>Perempuan</label></td>
                        @else
                            <td><label>Laki-Laki</label></td>
                        @endif
                    </tr>
                    <tr>
                        <td><label>Alamat</label></td>
                        <td><label>{{$karyawan->alamat}}</label></td>
                    </tr>
                    <tr>
                        <td><label>Nomor Handphone</label></td>
                        <td><label>{{$karyawan->no_hp}}</label></td>
                    </tr>
                    <tr>
                        <td><label>Golongan Darah</label></td>
                        <td><label>{{$karyawan->gol_darah}} </label></td><tr></tr>
                    </tr>
                    <tr>
                        <td><label>Email</label></td>
                        <td><label>{{$karyawan->email}}</label></td>
                    </tr>
                    <tr>
                        <td><label>Jabatan</label></td>
                        <td><label>{{$karyawan->jabatan}} </label></td>
                    </tr>
                    <tr>
                        <td><label>Agama</label></td>
                        <td><label>{{$karyawan->agama}}</label></td>
                    </tr>
                    <tr>
                        <td><label>Status Pernikahan</label></td>
                        <td><label>{{ $status->status_pernikahan}}</label></td>
                    </tr>
                </tbody>
            </table>

           
            {{-- DATA KELUARGA --}}
            <div class="row">
                <label class="m-l-10"><h4>B. KELUARGA </h4></label>
                <a class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#addKeluarga" style="margin-right:10px;margin-top:10px">
                    <i class="fa fa-plus"> <strong> Add Data Keluarga</strong></i>
                </a>
                @include('admin.karyawan.addKeluarga')
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal Lahir</th>
                        <th>Hubungan</th>
                        <th>Alamat</th>
                        <th>Pendidikan Terakhir</th>
                        <th>Pekerjaan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($keluarga as $keluarga)
                        <tr>
                            <td>{{$loop->iteration }}</td>
                            <td>{{$keluarga->nama }}</td>
                            <td>{{\Carbon\Carbon::parse($keluarga->tgllahir)->format('d/m/Y')}}</td>
                            <td>{{$keluarga->hubungan }}</td> 
                            <td>{{$keluarga->alamat }}</td>
                            <td>{{$keluarga->pendidikan_terakhir }}</td>
                            <td>{{$keluarga->pekerjaan}}</td>
                            <td class="">
                                <a class="btn btn-sm btn-primary editKeluarga pull-right" data-toggle="modal" data-target="#editKeluarga{{$keluarga->id}}" style="margin-right:10px">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @include('admin.karyawan.editKeluarga')
                    @endforeach
                </tbody>
            </table>
            {{-- END DATA KELUARGA --}}

            {{-- KONTAK DARURAT --}}
            <div class="row">
                <label class="" width="50%"><h4>C. KONTAK DARURAT </h4></label>
                <a class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#addKontak" style="margin-right:10px;margin-top:10px">
                    <i class="fa fa-plus"> <strong> Add Kontak Darurat</strong></i>
                </a>
                @include('admin.karyawan.addKontak')
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Hubungan</th>
                        <th>Alamat</th>
                        <th>Nomor Handphone</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($kdarurat as $kdarurat)
                        <tr>
                            <td>{{$loop->iteration }}</td>
                            <td>{{$kdarurat->nama }}</td>
                            <td>{{$kdarurat->hubungan }}</td>
                            <td>{{$kdarurat->alamat }}</td>
                            <td>{{$kdarurat->no_hp}}</td>
                            <td class="">
                                <a class="btn btn-sm btn-primary editDarurat pull-right" data-toggle="modal" data-target="#editDarurat{{$kdarurat->id}}" style="margin-right:10px">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @include('admin.karyawan.editKontakdarurat')
                    @endforeach
                </tbody>
            </table>
            {{-- END KONTAK DARURAT --}}

            {{-- RIWAYAT PENDIDIKAN --}}
            <label class="" width="50%"><h4>D. RIWAYAT PENDIDIKAN </h4></label><br>
            <div class="row">
                <td style="width:25%"><label class="text-white badge bg-info">1. Pendidikan Formal </label></td>
                <a class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#addPformal" style="margin-right:10px;margin-bottom:10px">
                    <i class="fa fa-plus"> <strong> Add Pendidikan Formal</strong></i>
                </a>
                @include('admin.karyawan.addPformal')
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tingkat</th>
                        <th>Nama Sekolah</th>
                        <th>Kota</th>
                        <th>Jurusan</th>
                        <th>Tahun Lulus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($rpendidikan as $rpendidikan)
                        @if($rpendidikan->tingkat != null)
                            <tr>
                                <td>{{$loop->iteration }}</td>
                                <td>{{$rpendidikan->tingkat}}</td>
                                <td>{{$rpendidikan->nama_sekolah}}</td>
                                <td>{{$rpendidikan->kota_pformal}}</td>
                                <td>{{$rpendidikan->jurusan}}</td>
                                <td>{{$rpendidikan->tahun_lulus_formal}}</td>
                                <td class="">
                                    <a class="btn btn-sm btn-primary editPformal pull-right" data-toggle="modal" data-target="#editPformal{{$rpendidikan->id}}" style="margin-right:10px">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @include('admin.karyawan.editPformal')
                        @endif
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <td style="width:25%"><label class="text-white badge bg-info"> Pendidikan Non Formal </label></td>
                <a class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#addPnformal" style="margin-right:10px;margin-bottom:10px">
                    <i class="fa fa-plus"> <strong> Add Pend. Non Formal</strong></i>
                </a>
            </div>
            @include('admin.karyawan.addPnformal')
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bidang</th>
                        <th>Kota</th>
                        <th>Tahun Lulus</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nonformal as $rpendidikan)
                        <tr>
                            <td>{{$loop->iteration }}</td>
                            <td>{{$rpendidikan->jenis_pendidikan}}</td>
                            <td>{{$rpendidikan->kota_pnonformal}}</td>
                            <td>{{$rpendidikan->tahun_lulus_nonformal}}</td>
                            <td class="">
                                <a class="btn btn-sm btn-primary editPnformal pull-right" data-toggle="modal" data-target="#editPnformal{{$rpendidikan->id}}" style="margin-right:10px">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @include('admin.karyawan.editPnformal')
                    @endforeach
                </tbody>
            </table>
            {{-- END RIWAYAT PENDIDIKAN --}}

            {{-- RIWAYAT PEKERJAAN --}}
            <div class="row m-t-10">
                <label class="" width="50%"><h4>E. RIWAYAT PEKERJAAN </h4></label>
                <a class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#addPekerjaan" style="margin-right:10px;margin-bottom:10px">
                    <i class="fa fa-plus"> <strong> Add Data Pekerjaan</strong></i>
                </a>
                @include('admin.karyawan.addPekerjaan')
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Perusahaan</th>
                        <th>Atasan</th>
                        <th>Direktur</th>
                        <th>Jabatan</th>
                        <th>Lama Kerja</th>
                        <th>Gaji</th>
                        <th>Alasan Berhenti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rpekerjaan as $rpekerjaan)
                        <tr>
                            <td>{{$loop->iteration }}</td>
                            <td>{{$rpekerjaan->nama_perusahaan}}</td>
                            <td>{{$rpekerjaan->nama_atasan}}</td>
                            <td>{{$rpekerjaan->nama_direktur}}</td>
                            <td>{{$rpekerjaan->jabatan}}</td>
                            <td>{{$rpekerjaan->lama_kerja}}</td>
                            <td>Rp. {{$rpekerjaan->gaji}},-</td>
                            <td>{{$rpekerjaan->alasan_berhenti}}</td>
                            <td class="">
                                <a class="btn btn-sm btn-primary pull-right" data-toggle="modal" data-target="#editPekerjaan{{$rpekerjaan->id}}" style="margin-right:10px">
                                    <i class="fa fa-edit"></i>
                                </a>
                                {{-- <button onclick="pekerjaan({{$$rpekerjaan->id}})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button> --}}
                            </td>
                        </tr>
                        @include('admin.karyawan.editPekerjaan')
                    @endforeach
                </tbody>
            </table>
            {{-- </div> --}}
        </div>
    {{-- </form> --}}

    <div class="modal-footer">
        {{-- <a href="karyawanedit{{$karyawan->id}}" type="button" class="btn btn-sm btn-primary ">Edit Karyawan</a> --}}
        <a href="karyawan" class="btn btn-sm btn-danger">Kembali</a>
    </div>
</div>

@endsection

    {{-- <div class="col-md-6">
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
                </div> --}}
                {{-- <div class="col-md-6">
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
                </div> --}}
            {{-- </div>

            <div class="row"> --}}
                {{-- <div class="col-md-6">
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
                                <td><label for="bpjsket_number">{{\Carbon\Carbon::parse($rpendidikan->tahun_lulus_formal)->format('Y')}}</label></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped">
                        <tbody>
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
                                <td><label>{{\Carbon\Carbon::parse($rpendidikan->tahun_lulus_nonformal)->format('Y')}}</label></td>
                            </tr>

                        </tbody>
                    </table>
                </div>
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
                </div> --}}