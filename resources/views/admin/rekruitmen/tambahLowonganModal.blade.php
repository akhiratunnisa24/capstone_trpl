<!-- MODAL BEGIN -->

<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title text-center" id="myModalLabel">Tambah Lowongan Pekerjaan</h4>


            <div class="modal-body">

                <form method="POST" action="{{ url('store_rekrutmen') }}">
                    @csrf
                    @method('POST')

                    <div class="form-group col-xs-12">
                        <label class="form-label">Posisi</label>
                        <input type="text" class="form-control" name="posisi" placeholder="Masukkan posisi"
                            required>
                    </div>


                    <div class="form-group col-xs-12">
                        <label class="form-label">Jumlah Dibutuhkan</label>
                        <input type="number" class="form-control " name="jumlah_dibutuhkan"
                            placeholder="Masukkan jumlah dibutuhkan">
                    </div>

                    <div class="form-group col-xs-12">
                        <label class="form-label">Persyaratan</label>
                        <textarea type="text" class="form-control " rows="9" name="persyaratan"
                            placeholder="Masukkan Persyaratan"></textarea>
                    </div>




                    {{-- {{-- <div class="form-group"> --}}
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">

                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary w-md waves-effect waves-light"
                                type="submit">Simpan</button>
                        </div>
                    </div>

                </form>


                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button> --}}
                    <!-- <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button> -->
                </div>

            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<!-- END MODAL -->
