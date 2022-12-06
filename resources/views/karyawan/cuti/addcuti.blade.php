{{-- FORM PENGAJUAN CUTI --}}
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="Modal">Form Permohonan Cuti</h4>
                </div>
                @if ($errors->any()) 
                    <div class="alert alert-danger show" role="alert">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br> 
                            <ul> 
                                @foreach ($errors->all() as $error) 
                                    <li>{{ $error }}</li> 
                                @endforeach 
                            </ul> 
                    </div> 
                @endif 
                <div class="modal-body">
                    <form action="{{ route('cuti.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group col-sm">
                            <label for="id_karyawan" class="col-form-label">Nama</label>
                            <input type="text" class="form-control" id="id_karyawan" value="{{Auth::user()->name}}" readonly>
                            <input type="hidden" class="form-control" id="id_karyawan" value="{{$karyawan}}" hidden>
                        </div>
                    
                        <div class="form-group col-sm">
                            <label for="id_jeniscuti" class="col-form-label">Kategori Cuti</label>
                            <select name="id_jeniscuti" id="id_jeniscuti" class="form-control">
                                <option>-- Pilih Kategori --</option>
                                @foreach ($jeniscuti as $data)
                                    <option value="{{ $data->id}}"
                                        @if ($data->id ==request()->id_jeniscuti)
                                        selected
                                        @endif
                                        >{{ $data->jenis_cuti }}
                                    </option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="form-group col-sm">
                            <label for="keperluan" class="col-form-label">Keperluan</label>
                            <input type="text" class="form-control" name="keperluan" id="keperluan" required>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="m-t-20">
                                    {{-- <form class="" action="#"> --}}
                                        <div class="form-group">
                                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclosea" name="tgl_mulai"  autocomplete="off" onchange=(jumlahcuti()) rows="10" required>
                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                           
                            <div class="col-sm-6 col-xs-12">
                                <div class="m-t-20">
                                    {{-- <form class="" action="#"> --}}
                                        <div class="form-group">
                                            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autocloseb" name="tgl_selesai"  autocomplete="off" onchange=(jumlahcuti()) rows="10" required>
                                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                            </div>
                                        </div>
                                    {{-- </form> --}}
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group col-sm">
                            <label for="jml_cuti" class="col-form-label">Jumlah Cuti</label>
                            <input type="text" class="form-control" name="jml_cuti" id="jumlah" readonly>
                        </div>

                        <div class="form-group col-sm">
                            <input type="hidden" class="form-control" name="status" id="status" value="Pending" readonly>
                        </div>
                            
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success" value="save">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
    <script type="text/javascript">
        $('#datepicker-autoclosea').datepicker({
            autoclose: true,
        });
        $('#datepicker-autocloseb').datepicker({
            autoclose: true,
        });

        function jumlahcuti(){
            var start= $('#datepicker-autoclosea').val();
            var end  = $('#datepicker-autocloseb').val();

            var start_date = new Date(start);
            var end_date   = new Date(end);
            var daysOfYear = [];

            //untuk mendapatkan jumlah hari cuti
            for (var d = start_date; d <= end_date; d.setDate(d.getDate() + 1)) {
                
                //cek workdays
                let tanggal = new Date(d);
                if(tanggal.getDay() !=0 && tanggal.getDay() !=6){
                    daysOfYear.push(tanggal);
                    console.log(tanggal);
                } else{
                    console.log(" Hari Libur" + tanggal.getDay());
                }
            }
            //mengambil value tanggal mulai
            $('#start_date').on('change', function() {
                jumlahcuti();
            });

            //mengambil value tanggal selesai
            $('#end_date').on('change', function() {
                jumlahcuti();
            });

            console.info(daysOfYear);
            // alert('test');

            $('#jumlah').val(daysOfYear.length ?? 0);
        };
    </script>

     <!-- jQuery  -->
     <script src="assets/js/jquery.min.js"></script>
     <script src="assets/js/bootstrap.min.js"></script>
     <script src="assets/js/modernizr.min.js"></script>
     <script src="assets/js/detect.js"></script>
     <script src="assets/js/fastclick.js"></script>
     <script src="assets/js/jquery.slimscroll.js"></script>
     <script src="assets/js/jquery.blockUI.js"></script>
     <script src="assets/js/waves.js"></script>
     <script src="assets/js/wow.min.js"></script>
     <script src="assets/js/jquery.nicescroll.js"></script>
     <script src="assets/js/jquery.scrollTo.min.js"></script>
 
     {{-- plugin js --}}
     <script src="assets/plugins/timepicker/bootstrap-timepicker.js"></script>
     <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
   
     <!-- Datatable init js -->
     <script src="assets/pages/datatables.init.js"></script>
     <script src="assets/js/app.js"></script>
 
     <!-- Plugins Init js -->
     <script src="assets/pages/form-advanced.js"></script>
    
   