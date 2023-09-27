{{-- FORM TAMBAH KATEGORI CUTI --}}
<div class="modal fade" id="nilai" tabindex="-1" role="dialog" aria-labelledby="Modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambahkan Nilai</h4>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="jenis_cuti" class="col-sm-2 col-form-label">Master Kpi</label>
                            
                            <div class="col-sm-10">
                                <label width="100%">Master A</label>
                            </div>
                        </div>
                        <div class="form-group row">
                           
                            <label for="jenis_cuti" class="col-sm-2 col-form-label">Indikator</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" name="indikator" id="indikator" autocomplete="off" rows="3" value="" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                           <label for="jenis_cuti" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" name="deskripsi" id="deskripsi" autocomplete="off" rows="5" readonly></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">Nilai KPI</label>
                            <div class="col-sm-10">
                                <label><input class="form-control" name="nilai" id="nilai" style="width:100%"></label>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit"
                            value="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>