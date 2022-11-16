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

                <form action="/karyawan/store" method="POST">

                    @csrf

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">NIP</label>
                        <input type="number" name="nip" class="form-control" id="nip" placeholder="Masukkan NIP">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Nama">
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
                        <input type="number" name="no_hp" class="form-control" id="no_hp" placeholder="Masukkan Nomor Handphone">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">NIP</label>
                        <input type="number" name="nik" class="form-control" id="nik" placeholder="Masukkan NIK">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" name="email" no_kk class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Email">
                        <div id="emailHelp" class="form-text"></div>
                    </div>

                    <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select><br>


                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="10"></textarea><br>
                    </div>

                    

                    <label for="exampleInputEmail1" class="form-label">Status Karyawan</label>
                    <select class="form-control" name="status_karyawan" required>
                        <option value="">Pilih Status Karyawan</option>
                        <option value="Tetap">Tetap</option>
                        <option value="Kontrak">Kontrak</option>
                        <option value="Probation">Probation</option>
                    </select><br>

                    <label for="exampleInputEmail1" class="form-label">Tipe Karyawan</label>
                    <select class="form-control" name="tipe_karyawan" required>
                        <option value="">Pilih Tipe Karyawan</option>
                        <option value="Fulltime">Fulltime</option>
                        <option value="Freelance">Freelance</option>
                        <option value="Magang">Magang</option>
                    </select><br>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Masuk</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose" name="tglmasuk" rows="10" required></input><br>
                            <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                        </div><!-- input-group -->
                    </div>



                    <div class="mb-3">                        
                        <div class="input-group" disable>
                            <input  type="hidden" class="form-control" placeholder="dd/mm/yyyy" id="datepicker" name="tglkeluar" rows="10" disabled></input><br>                            
                        </div><!-- input-group -->
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