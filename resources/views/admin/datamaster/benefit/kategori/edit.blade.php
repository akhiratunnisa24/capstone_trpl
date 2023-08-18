{{-- MODALS EDIT DATA CUTI --}}
<div class="modal fade" id="edit{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="Modaleditcuti" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Modaleditcuti">Edit Kategori</h4>
            </div>
            <div class="modal-body">
                <form id="formModaleditcuti" action="/kategori-update/{{$data->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group col-sm">
                        <label class="col-form-label">Kategori Benefit</label>
                        <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" value="{{$data->nama_kategori}}" autocomplete="off">
                    </div>
                    <div class="form-group col-sm">
                        <label for="jenis_cuti" class="col-form-label">Kode Kategori</label>
                        <input type="text" class="form-control" name="kode" id="kode" autocomplete="off" value="{{$data->kode}}" placeholder="Masukkan Kode">
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