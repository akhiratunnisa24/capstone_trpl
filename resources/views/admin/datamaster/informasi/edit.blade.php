 <!--bootstrap-wysihtml5-->

<div class="modal fade" id="ShowInformasi{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Edit Data Informasi</h4>
            </div>
            <div class="modal-body">
                <form action="/informasi/update/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Judul</label>
                                <input type="text" class="form-control" name="judul" id="judul" value="{{$data->judul}}" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label">Konten</label>
                            <div class="panel panel-secondary">
                                {{-- <div class="panel-heading">Konten</div> --}}
                                <div class="panel-body">
                                    <textarea class="wysihtml5 form-control" rows="9" name="konten">{{$data->konten}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="date_range">
                        <div class="col-sm-6 col-xs-12">
                            <div class="m-t-10">
                                <div class="form-group">
                                    <label class="form-label">Tanggal Aktif</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="dd/mm/yyyy" value="{{\Carbon\Carbon::parse($data->tanggal_aktif)->format('d/m/Y')}}" id="datepicker-autoclose49" name="tanggal_aktif"  autocomplete="off" readonly>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-xs-12">
                            <div class="m-t-10">
                                <div class="form-group">
                                    <label class="form-label">Sampai</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="dd/mm/yyyy" value="{{\Carbon\Carbon::parse($data->tanggal_berakhir)->format('d/m/Y')}}"  id="datepicker-autoclose50" name="tanggal_berakhir"  autocomplete="off" readonly>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit" value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <script src="assets/js/jquery.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script><!--Summernote js-->
<script src="assets/js/modernizr.min.js"></script>
<script src="assets/js/detect.js"></script>
<script src="assets/js/fastclick.js"></script>
<script src="assets/js/jquery.slimscroll.js"></script>
<script src="assets/js/jquery.blockUI.js"></script>
<script src="assets/js/waves.js"></script>
<script src="assets/js/wow.min.js"></script>
<script src="assets/js/jquery.nicescroll.js"></script>
<script src="assets/js/jquery.scrollTo.min.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script> --}}

<script src="assets/js/app.js"></script>

<script>

    jQuery(document).ready(function(){
        $('.wysihtml5').wysihtml5();

        $('.summernote').summernote({
            height: 200,                 // set editor height

            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor

            focus: true                 // set focus to editable area after initializing summernote
        });

    });
</script>
