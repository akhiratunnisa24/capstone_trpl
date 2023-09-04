<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="Modals" tabindex="-1" role="dialog" aria-labelledby="editPformal"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myLargeModalLabel">Tambah Data Lembur</h4>
            </div>
            <div class="modal-body">
                <form id="" action="/rekap-kehadiran" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="col-sm-12">
                        <div class="form-group">
                            <div class="mb-3">
                                <label class="form-label">Periode</label>
                                <div>
                                    <div class="input-group">
                                        <input id="datepicker-autoclose-format-ag" type="text" class="form-control" placeholder="dd/mm/yyyy" 
                                        name="tgl_awal"  autocomplete="off"  rows="10">
                                        <span class="input-group-addon bg-info text-white b-0">-</span>
                                        <input id="datepicker-autoclose-format-ah" type="text" class="form-control" placeholder="dd/mm/yyyy" 
                                            name="tgl_akhir" autocomplete="off"  rows="10">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="form-control" name="partner" value="{{Auth::user()->partner}}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success">Kalkulasi Kehadiran</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
