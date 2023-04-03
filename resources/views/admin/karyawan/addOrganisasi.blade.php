<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="addPekerjaan" tabindex="-1" role="dialog" aria-labelledby="addPekerjaan"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myLargeModalLabel">Tambah Data Organisasi</h4>
            </div>
            <div class="modal-body">
                <form id="" action="/storesorganisasi/{{ $karyawan->id }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <input type="hidden" name="idpegawai" autocomplete="off" value="{{ $karyawan->id }}"
                            class="form-control">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nama Organisasi</label>
                                    <input type="text" name="namaOrganisasi" class="form-control"
                                        placeholder="Masukkan Nama Organisasi" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Alamat Organisasi </label>
                                    <input type="text" name="alamatOrganisasi" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Alamat"autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label class="form-label">Lama Bertugas</label>
                                    <div>
                                        <div class="input-daterange input-group" id="date-range">
                                            <input type="text" class="form-control" name="tglmulai" id="tglmulai" />
                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                            <input type="text" class="form-control" name="tglselesai"
                                                id="tglselesai"/>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Jabatan</label>
                                    <input type="text" name="jabatanRorganisasi" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Jabatan" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Nomor Surat Keterangan</label>
                                    <input type="number" name="noSKorganisasi" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Jabatan" autocomplete="off">
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
