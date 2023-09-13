<!--  Modal content for the above example -->
<div class="modal fade bs-example-modal-md" id="addKeluarga" tabindex="-1" role="dialog" aria-labelledby="addKeluarga"
    aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myLargeModalLabel">Tambah Data</h4>
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
                                    <label for="exampleInputEmail1" class="form-label">Hubungan</label>
                                    <select class="form-control " name="hubungankeluarga">
                                        <option value="">Pilih Hubungan</option>
                                        <option value="Ayah">Ayah</option>
                                        <option value="Ibu">Ibu</option>
                                        <option value="Suami">Suami</option>
                                        <option value="Istri">Istri</option>
                                        <option value="Kakak">Kakak</option>
                                        <option value="Adik">Adik</option>
                                        <option value="Anak Ke-1">Anak Ke-1</option>
                                        <option value="Anak Ke-2">Anak Ke-2</option>
                                        <option value="Anak Ke-3">Anak Ke-3</option>
                                        <option value="Anak Ke-4">Anak Ke-4</option>
                                        <option value="Anak Ke-5">Anak Ke-5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="namaKeluarga" class="form-control" autocomplete="off"
                                        placeholder="Masukkan Nama">
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
                                        <input type="text" class="form-control" placeholder="dd/mm/yyyy"
                                            id="datepicker-autoclose-format" autocomplete="off" name="tgllahirKeluarga"
                                            rows="10" readonly><br>
                                        <span class="input-group-addon bg-custom b-0"><i
                                                class="mdi mdi-calendar text-white"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="mb-3">
                                    <label class="form-label">Kota Kelahiran</label>
                                    <input class="form-control" name="tempatlahirKeluarga" autocomplete="off"
                                        rows="9" placeholder="Masukkan Tempat Lahir">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Pendidikan Terakhir</label>
                                <select class="form-control" name="pendidikan_terakhirKeluarga">
                                    <option value="">Pilih Pendidikan Terakhir</option>
                                    <option value="Belum Sekolah">Belum Sekolah</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA/Sederajat">SMA/Sederajat</option>
                                    <option value="Sarjana Muda D3">Sarjana Muda D3</option>
                                    <option value="Sarjana S1">Sarjana S1</option>
                                    <option value="Pasca Sarjana S2">Pasca Sarjana S2</option>
                                    <option value="Doktoral/Phd">Doktoral/Phd</option>
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
