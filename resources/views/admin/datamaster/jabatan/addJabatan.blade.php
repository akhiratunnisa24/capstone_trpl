{{-- FORM TAMBAH DATA JABATAN--}}
<div class="modal fade" id="AddModal" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Jabatan</h4>
            </div>
            <div class="modal-body">
                <form action="{{ route('jabatan.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="level_jabatan" class="col-form-label">Level jabatan</label>
                        <input type="text" class="form-control" name="level_jabatan" id="level_jabatan" autocomplete="off"
                            placeholder="Pilih Level Jabatan" required>
                    </div>

                    <div class="form-group col-sm">
                        <label for="nama_jabatan" class="col-form-label">Nama Jabatan</label>
                        <input type="text" class="form-control" name="nama_jabatan" id="nama_jabatan" autocomplete="off"
                            placeholder="Masukkan Nama Jabatan" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success waves-effect waves-light" name="submit"
                            value="save">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>