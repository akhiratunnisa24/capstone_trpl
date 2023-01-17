<!-- MODAL BEGIN -->

<!-- sample modal content -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title text-center" id="myModalLabel">Keterangan Tidak Masuk </h4>


            <div class="modal-body ">

                <form method="POST" action="{{ url('/tidakmasuk') }}">
                    @csrf
                    @method('POST')

                    <div class="form-group">
                        <div class="form-group" id="id_pegawai">
                            <div class="col-xs-12" id="id_pegawai">
                                <br>
                                <label for="id_pegawai" class="form-label">Keterangan</label>
                                <select id="status" class="form-control" name="status" required>
                                    <option value="">Pilih Keterangan Tidak Masuk</option>
                                    <option value="Cuti">Cuti</option>
                                    <option value="Izin">Izin</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="checkbox checkbox-primary">

                            </div>

                        </div>
                    </div>

                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">

                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button class="btn btn-primary w-md waves-effect waves-light"type="submit">Submit</button>
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    </div>

                </form>

            </div>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->


<!-- END MODAL -->
<!-- jQuery  -->
