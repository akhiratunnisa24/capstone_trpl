{{-- MODALS EDIT DATA CUTI --}}
<div class="modal fade" id="Modaleditizin{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modaleditizin" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Modaleditizin">Edit Kategori</h4>
            </div>
            <div class="modal-body">
                {{-- {{ route('cuti.update',$jeniscuti->id) }} --}}
                <form id="formModaleditizin" action="/izin_update/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-sm">
                        <label for="jenis_izin" class="col-form-label">Kategori Ijin</label>
                        <input type="text" class="form-control" name="jenis_izin" id="jenis_izin" value="{{$data->jenis_izin}}" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="code" class="col-form-label">Kode Kategori</label>
                        <input type="text" class="form-control" name="code" id="code" value="{{$data->code}}" autocomplete="off">
                    </div>
        
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>