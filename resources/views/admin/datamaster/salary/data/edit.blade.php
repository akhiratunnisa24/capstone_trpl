{{-- MODALS EDIT DATA CUTI --}}
<div class="modal fade" id="Modaleditcuti{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modaleditcuti" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Modaleditcuti">Edit Kategori</h4>
            </div>
            <div class="modal-body">
                {{-- {{ route('cuti.update',$jeniscuti->id) }} --}}
                <form id="formModaleditcuti" action="/cuti_update/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-sm">
                        <label for="jenis_cuti" class="col-form-label">Kategori Cuti</label>
                        <input type="text" class="form-control" name="jenis_cuti" id="jenis_cuti" value="{{$data->jenis_cuti}}" autocomplete="off" required>
                    </div>
            
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>