<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="addPrestasi" tabindex="-1" role="dialog" aria-labelledby="addPekerjaan"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myLargeModalLabel">Tambah Data Prestasi</h4>
            </div>
            <div class="modal-body">
                <form id="" action="/storesprestasi/{{ $karyawan->id }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <input type="hidden" name="idpegawai" autocomplete="off" value="{{ $karyawan->id }}"
                            class="form-control">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Perihal / Keterangan</label>
                                    <input type="text" name="keterangan" class="form-control"
                                        placeholder="Masukkan Nama Prestasi" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Instansi Pemberi </label>
                                    <input type="text" name="namaInstansi" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Instansi"autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Alamat </label>
                                    <input type="text" name="alamatInstansi" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Alamat" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Nomor Surat / Sertifikat</label>
                                    <input type="text" name="noSurat" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Nomor Surat" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label>Tanggal Surat</label>
                                    <div class="input-group">
                                        <input id="datepicker-autoclose-format" type="text" class="form-control"
                                            placeholder="dd/mm/yyyy" id="4" name="tgl_surat" rows="10"
                                            autocomplete="off"><br>
                                        <span class="input-group-addon bg-custom b-0"><i
                                                class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
