<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="addPnformal" tabindex="-1" role="dialog" aria-labelledby="editPformal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myLargeModalLabel">Tambah Pendidikan Non Formal</h4>
            </div>
            <div class="modal-body">
                <form id="" action="/tambah-pendidikan/{{$karyawan->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Bidang / Jenis Pendidikan</label>
                                    <input type="hidden" name="id_pegawai" autocomplete="off" value="{{$karyawan->id}}" class="form-control">
                                    <input type="text" name="jenis_pendidikan" autocomplete="off" class="form-control">
                                </div>
                            </div>
                             <div class="form-group">
                                <div class="mb-3">
                                    <label>Lembaga Pendidikan</label>
                                    <input type="text" name="namaLembaga" autocomplete="off" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <input type="text" name="kotaPendidikanNonFormal" autocomplete="off" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label class="form-label">Lama Pendidikan</label>
                                    <div>
                                        <div class="input-group">
                                            <input  id="datepicker-autoclose-format-bc" type="text" class="form-control" name="tahun_masukNonFormal"
                                                placeholder="yyyy" autocomplete="off" readonly />
                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                            <input  id="datepicker-autoclose-format-bd" type="text" class="form-control" name="tahun_lulusNonFormal"
                                                placeholder="yyyy" autocomplete="off" readonly/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <div class="mb-3">
                                    <label>Tahun Lulus</label>
                                    <div class="input-group">
                                        <input id="datepicker-autoclose4" type="text"
                                                class="form-control" placeholder="yyyy" id="4" name="tahunLulusNonFormal" autocomplete="off" rows="10"><br>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nomor Ijazah</label>
                                    <input type="text" name="noijazahPnonformal" autocomplete="off" class="form-control">
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
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
