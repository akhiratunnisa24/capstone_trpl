<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="editPrestasi{{ $pres->id }}" tabindex="-1" role="dialog"
    aria-labelledby="editIdentitas" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myLargeModalLabel">Edit Data Prestasi</h4>
            </div>
            <div class="modal-body">
                <form id="formModaleditcuti" action="/updatePrestasi/{{ $pres->id }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="id_organisasi" value="{{ $pres->id }}">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Perihal / Keterangan</label>
                                    <input type="text" name="keterangan" autocomplete="off" class="form-control"
                                        value="{{ $pres->keterangan }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Instansi Pemberi</label>
                                    <input type="text" name="namaInstansi" autocomplete="off" class="form-control"
                                        value="{{ $pres->nama_instansi }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Alamat</label>
                                    <input type="text" name="alamatInstansi" autocomplete="off" class="form-control"
                                        value="{{ $pres->alamat }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Nomor Surat / Sertifikat</label>
                                    <input type="text" name="noSurat" class="form-control" autocomplete="off"
                                        value="{{ $pres->no_surat }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Tanggal Surat</label>
                                    <div class="input-group">
                                    <input type="date" class="form-control"
                                        placeholder="dd/mm/yyyy" name="tgl_surat" rows="10" autocomplete="off"
                                        value="{{ $pres->tanggal_surat }}">
                                    <span class="input-group-addon bg-custom b-0"><i
                                                class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                <div class="mb-3">
                                    <label>Tanggal Lahir </label>
                                    <input type="date" name="tgllahirKeluarga"
                                    autocomplete="off" class="form-control" placeholder="yyyy/mm/dd" 
                                    value="{{ $kel->tgllahir }}">
                                </div>
                            </div> --}}
                    </div>


            </div>

            <div class="modal-footer">
                <input type="hidden" name="id" id="id">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
