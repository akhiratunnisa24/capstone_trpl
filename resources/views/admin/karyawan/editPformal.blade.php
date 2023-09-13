<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="editPformal{{ $rpendidikan->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editPformal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title center" id="myLargeModalLabel">Edit Data Pendidikan Formal</h4>
            </div>
            <div class="modal-body">
                <form id="formModaleditcuti" action="/updatePendidikan/{{ $rpendidikan->id }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id_pendidikan" value="{{ $rpendidikan->id }}">
                            {{-- <div class="form-group">
                                <div class="mb-3">
                                    <label>Tingkat Pendidikan</label>
                                    <input type="text" name="tingkat_pendidikan" autocomplete="off"
                                        class="form-control" value="{{ $rpendidikan->tingkat }}">
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <div class="mb-3">
                                <label class="form-label">Tingkat Pendidikan</label>
                                <select class="form-control" name="tingkat_pendidikan" type="text">
                                    <option value="">Pilih Tingkat Pendidikan</option>
                                    <option value="SD"  @if($rpendidikan->tingkat == "SD") selected @endif>SD</option>
                                    <option value="SMP"  @if($rpendidikan->tingkat == "SMP") selected @endif>SMP</option>
                                    <option value="SMA/Sederajat"  @if($rpendidikan->tingkat == "SMA/Sederajat") selected @endif>SMA/Sederajat</option>
                                    <option value="Sarjana Muda D3"  @if($rpendidikan->tingkat == "Sarjana Muda D3") selected @endif>Sarjana Muda D3</option>
                                    <option value="Sarjana S1"  @if($rpendidikan->tingkat == "Sarjana S1") selected @endif>Sarjana S1</option>
                                    <option value="Pasca Sarjana S2"  @if($rpendidikan->tingkat == "Pasca Sarjana S2") selected @endif>Pasca Sarjana S2</option>
                                    <option value="Doktoral/Phd S3"  @if($rpendidikan->tingkat == "Doktoral/Phd S3") selected @endif>Doktoral/Phd S3</option>
                                </select>
                            </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Jurusan</label>
                                    <input type="text" name="jurusan" class="form-control" autocomplete="off"
                                        value="{{ $rpendidikan->jurusan }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nama Sekolah</label>
                                    <input type="text" name="nama_sekolah" class="form-control" autocomplete="off"
                                        value="{{ $rpendidikan->nama_sekolah }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <input type="text" name="kotaPendidikanFormal" class="form-control"
                                        autocomplete="off" value="{{ $rpendidikan->kota_pformal }}">
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <div class="mb-3">
                                    <label>Lulus Tahun</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control"
                                            value="{{ $rpendidikan->tahun_lulus_formal }}" placeholder="yyyy"
                                            id="4" name="tahun_lulusFormal" rows="10"
                                            autocomplete="off"><br>
                                        <span class="input-group-addon bg-custom b-0"><i
                                                class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <div class="mb-3">
                                    <label class="form-label">Lama Pendidikan</label>
                                    <div>
                                        <div class="input-group">
                                            <input id="datepicker-autoclose-format-c" type="text" class="form-control" placeholder="yyyy"
                                                name="tahun_masukFormal" autocomplete="off"  rows="10"  value="{{ $rpendidikan->tahun_masuk_formal }}" readonly>
                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                            <input id="datepicker-autoclose-format-d" type="text" class="form-control" placeholder="yyyy"
                                                name="tahun_lulusFormal" autocomplete="off"  rows="10" value="{{ $rpendidikan->tahun_lulus_formal }}" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nomor Ijazah</label>
                                    <input type="text" name="noijazahPformal" class="form-control" autocomplete="off"
                                        value="{{ $rpendidikan->ijazah_formal }}">
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
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
