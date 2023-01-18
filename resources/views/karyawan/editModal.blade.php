<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">



<!-- sample modal content -->
<div id="myModal2{{ $k->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Karyawan </h4>
            </div>


            <div class="modal-body">

            

                <form action="karyawan/update/{{$k->id}}" method="POST">

                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" id="nik" value="{{$k->nik}}">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" id="exampleInputEmail1"  value="{{$k->nama}}">
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                        <input id="datepicker-autoclose4" class="form-control" name="tgllahir" rows="10" value="{{$k->tgllahir}}"></input>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="exampleInputEmail1"  value="{{$k->email}}">
                    </div>
                    <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                    <select class="form-control" name="jenis_kelamin" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>


                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat" rows="10">{{$k->alamat}}</textarea><br>
                    </div>

                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">No. Handphone</label>
                        <input type="text" class="form-control" name="no_hp" id="no_hp" value="{{$k->no_hp}}">
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
                        <input id="" class="form-control" name="tglmasuk" rows="10" value="{{$k->tglmasuk}}"></input><br>
                    </div>

                    <div class="mb-3">                        
                        <input type="hidden" class="form-control" name="tglkeluar" rows="10" value="{{$k->tglkeluar}}" id="" disabled></input><br>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-success waves-effect waves-light">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
<!-- END MODAL -->


<script src="assets/js/jquery.min.js"></script>



<!-- Plugins js -->
<script src="assets/plugins/timepicker/bootstrap-timepicker.js"></script>
<script src="assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-touchspin/js/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>

<!-- Plugins Init js -->
<script src="assets/pages/form-advanced.js"></script>
