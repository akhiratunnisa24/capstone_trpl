{{-- FORM TAMBAH JOBS --}}
<div class="modal fade" id="addJob" tabindex="-1" role="dialog" aria-labelledby="addJob" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Jobs Baru</h4>
            </div>
            <div class="modal-body">
                {{-- {{route ('job.store')}} --}}
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="" class="col-form-label">Nama Jobs</label>
                        <input type="text" class="form-control" name="nama_job" id="nama_job" autocomplete="off"
                            placeholder="Masukkan Job Baru" required>
                    </div>
                    <div class="form-group col-sm">
                        <label for="" class="col-form-label">Departemen</label>
                        <select class="form-control selecpicker" data-live-search="true" name="id_departemen" id="id_departemen" autocomplete="off">
                            <option value="">Pilih Departemen</option>
                            <option value="">A</option>
                            <option value="">B</option>
                        </select>
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