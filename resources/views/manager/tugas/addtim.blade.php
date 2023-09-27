{{-- FORM TAMBAH KATEGORI CUTI --}}
<style>
    .col-form-label{
        -webkit-text-fill-color: black;
    }
</style>
<div class="modal fade" id="Modaltim" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Master Tim</h4>
            </div>
            <div class="modal-body">
                <form action="{{route ('tim.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="divisi" class="col-form-label">Departemen Tim</label>
                        <input type="text" class="form-control" name="divisis" id="divisis" value="{{$departemen->nama_departemen}}" autocomplete="off" disabled>
                        <input type="hidden" class="form-control" name="divisi" id="divisi" value="{{$departemen->id}}" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="namatim" class="col-form-label">Nama Tim</label>
                        <input type="text" class="form-control" name="namatim" id="namatim" placeholder="Masukkan Nama Tim" autocomplete="off" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="deskripsi" class="col-form-label">Deskripsi</label>
                        <textarea type="text" class="form-control" name="deskripsi" id="deskripsi" placeholder="Deskripsi Tim" autocomplete="off" required></textarea>
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

