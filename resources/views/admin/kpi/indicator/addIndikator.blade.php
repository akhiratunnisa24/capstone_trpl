{{-- FORM TAMBAH JOBS --}}
<div class="modal fade" id="addIndikator" tabindex="-1" role="dialog" aria-labelledby="addJob" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Indikator Baru</h4>
            </div>
            <div class="modal-body">
                {{-- {{route ('job.store')}} --}}
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group col-sm">
                        <label for="" class="col-form-label">Nama Master</label>
                        <select class="form-control selectpicker" name="id_master" id="id_master" autocomplete="off" data-live-search="true">
                            <option value="">Pilih Master</option>
                            <option value="">Master A</option>
                            <option value="">Master B</option>
                            {{-- @foreach ($departemen as $dep)
                                <option value="{{ $dep->id }}">{{ $dep->nama_departemen }}
                                </option>
                            @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group col-sm">
                        <label for="" class="col-form-label">Indikator</label>
                        <textarea type="text" class="form-control" name="indikator" id="indikator" autocomplete="off" rows="3" placeholder="Masukkan Indikator" required></textarea>
                    </div>
                    <div class="form-group col-sm">
                        <label for="" class="col-form-label">Deskripsi</label>
                        <textarea type="text" class="form-control" name="deskripsi" id="deskripsi" autocomplete="off" rows="5" placeholder="Masukkan Indikator" required></textarea>
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
<!-- jQuery  -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
