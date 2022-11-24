<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">


<!-- MODAL BEGIN -->

<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Data Karyawan </h4>
            </div>

            <div class="modal-body">

                <form action="/karyawan/store" method="POST" enctype="multipart/form-data">

                    @csrf

                    
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label col-sm-4" >Pilih Foto Karyawan</label>
                        <img class="img-preview img-fluid mb-3 col-sm-4">
                        <input type="file" name="foto" class="form-control" id="foto" onchange="previewImage()">
                    </div>


                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">NIP</label>
                        <input type="number" name="nip" class="form-control" id="nip" placeholder="Masukkan NIP" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Nama" required>
                        <div id="emailHelp" class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose3" name="tgllahir" rows="10" required></input><br>
                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                        </div><!-- input-group -->
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">No. Handphone</label>
                        <input type="number" name="no_hp" class="form-control" id="no_hp" placeholder="Masukkan Nomor Handphone" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">NIK</label>
                        <input type="number" name="nik" class="form-control" id="nik" placeholder="Masukkan NIK" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">No. KK</label>
                        <input type="number" name="no_kk" class="form-control" id="no_kk" placeholder="Masukkan No KK" required>
                    </div>

                    <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>

                    <label for="exampleInputEmail1" class="form-label">Status Karyawan</label>
                    <select class="form-control" name="status_karyawan" required>
                        <option value="">Pilih Status Karyawan</option>
                        <option value="Tetap">Tetap</option>
                        <option value="Kontrak">Kontrak</option>
                        <option value="Probation">Probation</option>
                    </select>

                    <label for="exampleInputEmail1" class="form-label">Status Kerja</label>
                    <select class="form-control" name="status_kerja" required>
                        <option value="">Pilih Status Karyawan</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Non-Aktif">Non-Aktif</option>
                    </select>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Masuk</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose" name="tglmasuk" rows="10" required></input><br>
                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                        </div><!-- input-group -->
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">No. NPWP</label>
                        <input type="number" name="no_npwp" class="form-control" id="no_npwp" placeholder="Masukkan No NPWP">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Divisi</label>
                        <input type="text" name="divisi" class="form-control" id="divisi" aria-describedby="emailHelp" placeholder="Masukkan Divisi">
                        <div id="emailHelp" class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">No. Rekening</label>
                        <input type="number" name="no_rek" class="form-control" id="no_rek" placeholder="Masukkan No Rekening" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">No. BPJS Kesehatan</label>
                        <input type="number" name="no_bpjs_kes" class="form-control" id="no_bpjs_kes" placeholder="Masukkan No BPJS Kesehatan">
                    </div>


                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" name="email" no_kk class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Email" required>
                        <div id="emailHelp" class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Durasi Kontrak</label>
                        <input type="text" name="kontrak" no_kk class="form-control" id="kontrak" aria-describedby="emailHelp" placeholder="Kosongkan jika karyawan tetap" >
                        <div id="emailHelp" class="form-text"></div>
                    </div>

                    <label for="exampleInputEmail1" class="form-label">Tipe Karyawan</label>
                    <select class="form-control" name="tipe_karyawan" required>
                        <option value="">Pilih Tipe Karyawan</option>
                        <option value="Fulltime">Fulltime</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Magang">Magang</option>
                    </select>

                    <div class="mb-3">                        
                        <div class="input-group" disable>
                            <input  type="hidden" class="form-control" placeholder="dd/mm/yyyy" id="datepicker" name="tglkeluar" rows="10" disabled></input>                           
                        </div><!-- input-group -->
                    </div>                    

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Jabatan</label>
                        <input type="text" name="jabatan" no_kk class="form-control" id="jabatan" aria-describedby="emailHelp" placeholder="Masukkan Jabatan" required>
                        <div id="emailHelp" class="form-text"></div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Gaji Pokok</label>
                        <input type="text" name="gaji" class="form-control" id="gaji" placeholder="Masukkan Gaji Pokok" required>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">No. BPJS Ketenagakerjaan</label>
                        <input type="number" name="no_bpjs_ket" class="form-control" id="no_bpjs_ket" placeholder="Masukkan No BPJS Kesehatan">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="10"></textarea><br>
                    </div>
                   

        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" value="save" class="btn btn-primary waves-effect waves-light">Save changes</button>
                    </div>

                    

                    <!-- <div class="alert alert-success">
                        Data berhasil disimpan <a href="#" class="alert-link"></a>.
                    </div> -->


                </form>

                
            </div>

        </div>

    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<!-- END MODAL -->

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

<!-- jQuery  -->


<script src="assets/js/jquery.min.js"></script>



<!-- Plugins js -->
<script src="assets/plugins/timepicker/bootstrap-timepicker.js"></script>
<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="assets/pages/form-advanced.js"></script>