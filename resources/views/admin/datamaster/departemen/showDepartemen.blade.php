{{-- MODALS Show Departemen--}}
<div class="modal fade" id="showDepartmen{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="showDepartmen" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="showDepartmen">Detail Departemen</h4>
            </div>
            <div class="modal-body">
                
                {{-- <div class="form-group row">
                    <label for="id" class="col-sm-3 col-form-label">ID Departemen</label>
                    <div class="col-sm-9">
                        <label>: {{$data->id}}</label>
                    </div>
                </div> --}}

                <div class="form-group row">
                    <label for="nama-departemen" class="col-sm-3 col-form-label">Nama Departemen</label>
                    <div class="col-sm-9">
                        <label>: {{$data->nama_departemen}}</label>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>