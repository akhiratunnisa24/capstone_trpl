{{-- FORM SETTING ALOKASI--}}
<div class="modal fade" id="editalokasi" tabindex="-1" role="dialog" aria-labelledby="editalokasi" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="editaloaksi">Edit Alokasi Cuti</h4>
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
                <form class="input" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="panel-body">
                        <div class="col-md-6">
                            <h4 for="" class="col-form-label">Opsi</h4>
                            <div class="form-group" id="kode">
                                <label for="code_p" class="col-form-label">Kode</label>
                                <input type="text" class="form-control" name="code_p" id="code_p">
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="take_timeoff" class="col-form-label">Waktu Cuti</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="radio">
                                        <input type="radio" name="take_timeoff1" id="radio1" value="Day" checked>
                                        <label for="take_timeoff">
                                            Day
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="take_timeoff2" id="radio2" value="Half Day">
                                        <label for="take_timeoff">
                                            Half Day
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="take_timeoff3" id="radio3" value="Hours">
                                        <label for="take_timeoff">
                                            Hours
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 for="" class="col-form-label">Tujuan Alokasi</h4>
                                <div class="col-md-3">
                                    <label for="allocation_mode" class="col-form-label">Mode</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="radio">
                                        <input type="radio" name="take_timeoff4" id="radio4" value="Day" checked>
                                        <label for="take_timeoff">
                                            No Limit
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="take_timeoff5" id="radio5" value="Half Day">
                                        <label for="take_timeoff">
                                           Allow Employee Request
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="take_timeoff6" id="radio6" value="Hours">
                                        <label for="take_timeoff">
                                            Set By Time Office
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" id="responsible">
                                <label for="respon" class="col-form-label">Responsible</label>
                                <input type="text" class="form-control" name="respon" id="respon">
                            </div>
                        </div>

                        <div class="col-md-6" id="validitas">
                            <h4 for="" class="col-form-label">Validasi</h4>
                            <div class=""  id="tanggalmulai">
                                <div class="form-group">
                                    <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose3" name="tgl_mulai" onchange=(jumlahhari()) autocomplete="off">
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="" id="tanggalselesai">
                                <div class="form-group">
                                    <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="mm/dd/yyyy" id="datepicker-autoclose4" name="tgl_selesai"  onchange=(jumlahhari()) autocomplete="off">
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h4 for="" class="col-form-label">Permintaan Cuti</h4>
                                <div class="col-md-3">
                                    <label for="allocation_mode" class="col-form-label">Persetujuan</label>
                                </div>
                                <div class="col-md-9">
                                    <div class="radio">
                                        <input type="radio" name="take_timeoff7" id="radio7" value="No Validation" checked>
                                        <label for="take_timeoff">
                                            No Validation
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="take_timeoff8" id="radio8" value="By time off officer">
                                        <label for="take_timeoff">
                                           By time off officer
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="take_timeoff9" id="radio9" value="HBy Employees Manager">
                                        <label for="take_timeoff">
                                            By Employees Manager
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <input type="radio" name="take_timeoff9" id="radio9" value="By Employees Manager & Time off officer">
                                        <label for="take_timeoff">
                                            By Employees Manager & Time off officer
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info" name="submit" value="save">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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

{{-- // Datatable init js  --}}
<script src="assets/pages/datatables.init.js"></script>
<script src="assets/js/app.js"></script>

{{-- // Plugins Init js --}}
<script src="assets/pages/form-advanced.js"></script>

<script type="text/javascript">
    $(function()
    {
        $('#mode_compan').prop("hidden", true);
        $('#mode_departeme').prop("hidden", true);
        $('#mode_employe').prop("hidden", true);

        $('#modealokasis').on('change', function(e)
        {
            if(e.target.value== 'By Company')
            {
                $('#mode_compan').prop("hidden", false);
                $('#mode_departeme').prop("hidden", true);
                $('#mode_employe').prop("hidden", true);
            } else if(e.target.value== 'By Departemen')
            {
                $('#mode_compan').prop("hidden", true);
                $('#mode_departeme').prop("hidden", false);
                $('#mode_employe').prop("hidden", true);
            }else{
                $('#mode_compan').prop("hidden", true);
                $('#mode_departeme').prop("hidden", true);
                $('#mode_employe').prop("hidden", false);
            }
        });
    });
</script>





         