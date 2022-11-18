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
<!-- Close Header -->

<!-- 
                    <form action="karyawan/update/{{$karyawan->id}}" method="POST">

                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" id="nik" value="{{$karyawan->nik}}">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" id="exampleInputEmail1"  value="{{$karyawan->nama}}">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                        <input id="datepicker-autoclose4" class="form-control" name="tgllahir" rows="10" value="{{$karyawan->tgllahir}}"></input>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="exampleInputEmail1"  value="{{$karyawan->email}}">
                    </div>
                    <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>


                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="10">{{$karyawan->alamat}}</textarea><br>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">No. Handphone</label>
                        <input type="text" class="form-control" name="no_hp" id="no_hp" value="{{$karyawan->no_hp}}">
                    </div>

                    <label for="exampleInputEmail1" class="form-label">Status Karyawan</label>
                    <select class="form-control" name="status_karyawan" required>
                        <option value="">Pilih Status Karyawan</option>
                        <option value="Tetap">Tetap</option>
                        <option value="Kontrak">Kontrak</option>
                        <option value="Probation">Probation</option>
                    </select>

                   
                    <label for="exampleInputEmail1" class="form-label">Tipe Karyawan</label>
                    <select class="form-control" name="tipe_karyawan" required>
                        <option value="">Pilih Tipe Karyawan</option>
                        <option value="Fulltime">Fulltime</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Magang">Magang</option>
                    </select>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Masuk</label>
                        <input id="datepicker-autoclose2" class="form-control" name="tglmasuk" rows="10" value="{{$karyawan->tglmasuk}}"></input><br>
                    </div>

                    <div class="mb-3">                        
                        <input type="hidden" class="form-control" name="tglkeluar" rows="10" value="{{$karyawan->tglkeluar}}" id="datepicker-autoclose2" disabled></input><br>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div> -->




<div class="panel panel-primary">
                    <div class=" col-sm-0 m-b-0">
                   
                    </div>

                    <form action="karyawan/update/{{$karyawan->id}}" method="POST">

                    @csrf
                    @method('put')
                    
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr style="background-color: #2B323A; color: #FFFFFF">
                            <td><label  class="text-bold">NIP : {{$karyawan->nip}}</label></td>
                            <td><span  class="text-bold" ></span></td>
                            <td></td>
                            <td><label for="name" class="text-bold">Nama Lengkap : {{$karyawan->nama}}</label></td>
                            <td><span id="name" class="text-bold"></span></td>
                        </tr>
                        <tr>
                            <td><label for="dob">Tanggal Lahir: {{$karyawan->tgllahir}} </label></td>
                            <td><span id="dob"></span></td>
                            <td rowspan="13"></td>        
                            <td rowspan="4" colspan="2" class="text-center">
                                <img id="img-modal" src="{{ url($karyawan->foto)}}" alt="Tidak ada foto profil." style="width:128px;">
                            </td>
                        </tr>
                        <tr>
                            <td><label for="phone_number">Nomor Handphone: {{$karyawan->no_hp}} </label></td>
                            <td><span id="phone_number"></span></td>
                        </tr>
                        <tr>
                            <td><label for="ktp_number">No. KTP: {{$karyawan->nik}}</label></td>
                            <td><span id="ktp_number"></span></td>
                        </tr>
                        <tr>
                            <td><label for="kk_number">No. KK: {{$karyawan->no_kk}}</label></td>
                            <td><span id="kk_number"></span></td>
                        </tr>
                        <tr>
                            <td><label for="gender">Jenis Kelamin: {{$karyawan->jenis_kelamin}}</label></td>
                            <td><span id="gender"></span></td>
                            <td><label for="email">Email: {{$karyawan->email}}</label></td>
                            <td><span id="email"></span></td>
                        </tr>
                        <tr>
                            <td><label for="employee_status">Status Karyawan: {{$karyawan->status_karyawan}}</label></td>
                            <td><span id="employee_status"></span></td>
                            <td><label for="contract_duration">Durasi Kontrak: {{$karyawan->kontrak}}</label></td>
                            <td><span id="contract_duration"></span></td>
                        </tr>
                        <tr>
                            <td><label for="status">Status Kerja: {{$karyawan->status_kerja}} </label></td>
                            <td><span id="status"></span></td>
                            <td><label for="employee_type">Tipe Karyawan: {{$karyawan->tipe_karyawan}}</label></td>
                            <td><span id="employee_type"></span></td>
                        </tr>
                        <tr>
                            <td><label for="start_work_date">Tanggal Mulai Bekerja: {{$karyawan->tglmasuk}}</label></td>
                            <td><span id="start_work_date"></span></td>
                            <td><label for="end_work_date">Tanggal Akhir Bekerja: {{$karyawan->tglkeluar}}</label></td>
                            <td><span id="end_work_date"></span></td>
                        </tr>
                        <tr>
                            <td><label for="npwp_number">No. NPWP {{$karyawan->no_npwp}}</label></td>
                            <td><span id="npwp_number"></span></td>
                            <td><label for="role_name">Alamat: {{$karyawan->alamat}}</label></td>
                            <td><span id="role_name"></span></td>
                        </tr>
                        <tr>
                            <td><label for="division_name">Divisi: {{$karyawan->divisi}}</label></td>
                            <td><span id="division_name"></span></td>
                            <td><label for="position_name">Jabatan: {{$karyawan->jabatan}}</label></td>
                            <td><span id="position_name"></span></td>
                        </tr>
                        <tr>
                            <td><label for="cc_number">No. Rekening: {{$karyawan->no_rek}}</label></td>
                            <td><span id="cc_number"></span></td>
                            <td><label for="salary">Gaji Pokok: Rp. {{($karyawan->gaji) }}</label></td>
                            <td><span id="salary"></span></td>
                        </tr>
                        <tr>
                            <td><label for="bpjskes_number">No. BPJS Kesehatan: {{$karyawan->no_bpjs_kes}}</label></td>
                            <td><span id="bpjskes_number"></span></td>
                            <td><label for="bpjsket_number">No. BPJS Ketenagakerjaan: {{$karyawan->no_bpjs_ket}}</label></td>
                            <td><span id="bpjsket_number"></span></td>
                        </tr>
                      
                        </form>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                
                    <a href="karyawanedit{{$karyawan->id}}" type="button" class="btn btn-sm btn-primary ">Edit Karyawan</a>
                    
                    
                <a href="karyawan"  class="btn btn-sm btn-danger">Kembali</a>
            </div>
        </div>
    </div>
</div>



@endsection
