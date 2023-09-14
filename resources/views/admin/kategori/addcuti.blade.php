{{-- FORM TAMBAH KATEGORI CUTI --}}
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Kategori Cuti</h4>
            </div>
            <div class="modal-body">
                <form action="{{route ('kategori.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="jenis_cuti" class="col-form-label">Kategori Baru</label>
                        <input type="text" class="form-control" name="jenis_cuti" id="jenis_cuti" autocomplete="off"
                            placeholder="Masukkan Kategori" required>
                            <input type="hidden" class="form-control" name="status" id="status" autocomplete="off" value="0"
                            placeholder="Masukkan Kategori" required>
                    </div>
                    <input id="partner" type="hidden" class="form-control" name="partner" value="{{Auth::user()->partner}}" autocomplete="off" >

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>