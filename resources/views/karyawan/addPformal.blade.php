<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="addPformal" tabindex="-1" role="dialog" aria-labelledby="editPformal"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myLargeModalLabel">Tambah Data Pendidikan Formal</h4>
            </div>
            <div class="modal-body">
                <form id="" action="{{ route('add.pendidikan', ['id' => $karyawan->id]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id_pegawai" autocomplete="off" value="{{$karyawan->id}}" class="form-control">
                            <div class="form-group">
                                <label for="exampleInputEmail1" name="tingkat_pendidikan" class="form-label">Tingkat Pendidikan</label>
                                <select class="form-control" name="tingkat_pendidikan">
                                    <option value="">Pilih Tingkat Pendidikan</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA/Sederajat">SMA/Sederajat</option>
                                    <option value="Sarjana Muda D3">Sarjana Muda D3</option>
                                    <option value="Sarjana S1">Sarjana S1</option>
                                    <option value="Pasca Sarjana S2">Pasca Sarjana S2</option>
                                    <option value="Doktoral/Phd S3">Doktoral/Phd S3</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Jurusan</label>
                                    <input type="text" name="jurusan" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nama Sekolah</label>
                                    <input type="text" name="nama_sekolah" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <input type="text" name="kotaPendidikanFormal" class="form-control"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label class="form-label">Lama Pendidikan</label>
                                    <div>
                                        <div class="input-group">
                                            <input id="datepicker-autoclose-format-ba" type="text" class="form-control" name="tahun_masukFormal"
                                                placeholder="yyyy" autocomplete="off" readonly/>
                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                            <input id="datepicker-autoclose-format-bb" type="text" class="form-control" name="tahun_lulusFormal"
                                                placeholder="yyyy" autocomplete="off" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <div class="mb-3">
                                    <label>Lulus Tahun</label>
                                    <div class="input-group">
                                        <input id="datepicker-autoclose3" type="text" class="form-control"
                                            placeholder="yyyy" id="4" name="tahun_lulusFormal" rows="10"
                                            autocomplete="off"><br>
                                        <span class="input-group-addon bg-custom b-0"><i
                                                class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nomor Ijazah</label>
                                    <input type="text" name="noijazahPformal" class="form-control"
                                        autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
