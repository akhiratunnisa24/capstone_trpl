{{-- FORM TAMBAH KATEGORI CUTI --}}
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Kategori Cuti</h4>
            </div>
            <div class="modal-body">
                <form action="{{route ('kategori.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="jenis_cuti" class="col-form-label">Kategori Baru</label>
                        <input type="text" class="form-control" name="jenis_cuti" id="jenis_cuti" required>
                    </div>
            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light" name="submit" value="save">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>