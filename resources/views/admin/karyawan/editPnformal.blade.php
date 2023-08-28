<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="editPnformal{{$rpendidikan->id}}" tabindex="-1" role="dialog" aria-labelledby="editPformal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title center" id="myLargeModalLabel">Edit Data Pendidikan Non Formal</h4>
            </div>
            <div class="modal-body">
                <form id="formModaleditcuti" action="/updatePendidikan/{{$rpendidikan->id}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id_pendidikan" value="{{$rpendidikan->id}}">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Bidang/ Jenis</label>
                                    <input type="text" name="jenis_pendidikan" autocomplete="off" class="form-control" value="{{$rpendidikan->jenis_pendidikan}}">
                                </div>
                            </div><div class="form-group">
                                <div class="mb-3">
                                    <label>Lembaga Pendidikan</label>
                                    <input type="text" name="namaLembaga" autocomplete="off" class="form-control" value="{{$rpendidikan->nama_lembaga}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <input type="text" name="kotaPendidikanNonFormal" autocomplete="off" class="form-control" value="{{$rpendidikan->kota_pnonformal}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label class="form-label">Lama Pendidikan</label>
                                    <div>
                                        <div class="input-group">
                                            <input id="datepicker-autoclose-format-g" type="text" class="form-control" placeholder="yyyy" 
                                                name="tahun_masukNonFormal" autocomplete="off"  rows="10"  value="{{ $rpendidikan->tahun_masuk_nonformal }}">
                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                            <input id="datepicker-autoclose-format-l" type="text" class="form-control" placeholder="yyyy" 
                                                name="tahun_lulusNonFormal" autocomplete="off"  rows="10" value="{{ $rpendidikan->tahun_lulus_nonformal }}">
                                        </div>
                                    </div>
                                    {{-- <div>
                                        <div class="input-daterange input-group">
                                            <input type="date" class="form-control" name="tahun_masukNonFormal"
                                                placeholder="dd/mm/yyyy" autocomplete="off" value="{{ $rpendidikan->tahun_masuk_nonformal }}" />
                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                            <input type="date" class="form-control" name="tahun_lulusNonFormal"
                                                placeholder="dd/mm/yyyy" autocomplete="off" value="{{ $rpendidikan->tahun_lulus_nonformal }}" />
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <div class="mb-3">
                                    <label>Lulus Tahun</label>
                                    <div class="input-group">
                                        <input  type="date"
                                                class="form-control" placeholder="yyyy" id="4"  value="{{$rpendidikan->tahun_lulus_nonformal}}"
                                                name="tahunLulusNonFormal" autocomplete="off" rows="10"><br>
                                        <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nomor Ijazah</label>
                                    <input type="text" name="noijazahPnonformal" autocomplete="off" class="form-control" value="{{$rpendidikan->ijazah_nonformal}}">
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
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="assets/pages/form-advanced.js"></script>
