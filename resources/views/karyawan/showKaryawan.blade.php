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
                        <td style="width: 40%"><label>Nama Lengkap</label></td>
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

            <table class="table table-bordered table-striped" style="width:100%">
                <tbody class="col-sm-16">
                    
                   <div class="row col-md-12">
                        <div class="col-md-6 pull-left">
                            <label class="" width="50%"><h4>B. KELUARGA </h4></label>
                        </div>
                        <div class="col-md-6 pull-right">
                            <label class="" width="50%"><h4>E. KONTAK DARURAT </h4></label>
                        </div>
                   </div>
                    <tr>
                        <td style="width:25%"><label class="text-white badge bg-dark">Data Istri / Suami *)</label></td>
                        <td></td>
                        <td><label class="text-white badge bg-dark">Kontak yang Dapat Dihubungi:</label></td>
                    </tr>

                    <tr>
                        <td style="width:25%"><label>Status Pernikahan</label></td>
                        <td style="width:25%"><label>{{$keluarga->status_pernikahan}} </label></td>

                        <td style="width:25%"><label for="bpjsket_number">Nama Lengkap</label></td>
                        <td style="width:25%"><label for="bpjsket_number">{{$kdarurat->nama}} </label></td>
                    </tr>
                    <tr>
                        <td><label for="division_name">Nama Pasangan</label></td>
                        <td><label for="division_name">{{$keluarga->nama}}</label></td>
                        <td><label for="bpjsket_number">Alamat</label></td>
                        <td><label for="bpjsket_number">{{$kdarurat->alamat}} </label></td>
                    </tr>
                    <tr>
                        <td><label for="division_name">Tanggal Lahir</label></td>
                        <td></label>{{($keluarga->tgllahir)}}</label></td>
                        <td><label for="bpjsket_number">Nomor Handphone</label></td>
                        <td><label for="bpjsket_number">{{$kdarurat->no_hp}} </label></td>
                    </tr>

                    <tr>
                        <td><label for="bpjskes_number">Alamat</label></td>
                        <td><label for="bpjskes_number">{{$keluarga->alamat}}</label></td>
                        <td><label for="bpjsket_number">Hubungan</label></td>
                        <td><label for="bpjsket_number">{{$kdarurat->hubungan}}</label></td>
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

            <table class="table table-bordered table-striped" style="width: 100%">
                <tbody class="col-sm-20">
                    <label class="  "><h4>C. RIWAYAT PENDIDIKAN</h4></label>
                    <tr>
                        <td style="width: 25%"><label class="text-white badge bg-dark"> Pendidikan Formal </label></td>
                        <td></td>
                        <td style="width: 25%"><label class=" text-white badge bg-dark">Pendidikan Non Formal</label></td>
                        {{-- <td></td> --}}
                    </tr>
                    <tr>
                        <td><label>Tingkat</label></td>
                        <td><label>{{$rpendidikan->tingkat}}</label></td>
                        <td><label>Bidang / Jenis</label></td>
                        <td><label>{{$rpendidikan->jenis_pendidikan}}</label></td>
                    </tr>
                    <tr>
                        <td><label>Nama Sekolah</label></td>
                        <td><label>{{$rpendidikan->nama_sekolah}} </label></td>
                        <td><label>Kota</label></td>
                        <td><label>{{$rpendidikan->kota_pnonformal}}</label></td>
                    </tr>

                    <tr>
                        <td><label>Kota</label></td>
                        <td><label>{{$rpendidikan->kota_pformal}} </label></td>
                        <td><label>Lulus Tahun</label></td>
                        <td><label>{{($rpendidikan->tahun_lulus_nonformal)}}</label></td>
                    </tr>
                    <tr>
                        <td><label>Jurusan</label></td>
                        <td><label>{{$rpendidikan->jurusan}}</label></td>

                    </tr>
                    <tr>
                        <td><label for="bpjsket_number">Lulus Tahun</label></td>
                        <td><label for="bpjsket_number">{{($rpendidikan->tahun_lulus_formal)}}</label></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered table-striped" style="width: 100%">
                <tbody class="col-sm-20">
                    <label class="  "><h4>D. RIWAYAT PEKERJAAN</h4></label>
                    <tr>
                        <td style="width:50%"><label for="bpjskes_number">Nama Perusahaan : {{$rpekerjaan->nama_perusahaan}} </label></td>
                        <td><label for="bpjskes_number">Nama Direktur : {{$rpekerjaan->nama_direktur}} </label></td>

                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <td><label for="bpjskes_number">Alamat Perusahaan : {{$rpekerjaan->alamat}} </label></td>

                        <td><label for="bpjskes_number">Nama Atasan Langsung : {{$rpekerjaan->nama_atasan}} </label>
                        </td>


                    </tr>
                    <tr>
                        <td><label for="bpjskes_number">Jenis Usaha : {{$rpekerjaan->jenis_usaha}} </label></td>

                        <td><label for="bpjskes_number">Jabatan : {{$rpekerjaan->jabatan}} </label></td>



                    </tr>

                    <tr>
                        <td><label for="bpjskes_number">Lama Kerja : {{$rpekerjaan->lama_kerja}} </label></td>

                        <td><label for="bpjskes_number">Gaji : Rp {{$rpekerjaan->gaji}},-  </label></td>



                    </tr>
                    <tr>
                        <td><label for="bpjskes_number">Alasan Berhenti : {{$rpekerjaan->alasan_berhenti}} </label></td>
                        <td><span id="bpjskes_number"></span></td>


                    </tr>
                </tbody>

            </table>

            {{-- <table class="table table-bordered table-striped" style="width: 100%">
                <tbody class="col-sm-20">

                    <label class="  "><h4>E. KONTAK DARURAT</h4></label>

                    <tr>
                        <td style="width: 50%"><label for="bpjsket_number">Nama Lengkap : {{$kdarurat->nama}} </label></td>
                        
                        <td><label for="bpjsket_number">Alamat : {{$kdarurat->alamat}} </label></td>
                        
                    </tr>
                    <tr>

                        <td><label for="bpjsket_number">Nomor Handphone :{{$kdarurat->no_hp}} </label></td>
                        
                        <td><label for="bpjsket_number">Hubungan : {{$kdarurat->hubungan}}</label></td>
                        
                    </tr>


                </tbody>
            </table> --}}
        </div>
    </form>


    <div class="modal-footer">
        <a href="karyawandashboard" class="btn btn-sm btn-danger">Kembali</a>
    </div>
</div>


@endsection