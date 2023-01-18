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

                    <label class="  "><h4> A. IDENTITAS </h4></label>


                    <tr>
                        <td style="width: 50%"><label>Nama Lengkap : {{$karyawan->nama}}</label></td>


                        <td rowspan="6" colspan="2" class="text-center">
                            <img src="{{ asset('Foto_Profile/' . $karyawan->foto)}}" alt="" style="width:280px;">
                        </td>
                    </tr>

                    <tr>
                        <td><label>NIK : {{$karyawan->nik}} </label></td>

                    </tr>

                    <tr>
                        <td><label>Tanggal Lahir :
                                {{\Carbon\Carbon::parse($karyawan->tgllahir)->format('d/m/Y')}}</label></td>

                    </tr>

                    <tr>
                        <td><label>Jenis Kelamin : {{$karyawan->jenis_kelamin}}</label></td>

                    </tr>

                    <tr>
                        <td><label>Alamat : {{$karyawan->alamat}}</label></td>

                    </tr>

                    <tr>
                        <td><label>Nomor Handphone : {{$karyawan->no_hp}}</label></td>



                    </tr>
                    <tr>
                        <td><label>Golongan Darah : {{$karyawan->gol_darah}} </label></td>
                        <td><label>Email : {{$karyawan->email}}</label></td>

                    </tr>

                    <tr>
                        <td><label> Jabatan : {{$karyawan->jabatan}} </label></td>
                        <td><label>Agama : {{$karyawan->agama}}</label></td>

                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered table-striped" style="width:100%">
                <tbody class="col-sm-16">
                    <label class="  "><h4>B. KELUARGA </h4></label>

                    <tr>
                        <td style="width:50%"><label class="text-white badge bg-dark">Data Istri / Suami *)</label></td>
                    </tr>

                    <tr>
                        <td><label>Status Pernikahan : {{$keluarga->status_pernikahan}} </label></td>
                        <td><label for="division_name">Nama Pasangan : {{$keluarga->nama}}</label></td>

                    </tr>

                    <tr>
                        <td><label for="cc_number">Tanggal Lahir :
                                {{($keluarga->tgllahir)}} </label></td>

                        <td><label for="bpjskes_number">Alamat : {{$keluarga->alamat}}</label></td>
                    </tr>

                    <tr>
                        <td><label for="bpjskes_number">Pendidikan Terakhir : {{$keluarga->pendidikan_terakhir}}</label>
                        </td>
                        <td><label for="bpjskes_number">Pekerjaan : {{$keluarga->pekerjaan}}</label></td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered table-striped" style="width: 100%">
                <tbody class="col-sm-20">
                    <label class="  "><h4>C. RIWAYAT PENDIDIKAN</h4></label>
                    <tr>
                        <td style="width: 50%"><label class="text-white badge bg-dark"> Pendidikan Formal </label></td>

                        <td><label class=" text-white badge bg-dark">Pendidikan Non Formal</label></td>
                    </tr>
                    <tr>
                        <td><label>Tingkat : {{$rpendidikan->tingkat}}</label></td>

                        <td><label for="bpjsket_number">Bidang / Jenis : {{$rpendidikan->jenis_pendidikan}}</label></td>



                    </tr>
                    <tr>


                        <td><label> Nama Sekolah : {{$rpendidikan->nama_sekolah}} </label></td>
                        <td><label for="bpjsket_number">Kota : {{$rpendidikan->kota_pnonformal}}</label></td>
                        



                    </tr>

                    <tr>
                        
                        <td><label for="bpjskes_number"> Kota : {{$rpendidikan->kota_pformal}} </label></td>
                        <td><label for="bpjsket_number">Lulus Tahun :
                                {{($rpendidikan->tahun_lulus_nonformal)}}</label>
                        </td>
                        

                    </tr>
                    <tr>
                        <td><label for="bpjsket_number">Jurusan : {{$rpendidikan->jurusan}}</label></td>
                        <td><span></span></td>

                    </tr>
                    <tr>
                        <td><label for="bpjsket_number">Lulus Tahun :
                                {{($rpendidikan->tahun_lulus_formal)}}</label>
                        </td>
                        <td><span id="bpjsket_number"></span></td>
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

            <table class="table table-bordered table-striped" style="width: 100%">
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
            </table>
        </div>
    </form>


    <div class="modal-footer">

        <a href="karyawanedit{{$karyawan->id}}" type="button" class="btn btn-sm btn-primary ">Edit Karyawan</a>


        <a href="karyawan" class="btn btn-sm btn-danger">Kembali</a>
    </div>
</div>



@endsection