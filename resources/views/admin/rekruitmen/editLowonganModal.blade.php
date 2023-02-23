<!-- MODAL BEGIN -->
<!-- sample modal content -->
<div id="myModal{{ $k->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="Showcuti">Detail Lowongan</h4>
            </div>

            <div class="modal-body">
                <form method="POST" action="rekrutmenupdate{{ $k->id }}">
                    @csrf
                    @method('put')

                    <div class="form-group row">
                        <h4 class="col-sm-9  col-form-label ">Nama Posisi : <strong> {{ $k->posisi }}</strong></h4>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-9 col-form-label">Jumlah Dibutuhkan :</label>
                        <div class="col-sm-12">
                            <input name="jumlahDibutuhkan" class="form-control" value="{{ $k->jumlah_dibutuhkan }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-9 col-form-label">Status Lowongan :</label>
                        <div class="col-sm-12">
                            <select class=" form-control selectpicker" name="statusLowongan" required>
                                <option value="">Pilih Status</option>
                                <option value="Aktif" @if ($k->status == 'Aktif') selected @endif>Aktif</option>
                                <option value="Tidak Aktif" @if ($k->status == 'Tidak Aktif') selected @endif>Tidak
                                    Aktif</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-9 col-form-label">Periode Lamaran</label>
                        <div class="col-sm-12">
                            <div class="input-daterange input-group" >
                                <input id="date" type="date" class="form-control" name="tglmulai" value="{{ $k->tgl_mulai }}"/>
                                <span class="input-group-addon bg-primary text-white b-0">To</span>
                                <input id="date" type="date" class="form-control" name="tglselesai" value="{{ $k->tgl_selesai }}"/>
                            </div>
                        </div>
                    </div>

                    

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

            </form>
        </div>
    </div>
</div><!-- /.modal-content -->
