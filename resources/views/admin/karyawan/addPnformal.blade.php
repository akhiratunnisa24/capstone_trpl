<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="addPnformal" tabindex="-1" role="dialog" aria-labelledby="editPformal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title center" id="myLargeModalLabel">Edit Data Pendidikan Non Formal</h4>
            </div>
            <div class="modal-body">
                <form id="formModaleditcuti" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id_pendidikan">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Bidang/ Jenis Pendidikan</label>
                                    <input type="text" name="jenis_pendidikan" autocomplete="off" class="form-control">
                                    <input type="text" name="jenis_pendidikan" autocomplete="off" value="{{$karyawan->id}}" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Kota</label>
                                    <input type="text" name="kotaPendidikanNonFormal" autocomplete="off" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Lulus Tahun</label>
                                    <div class="input-group">
                                        <input id="datepicker-autoclose4" type="text"
                                                class="form-control" placeholder="yyyy" id="4" name="tahunLulusNonFormal" autocomplete="off" rows="10"><br>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->