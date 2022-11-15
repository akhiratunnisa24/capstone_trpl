
        <link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">



<!-- sample modal content -->
<div id="myModal2{{ $k->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                    <h4 class="modal-title" id="myModalLabel">Edit Data Karyawan </h4>
                                                                </div>
                                                                

                                                                <div class="modal-body">

                                                                
                                                                   
                                                                    <form  action="karyawan/update/{{$k->id}}" method="POST">
                                                                    
                                                                    @csrf
                                                                    @method('put')

                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">NIK</label>
                                                                        <input type="text" class="form-control" name="nik" id="nik" value="{{$k->nik}}">                                                                                                                                  
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Nama</label>
                                                                        <input  type="text" name="nama" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$k->nama}}">
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Email</label>
                                                                        <input  type="text" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{$k->email}}">
                                                                    </div>
                                                                    <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                                                        <select class="form-control" name="jenis_kelamin" required>
                                                                            <option value="">Pilih Jenis Kelamin</option>
                                                                            <option value="L">Laki-Laki</option>
                                                                            <option value="P">Perempuan</option>
                                                                            
                                                                        </select><br>

                                                                        
                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                                                        <textarea class="form-control" name="alamat" rows="10" >{{$k->alamat}}</textarea><br>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Tanggal Masuk</label>
                                                                        <input id="datepicker-autoclose2" class="form-control" name="tglmasuk" rows="10" value="{{$k->tglmasuk}}"></input><br>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="exampleInputEmail1" class="form-label">Tanggal Keluar</label>
                                                                        <input  class="form-control" name="tglkeluar" rows="10" value="{{$k->tglkeluar}}" id="datepicker-autoclose2" disabled></input><br>
                                                                    </div>
                                                                     
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                                                                            <button type="submit" name="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>                                                            
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