{{-- MODALS EDIT DATA CUTI --}}
<div class="modal fade" id="Modaledittim{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modaleditcuti" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Modaleditcuti">Edit master Tim</h4>
            </div>
            <div class="modal-body">
                <form id="formModaleditcuti" action="/tim-update/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-sm">
                        <label for="divisi" class="col-form-label">Divisi/Departemen</label>
                        <input type="text" class="form-control" name="divisis" id="divisis" value="{{$data->departemens->nama_departemen}}" autocomplete="off" disabled>
                        <input type="hidden" class="form-control" name="divisi" id="divisi" value="{{$data->divisi}}" autocomplete="off">
                    </div>
                    <div class="form-group col-sm">
                        <label for="namatim" class="col-form-label">Nama Tim</label>
                        <input type="text" class="form-control" name="namatim" id="namatim" value="{{$data->namatim}}" autocomplete="off">
                    </div>
                    <div class="form-group col-sm">
                        <label for="deskripsi" class="col-form-label">Deskripsi</label>
                        <input type="text" class="form-control" name="deskripsi" id="deskripsi" value="{{$data->deskripsi}}" autocomplete="off">
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