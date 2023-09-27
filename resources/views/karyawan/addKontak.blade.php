<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="addKontak" tabindex="-1" role="dialog" aria-labelledby="editPformal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myLargeModalLabel">Tambah Data Kontak Darurat</h4>
            </div>
            <div class="modal-body">
                <form id="" action="/storeskontakdarurat/{{$karyawan->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="idpegawai" autocomplete="off" value="{{$karyawan->id}}" class="form-control">
                            <div class="form-group m-t-10">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="namaKdarurat" class="form-control" placeholder="Masukkan Nama" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Hubungan</label>
                                    <select class="form-control" name="hubunganKdarurat" required>
                                        <option value="">Pilih Hubungan</option>
                                        <option value="Ayah">Ayah</option>
                                        <option value="Ibu">Ibu</option>
                                        <option value="Suami">Suami</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Kakak">Kakak</option>
                                        <option value="Adik">Adik</option>
                                        <option value="Anak">Anak</option>
                                        <option value="Famili/Suadara/Teman">Famili/Suadara/Teman</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="mb-3 ">
                                    <label for="exampleInputEmail1" class="form-label">Alamat</label>
                                    <input class="form-control" name="alamatKdarurat" rows="9" placeholder="Masukkan Alamat">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">No. Handphone</label>
                                    <input type="number" name="no_hpKdarurat" class="form-control" id="no_hp" placeholder="Masukkan Nomor Handphone">
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->