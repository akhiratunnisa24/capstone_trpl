  {{-- FORM TAMBAH KATEGORI IZIN--}}
  <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="smallModal">Tambah Kategori Ijin</h4>
            </div>
            <div class="modal-body">
                <form action="{{route ('izin.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="jenis_izin" class="col-form-label">Kategori Baru</label>
                        <input type="text" class="form-control" name="jenis_izin" id="jenis_izin" placeholder="Masukkan Kategori" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="code" class="col-form-label">Kode Kategori</label>
                        <input type="text" class="form-control" name="code" id="code" placeholder="Masukkan Kode" autocomplete="off" required>
                    </div>
        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="submit" value="save" class="btn btn-sm btn-success waves-effect waves-light">Simpan</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div> 