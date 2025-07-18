{{-- <script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> --}}
<div class="modal fade bs-example-modal-lg" id="addPekerjaan" tabindex="-1" role="dialog" aria-labelledby="addPekerjaan"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-center" id="myLargeModalLabel">Tambah Data Pekerjaan</h4>
            </div>
            <div class="modal-body">
                <form id="" action="/storespekerjaan/{{ $karyawan->id }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <input type="hidden" name="idpegawai" autocomplete="off" value="{{ $karyawan->id }}"
                            class="form-control">
                        <div class="col-md-6 m-t-10">
                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Nama Perusahaan</label>
                                    <input type="text" name="namaPerusahaan" class="form-control"
                                        placeholder="Masukkan Nama Perusahaan" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Alamat</label>
                                    <input type="text" name="alamatPerusahaan" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Alamat"autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label class="form-label">Lama Kerja</label>
                                    <div class="input-group">
                                        <input id="datepicker-autoclose-format-k" type="text" class="form-control" placeholder="mm/yyyy"
                                            name="tglmulai" autocomplete="off"  rows="10" readonly>
                                        <span class="input-group-addon bg-primary text-white b-0">To</span>
                                        <input id="datepicker-autoclose-format-h" type="text" class="form-control" placeholder="mm/yyyy"
                                            name="tglselesai" autocomplete="off"  rows="10" readonly>

                                    </div>
                                    {{-- <div>
                                        <div class="input-daterange input-group" id="date-range">
                                            <input type="text" class="form-control" name="tglmulai" id="tglmulai" placeholder="dd/mm/yyyy" autocomplete="off" />
                                            <span class="input-group-addon bg-primary text-white b-0">To</span>
                                            <input type="text" class="form-control" name="tglselesai"
                                                id="tglselesai" placeholder="dd/mm/yyyy" autocomplete="off"/>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Jabatan Terakhir</label>
                                    <input type="text" name="jabatanRpkerejaan" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Jabatan" autocomplete="off">
                                </div>
                            </div>

                        </div>

                        {{-- KANAN --}}
                        <div class="col-md-6 m-t-10">

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label"> Level/Pangkat/Golongan</label>
                                    <input type="text" name="levelRpekerjaan" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Jabatan" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Gaji</label>
                                    <input type="text" name="gajiRpekerjaan" class="form-control" id="gaji"
                                        aria-describedby="emailHelp" placeholder="Masukkan Gaji" autocomplete="off">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Alasan Berhenti</label>
                                    <input type="text" name="alasanBerhenti" class="form-control"
                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                        placeholder="Masukkan Alasan Berhenti" autocomplete="off">

                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
                        <button type="button" class="btn  btn-sm btn-danger" data-dismiss="modal">Tutup</button>
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

