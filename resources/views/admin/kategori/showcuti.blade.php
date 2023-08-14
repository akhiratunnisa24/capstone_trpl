{{-- MODALS EDIT DATA CUTI --}}
<div class="modal fade" id="Modalshowcuti{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modalshowcuti" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Modalshowcuti">Detail Kategori</h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="id" class="col-sm-3 col-form-label">ID Kategori</label>
                    <div class="col-sm-9">
                        <label>: {{$data->id}}</label>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis_cuti" class="col-sm-3 col-form-label">Kategori Cuti</label>
                    <div class="col-sm-9">
                        <label>: {{$data->jenis_cuti}}</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
