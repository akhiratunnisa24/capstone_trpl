{{-- FORM TAMBAH DATA DEPARTEMEN --}}
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Data Divisi</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('divisi.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="nama_departemen" class="col-form-label">Nama Divisi</label>
                        <input type="text" class="form-control" name="nama_departemen" id="nama_departemen" autocomplete="off"
                            placeholder="Masukkan Nama Divisi" required>
                    </div>
                    <input id="partner" type="hidden" class="form-control" name="partner" value="{{Auth::user()->partner}}" autocomplete="off" >

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>