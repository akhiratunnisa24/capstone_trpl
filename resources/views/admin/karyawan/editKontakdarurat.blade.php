<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="editDarurat{{$kondar->id}}" tabindex="-1" role="dialog" aria-labelledby="editDarurat" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title center" id="myLargeModalLabel">Edit Data Kontak Darurat</h4>
            </div>
            <div class="modal-body">
                <form id="formModaleditcuti" action="/updateKontak/{{$kondar->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id_kdarurat" value="{{$kondar->id}}">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="namaKdarurat" class="form-control" autocomplete="off" value="{{$kondar->nama}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Hubungan</label>
                                    <select type="text" class="form-control" name="hubunganKdarurat" required>
                                        <option value="">Pilih Hubungan</option>
                                        <option value="Ayah" @if($kondar->hubungan == "Ayah") selected @endif >Ayah</option>
                                        <option value="Ibu"  @if($kondar->hubungan == "Ibu") selected @endif >Ibu</option>
                                        <option value="Suami" @if($kondar->hubungan == "Suami") selected @endif>Suami</option>
                                        <option value="Istri" @if($kondar->hubungan == "Istri") selected @endif>Istri</option>
                                        <option value="Kakak" @if($kondar->hubungan == "Kakak") selected @endif>Kakak</option>
                                        <option value="Adik" @if($kondar->hubungan == "Adik") selected @endif>Adik</option>
                                        <option value="Anak" @if($kondar->hubungan == "Anak") selected @endif>Anak</option>
                                        <option value="Famili/Suadara/Teman"@if($kondar->hubungan == "Famili/Suadara/Teman") selected @endif>Famili/Suadara/Teman</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Alamat </label>
                                    <input type="text" name="alamatKdarurat" class="form-control" autocomplete="off" value="{{$kondar->alamat}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nomor Handphone</label>
                                    <input type="text" name="no_hpKdarurat" autocomplete="off" class="form-control" value="{{$kondar->no_hp}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
