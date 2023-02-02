<!-- MODAL BEGIN -->

<!-- MODAL BEGIN -->

<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 class="modal-title text-center" id="myModalLabel">Tambah Tahapan Rekruitmen</h4>


            <div class="modal-body">

                <form method="POST" action="{{ url('store_metode_rekrutmen') }}">
                    @csrf
                    @method('POST')

                   <div class="form-group col-xs-12  m-t-20">
                        <label class="form-label">Nama Tahapan Rekruitmen</label>
                        <input type="text" class="form-control m-t-10" name="namaTahapan" placeholder="Masukkan Nama Tahapan Rekruitmen" required>
                    </div>


                    {{-- {{-- <div class="form-group"> --}}
                    <div class="col-xs-12">
                        <div class="checkbox checkbox-primary">

                        </div>
                    </div>

                    {{-- <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary w-md waves-effect waves-light"
                                type="submit">Simpan</button>
                                
                        </div>
                    </div> --}}



                <div class="modal-footer">
                    <button class="btn btn-primary waves-effect waves-light"
                                type="submit">Simpan</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="modal">Tutup</button>
                </div>
                </form>

            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<!-- END MODAL -->



