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

                    <form action="#" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('put')
                    
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                <form role="form"  method="post" action="tambah_alumni.php">
                <div class="card-body">
                  <div class="row">
                  <div class="col-md-6">
                  <div class="form-group ">
                    <label for="exampleInputEmail1">Npm</label>
                    <input type="text" class="form-control" name="npm" placeholder="Npm" required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nama</label>
                    <input type="text" class="form-control" name="nama" placeholder="Nama"required>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Jenis Kelamin</label>
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="jenkel" value="Laki-Laki" >
                      <label class="form-check-label">Laki-Laki</label>
                  </div>
                  <div class="form-check">
                      <input class="form-check-input" type="radio" name="jenkel"value="Perempuan">
                      <label class="form-check-label">Perempuan</label>
                  </div>
                  </div>
                
                  
                  <div class="form-group">
                    <label for="tgl_lahir">Tanggal Lahir</label>
                    <input type="text" id="datepicker" class="form-control" name="tgl_lahir" placeholder="Tanggal Lahir">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Priode Wisuda</label>
                  <select id="periode_wisuda" class="form-control" name="periode_wisuda">
  <option disabled selected>-Pilih Periode-</option>
  <option value="Pertama">Pertama</option>
  <option value="Kedua">Kedua</option>
  <option value="Ketiga">Ketiga</option>
</select>
</div>
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nama Kosentrasi</label>
                    <select id="id_kosentrasi" class="form-control" name="id_kosentrasi">
                      <option disabled selected>-Pilih Kosentrasi-</option>
      </select>
                  </div>
                  <div class="form-group">
                    <label for="thn_masuk">Tahun Masuk</label>
                    <input type="text" id="datepicker1" class="form-control" name="thn_masuk" placeholder="Tahun Masuk">
                  </div>
                  <div class="form-group">
                    <label for="thn_selesai">Tahun Selesai</label>
                    <input type="text" id="datepicker2" class="form-control" name="thn_selesai" placeholder="Tahun Selesai">
                  </div>
                  <div class="form-group">
                    <label for="ipk">IPK</label>
                    <input type="text" class="form-control" name="ipk" placeholder="IPK">
                  </div>
                </div>
                </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-success float-right">Simpan</button>
                </div>
              </form>
                </table>
            </div>
            <div class="modal-footer">                
           
                    <button  type="submit" name="submit"  class="btn btn-sm btn-primary" >Simpan</button> 
                    <a href="#"  class="btn btn-sm btn-danger" >Kembali</a>
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
