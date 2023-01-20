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

    <form action="karyawan/update/{{$karyawan->id}}" method="POST">

        @csrf
        @method('put')

        <div class="modal-body">
            <table class="table table-bordered table-striped" style="width:100%">
                <tbody class="col-sm-20">
                    <label class=""><h4> A. IDENTITAS </h4></label>
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
    </form>


    <div class="modal-footer">

        <a href="karyawanedit{{$karyawan->id}}" type="button" class="btn btn-sm btn-primary ">Edit Karyawan</a>


        <a href="karyawan" class="btn btn-sm btn-danger">Kembali</a>
    </div>
</div>



@endsection