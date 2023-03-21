<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="addKeluarga" tabindex="-1" role="dialog" aria-labelledby="addKeluarga"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myLargeModalLabel">Tambah Data Keluarga</h4>
            </div>
            <div class="modal-body">
                <form id="" action="/storesdatakeluarga/{{ $karyawan->id }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="idpegawai" autocomplete="off" value="{{ $karyawan->id }}"
                                class="form-control">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nama Keluarga</label>
                                    <input type="text" name="namaKeluarga" class="form-control" autocomplete="off"
                                        placeholder="Masukkan Nama">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3" >
                                    <label for="exampleInputEmail1" class="form-label">Hubungan</label>
                                    <select class="form-control " name="hubungankeluarga">
                                        <option value="">Pilih Hubungan</option>
                                        <option value="Ayah">Ayah</option>
                                        <option value="Ibu">Ibu</option>
                                        <option value="Suami">Suami</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Kakak">Kakak</option>
                                        <option value="Adik">Adik</option>
                                        <option value="Anak">Anak</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                                <select class="form-control" name="jenis_kelaminKeluarga">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="yyyy/mm/dd"
                                            id="datepicker-autoclose8" autocomplete="off" name="tgllahirKeluarga"
                                            rows="10"><br>
                                        <span class="input-group-addon bg-custom b-0"><i
                                                class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Tempat Lahir</label>
                                    <input class="form-control" name="tempatlahirKeluarga" autocomplete="off" rows="9"
                                        placeholder="Masukkan Tempat Lahir">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Pendidikan Terakhir</label>
                                <select class="form-control" name="pendidikan_terakhirKeluarga">
                                    <option value="">Pilih Pendidikan Terakhir</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA/K">SMA/K</option>
                                    <option value="D-3">D-3</option>
                                    <option value="S-1">S-1</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Pekerjaan</label>
                                    <input type="text" name="pekerjaanKeluarga" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Pekerjaan">
                                    <div id="emailHelp" class="form-text"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
