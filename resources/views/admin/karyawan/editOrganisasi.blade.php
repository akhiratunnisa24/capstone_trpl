<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<div class="modal fade bs-example-modal-md" id="editPekerjaan{{ $org->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editIdentitas" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myLargeModalLabel">Edit Data Riwayat Organisasi & Komunitas</h4>
            </div>
            <div class="modal-body">
                <form id="formModaleditcuti" action="/updateOrganisasi/{{ $org->id }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id_organisasi" value="{{ $org->id }}">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nama Organisasi</label>
                                    <input type="text" name="namaOrganisasi" autocomplete="off" class="form-control"
                                        value="{{ $org->nama_organisasi }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Alamat Organisasi</label>
                                    <input type="text" name="alamatOrganisasi" autocomplete="off"
                                        class="form-control" value="{{ $org->alamat }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label class="form-label">Lama Bertugas</label>
                                    <div>
                                        <div class="input-group">
                                            <input id="datepicker-autoclose-format-o" type="text" class="form-control" placeholder="mm/yyyy" 
                                                name="tglmulai" autocomplete="off"  rows="10"  id="tglmulai" value="{{ $org->tgl_mulai }}">
                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                            <input id="datepicker-autoclose-format-p" type="text" class="form-control" placeholder="mm/yyyy" 
                                                name="tglselesai" autocomplete="off" id="tglselesai"  rows="10" value="{{ $org->tgl_selesai }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="mb-3">
                                        <label>Jabatan</label>
                                        <input type="text" name="jabatanRorganisasi" class="form-control"
                                            autocomplete="off" value="{{ $org->jabatan }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Nomor Surat Keterangan</label>
                                    <input type="text" name="noSKorganisasi" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Jabatan" autocomplete="off" value="{{ $org->no_sk }}">
                                </div>
                            </div>

                        </div>


                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
