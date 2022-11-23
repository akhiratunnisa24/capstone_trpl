@extends('layouts.default')



@section('content')

<!-- Header -->
<div class="row">
    <div class="col-sm-12">

        <div class="page-header-title">
            <h4 class="pull-left page-title ">Edit Karyawan</h4>

            <ol class="breadcrumb pull-right">
                <li>Human Resources Management System</li>
                <li class="active">Edit Karyawan</li>
            </ol>

            <div class="clearfix">
            </div>
        </div>
    </div>
</div>
<!-- Close Header -->





<div class="panel panel-primary">
                    <div class=" col-sm-0 m-b-0">
                   
                    </div>

                    <form action="karyawanupdate{{$karyawan->id}}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('put')
                    
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <tbody>
                        

                        <!-- <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">NIK</label>
                            <input type="text" class="form-control" name="nik" id="nik" value="">
                        </div>         -->

                        <tr>
                            <td><label for="exampleInputEmail1" class="form-label">NIP</label>
                            <input type="text" class="form-control" name="nip" id="nip" value="{{$karyawan->nip}}"></td>
                            <td><span  class="text-bold" ></span></td>
                            <td></td>
                            <td><label for="name" class="text-bold">Nama Lengkap</label>
                            <input type="text" class="form-control" name="nama" id="nama" value="{{$karyawan->nama}}"></td>
                        </tr>
                       
                        <tr>

                            <td><label for="dob">Tanggal Lahir </label>
                            <div>
                            <input id="datepicker-autoclose5" class="form-control" name="tgllahir" value="{{$karyawan->tgllahir}}"></td>
                            <td><span id="dob"></span></td>

                            <td rowspan="13"></td>
                            <td rowspan="4" colspan="2" class="text-center">
                                <img  class="img-preview img-fluid mb-3 col-sm-5" src="{{ asset('Foto_Profile/' . $karyawan->foto)}}" alt="Tidak ada foto profil." style="width:185px; ">
                                <label >Pilih Foto Karyawan</label>
                                <input type="file" name="foto" class="form-control" id="foto" onchange="previewImage()" >
                            </td>

                        </tr>

                        <tr>
                            <td><label for="phone_number">Nomor Handphone </label>
                            <input type="number" class="form-control" name="no_hp" id="no_hp" value="{{$karyawan->no_hp}}"></td>
                            <td><span id="phone_number"></span></td>
                        </tr>

                        <tr>
                            <td><label for="ktp_number">No. KTP</label>
                            <input type="number" class="form-control" name="nik" id="nik" value="{{$karyawan->nik}}"></td>
                            <td><span id="ktp_number"></span></td>
                        </tr>

                        <tr>
                            <td><label for="kk_number">No. KK</label>
                            <input type="number" class="form-control" name="no_kk" id="no_kk" value="{{$karyawan->no_kk}}"></td>
                            <td><span id="kk_number"></span></td>
                        </tr>

                        <tr>
                            <td><label for="gender">Jenis Kelamin </label>
                            <select class="form-control" name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="L" @if($karyawan->jenis_kelamin == "L") selected @endif >Laki-Laki</option>
                                <option value="P" @if($karyawan->jenis_kelamin == "P") selected @endif >Perempuan</option>
                            </select></td>
                            <td><span id="gender"></span></td>
                            
                            
                            <td><label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{$karyawan->email}}"></td>
                            <td><span id="email"></span></td>
                        </tr>

                        <tr>
                            <td><label for="employee_status">Status Karyawan</label>
                            <select class="form-control" name="status_karyawan" required>
                                <option value="">Pilih Status Karyawan</option>
                                <option value="Tetap" @if($karyawan->status_karyawan == "Tetap") selected @endif>Tetap</option>
                                <option value="Kontrak" @if($karyawan->status_karyawan == "Kontrak") selected @endif>Kontrak</option>
                                <option value="Probation" @if($karyawan->status_karyawan == "Probation") selected @endif>Probation</option>
                            </select></td>
                            <td><span id="employee_status"></span></td>
                            
                            <td><label for="contract_duration">Durasi Kontrak </label>
                            <input type="text" class="form-control" name="kontrak" id="kontrak" value="{{$karyawan->kontrak}}"></td>
                            <td><span id="contract_duration"></span></td>
                        </tr>

                        <tr>
                            <td><label for="status">Status Kerja</label>
                            <select class="form-control" name="status_kerja" required>
                                <option value="">Pilih Status Karyawan</option>
                                <option value="Aktif" @if($karyawan->status_kerja == "Aktif") selected @endif >Aktif</option>
                                <option value="Non-Aktif" @if($karyawan->status_kerja == "Non-Aktif") selected @endif>Non-Aktif</option>
                            </select></td>
                            <td><span id="status"></span></td>

                            <td><label for="employee_type">Tipe Karyawan</label>
                            <select class="form-control" name="tipe_karyawan" required>
                                <option value="">Pilih Tipe Karyawan</option>
                                <option value="Fulltime" @if($karyawan->tipe_karyawan == "Fulltime") selected @endif>Fulltime</option>
                                <option value="Freelance" @if($karyawan->tipe_karyawan == "Freelance") selected @endif>Freelance</option>
                                <option value="Magang" @if($karyawan->tipe_karyawan == "Magang") selected @endif>Magang</option>
                            </select></td>
                            <td><span id="employee_type"></span></td>
                        </tr>

                        <tr>
                            <td><label for="start_work_date">Tanggal Mulai Bekerja</label>
                            <input type="text" class="form-control" id="datepicker-autoclose6" name="tglmasuk" value="{{$karyawan->tglmasuk}}" ></input></td>
                            <td><span id="start_work_date"></span></td>

                            <td><label for="end_work_date">Tanggal Akhir Bekerja</label>
                            <input type="text" class="form-control" id="datepicker-autoclose7" name="tglkeluar" value="{{$karyawan->tglkeluar}}" ></input></td>
                            <td><span id="end_work_date"></span></td>
                        </tr>

                        <tr>
                            <td><label for="npwp_number">No. NPWP</label>
                            <input type="number" class="form-control" name="no_npwp" id="no_npwp" value="{{$karyawan->no_npwp}}"></td>
                            <td><span id="npwp_number"></span></td>
                            
                            <td><label for="role_name">Alamat</label>
                            <input type="text" class="form-control" name="alamat" id="alamat" value="{{$karyawan->alamat}}"></td>
                            <td><span id="role_name"></span></td>
                        </tr>
                        <tr>
                            <td><label for="division_name">Divisi</label>
                            <input type="text" class="form-control" name="divisi" id="divisi" value="{{$karyawan->divisi}}"></td>
                            <td><span id="division_name"></span></td>

                            <td><label for="position_name">Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan" value="{{$karyawan->jabatan}}"></td>
                            <td><span id="position_name"></span></td>
                        </tr>

                        <tr>
                            <td><label for="cc_number">No. Rekening</label>
                            <input type="number" class="form-control" name="no_rek" id="no_rek" value="{{$karyawan->no_rek}}"></td>
                            <td><span id="cc_number"></span></td>

                            <td><label for="salary">Gaji Pokok</label>
                            <input type="text" class="form-control" name="gaji" id="gaji" value="{{$karyawan->gaji}}"></td>
                            <td><span id="salary"></span></td>
                        </tr>
                        <tr>
                            <td><label for="bpjskes_number">No. BPJS Kesehatan</label>
                            <input type="number" class="form-control" name="no_bpjs_kes" id="no_bpjs_kes" value="{{$karyawan->no_bpjs_kes}}"></td>
                            <td><span id="bpjskes_number"></span></td>

                            <td><label for="bpjsket_number">No. BPJS Ketenagakerjaan</label>
                            <input type="number" class="form-control" name="no_bpjs_ket" id="no_bpjs_ket" value="{{$karyawan->no_bpjs_ket}}"></td>
                            <td><span id="bpjsket_number"></span></td>
                        </tr>
                      
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">                
           
                    <button  type="submit" name="submit"  class="btn btn-sm btn-primary" >Simpan</button> 
                    <a href="karyawanshow{{$karyawan->id}}"  class="btn btn-sm btn-danger" >Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>



<script>
 
var rupiah = document.getElementById('gaji');
rupiah.addEventListener('keyup', function(e){
    // tambahkan 'Rp.' pada saat form di ketik
    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
    rupiah.value = formatRupiah(this.value);
});
/* Fungsi formatRupiah */
function formatRupiah(angka, prefix){
    var number_string = angka.replace(/[^,\d]/g, '').toString(),
    split   		= number_string.split(','),
    sisa     		= split[0].length % 3,
    rupiah     		= split[0].substr(0, sisa),
    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
    // tambahkan titik jika yang di input sudah menjadi angka ribuan
    if(ribuan){
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
}

function previewImage(){

const image = document.querySelector('#foto');
const imgPreview =document.querySelector('.img-preview');

    imgPreview.style.display = 'block';

const oFReader = new FileReader();
oFReader.readAsDataURL(image.files[0]);

oFReader.onload = function(oFREvent){
    imgPreview.src = oFREvent.target.result;
}
}


</script>


<script src="assets/js/jquery.min.js"></script>



<!-- Plugins js -->
<script src="assets/plugins/timepicker/bootstrap-timepicker.js"></script>
<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="assets/pages/form-advanced.js"></script>
@endsection
