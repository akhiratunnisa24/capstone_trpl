{{-- FORM TAMBAH DATA DEPARTEMEN --}}
<div class="modal fade" id="AddSetting" tabindex="-1" role="dialog" aria-labelledby="AddModal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title text-center" id="myModalLabel">Tambah Data Hari Libur</h4>
            </div>

            <div class="modal-body">
                <form action="/store-kalender" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="" id="start">
                        <div class="form-group">
                            <label class="form-label">Tanggal</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="dd/mm/yyyy" id="datepicker-autoclose33" name="tanggal" autocomplete="off" required readonly>
                                <span class="input-group-addon bg-custom b-0"><i class="mdi mdi-calendar text-white"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="mb-3">
                            <label class="form-label">Tipe Hari Libur</label>
                            <select class="form-control" name="tipe" required>
                                <option value="">Pilih Tipe Hari Libur</option>
                                <option value="Hari Libur Nasional">Hari Libur Nasional</option>
                                <option value="Cuti Bersama">Cuti Bersama</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm">
                        <label for="keterangan" class="col-form-label">Keterangan</label>
                        <input type="text" class="form-control" name="keterangan" id="keterangan" autocomplete="off" placeholder="Masukkan Keterangan" required>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger waves-effect" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-sm btn-success waves-effect waves-light" name="submit"
                            value="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
