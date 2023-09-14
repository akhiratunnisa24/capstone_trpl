{{-- FORM TAMBAH KATEGORI CUTI --}}
<div class="modal fade" id="Add" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Kategori Benefit</h4>
            </div>
            <div class="modal-body">
                <form action="{{route ('kategori.benefit')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="jenis_cuti" class="col-form-label">Kategori Baru</label>
                        <input type="text" class="form-control" name="nama_kategori" id="nama_kategori" autocomplete="off"
                            placeholder="Masukkan Kategori" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="jenis_cuti" class="col-form-label">Kode Kategori</label>
                        <input type="text" class="form-control" name="kode" id="kode" autocomplete="off" placeholder="Masukkan Kode" required>
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